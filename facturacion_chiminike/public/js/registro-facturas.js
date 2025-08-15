(async ()=>{
  const API = '';
  const TIPO_FACTURA = window.TIPO_FACTURA || '';

  // =========================
  // Estado global y helpers
  // =========================
  let facturas = [], clientes = [];
  let descuentosConfig = { descuento: 0, rebaja: 0, exento: 0 };

  // Estado sólo para EDITAR (aplicar/cancelar)
  const stateMap = { editar: {
    gRate: null, // 18|15|null (grabado elegido)
    iRate: null, // 18|15|null (impuesto elegido)
    exoAmt: 0,   // monto exonerado fijo
    hasExo: false,
    hasDesc: false,
    hasReb: false,
    hasEx: false
  }};

  const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

  const fetchConfig = (method, data = null) => {
    const config = {
      method,
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': CSRF_TOKEN
      },
      credentials: 'same-origin'
    };
    if (data) config.body = JSON.stringify(data);
    return config;
  };

  // ---- helpers money ----
  const money = n => `L. ${(Number(n||0)).toFixed(2)}`;
  const unmoney = txt => typeof txt==='number' ? txt :
    (parseFloat(String(txt||'0').replace(/L\.\s?/, '').replace(',', '.')) || 0);

  // =========================
  // Carga descuentos (%)
  // =========================
  async function loadDescuentosConfig() {
    try {
      const res = await fetch(`${API}/api/descuentos`, fetchConfig('GET'));
      const js = await res.json();
      descuentosConfig = {
        descuento: Number(js.descuento_otorgado)||0,
        rebaja:    Number(js.rebaja_otorgada)||0,
        exento:    Number(js.importe_exento)||0
      };
    } catch (e) {
      descuentosConfig = { descuento: 0, rebaja: 0, exento: 0 };
      console.warn('No se pudo cargar /api/descuentos, se usan 0%.');
    }
  }

  // =========================
  // INIT (lista + clientes)
  // =========================
  async function init(){
    try {
      const [fs, cs] = await Promise.all([
        fetch(`${API}/api/facturas`, fetchConfig('GET')).then(r=>r.json()),
        fetch(`${API}/api/clientes`, fetchConfig('GET')).then(r=>r.json()),
        loadDescuentosConfig()
      ]);
      facturas = Array.isArray(fs.data) ? fs.data.filter(f => f.tipo_factura === TIPO_FACTURA) : [];
      clientes = Array.isArray(cs.data) ? cs.data : [];
      pintarTabla(facturas);
    } catch(err) {
      Swal.fire({ icon: 'error', title: 'Error', text: 'Error cargando datos iniciales' });
    }
  }

  // =========================
  // Tabla principal
  // =========================
  function pintarTabla(data){
    const tbody = document.querySelector('#facturasTable tbody');
    tbody.innerHTML = '';
    data.forEach(f=>{
      const cli = clientes.find(c=>c.cod_cliente==f.cod_cliente);
      const nombre = cli? cli.nombre : '—';
      const tr = document.createElement('tr');
      tr.dataset.id = f.cod_factura;
      tr.innerHTML = `
        <td>${f.numero_factura}</td>
        <td>${f.fecha_emision?.split('T')[0]||''}</td>
        <td>${f.tipo_factura}</td>
        <td>${nombre}</td>
        <td>${f.rtn||''}</td>
        <td>${money(f.subtotal)}</td>
        <td>${money(f.total_pago)}</td>
        <td>
          <button class="btn-sm btn-view"><i class="fas fa-eye"></i></button>
          <button class="btn-sm btn-edit"><i class="fas fa-pen"></i></button>
        </td>`;
      tbody.appendChild(tr);
    });
  }

  // =========================
  // Filtros
  // =========================
  document.getElementById('filtrarBtn').onclick = ()=> {
    const fd  = document.getElementById('fechaDesde').value;
    const fh  = document.getElementById('fechaHasta').value;
    const txt = document.getElementById('busqueda').value.toLowerCase();
    let arr = facturas.filter(f=> f.tipo_factura === TIPO_FACTURA);
    if(fd)  arr = arr.filter(f=> f.fecha_emision.split('T')[0] >= fd);
    if(fh)  arr = arr.filter(f=> f.fecha_emision.split('T')[0] <= fh);
    if(txt) arr = arr.filter(f=>
      f.numero_factura.toLowerCase().includes(txt) ||
      (clientes.find(c=>c.cod_cliente==f.cod_cliente)?.nombre||'').toLowerCase().includes(txt)
    );
    pintarTabla(arr);
  };

  // =========================
  // Delegación de clicks tabla
  // =========================
  document.querySelector('#facturasTable tbody').addEventListener('click',async e=>{
    const tr = e.target.closest('tr');
    if(!tr) return;
    const id = tr.dataset.id;

    if(e.target.closest('button.btn-view')){
      const f = facturas.find(x=>x.cod_factura==id);
      const cli = clientes.find(c=>c.cod_cliente==f.cod_cliente);
      await mostrarModalVer(f, cli);
    } else if(e.target.closest('button.btn-edit')){
      const f = facturas.find(x=>x.cod_factura==id);
      const cli = clientes.find(c=>c.cod_cliente==f.cod_cliente);
      await mostrarModalEditar(f, cli);
    } else if(e.target.closest('button.btn-delete')){
      const result = await Swal.fire({
        title: '¿Eliminar factura?',
        text: `¿Deseas eliminar la factura ${id}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
      });
      if (result.isConfirmed) {
        try {
          const res = await fetch(`${API}/api/facturas/${id}`, fetchConfig('DELETE'));
          if (res.ok) {
            facturas = facturas.filter(x=>x.cod_factura!=id);
            pintarTabla(facturas);
            Swal.fire('Eliminada','La factura ha sido eliminada','success');
          } else {
            throw new Error('Error al eliminar');
          }
        } catch (err) {
          Swal.fire({ icon: 'error', title: 'Error', text: 'No se pudo eliminar la factura' });
        }
      }
    }
  });

  // =========================
  // Cerrar modales
  // =========================
  document.querySelectorAll('.modal .close').forEach(btn=>{
    btn.onclick = ()=>{ document.getElementById(btn.dataset.close).style.display = 'none'; };
  });

  // =========================
  // Modal Ver
  // =========================
  async function mostrarModalVer(fTabla, cli) {
    let f;
    try {
      const resp = await fetch(`${API}/api/facturas/${fTabla.cod_factura}`, fetchConfig('GET'));
      const data = await resp.json();
      f = data.data;
    } catch (err) {
      Swal.fire({ icon: 'error', title: 'Error', text: 'Error al cargar datos de CAI' });
      return;
    }
    let detalles = [];
    try {
      const res = await fetch(`${API}/api/facturas/${f.cod_factura}/detalle`, fetchConfig('GET'));
      const data = await res.json();
      detalles = Array.isArray(data.data) ? data.data : [];
    } catch (e) {}

    const filasDetalle = detalles.map(d => `
      <tr>
        <td>${d.cantidad}</td>
        <td>${d.descripcion}</td>
        <td>${money(d.precio_unitario)}</td>
        <td>${money(d.total)}</td>
      </tr>
    `).join('');

    const html = `
      <h2>Factura N° ${f.numero_factura}</h2>
      <p><strong>Empresa:</strong> Fundación por Futuro</p>
      <p><strong>RTN Empresa:</strong> 0801199912345</p>
      <p><strong>CAI:</strong> ${f.cai_numero}</p>
      <p><strong>Rango válido:</strong> ${f.rango_desde} – ${f.rango_hasta}</p>
      <p><strong>Fecha Emisión:</strong> ${f.fecha_emision.split('T')[0]}</p>
      <p><strong>Cliente:</strong> ${cli.nombre}</p>
      <p><strong>RTN Cliente:</strong> ${f.rtn}</p>
      <p><strong>Dirección:</strong> ${cli.direccion}</p>
      <hr>
      <table border="1" width="100%" cellpadding="4">
        <tr><th>Cant.</th><th>Descripción</th><th>P.Unit.</th><th>Total</th></tr>
        ${filasDetalle}
      </table>
      <hr>
      <p><strong>Descuento otorgado:</strong> ${money(f.descuento_otorgado)}</p>
      <p><strong>Rebajas otorgadas:</strong> ${money(f.rebajas_otorgadas)}</p>
      <p><strong>Importe exento:</strong> ${money(f.importe_exento)}</p>
      <p><strong>Importe gravado 18%:</strong> ${money(f.importe_gravado_18)}</p>
      <p><strong>Importe gravado 15%:</strong> ${money(f.importe_gravado_15)}</p>
      <p><strong>Impuesto 18%:</strong> ${money(f.impuesto_18)}</p>
      <p><strong>Impuesto 15%:</strong> ${money(f.impuesto_15)}</p>
      <p><strong>Importe exonerado:</strong> ${money(f.importe_exonerado)}</p>
      <p><strong>Subtotal:</strong> ${money(f.subtotal)}</p>
      <p><strong>Total:</strong> ${money(f.total_pago)}</p>
    `;
    document.getElementById('facturaVistaContent').innerHTML = html;
    const verModal = document.getElementById('verFacturaModal');
    verModal.dataset.facturaId = f.cod_factura;
    verModal.style.display = 'flex';
    const downloadLink = document.getElementById('downloadInvoicePdf');
    if (downloadLink) downloadLink.href = `/facturas/pdf/${fTabla.cod_factura}`;
  }

  // Botón enviar correo (modal Ver)
  const btnEnviarCorreo = document.getElementById('btnEnviarCorreo');
  if (btnEnviarCorreo) {
    btnEnviarCorreo.onclick = async () => {
      try {
        const facturaId = document.getElementById('verFacturaModal').dataset.facturaId;
        const { isConfirmed } = await Swal.fire({
          icon: 'question', title: '¿Enviar factura por correo?',
          text: 'Se enviará al correo del cliente',
          showCancelButton: true, confirmButtonText: 'Enviar'
        });
        if (!isConfirmed) return;

        const resp = await fetch(`/facturas/${facturaId}/enviar-correo`, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          },
          credentials: 'same-origin',
          body: JSON.stringify({})
        });
        const data = await resp.json();
        if (resp.ok && data.success) {
          Swal.fire('¡Listo!','Factura enviada correctamente','success');
        } else {
          const msg = data.error || data.message || 'Error al enviar la factura';
          throw new Error(msg);
        }
      } catch (err) {
        Swal.fire('Error', err.message || 'No se pudo enviar la factura por correo','error');
      }
    };
  }

  // =========================
  // EDITAR — lógica aplicar/cancelar
  // =========================
  function setSpan(id, val){
    const el = document.getElementById(id);
    if (el) el.textContent = money(val);
  }
  function setHidden(id, val){
    const el = document.getElementById(id);
    if (el) el.value = Number(val||0).toFixed(2);
  }

  function recalcAllEditar(){
    const st = stateMap.editar;

    // 1) bruto desde filas
    let bruto = 0;
    document.querySelectorAll('#tabla-productos-edit tbody tr').forEach(tr=>{
      bruto += unmoney(tr.querySelector('input[name^="tot_"]')?.value);
    });

    // 2) porcentajes desde API
    const p = descuentosConfig;
    const descAmt   = st.hasDesc ? bruto * (p.descuento/100) : 0;
    const rebAmt    = st.hasReb  ? bruto * (p.rebaja/100)    : 0;
    const exentoAmt = st.hasEx   ? bruto * (p.exento/100)    : 0;
    const exoAmt    = st.hasExo  ? st.exoAmt                 : 0;

    // 3) base
    const base = Math.max(0, bruto - descAmt - rebAmt - exentoAmt - exoAmt);

    // 4) grabados e impuestos (excluyentes)
    const g18 = st.gRate===18 ? base : 0;
    const g15 = st.gRate===15 ? base : 0;
    const i18 = st.iRate===18 ? base * 0.18 : 0;
    const i15 = st.iRate===15 ? base * 0.15 : 0;

    // 5) pintar spans
    setSpan('descuento-valor-editar', descAmt);
    setSpan('rebaja-valor-editar',    rebAmt);
    setSpan('exento-valor-editar',    exentoAmt);
    setSpan('exonerado-editar',       exoAmt);
    setSpan('grabado18-editar',       g18);
    setSpan('grabado15-editar',       g15);
    setSpan('impuesto18-editar',      i18);
    setSpan('impuesto15-editar',      i15);
    setSpan('subtotal-editar',        base);
    setSpan('total-editar',           base + i18 + i15);

    // 6) set hidden (para submit)
    setHidden('hd-descuento-editar',  descAmt);
    setHidden('hd-rebaja-editar',     rebAmt);
    setHidden('hd-exento-editar',     exentoAmt);
    setHidden('hd-exonerado-editar',  exoAmt);
    setHidden('hd-grabado18-editar',  g18);
    setHidden('hd-grabado15-editar',  g15);
    setHidden('hd-imp18-editar',      i18);
    setHidden('hd-imp15-editar',      i15);
    setHidden('hd-subtotal-editar',   base);
    setHidden('hd-total-editar',      base + i18 + i15);
  }

  function aplicarEditar(valor){
    const st = stateMap.editar;
    // bruto para calcular exonerado si aplica ahora
    let bruto = 0;
    document.querySelectorAll('#tabla-productos-edit tbody tr').forEach(tr=>{
      bruto += unmoney(tr.querySelector('input[name^="tot_"]')?.value);
    });
    const p = descuentosConfig;
    const descAmt   = bruto * (p.descuento/100);
    const rebAmt    = bruto * (p.rebaja/100);
    const exentoAmt = bruto * (p.exento/100);

    switch(valor){
      case 'descuento':  st.hasDesc = true;  break;
      case 'rebaja':     st.hasReb  = true;  break;
      case 'exento':     st.hasEx   = true;  break;
      case 'exonerado':  st.hasExo  = true;  st.exoAmt = Math.max(0, bruto - descAmt - rebAmt - exentoAmt) * 0.20; break;
      case 'grabado18':  st.gRate   = 18; st.iRate = null; break;
      case 'grabado15':  st.gRate   = 15; st.iRate = null; break;
      case 'impuesto18': st.iRate   = 18; st.gRate = null; break;
      case 'impuesto15': st.iRate   = 15; st.gRate = null; break;
    }
    recalcAllEditar();
    syncApplyButtonsEditar();
  }

  function syncApplyButtonsEditar(){
    const st = stateMap.editar;
    document.querySelectorAll('#editarFacturaModal .toggle-aplicar[data-factura="editar"]').forEach(btn=>{
      const v = btn.dataset.valor;
      const on = {
        descuento:  st.hasDesc,
        rebaja:     st.hasReb,
        exento:     st.hasEx,
        exonerado:  st.hasExo,
        grabado18:  st.gRate===18 && st.iRate===null,
        grabado15:  st.gRate===15 && st.iRate===null,
        impuesto18: st.iRate===18,
        impuesto15: st.iRate===15
      }[v] || false;
      btn.textContent = on ? 'Cancelar' : 'Aplicar';
    });
  }

  function wireApplyCancelarEditar(){
    document.querySelectorAll('#editarFacturaModal .toggle-aplicar[data-valor]').forEach(el=>{
      el.setAttribute('role','button');
      el.tabIndex = 0;
      el.addEventListener('click', ()=>{
        const v = el.dataset.valor;
        const st = stateMap.editar;
        const on = {
          descuento:  st.hasDesc,
          rebaja:     st.hasReb,
          exento:     st.hasEx,
          exonerado:  st.hasExo,
          grabado18:  st.gRate===18 && st.iRate===null,
          grabado15:  st.gRate===15 && st.iRate===null,
          impuesto18: st.iRate===18,
          impuesto15: st.iRate===15
        }[v] || false;

        if(!on){
          aplicarEditar(v);
        } else {
          switch(v){
            case 'descuento':  st.hasDesc=false; break;
            case 'rebaja':     st.hasReb=false;  break;
            case 'exento':     st.hasEx=false;   break;
            case 'exonerado':  st.hasExo=false; st.exoAmt=0; break;
            case 'grabado18':
            case 'grabado15':  st.gRate=null; break;
            case 'impuesto18':
            case 'impuesto15': st.iRate=null; st.gRate=null; break;
          }
          recalcAllEditar();
          syncApplyButtonsEditar();
        }
      });
    });
  }

  function hydrateEditStateFromFactura(f){
    const st = stateMap.editar;
    st.hasDesc = unmoney(f.descuento_otorgado) > 0;
    st.hasReb  = unmoney(f.rebajas_otorgadas) > 0;
    st.hasEx   = unmoney(f.importe_exento)    > 0;
    st.hasExo  = unmoney(f.importe_exonerado) > 0;
    st.exoAmt  = unmoney(f.importe_exonerado) || 0;

    if (unmoney(f.impuesto_18) > 0)      { st.iRate = 18; st.gRate = null; }
    else if (unmoney(f.impuesto_15) > 0) { st.iRate = 15; st.gRate = null; }
    else if (unmoney(f.importe_gravado_18) > 0) { st.gRate = 18; st.iRate = null; }
    else if (unmoney(f.importe_gravado_15) > 0) { st.gRate = 15; st.iRate = null; }
    else { st.gRate = null; st.iRate = null; }
  }

  // =========================
  // Modal Editar (async)
  // =========================
  async function mostrarModalEditar(f, cli) {
    // detalles
    const dataDet = await fetch(`${API}/api/facturas/${f.cod_factura}/detalle`, fetchConfig('GET')).then(r=>r.json());
    const detalles = Array.isArray(dataDet.data) ? dataDet.data : [];

    // select clientes
    const selClientes = clientes.map(c =>
      `<option value="${c.cod_cliente}" data-rtn="${c.rtn||''}" data-dir="${c.direccion||''}"
        ${c.cod_cliente==f.cod_cliente?'selected':''}>${c.nombre}</option>`
    ).join('');

    // filas productos
    const prodHtml = detalles.map((d,idx)=> `
      <tr data-cod-detalle="${d.cod_detalle||''}">
        <td><input type="number" name="cant_${idx}" value="${d.cantidad}" min="1" style="width:50px"></td>
        <td><input type="text"   name="desc_${idx}" value="${(d.descripcion||'').replace(/"/g,'&quot;')}" style="width:180px" maxlength="20"></td>
        <td>
          <select name="tipo_${idx}" style="width:110px">
            <option value="Entrada" ${d.tipo==='Entrada'?'selected':''}>Entrada</option>
            <option value="Paquete" ${d.tipo==='Paquete'?'selected':''}>Paquete</option>
            <option value="Libro"   ${d.tipo==='Libro'  ?'selected':''}>Libro</option>
            <option value="Extra"   ${(!['Entrada','Paquete','Libro'].includes(d.tipo))?'selected':''}>Extra</option>
          </select>
        </td>
        <td><input type="number" name="unit_${idx}" value="${Number(d.precio_unitario).toFixed(2)}" step="0.01" style="width:70px"></td>
        <td><input type="number" name="tot_${idx}"  value="${Number(d.total).toFixed(2)}" step="0.01" style="width:90px" readonly></td>
        <td>
          <button type="button" class="btn-sm btn-del-prod" data-idx="${idx}" data-cod-detalle="${d.cod_detalle||''}" title="Eliminar línea">
            <i class="fas fa-times"></i>
          </button>
        </td>
      </tr>
    `).join('');

    // bloque aplicar/cancelar + spans + hidden
    const html = `
      <form id="formEdit" autocomplete="off">
        <label>Cliente:
          <select name="cod_cliente" id="selEditCliente">${selClientes}</select>
        </label>
        <label>RTN Cliente:
          <input id="editRtnCliente" name="rtn" value="${f.rtn||''}" readonly>
        </label>
        <label>Dirección:
          <input id="editDirCliente" name="direccion" value="${f.direccion||''}" readonly>
        </label>
        <label>Tipo:</label>
        <input type="text" class="form-control" name="tipo_factura" value="${f.tipo_factura}" readonly>
        <input type="hidden" name="tipo_factura" value="${f.tipo_factura}">
        <label>Fecha Emisión:
          <input type="date" name="fecha_emision" value="${f.fecha_emision.split('T')[0]}">
        </label>
        <label>Observaciones:
          <textarea name="observaciones" id="editObs" maxlength="200">${f.observaciones||''}</textarea>
        </label>
        <hr>
        <table id="tabla-productos-edit" border="1" cellpadding="3" style="width:100%;font-size:13px;">
          <thead>
            <tr><th>Cant.</th><th>Descripción</th><th>Tipo</th><th>Unitario</th><th>Total</th><th></th></tr>
          </thead>
          <tbody>${prodHtml}</tbody>
        </table>
        <button type="button" id="btnAddProdEdit" class="btn-primary btn-sm" style="margin:6px 0">Agregar producto</button>
        <hr>

        <div id="edit-toggles" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:10px;align-items:center;">
          <div>
            <strong>Descuento (<span id="descuento-pct-editar">${descuentosConfig.descuento}</span>%)</strong>
            <span class="toggle-aplicar" data-factura="editar" data-valor="descuento" style="cursor:pointer;margin-left:8px;display:inline-block;padding:2px 8px;border:1px solid #ddd;border-radius:8px;">Aplicar</span>
            <span id="descuento-valor-editar" style="margin-left:10px;">${money(f.descuento_otorgado)}</span>
          </div>
          <div>
            <strong>Rebaja (<span id="rebaja-pct-editar">${descuentosConfig.rebaja}</span>%)</strong>
            <span class="toggle-aplicar" data-factura="editar" data-valor="rebaja" style="cursor:pointer;margin-left:8px;display:inline-block;padding:2px 8px;border:1px solid #ddd;border-radius:8px;">Aplicar</span>
            <span id="rebaja-valor-editar" style="margin-left:10px;">${money(f.rebajas_otorgadas)}</span>
          </div>
          <div>
            <strong>Exento (<span id="exento-pct-editar">${descuentosConfig.exento}</span>%)</strong>
            <span class="toggle-aplicar" data-factura="editar" data-valor="exento" style="cursor:pointer;margin-left:8px;display:inline-block;padding:2px 8px;border:1px solid #ddd;border-radius:8px;">Aplicar</span>
            <span id="exento-valor-editar" style="margin-left:10px;">${money(f.importe_exento)}</span>
          </div>
          <div>
            <strong>Exonerado</strong>
            <span class="toggle-aplicar" data-factura="editar" data-valor="exonerado" style="cursor:pointer;margin-left:8px;display:inline-block;padding:2px 8px;border:1px solid #ddd;border-radius:8px;">Aplicar</span>
            <span id="exonerado-editar" style="margin-left:10px;">${money(f.importe_exonerado)}</span>
          </div>
          <div>
            <strong>Grabado 18%</strong>
            <span class="toggle-aplicar" data-factura="editar" data-valor="grabado18" style="cursor:pointer;margin-left:8px;display:inline-block;padding:2px 8px;border:1px solid #ddd;border-radius:8px;">Aplicar</span>
            <span id="grabado18-editar" style="margin-left:10px;">${money(f.importe_gravado_18)}</span>
          </div>
          <div>
            <strong>Grabado 15%</strong>
            <span class="toggle-aplicar" data-factura="editar" data-valor="grabado15" style="cursor:pointer;margin-left:8px;display:inline-block;padding:2px 8px;border:1px solid #ddd;border-radius:8px;">Aplicar</span>
            <span id="grabado15-editar" style="margin-left:10px;">${money(f.importe_gravado_15)}</span>
          </div>
          <div>
            <strong>Impuesto 18%</strong>
            <span class="toggle-aplicar" data-factura="editar" data-valor="impuesto18" style="cursor:pointer;margin-left:8px;display:inline-block;padding:2px 8px;border:1px solid #ddd;border-radius:8px;">Aplicar</span>
            <span id="impuesto18-editar" style="margin-left:10px;">${money(f.impuesto_18)}</span>
          </div>
          <div>
            <strong>Impuesto 15%</strong>
            <span class="toggle-aplicar" data-factura="editar" data-valor="impuesto15" style="cursor:pointer;margin-left:8px;display:inline-block;padding:2px 8px;border:1px solid #ddd;border-radius:8px;">Aplicar</span>
            <span id="impuesto15-editar" style="margin-left:10px;">${money(f.impuesto_15)}</span>
          </div>
          <div>
            <strong>Sub-total</strong>
            <span id="subtotal-editar" style="margin-left:10px;">${money(f.subtotal)}</span>
          </div>
          <div>
            <strong>Total</strong>
            <span id="total-editar" style="margin-left:10px;">${money(f.total_pago)}</span>
          </div>
        </div>

        <!-- Hidden inputs que se envían en el submit -->
        <input type="hidden" name="descuento_otorgado" id="hd-descuento-editar" value="${Number(f.descuento_otorgado||0).toFixed(2)}">
        <input type="hidden" name="rebajas_otorgadas" id="hd-rebaja-editar"    value="${Number(f.rebajas_otorgadas||0).toFixed(2)}">
        <input type="hidden" name="importe_exento"     id="hd-exento-editar"    value="${Number(f.importe_exento||0).toFixed(2)}">
        <input type="hidden" name="importe_exonerado"  id="hd-exonerado-editar" value="${Number(f.importe_exonerado||0).toFixed(2)}">
        <input type="hidden" name="importe_gravado_18" id="hd-grabado18-editar" value="${Number(f.importe_gravado_18||0).toFixed(2)}">
        <input type="hidden" name="importe_gravado_15" id="hd-grabado15-editar" value="${Number(f.importe_gravado_15||0).toFixed(2)}">
        <input type="hidden" name="impuesto_18"        id="hd-imp18-editar"     value="${Number(f.impuesto_18||0).toFixed(2)}">
        <input type="hidden" name="impuesto_15"        id="hd-imp15-editar"     value="${Number(f.impuesto_15||0).toFixed(2)}">
        <input type="hidden" name="subtotal"           id="hd-subtotal-editar"  value="${Number(f.subtotal||0).toFixed(2)}">
        <input type="hidden" name="total_pago"         id="hd-total-editar"     value="${Number(f.total_pago||0).toFixed(2)}">

        <div style="text-align:right;margin-top:1rem;">
          <button type="submit" class="btn-primary" id="btnGuardarEdit">Guardar</button>
        </div>
      </form>
    `;

    document.getElementById('formEditarFactura').innerHTML = html;
    const editarModal = document.getElementById('editarFacturaModal');
    editarModal.style.display = 'flex';

    // cambiar RTN/Dirección al elegir cliente
    document.getElementById('selEditCliente').onchange = function() {
      const sel = this.options[this.selectedIndex];
      document.getElementById('editRtnCliente').value = sel.getAttribute('data-rtn')||'';
      document.getElementById('editDirCliente').value = sel.getAttribute('data-dir')||'';
    };

    // Borrar producto (+ DB si trae cod_detalle)
    document.querySelectorAll('#tabla-productos-edit .btn-del-prod').forEach(btn=>{
      btn.onclick = async function(){
        const row = this.closest('tr');
        const codDetalle = btn.getAttribute('data-cod-detalle');
        const result = await Swal.fire({
          title:'¿Eliminar producto?', text:'Esta acción no se puede deshacer',
          icon:'question', showCancelButton:true, confirmButtonText:'Sí, eliminar', cancelButtonText:'Cancelar'
        });
        if (!result.isConfirmed) return;

        if (codDetalle) {
          try {
            const res = await fetch(`${API}/api/facturas/detalle-factura/${codDetalle}`, fetchConfig('DELETE'));
            if (!res.ok) throw new Error('No se pudo eliminar en la base');
            row.remove();
            recalcAllEditar();
            Swal.fire('Eliminado','El producto ha sido eliminado','success');
          } catch (err) {
            Swal.fire({ icon:'error', title:'Error', text:'Error eliminando producto en la base' });
          }
        } else {
          row.remove();
          recalcAllEditar();
        }
      };
    });

    // Agregar producto
    document.getElementById('btnAddProdEdit').onclick = ()=>{
      const tbody = document.querySelector('#tabla-productos-edit tbody');
      const idx = tbody.rows.length;
      const row = document.createElement('tr');
      row.innerHTML = `
        <td><input type="number" name="cant_${idx}" value="1" min="1" style="width:50px"></td>
        <td><input type="text"   name="desc_${idx}" value="" style="width:180px" maxlength="20"></td>
        <td>
          <select name="tipo_${idx}" style="width:110px">
            <option value="Entrada">Entrada</option>
            <option value="Paquete">Paquete</option>
            <option value="Libro">Libro</option>
            <option value="Extra" selected>Extra</option>
          </select>
        </td>
        <td><input type="number" name="unit_${idx}" value="0.00" step="0.01" style="width:70px"></td>
        <td><input type="number" name="tot_${idx}"  value="0.00" step="0.01" style="width:90px" readonly></td>
        <td>
          <button type="button" class="btn-sm btn-del-prod" data-idx="${idx}" title="Eliminar línea">
            <i class="fas fa-times"></i>
          </button>
        </td>
      `;
      tbody.appendChild(row);

      // eventos de fila
      const upd = ()=>{
        const cant = parseFloat(row.querySelector(`input[name="cant_${idx}"]`).value)||0;
        const unit = parseFloat(row.querySelector(`input[name="unit_${idx}"]`).value)||0;
        row.querySelector(`input[name="tot_${idx}"]`).value = (cant*unit).toFixed(2);
        recalcAllEditar();
      };
      row.querySelector(`input[name="cant_${idx}"]`).addEventListener('input', upd);
      row.querySelector(`input[name="unit_${idx}"]`).addEventListener('input', upd);
      row.querySelector('.btn-del-prod').onclick = async ()=>{
        const result = await Swal.fire({
          title:'¿Eliminar producto?', icon:'question',
          showCancelButton:true, confirmButtonText:'Sí, eliminar', cancelButtonText:'Cancelar'
        });
        if (result.isConfirmed){ row.remove(); recalcAllEditar(); }
      };
      upd();
    };

    // inputs de filas existentes
    document.querySelectorAll('#tabla-productos-edit tbody tr').forEach(tr=>{
      const cant = tr.querySelector('input[name^="cant_"]');
      const unit = tr.querySelector('input[name^="unit_"]');
      const tot  = tr.querySelector('input[name^="tot_"]');
      const upd = ()=>{
        const c = parseFloat(cant.value)||0;
        const u = parseFloat(unit.value)||0;
        tot.value = (c*u).toFixed(2);
        recalcAllEditar();
      };
      cant.addEventListener('input', upd);
      unit.addEventListener('input', upd);
    });

    // Hidratar estado desde la factura original
    hydrateEditStateFromFactura(f);

    // Wire de aplicar/cancelar y sync inicial
    wireApplyCancelarEditar();
    syncApplyButtonsEditar();

    // Recalcular una vez cargado
    recalcAllEditar();

    // Submit
    document.getElementById('formEdit').addEventListener('submit', async function(e){
      e.preventDefault();
      try {
        const data = Object.fromEntries(new FormData(this).entries());
        // cabecera: viene de los hidden + campos visibles
        const cabecera = {
          fecha_emision: data.fecha_emision,
          cod_cliente: data.cod_cliente,
          direccion: data.direccion,
          rtn: data.rtn,
          tipo_factura: data.tipo_factura,
          descuento_otorgado:  Number(data.descuento_otorgado)||0,
          rebajas_otorgadas:   Number(data.rebajas_otorgadas)||0,
          importe_exento:      Number(data.importe_exento)||0,
          importe_gravado_18:  Number(data.importe_gravado_18)||0,
          importe_gravado_15:  Number(data.importe_gravado_15)||0,
          impuesto_18:         Number(data.impuesto_18)||0,
          impuesto_15:         Number(data.impuesto_15)||0,
          importe_exonerado:   Number(data.importe_exonerado)||0,
          subtotal:            Number(data.subtotal)||0,
          total_pago:          Number(data.total_pago)||0,
          observaciones: data.observaciones
        };

        const rows = Array.from(document.querySelectorAll('#tabla-productos-edit tbody tr'));
        const productos = rows.map(tr => ({
          cod_detalle: tr.getAttribute('data-cod-detalle') || null,
          cantidad: parseInt(tr.querySelector('input[name^="cant_"]').value) || 0,
          descripcion: tr.querySelector('input[name^="desc_"]').value,
          tipo: tr.querySelector('select[name^="tipo_"]').value,
          precio_unitario: parseFloat(tr.querySelector('input[name^="unit_"]').value) || 0,
          total: parseFloat(tr.querySelector('input[name^="tot_"]').value) || 0
        })).filter(p=>p.cantidad && p.descripcion);

        // Actualizar cabecera
        const cabRes = await fetch(`${API}/api/facturas/${f.cod_factura}`, fetchConfig('PUT', cabecera));
        const cabJson = await cabRes.json();
        if (!cabRes.ok) throw new Error(cabJson.message || 'Error actualizando cabecera');

        // Actualizar/crear detalles
        for (let prod of productos) {
          if (prod.cod_detalle) {
            const res = await fetch(`${API}/api/facturas/detalle-factura/${prod.cod_detalle}`, fetchConfig('PUT', {
              cantidad: prod.cantidad,
              descripcion: prod.descripcion,
              precio_unitario: prod.precio_unitario,
              total: prod.total,
              tipo: prod.tipo
            }));
            const js = await res.json();
            if (!res.ok) throw new Error(js.message || 'Error actualizando línea');
          } else {
            const res = await fetch(`${API}/api/facturas/detalle`, fetchConfig('POST', {
              cod_factura: f.cod_factura,
              cantidad: prod.cantidad,
              descripcion: prod.descripcion,
              precio_unitario: prod.precio_unitario,
              total: prod.total,
              tipo: prod.tipo
            }));
            const js = await res.json();
            if (!res.ok) throw new Error(js.message || 'Error agregando línea');
          }
        }

        Swal.fire({ icon:'success', title:'Actualizada', text:'Factura actualizada exitosamente' });
        document.getElementById('editarFacturaModal').style.display = 'none';
        await init();
      } catch(err) {
        Swal.fire({ icon:'error', title:'Error', text:'Error al actualizar factura: ' + (err.message || err) });
      }
    });
  }

  // =========================
  // Validaciones básicas en EDITAR
  // =========================
  document.addEventListener('DOMContentLoaded', function () {
    function soloNumeros(e){ const ch=String.fromCharCode(e.which); if(!/^\d$/.test(ch)) e.preventDefault(); }
    function soloDireccion(e){ const ch=String.fromCharCode(e.which); if(!/[a-zA-Z0-9\s#.,áéíóúÁÉÍÓÚüÜñÑ-]/.test(ch)) e.preventDefault(); }

    // Observaciones
    document.body.addEventListener('keypress', e => {
      if (e.target.id === 'editObs') {
        const char = String.fromCharCode(e.which || e.keyCode);
        if (!/[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s\.,;:¡!\¿\?'"()\-\–]/.test(char)) e.preventDefault();
      }
    });
    document.body.addEventListener('input', e => {
      if (e.target.id === 'editObs') {
        e.target.value = e.target.value.split('').filter(c =>
          /[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s\.,;:¡!\¿\?'"()\-\–]/.test(c)
        ).join('');
      }
    });

    // RTN/Dirección (cuando existan en DOM)
    document.body.addEventListener('keypress', e=>{
      if (e.target && e.target.id==='editRtnCliente') soloNumeros(e);
      if (e.target && e.target.id==='editDirCliente') soloDireccion(e);
    });
    document.body.addEventListener('input', e=>{
      if (e.target && e.target.id==='editRtnCliente') e.target.value = e.target.value.replace(/\D/g,'');
      if (e.target && e.target.id==='editDirCliente') e.target.value = e.target.value.replace(/[^a-zA-Z0-9\s#.,áéíóúÁÉÍÓÚüÜñÑ-]/g,'');
    });

    // Descripciones: sólo permitir borrar/mover sin bloquear
    document.body.addEventListener('keydown', e => {
      const t = e.target;
      if (t.tagName==='INPUT' && t.name?.startsWith('desc_')) {
        const allow = ['Backspace','Delete','ArrowLeft','ArrowRight','Home','End','Tab'];
        if (allow.includes(e.key)) { /* permitir */ }
      }
    }, true);
  });

  await init();
})();
