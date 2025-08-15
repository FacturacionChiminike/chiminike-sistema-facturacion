const API_BASE = "";

let municipios = [];

async function loadMunicipios() {
  try {
    const res = await axios.get(`${API_BASE}/api/municipios`);
    municipios = res.data.data;
  } catch (err) {
    console.error('Error cargando municipios:', err);
  }
}

function fillMunicipioSelect(tipo) {
  const sel = document.getElementById(`new-municipio-${tipo}`);
  if (!sel) return;
  sel.innerHTML = '<option value="">Seleccione municipio...</option>';
  municipios.forEach(m => {
    const opt = document.createElement('option');
    opt.value = m.cod_municipio;
    opt.textContent = m.municipio;
    sel.appendChild(opt);
  });
}

// —————————————————————————————————————————————————
// DATOS PRINCIPALES
let clientes = [],
  empleados = [],
  eventos = [],
  boletosDisponibles = [],
  adicionalesDisponibles = [],
  paquetesDisponibles = [],
  inventarioDisponibles = [],
  librosDisponibles = [],
  salonesDisponibles = [];
let descuentosConfig = {};
let codCorrelativo, siguienteNumero, caiActivo;

// ——— Anti-spam / loader para generación de facturas ———
let __generandoFactura = false;
let __prevDisabled = [];

function startGeneratingLock() {
  if (__generandoFactura) return false; // ya hay una en proceso
  __generandoFactura = true;

  // Guardamos el estado previo y deshabilitamos todos los botones de guardar
  __prevDisabled = [];
  document.querySelectorAll('.btn-invoice, [id^="guardar-factura-"]').forEach(b => {
    __prevDisabled.push([b, b.disabled]);
    b.disabled = true;
  });

  // Loader SweetAlert
  Swal.fire({
    title: 'Generando factura…',
    text: 'Por favor espera',
    allowOutsideClick: false,
    allowEscapeKey: false,
    allowEnterKey: false,
    didOpen: () => { Swal.showLoading(); }
  });

  return true;
}

function closeGeneratingAlert() {
  if (Swal.isVisible()) Swal.close();
}

function releaseGeneratingLock() {
  // Restaurar estado previo de los botones
  __prevDisabled.forEach(([b, wasDisabled]) => b.disabled = wasDisabled);
  __prevDisabled = [];
  __generandoFactura = false;
}

// ——— Límite de ítems por factura / formulario ———
const MAX_ITEMS = 5;

function totalItemsForTipo(tipo) {
  let selectors = [];
  if (tipo === 'taquilla') {
    selectors = ['#boletos-container-taquilla tr'];
  } else if (tipo === 'recorrido' || tipo === 'obras') {
    selectors = [`#boletos-container-${tipo} tr`, `#productos-container-${tipo} tr`];
  } else if (tipo === 'eventos') {
    selectors = ['#productos-container-eventos tr'];
  } else {
    selectors = [`#productos-container-${tipo} tr`];
  }
  let count = 0;
  selectors.forEach(sel => (count += document.querySelectorAll(sel).length));
  return count;
}

function canAddItem(tipo) {
  const count = totalItemsForTipo(tipo);
  if (count >= MAX_ITEMS) {
    Swal.fire({
      icon: 'warning',
      title: 'Límite de ítems',
      text: `Sólo se permiten ${MAX_ITEMS} ítems por factura.`
    });
    return false;
  }
  return true;
}

// ——— Cliente por defecto (Consumidor Final) ———
const DEFAULT_CF = {
  nombre: 'CONSUMIDOR FINAL',
  rtn: 'XXXXXXXXXXXXX',        // 13 "X"
  direccion: 'S/D',
  tipo_cliente: 'CONSUMIDOR FINAL'
};

/**
 * Asegura que exista un cliente "CONSUMIDOR FINAL" en BD.
 * - Si ya existe en cache `clientes`, lo usa.
 * - Si no existe, lo crea vía API y lo añade a `clientes`.
 * Devuelve el objeto { cod_cliente, nombre, rtn, direccion, ... }
 */
async function ensureDefaultCF() {
  let cf = clientes.find(c =>
    (c.nombre || '').toUpperCase() === DEFAULT_CF.nombre ||
    (c.rtn || '') === DEFAULT_CF.rtn
  );
  if (cf) return cf;

  // Crear en API
  const payload = {
    nombre: DEFAULT_CF.nombre,
    rtn: DEFAULT_CF.rtn,
    direccion: DEFAULT_CF.direccion,
    tipo_cliente: DEFAULT_CF.tipo_cliente,
    fecha_nacimiento: null, sexo: null, dni: null, correo: null,
    telefono: null, cod_municipio: null
  };
  const { data } = await axios.post(`${API_BASE}/api/clientes`, payload);
  cf = { cod_cliente: data.data.cod_cliente, ...payload };
  clientes.push(cf);
  fillAllSelects();
  return cf;
}

// —————————————————————————————————————————————————
// LIMPIEZA DE FORMULARIOS
function clearForm(tipo) {
  const form = document.getElementById(`form-factura-${tipo}`);
  if (form) {
    form.querySelectorAll('input, select, textarea').forEach(el => {
      // ❌ Saltar si es:
      //    - numero de factura
      //    - campo de CAI
      //    - campo empleado (hidden o display)
      //    - cualquier input readonly (tu display de empleado también)
      if (
        el.classList.contains('numero-factura') ||
        el.classList.contains('cai-field') ||
        el.id === `empleado-${tipo}` ||
        (el.tagName === 'INPUT' && el.readOnly)
      ) {
        return;
      }
      el.value = '';
    });
  }

  // Sólo limpiar el select de cliente
  const selCliente = document.getElementById(`cliente-${tipo}`);
  if (selCliente) selCliente.value = '';

  // Limpieza especial para event-forms
  if (tipo === 'eventos') {
    const formEv = document.getElementById('form-nuevo-evento');
    if (formEv) {
      formEv.style.display = 'none';
      formEv.querySelectorAll('input, select, textarea').forEach(el => el.value = '');
    }
    document.getElementById('productos-container-nuevo-evento').innerHTML = '';
    document.getElementById('evento-eventos').value = '';
    document.getElementById('cliente-eventos').disabled = false;
    document.getElementById('productos-container-eventos').innerHTML = '';
  }

  // Eliminar filas de boletos y productos
  document.querySelectorAll(
    `#boletos-container-${tipo} tr, #productos-container-${tipo} tr`
  ).forEach(tr => tr.remove());

  // Reiniciar el estado de descuentos/impuestos
  stateMap[tipo] = {
    gRate: null,
    iRate: null,
    exoAmt: 0,
    hasExo: false,
    hasDesc: false,
    hasReb: false,
    hasEx: false
  };

  // Restablecer todos los totales a 0
  [
    'descuento-valor',
    'rebaja-valor',
    'exento-valor',
    'exonerado',
    'grabado18',
    'grabado15',
    'impuesto18',
    'impuesto15',
    'subtotal',
    'total'
  ].forEach(id => {
    const span = document.getElementById(`${id}-${tipo}`);
    if (span) span.textContent = 'L. 0.00';
  });

  // Limpiar notas
  const nota = document.getElementById(`nota-${tipo}`);
  if (nota) nota.value = '';
}

/**
 * Muestra un alert de error y al cerrarlo limpia y enfoca el campo dado.
 * @param {HTMLElement} inputEl  —  elemento <input> o <select> a limpiar
 * @param {String} title        —  título del error
 * @param {String} text         —  mensaje del error
 */
function showErrorAndClear(inputEl, title, text) {
  Swal.fire({ icon: 'error', title, text })
    .then(() => {
      if (inputEl) {
        inputEl.value = '';
        inputEl.focus();
      }
    });
}


// ===== INIT =====
document.addEventListener('DOMContentLoaded', async () => {
  await loadMunicipios();
  await initData();
  setupInlineNewClient();
  setupAddButtons();
  setupSaveFacturaButtons(['recorrido', 'taquilla', 'eventos', 'libros', 'obras']);
  
  // Mostrar todos los formularios de facturación
  ['recorrido', 'taquilla', 'eventos', 'libros', 'obras'].forEach(tipo => {
    const section = document.getElementById(`section-${tipo}`);
    if (section) section.style.display = 'block';
  });

  const btnAgregarProdNuevoEv = document.getElementById('agregar-producto-nuevo-evento');
  if (btnAgregarProdNuevoEv) {
    btnAgregarProdNuevoEv.onclick = function () {
      // Límite de 5 ítems en "Nuevo Evento"
      const cont = document.getElementById('productos-container-nuevo-evento');
      if (cont && cont.querySelectorAll('tr').length >= MAX_ITEMS) {
        Swal.fire({
          icon: 'warning',
          title: 'Límite de ítems',
          text: `Sólo se permiten ${MAX_ITEMS} ítems en el evento.`
        });
        return;
      }

      const tbody = document.getElementById('productos-container-nuevo-evento');
      const tr = document.createElement('tr');
      
      tr.innerHTML = `
        <td>
          <select class="desc" required style="width:180px;">
            <option value="">Seleccione producto...</option>
            ${
              [
                ...salonesDisponibles.map(s => `<option data-precio="${s.precio_dia}" value="${s.nombre}">SALÓN: ${s.nombre} (L. ${s.precio_dia})</option>`),
              
                ...inventarioDisponibles.map(i => `<option data-precio="${i.precio_unitario}" value="${i.nombre}">INVENTARIO: ${i.nombre} (L. ${i.precio_unitario})</option>`)
              ].join('')
            }
          </select>
        </td>
        <td><input type="number" class="cantidad" min="1" value="1" style="width:60px;" required></td>
        <td><input type="number" class="precio" min="0" value="0" step="0.01" style="width:90px;" required></td>
        <td class="total">0.00</td>
        <td><button type="button" class="btn-remove">×</button></td>
      `;
      
      const sel = tr.querySelector('.desc');
      const qty = tr.querySelector('.cantidad');
      const prc = tr.querySelector('.precio');

      const update = () => {
        const total = (Number(qty.value) || 0) * (Number(prc.value) || 0);
        tr.querySelector('.total').textContent = total.toFixed(2);
      };

      sel.onchange = () => {
        const precio = parseFloat(sel.selectedOptions[0]?.dataset.precio || 0);
        prc.value = precio.toFixed(2);
        update();
      };

      qty.oninput = update;
      prc.oninput = update;
      tr.querySelector('.btn-remove').onclick = () => tr.remove();
      
      update();
      tbody.appendChild(tr);
    };
  }

  const btnNuevoEvento = document.getElementById('btn-nuevo-evento');
  if (btnNuevoEvento) {
    btnNuevoEvento.onclick = function () {
      fillSelectClientesNuevoEvento();
      const formNuevoEv = document.getElementById('form-nuevo-evento');
      if (formNuevoEv) formNuevoEv.style.display = 'block';
    };
    
   // ——— Cancelar Nuevo Evento: limpiar y ocultar formulario ———
const btnCancelarNuevoEvento = document.getElementById('cancelar-nuevo-evento');
if (btnCancelarNuevoEvento) {
  btnCancelarNuevoEvento.onclick = function () {
    const cont = document.getElementById('form-nuevo-evento');
    if (!cont) return;
    // 1) limpiar selects e inputs
    cont.querySelector('#select-cliente-nuevo-evento').value = '';
    cont.querySelector('#nuevo-nombre-evento').value = '';
    cont.querySelector('#nuevo-fecha-evento').value = '';
    cont.querySelector('#nuevo-hora-evento').value = '';
    cont.querySelector('#nuevo-horas-evento').value = '';
    // 2) eliminar todas las filas de productos
    document.getElementById('productos-container-nuevo-evento').innerHTML = '';
    // 3) ocultar el contenedor
    cont.style.display = 'none';
  };
}

    
    const btnGuardarNuevoEvento = document.getElementById('guardar-nuevo-evento');
if (btnGuardarNuevoEvento) {
  btnGuardarNuevoEvento.onclick = async function () {
    const cod_cliente = document.getElementById('select-cliente-nuevo-evento')?.value;
    const nombre      = document.getElementById('nuevo-nombre-evento')?.value.trim();
    const fecha       = document.getElementById('nuevo-fecha-evento')?.value;
    const hora        = document.getElementById('nuevo-hora-evento')?.value;
    const horas       = document.getElementById('nuevo-horas-evento')?.value;

    // Validaciones de campos requeridos
    if (!cod_cliente) {
      return Swal.fire({ icon: 'error', title: 'Cliente requerido', text: 'Por favor selecciona un cliente para el evento' });
    }
    if (!nombre) {
      return Swal.fire({ icon: 'error', title: 'Nombre requerido', text: 'Por favor ingresa el nombre del evento' });
    }
    if (!fecha) {
      return Swal.fire({ icon: 'error', title: 'Fecha requerida', text: 'Por favor selecciona la fecha del evento' });
    }
    if (!hora) {
      return Swal.fire({ icon: 'error', title: 'Hora requerida', text: 'Por favor selecciona la hora del evento' });
    }
    if (!horas) {
      return Swal.fire({ icon: 'error', title: 'Duración requerida', text: 'Por favor ingresa la duración en horas del evento' });
    }

    // Recoger productos añadidos
    const productos = [];
    document.querySelectorAll('#productos-container-nuevo-evento tr').forEach(tr => {
      const desc            = tr.querySelector('.desc')?.value;
      const cantidad        = Number(tr.querySelector('.cantidad')?.value || 0);
      const precio_unitario = Number(tr.querySelector('.precio')?.value || 0);
      if (desc && cantidad > 0 && precio_unitario >= 0) {
        productos.push({ descripcion: desc, cantidad, precio_unitario, total: cantidad * precio_unitario });
      }
    });

    if (productos.length === 0) {
      return Swal.fire({ icon: 'error', title: 'Productos requeridos', text: 'Debes agregar al menos un producto al evento' });
    }
    // Asegurar que haya al menos un salón (mirando el texto de la opción)
const tieneSalon = Array.from(
  document.querySelectorAll('#productos-container-nuevo-evento tr')
).some(tr => {
  const sel = tr.querySelector('.desc');
  if (!sel) return false;
  const texto = sel.selectedOptions[0].text.toUpperCase();
  // acepta tanto "SALÓN" como "SALON"
  return texto.startsWith('SALÓN') || texto.startsWith('SALON');
});
if (!tieneSalon) {
  return Swal.fire({
    icon: 'error',
    title: 'Salón requerido',
    text: 'Debes agregar al menos un salón para crear un evento nuevo'
  });
}


    try {
      // Llamada al API
      const resp = await axios.post(`${API_BASE}/api/eventos-completo`, {
        cod_cliente,
        nombre,
        fecha_programa: fecha,
        hora_programada: hora,
        horas_evento: horas,
        productos
      });

      // Actualizar listas y limpiar formulario
      eventos = await loadEventos();
      fillAllSelects();

      const formNuevoEv = document.getElementById('form-nuevo-evento');
      if (formNuevoEv) {
        formNuevoEv.style.display = 'none';
        formNuevoEv.querySelectorAll('input, select').forEach(el => el.value = '');
        document.getElementById('productos-container-nuevo-evento').innerHTML = '';
      }

      Swal.fire({ icon: 'success', title: 'Evento creado', text: 'El evento se ha creado correctamente' });
      
      // Preseleccionar el evento recién creado
      const selEv = document.getElementById('evento-eventos');
      if (selEv) {
        selEv.value = resp.data.data.cod_evento;
        selEv.dispatchEvent(new Event('change'));
      }
    } catch (e) {
      Swal.fire({
        icon: 'error',
        title: 'Error al crear evento',
        text: e.response?.data?.message || e.message
      });
    }
  };
}
  }

  const selEventoEv = document.getElementById('evento-eventos');
  if (selEventoEv) {
    selEventoEv.onchange = async function () {
      const codEvento = this.value;
      if (!codEvento) return;

      try {
        const resp = await axios.get(`${API_BASE}/api/eventos/${codEvento}`);
        const evento = resp.data.data;

        const clienteEv = document.getElementById('cliente-eventos');
      if (clienteEv) {
        // 1) precargas el valor…
        clienteEv.value = evento.cod_cliente || '';
        // 2) …y lo deshabilitas para que no pueda cambiarse:
        clienteEv.disabled = true;
      }
        const tbody = document.getElementById('productos-container-eventos');
        if (tbody) {
          tbody.innerHTML = '';

          if (evento.productos && evento.productos.length) {
            evento.productos.forEach(prod => {
              const tr = document.createElement('tr');

              let precio = prod.precio_unitario;
              if (prod.descripcion?.toUpperCase().includes('SALON')) {
                const salonData = salonesDisponibles.find(s => prod.descripcion.includes(s.nombre));
                if (salonData && evento.hora_programada) {
                  const hora = parseInt(evento.hora_programada.split(':')[0], 10);
                  const esNoche = hora >= 18 || hora < 6;
                  precio = esNoche ? salonData.precio_noche : salonData.precio_dia;
                }
              }

              tr.innerHTML = `
                <td><input type="text" class="desc" value="${prod.descripcion}" readonly></td>
                <td><input type="number" class="cantidad" value="${prod.cantidad}" min="1" style="width:60px;" required></td>
                <td><input type="number" class="precio" value="${precio}" min="0" step="0.01" style="width:90px;" readonly></td>
                <td class="total">${(prod.cantidad * precio).toFixed(2)}</td>
                <td><button type="button" class="btn-remove">×</button></td>
              `;

              const qty = tr.querySelector('.cantidad');
              const prc = tr.querySelector('.precio');
              const update = () => {
                const total = (Number(qty.value) || 0) * (Number(prc.value) || 0);
                tr.querySelector('.total').textContent = total.toFixed(2);
                recalcTotales('eventos');
              };
              qty.oninput = update;
              prc.oninput = update;
              tr.querySelector('.btn-remove').onclick = () => {
                tr.remove();
                recalcTotales('eventos');
              };

              tbody.appendChild(tr);
            });
          }

          if (evento.hora_programada) {
            const h = parseInt(evento.hora_programada.split(':')[0], 10);
            window.eventoEsNoche = h >= 18 || h < 6;
          }
        }

        recalcTotales('eventos');
      } catch (e) {
        Swal.fire({
          icon: 'error',
          title: 'Error al cargar evento',
          text: 'No se pudieron cargar los datos del evento seleccionado'
        });
      }
    };
  }

  const btnHorasExtra = document.getElementById('agregar-horas-extra');
  if (btnHorasExtra) {
    btnHorasExtra.onclick = function () {
      const tbody = document.getElementById('productos-container-eventos');
      if (!tbody) return;

      // Límite de ítems en factura tipo "eventos"
      if (!canAddItem('eventos')) return;

      const filas = [...tbody.querySelectorAll('tr')];
      const filaSalon = filas.find(tr =>
        tr.querySelector('.desc')?.value?.toUpperCase().includes('SALON')
      );

      if (!filaSalon) {
        Swal.fire({
          icon: 'warning',
          title: 'Salón no detectado',
          text: 'Agrega primero un salón al evento antes de añadir horas extra.'
        });
        return;
      }

      const nombreSalon = filaSalon.querySelector('.desc').value.trim();
      const salon = salonesDisponibles.find(s => nombreSalon.includes(s.nombre));
      if (!salon) {
        Swal.fire({
          icon: 'error',
          title: 'Salón no encontrado',
          text: 'No se encontró el precio de horas extra para el salón actual.'
        });
        return;
      }

      const esNoche = window.eventoEsNoche || false;
      const precioHora = esNoche ? salon.precio_hora_extra_noche : salon.precio_hora_extra_dia;

      const tr = document.createElement('tr');
      tr.classList.add('horas-extra-fila');
      tr.innerHTML = `
        <td><input type="text" value="Horas Extra" readonly></td>
        <td><input type="number" min="1" value="1" class="cantidad-horas-extra" style="width:65px;"></td>
        <td><input type="number" min="1" value="${precioHora}" class="precio-horas-extra" style="width:90px;"></td>
        <td class="total">L. ${Number(precioHora).toFixed(2)}</td>
        <td><button type="button" class="btn-remove">×</button></td>
      `;

      const qty = tr.querySelector('.cantidad-horas-extra');
      const prc = tr.querySelector('.precio-horas-extra');
      const update = () => {
        const total = (Number(qty.value) || 0) * (Number(prc.value) || 0);
        tr.querySelector('.total').textContent = `L. ${total.toFixed(2)}`;
        recalcTotales('eventos');
      };

      qty.oninput = update;
      prc.oninput = update;
      tr.querySelector('.btn-remove').onclick = () => {
        tr.remove();
        recalcTotales('eventos');
      };

      tbody.appendChild(tr);
      update();
    };
  }
});

// ===== FUNCIONES DE CARGA =====
async function loadClientes() { 
  const r = await axios.get(`${API_BASE}/api/clientes`); 
  return r.data.data; 
}

async function loadEmpleados() { 
  const r = await axios.get(`${API_BASE}/api/empleados`); 
  return r.data.data; 
}

async function loadEventos() { 
  const r = await axios.get(`${API_BASE}/api/eventos`); 
  return r.data.data; 
}

async function loadBoletos() { 
  const r = await axios.get(`${API_BASE}/api/boletos-taquilla`); 
  return r.data.data; 
}

async function loadAdicionales() { 
  const r = await axios.get(`${API_BASE}/api/adicionales`); 
  return r.data.data; 
}

async function loadPaquetes() { 
  const r = await axios.get(`${API_BASE}/api/paquetes`); 
  return r.data.data; 
}

async function loadInventario() { 
  const r = await axios.get(`${API_BASE}/api/inventario`); 
  return r.data.data; 
}

async function loadSalones() {
  const res = await axios.get(`${API_BASE}/api/salones`);
  return res.data.data;
}

async function loadDescuentosConfig() {
  try {
    const res = await axios.get(`${API_BASE}/api/descuentos`);
    descuentosConfig = {
      descuento: res.data.descuento_otorgado,
      rebaja:    res.data.rebaja_otorgada,
      exento:    res.data.importe_exento
    };
    
    ['recorrido','taquilla','eventos','libros','obras'].forEach(tipo => {
      const d = document.getElementById(`descuento-pct-${tipo}`);
      const r = document.getElementById(`rebaja-pct-${tipo}`);
      const e = document.getElementById(`exento-pct-${tipo}`);
      if (d) d.textContent = descuentosConfig.descuento;
      if (r) r.textContent = descuentosConfig.rebaja;
      if (e) e.textContent = descuentosConfig.exento;
    });
  } catch (err) {
    console.error('Error cargando descuentos:', err);
  }
}

async function loadLibros() {
  const r = await axios.get(`${API_BASE}/api/libros`);
  return r.data.data.map(l => ({
    cod_producto: l.cod_libro,
    nombre: l.nombre,
    precio: l.precio
  }));
}

async function fillSelectClientesNuevoEvento() {
  try {
    const res = await axios.get(`${API_BASE}/api/clientes`);
    const select = document.getElementById('select-cliente-nuevo-evento');
    if (!select) return;
    select.innerHTML = '<option value="">Seleccione cliente...</option>';
    res.data.data.forEach(c => {
      select.innerHTML += `<option value="${c.cod_cliente}">${c.nombre} (${c.rtn || 'Sin RTN'})</option>`;
    });
  } catch (err) {
    console.error('Error cargando clientes para nuevo evento:', err);
  }
}

const stateMap = {};
['recorrido','taquilla','eventos','libros','obras'].forEach(tipo => {
  stateMap[tipo] = {
    gRate: null,
    iRate: null,
    exoAmt: 0,
    hasExo: false,
    hasDesc: false,
    hasReb: false,
    hasEx: false
  };
});

function recalcAll(tipoFactura) {
  const state = stateMap[tipoFactura];

  // 1) bruto de ítems
  let bruto = 0;
  document.querySelectorAll(
    `#boletos-container-${tipoFactura} tr, #productos-container-${tipoFactura} tr`
  ).forEach(tr => {
    bruto += parseFloat(tr.querySelector('.total')?.textContent.replace(/L\.\s?/, '')||0);
  });

  // 2) porcentajes fijos de API
  const p = descuentosConfig;
  const descAmt   = state.hasDesc ? bruto * (p.descuento/100) : 0;
  const rebAmt    = state.hasReb  ? bruto * (p.rebaja/100)   : 0;
  const exentoAmt = state.hasEx   ? bruto * (p.exento/100)   : 0;
  const exoAmt    = state.hasExo  ? state.exoAmt             : 0;

  // 3) base neta
  const base = bruto - descAmt - rebAmt - exentoAmt - exoAmt;

  // 4) grabados excluyentes
  const g18 = state.gRate===18 ? base : 0;
  const g15 = state.gRate===15 ? base : 0;

  // 5) impuestos excluyentes (siempre sobre la base neta)
  const i18 = state.iRate===18 ? base * 0.18 : 0;
  const i15 = state.iRate===15 ? base * 0.15 : 0;

  // helper para pintar L. xxx
  const set = (id,val) =>
    document.getElementById(`${id}-${tipoFactura}`).textContent = `L. ${val.toFixed(2)}`;

  // 6) pintar todo
  set('grabado18', g18);
  set('grabado15', g15);
  set('impuesto18', i18);
  set('impuesto15', i15);
  set('subtotal', base);
  set('total', base + i18 + i15);
}

async function initData() {
  try {
    // Correlativo
    const corr = await axios.get(`${API_BASE}/api/correlativo/activo`);
    codCorrelativo = corr.data.data.cod_correlativo;
    siguienteNumero = corr.data.data.siguiente_numero;
    document.querySelectorAll('.numero-factura')
      .forEach(i => i.value = siguienteNumero);

    // CAI activo
    const caiRes = await axios.get(`${API_BASE}/api/cai/activo`);
    if (!caiRes.data.data) {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Necesita un CAI para hacer facturas'
      });
      document.querySelectorAll('.btn-invoice, [id^="guardar-factura-"]')
        .forEach(btn => btn.disabled = true);
      return;
    }
    caiActivo = caiRes.data.data;
    document.querySelectorAll('.cai-field')
      .forEach(i => i.value = `${caiActivo.cai} `);

    // Carga de listas
    [clientes, empleados, eventos, boletosDisponibles,
      adicionalesDisponibles, paquetesDisponibles, inventarioDisponibles, librosDisponibles, salonesDisponibles] =
      await Promise.all([
        loadClientes(), loadEmpleados(), loadEventos(),
        loadBoletos(), loadAdicionales(), loadPaquetes(),
        loadInventario(), loadLibros(), loadSalones(), loadDescuentosConfig()
      ]);

    fillAllSelects();
  } catch (err) {
    console.error('Error cargando datos iniciales', err);
    Swal.fire({
      icon: 'error',
      title: 'Error al cargar datos',
      text: err.response?.data?.message || err.message
    });
  }
}

function fillAllSelects() {
  ['recorrido', 'taquilla', 'eventos', 'libros', 'obras'].forEach(tipo => {
    // Clientes
    const csel = document.getElementById(`cliente-${tipo}`);
    if (csel) {
      csel.innerHTML = '<option value="">Seleccione...</option>';
      clientes.forEach(c => {
        csel.innerHTML += `<option value="${c.cod_cliente}"
                             data-rtn="${c.rtn}"
                             data-dir="${c.direccion}">${c.nombre} (${c.rtn || 'Sin RTN'})</option>`;
      });
    }
    // Empleados
    const esel = document.getElementById(`empleado-${tipo}`);
    if (esel) {
      esel.innerHTML = '<option value="">Seleccione...</option>';
      empleados.forEach(e => {
        esel.innerHTML += `<option value="${e.cod_empleado}">${e.nombre} (${e.cargo})</option>`;
      });
    }
    // Eventos
    if (tipo === 'eventos') {
      const evsel = document.getElementById('evento-eventos');
      if (evsel) {
        evsel.innerHTML = '<option value="">Seleccione...</option>';
        eventos.forEach(ev => {
          const nombreEv = ev.nombre_evento || ev.nombre || '(Sin nombre)';
          if (ev.cod_evento && nombreEv !== 'undefined')
            evsel.innerHTML += `<option value="${ev.cod_evento}">${nombreEv}</option>`;
        });
      }
    }
  });
}

// ===== INLINE NUEVO CLIENTE =====
function setupInlineNewClient() {
  ['recorrido', 'taquilla', 'eventos', 'libros', 'obras'].forEach(tipo => {
    const btnNuevo = document.getElementById(`btn-nuevo-cliente-${tipo}`);
    const btnCancelar = document.getElementById(`cancelar-nuevo-cliente-${tipo}`);
    const btnGuardar = document.getElementById(`guardar-nuevo-cliente-${tipo}`);
    
    if (btnNuevo) {
      btnNuevo.onclick = () => {
        fillMunicipioSelect(tipo);
        const form = document.getElementById(`form-nuevo-cliente-${tipo}`);
        if (form) form.style.display = 'block';
      };
    }
    
    if (btnCancelar) {
    btnCancelar.onclick = () => {
  const container = document.getElementById(`form-nuevo-cliente-${tipo}`);
  if (container) {
    // 1) Limpiar todos los campos
    container.querySelectorAll('input, select, textarea').forEach(el => {
      if (el.tagName === 'SELECT') el.selectedIndex = 0;
      else el.value = '';
    });
    // 2) Ocultar el contenedor
    container.style.display = 'none';
  }
};
    }
    
    if (btnGuardar) {
   btnGuardar.onclick = async () => {
  const nombre = document.getElementById(`new-nombre-${tipo}`)?.value.trim();
  const fechaNacimientoStr = document.getElementById(`new-fecha-${tipo}`)?.value;
  const rtn   = document.getElementById(`new-rtn-${tipo}`)?.value;
  const dni   = document.getElementById(`new-dni-${tipo}`)?.value;
  const telefono = document.getElementById(`new-telefono-${tipo}`)?.value.trim();
  const direccionInput = document.getElementById(`new-direccion-${tipo}`);
  const direccion      = direccionInput.value.trim();

  // 1) Nombre
  if (!nombre) {
    const input = document.getElementById(`new-nombre-${tipo}`);
    showErrorAndClear(input,
      'Nombre requerido',
      'Por favor ingrese el nombre del cliente'
    );
    return;
  }
if (/^([A-Za-z])\1\1/.test(nombre)) {
  const input = document.getElementById(`new-nombre-${tipo}`);
  showErrorAndClear(input,
    'Nombre inválido',
    'Ingrese un nombre real'
  );
  return;
}
  // 2) Edad ≥ 18 años
  if (fechaNacimientoStr) {
    const fechaNacimiento = new Date(fechaNacimientoStr);
    const hoy = new Date();
    let edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
    const mes = hoy.getMonth() - fechaNacimiento.getMonth();
    const dia = hoy.getDate() - fechaNacimiento.getDate();
    if (mes < 0 || (mes === 0 && dia < 0)) edad--;
    const esMayor18 = edad > 18 || (edad === 18 && (mes > 0 || (mes === 0 && dia >= 0)));
    if (!esMayor18) {
      const input = document.getElementById(`new-fecha-${tipo}`);
      showErrorAndClear(input,
        'Edad inválida',
        'El cliente debe tener al menos 18 años'
      );
      return;
    }
  }

  // 3) RTN (si existe) debe empezar con 0801
  if (rtn && !rtn.startsWith('0801')) {
    const input = document.getElementById(`new-rtn-${tipo}`);
    showErrorAndClear(input,
      'RTN inválido',
      'El RTN debe comenzar con 0801'
    );
    return;
  }

  // 4) DNI (si existe) 13 dígitos y empieza 0801
  if (dni && (!dni.startsWith('0801') || dni.length !== 13)) {
    const input = document.getElementById(`new-dni-${tipo}`);
    showErrorAndClear(input,
      'DNI inválido',
      'El DNI debe tener 13 dígitos y comenzar con 0801'
    );
    return;
  }

  // 5) Teléfono (si no está vacío) — 8 dígitos
  if (telefono !== '' && telefono.length !== 8) {
    const input = document.getElementById(`new-telefono-${tipo}`);
    showErrorAndClear(input,
      'Teléfono inválido',
      'El número de teléfono debe tener exactamente 8 dígitos'
    );
    return;
  }

  // 6) Teléfono comienza con 3, 8 o 9
  if (telefono !== '' && !/^[389]/.test(telefono)) {
    const input = document.getElementById(`new-telefono-${tipo}`);
    showErrorAndClear(input,
      'Número inválido',
      'Ingrese un número de celular real'
    );
    return;
  }

  // 7) Teléfono no repetido
  const telefonoRepetido = clientes.some(c => c.telefono === telefono);
  if (telefonoRepetido) {
    const input = document.getElementById(`new-telefono-${tipo}`);
    showErrorAndClear(input,
      'Teléfono repetido',
      'Este número de teléfono ya está registrado para otro cliente'
    );
    return;
  }
if (direccion && /^([A-Za-z])\1\1/.test(direccion)) {
  const inputDir = document.getElementById(`new-direccion-${tipo}`);
  showErrorAndClear(inputDir,
    'Dirección inválida',
    'Ingrese una dirección real'
  );
  return;
}

        try {
          const payload = {
            nombre: nombre,
            fecha_nacimiento: document.getElementById(`new-fecha-${tipo}`)?.value || null,
            sexo: document.getElementById(`new-sexo-${tipo}`)?.value || null,
            dni: document.getElementById(`new-dni-${tipo}`)?.value || null,
            correo: document.getElementById(`new-correo-${tipo}`)?.value || null,
            telefono: document.getElementById(`new-telefono-${tipo}`)?.value || null,
            direccion: document.getElementById(`new-direccion-${tipo}`)?.value || null,
            cod_municipio: Number(document.getElementById(`new-municipio-${tipo}`)?.value) || null,
            rtn: document.getElementById(`new-rtn-${tipo}`)?.value || null,
            tipo_cliente: document.getElementById(`new-tipo-${tipo}`)?.value || null
          };
          
          const res = await axios.post(`${API_BASE}/api/clientes`, payload);
          clientes.push({
            cod_cliente: res.data.data.cod_cliente,
            nombre: payload.nombre,
            rtn: payload.rtn,
            direccion: payload.direccion
          });
          
          fillAllSelects();
          const selCliente = document.getElementById(`cliente-${tipo}`);
          if (selCliente) {
            selCliente.value = res.data.data.cod_cliente;
            selCliente.dispatchEvent(new Event('change'));
          }
          
          Swal.fire({
            icon: 'success',
            title: 'Cliente creado',
            text: 'El cliente se ha creado exitosamente'
          });
          
         const container = document.getElementById(`form-nuevo-cliente-${tipo}`);
if (container) {
  container.querySelectorAll('input, select, textarea').forEach(el => {
    if (el.tagName === 'SELECT') el.selectedIndex = 0;
    else el.value = '';
  });
  container.style.display = 'none';
}
        } catch (err) {
          console.error('Error creando cliente:', err);
          Swal.fire({
            icon: 'error',
            title: 'Error al crear cliente',
            text: err.response?.data?.message || err.message
          });
        }
      };
    }
  });
}

// ===== BOTONES PARA AGREGAR FILAS DINÁMICAS =====
function setupAddButtons() {
  ['recorrido', 'taquilla', 'obras'].forEach(tipo => {
    const btn = document.getElementById(`agregar-boleto-${tipo}`);
    if (btn) btn.onclick = () => agregarBoletoFila(`boletos-container-${tipo}`, tipo);
  });
  
 ['recorrido', 'taquilla', 'eventos', 'libros', 'obras'].forEach(tipo => {
    const btn = document.getElementById(`agregar-producto-${tipo}`);
    if (btn) btn.onclick = () => agregarProductoFila(`productos-container-${tipo}`, tipo);
  });
}

function agregarBoletoFila(containerId, tipo) {
  if (!canAddItem(tipo)) return;

  const tbody = document.getElementById(containerId);
  if (!tbody) return;
  
  const tr = document.createElement('tr');
  tr.innerHTML = `
    <td>
      <select required>
        <option value="">Seleccione...</option>
        ${boletosDisponibles.map(b =>
          `<option value="${b.cod_boleto}" data-precio="${b.precio}">
             ${b.tipo} (L. ${b.precio})
           </option>`
        ).join('')}
      </select>
    </td>
    <td><input type="number" min="1" value="1" class="cantidad" required style="width:65px;"></td>
    <td><input type="number" class="precio" readonly style="width:90px;"></td>
    <td class="total">L. 0.00</td>
    <td><button type="button" class="btn-remove">×</button></td>
  `;
  
  tbody.appendChild(tr);
  const sel = tr.querySelector('select'),
    qty = tr.querySelector('.cantidad'),
    prc = tr.querySelector('.precio'),
    btn = tr.querySelector('.btn-remove');
  
  if (sel) sel.onchange = () => { 
    prc.value = sel.selectedOptions[0].dataset.precio; 
    calcularTotalFila(tr); 
    recalcTotales(tipo); 
  };
  
  if (qty) qty.oninput = () => { 
    calcularTotalFila(tr); 
    recalcTotales(tipo); 
  };
  
  if (btn) btn.onclick = () => { 
    tr.remove(); 
    recalcTotales(tipo); 
  };
}

function agregarProductoFila(containerId, tipo) {
  if (!canAddItem(tipo)) return;

  let lista;
  if (tipo === 'taquilla') {
    lista = adicionalesDisponibles;
  }

  if (tipo === 'recorrido') {
    lista = paquetesDisponibles;
    
  } else if (tipo === 'eventos') {
    lista = [
      ...salonesDisponibles.map(p => ({ cod_producto: `salon-${p.cod_salon}`, nombre: `SALÓN: ${p.nombre}`, precio: p.precio_dia })),
      ...inventarioDisponibles.map(p => ({ cod_producto: `inv-${p.cod_inventario}`, nombre: `INVENTARIO: ${p.nombre}`, precio: p.precio_unitario }))
    ];
  } else if (tipo === 'libros') {
    lista = librosDisponibles;
  } else if (tipo === 'obras') {
    lista = adicionalesDisponibles;
  }

  const tbody = document.getElementById(containerId);
  if (!tbody) return;
  
  const tr = document.createElement('tr');
  tr.innerHTML = `
    <td>
      <select required>
        <option value="">Seleccione...</option>
        ${lista.map(p =>
          `<option value="${p.cod_producto}" data-precio="${p.precio}">
             ${p.nombre} (L. ${p.precio})
           </option>`
        ).join('')}
      </select>
    </td>
    <td><input type="number" min="1" value="1" class="cantidad" required style="width:65px;"></td>
    <td><input type="number" class="precio" readonly style="width:90px;"></td>
    <td class="total">L. 0.00</td>
    <td><button type="button" class="btn-remove">×</button></td>
  `;
  
  tbody.appendChild(tr);
  const sel = tr.querySelector('select'),
    qty = tr.querySelector('.cantidad'),
    prc = tr.querySelector('.precio'),
    btn = tr.querySelector('.btn-remove');
  
  if (sel) sel.onchange = () => { 
    prc.value = sel.selectedOptions[0].dataset.precio; 
    calcularTotalFila(tr); 
    recalcTotales(tipo); 
  };
  
  if (qty) qty.oninput = () => { 
    calcularTotalFila(tr); 
    recalcTotales(tipo); 
  };
  
  if (btn) btn.onclick = () => { 
    tr.remove(); 
    recalcTotales(tipo); 
  };
}
function agregarAdicionalRecorrido() {
  if (!canAddItem('recorrido')) return; // respeta el límite de 5 ítems

  const tbody = document.getElementById('productos-container-recorrido');
  if (!tbody) return;

  const tr = document.createElement('tr');
  tr.innerHTML = `
    <td>
      <select required>
        <option value="">Seleccione adicional...</option>
        ${adicionalesDisponibles.map(a =>
          `<option value="${a.cod_producto}" data-precio="${a.precio}">
            ${a.nombre} (L. ${a.precio})
          </option>`
        ).join('')}
      </select>
    </td>
    <td><input type="number" min="1" value="1" class="cantidad" required style="width:65px;"></td>
    <td><input type="number" class="precio" readonly style="width:90px;"></td>
    <td class="total">L. 0.00</td>
    <td><button type="button" class="btn-remove">×</button></td>
  `;

  tbody.appendChild(tr);

  const sel = tr.querySelector('select');
  const qty = tr.querySelector('.cantidad');
  const prc = tr.querySelector('.precio');
  const btn = tr.querySelector('.btn-remove');

  if (sel) sel.onchange = () => {
    prc.value = sel.selectedOptions[0].dataset.precio;
    calcularTotalFila(tr);
    recalcTotales('recorrido');
  };

  if (qty) qty.oninput = () => {
    calcularTotalFila(tr);
    recalcTotales('recorrido');
  };

  if (btn) btn.onclick = () => {
    tr.remove();
    recalcTotales('recorrido');
  };
}
function calcularTotalFila(tr) {
  const c = Number(tr.querySelector('.cantidad')?.value) || 0;
  const p = Number(tr.querySelector('.precio')?.value) || 0;
  const total = c * p;
  const totalTd = tr.querySelector('.total');
  if (totalTd) totalTd.textContent = `L. ${total.toFixed(2)}`;
}

function recalcTotales(tipo) {
  let selector;
  if (tipo === 'recorrido'|| tipo === 'obras')  {
    selector = `#boletos-container-${tipo} tr, #productos-container-${tipo} tr`;
  } else if (tipo === 'taquilla') {
    selector = '#boletos-container-taquilla tr';
  } else {
    selector = `#productos-container-${tipo} tr`;
  }

  let sub = 0;
  document.querySelectorAll(selector).forEach(tr => {
    const td = tr.querySelector('.total');
    if (td) sub += parseFloat(td.textContent.replace(/L\.\s?/, '')) || 0;
  });

  document.getElementById(`subtotal-${tipo}`).textContent = `L. ${sub.toFixed(2)}`;
  document.getElementById(`total-${tipo}`).textContent = `L. ${sub.toFixed(2)}`;
}

// ===== GUARDAR FACTURA =====
function setupSaveFacturaButtons(tipos) {
  tipos.forEach(tipo => {
    const btn = document.getElementById(`guardar-factura-${tipo}`);
    if (btn) btn.onclick = () => guardarFactura(tipo);
  });
}


async function guardarFactura(tipo) {
  const Pref = tipo.charAt(0).toUpperCase() + tipo.slice(1);

  // ——— VALIDACIONES ANTES DE CONTINUAR ———
  const form = document.getElementById(`form-factura-${tipo}`);
  if (!form) {
    Swal.fire({
      icon: 'error',
      title: 'Error interno',
      text: `No existe el formulario para tipo "${tipo}"`
    });
    return;
  }

  // Número de factura
  const numeroFact = form.querySelector('.numero-factura')?.value.trim();
  if (!numeroFact) {
    Swal.fire({
      icon: 'error',
      title: 'Falta número de factura',
      text: 'El número de factura es obligatorio'
    });
    return;
  }

  // Cliente (si no selecciona, usar/crear "CONSUMIDOR FINAL")
  const clienteEl = document.getElementById(`cliente-${tipo}`);
  let codCli, dir, rtn;

  if (!clienteEl?.value) {
    const cf = await ensureDefaultCF();
    codCli = cf.cod_cliente;
    dir    = cf.direccion || 'S/D';
    rtn    = cf.rtn || DEFAULT_CF.rtn;

    // (Opcional) reflejarlo visualmente en el <select>
    if (clienteEl) {
      clienteEl.value = codCli;
      clienteEl.dispatchEvent(new Event('change'));
    }
  } else {
    codCli = clienteEl.value;
    dir    = clienteEl.selectedOptions[0].dataset.dir;
    rtn    = clienteEl.selectedOptions[0].dataset.rtn;
  }

  // Filas según tipo
  let filas;
  if (tipo === 'recorrido') {
    filas = [
      ...document.querySelectorAll('#boletos-container-recorrido tr'),
      ...document.querySelectorAll('#productos-container-recorrido tr')
    ];
  } else if (tipo === 'obras') {
    filas = [
      ...document.querySelectorAll('#boletos-container-obras tr'),
      ...document.querySelectorAll('#productos-container-obras tr')
    ];
  } else if (tipo === 'taquilla') {
    filas = Array.from(document.querySelectorAll('#boletos-container-taquilla tr'));
  } else {
    filas = Array.from(document.querySelectorAll(`#productos-container-${tipo} tr`));
  }

  if (filas.length === 0) {
    Swal.fire({
      icon: 'error',
      title: 'Sin productos o boletos',
      text: 'Debe agregar al menos un producto o boleto'
    });
    return;
  }

  // Total > 0
  const totalEl = document.getElementById(`total-${tipo}`);
  const totalNum = parseFloat(totalEl?.textContent.replace('L.', '').trim()) || 0;
  if (isNaN(totalNum) || totalNum <= 0) {
    Swal.fire({
      icon: 'error',
      title: 'Total inválido',
      text: 'El total de la factura debe ser mayor que 0'
    });
    return;
  }

  // Empleado (si existe campo)
  const empEl = document.getElementById(`empleado-${tipo}`);
  if (empEl && !empEl.value) {
    Swal.fire({
      icon: 'error',
      title: 'Falta empleado',
      text: 'Debe seleccionar un empleado'
    });
    return;
  }

  // Evento (solo para tipo "eventos")
  if (tipo === 'eventos') {
    const evEl = document.getElementById('evento-eventos');
    if (!evEl?.value) {
      Swal.fire({
        icon: 'error',
        title: 'Falta evento',
        text: 'Debe seleccionar un evento'
      });
      return;
    }
  }
  // ——— FIN VALIDACIONES ———

  // Candado anti-spam + loader
  if (!startGeneratingLock()) {
    Swal.fire({
      icon: 'info',
      title: 'Generando factura',
      text: 'Ya hay una factura en proceso. Espera a que se abra el resumen.'
    });
    return;
  }

  // Recabar detalles
  const detalles = filas.map(tr => {
    const sel = tr.querySelector('select');
    const qty = Number(
      tr.querySelector('.cantidad')?.value ||
      tr.querySelector('.cantidad-horas-extra')?.value ||
      0
    );
    const pri = Number(
      tr.querySelector('.precio')?.value ||
      tr.querySelector('.precio-horas-extra')?.value ||
      0
    );
    const tot = qty * pri;
    const desc = sel
      ? sel.selectedOptions[0].text
      : tr.querySelector('input[type="text"]').value;

    let tipoDet;
    if (tr.closest('tbody').id.startsWith('boletos-container'))       tipoDet = 'Entrada';
    else if (tipo === 'recorrido')                                   tipoDet = 'Adicional';
    else if (tipo === 'eventos' && desc === 'Horas Extra')           tipoDet = 'Extra';
    else if (tipo === 'eventos')                                     tipoDet = 'Paquete';
    else if (tipo === 'libros')                                      tipoDet = 'Libro';
    else if (tipo === 'obras')                                       tipoDet = 'Obra';
    else                                                             tipoDet = 'Inventario';

    return {
      cantidad: qty,
      precio_unitario: pri,
      total: tot,
      tipo: tipoDet,
      descripcion: desc
    };
  });

  // 2) datos de la cabecera
  const nf = form.querySelector('.numero-factura').value;
  const notas = document.getElementById(`nota-${tipo}`).value;
  const tipoMap = {
    recorrido: 'Recorrido Escolar',
    taquilla: 'Taquilla General',
    eventos: 'Evento',
    libros: 'Libros',
    obras: 'Obras'
  };

  const getVal = id =>
    parseFloat(
      document
        .getElementById(`${id}-${tipo}`)
        .textContent
        .replace('L. ', '')
    ) || 0;

  const now = new Date();
  const yyyy = now.getFullYear();
  const mm = String(now.getMonth() + 1).padStart(2, '0');
  const dd = String(now.getDate()).padStart(2, '0');
  const fechaLocal = `${yyyy}-${mm}-${dd}`;

  const payloadCabecera = {
    numero_factura: nf,
    fecha_emision: fechaLocal,
    cod_cliente: codCli,
    direccion: dir,
    rtn: rtn,
    cod_cai: caiActivo.cod_cai,
    tipo_factura: tipoMap[tipo],

    descuento_otorgado: getVal('descuento-valor'),
    rebajas_otorgadas: getVal('rebaja-valor'),
    importe_exento: getVal('exento-valor'),

    importe_gravado_18: getVal('grabado18'),
    importe_gravado_15: getVal('grabado15'),
    impuesto_18: getVal('impuesto18'),
    impuesto_15: getVal('impuesto15'),
    importe_exonerado: getVal('exonerado'),

    subtotal: getVal('subtotal'),
    total_pago: getVal('total'),

    observaciones: notas
  };

  try {
    const { data } = await axios.post(`${API_BASE}/api/facturas`, payloadCabecera);
    
    // Guardar detalles
    for (let d of detalles) {
      await axios.post(`${API_BASE}/api/facturas/detalle`, {
        cod_factura: data.data.cod_factura,
        ...d
      });
    }
    
    // actualiza correlativo
  // 1) Llamo al SP para que incremente en la base


// 2) Releo el correlativo ya incrementado
const respCorr = await axios.get(`${API_BASE}/api/correlativo/activo`);
const nuevoNum = respCorr.data.data.siguiente_numero;

// 3) Actualizo el campo en pantalla
document.querySelectorAll('.numero-factura').forEach(i => i.value = nuevoNum);
siguienteNumero = nuevoNum;


  // 4) marcar la cotización del evento como completada
 if (tipo === 'eventos') {
  const codEvento = document.getElementById('evento-eventos').value;
  if (codEvento) {
    await axios.put(`${API_BASE}/api/eventos/${codEvento}/completar`);

    // Actualizar el select de eventos para eliminar el evento completado
    const selectEvento = document.getElementById('evento-eventos');
    const options = selectEvento.options;

    // Buscar el evento completado y eliminarlo del select
    for (let i = 0; i < options.length; i++) {
      if (options[i].value == codEvento) {
        selectEvento.remove(i);  // Aquí eliminamos el evento completado
        break; // Salimos del loop una vez encontrado
      }
    }
  }
}

    // Cerramos el loader justo antes de mostrar el modal
    closeGeneratingAlert();

    // Mostrar modal de visualización
    await mostrarModalFacturaGenerada(data.data.cod_factura, tipoMap[tipo]);
    
    clearForm(tipo);
  } catch (e) {
    // Asegura cerrar loader si hubo error y mostrar alerta de error
    closeGeneratingAlert();
    console.error(e.response?.data || e);
    Swal.fire({ 
      icon: 'error', 
      title: 'Error al guardar', 
      text: e.response?.data?.mensaje || e.message 
    });
  } finally {
    // Soltamos el candado y reactivamos botones
    releaseGeneratingLock();
  }
}

// Función para mostrar el modal con la factura generada
async function mostrarModalFacturaGenerada(codFactura, tipoFactura) {
  try {
    // Obtener datos de la factura
    const [facturaRes, detalleRes] = await Promise.all([
      axios.get(`${API_BASE}/api/facturas/${codFactura}`),
      axios.get(`${API_BASE}/api/facturas/${codFactura}/detalle`)
    ]);
    
    const factura = facturaRes.data.data;
    const detalles = detalleRes.data.data || [];
    const cliente = clientes.find(c => c.cod_cliente == factura.cod_cliente) || {};
    
    // Generar HTML del modal
    const filasDetalle = detalles.map(d => `
      <tr>
        <td>${d.cantidad}</td>
        <td>${d.descripcion}</td>
        <td>L. ${parseFloat(d.precio_unitario).toFixed(2)}</td>
        <td>L. ${parseFloat(d.total).toFixed(2)}</td>
      </tr>
    `).join('');
    
    const html = `
      <div class="modal-content" style="max-width: 800px;">
        <span class="close" data-close="facturaGeneradaModal">&times;</span>
        <h2>Factura N° ${factura.numero_factura}</h2>
        <p><strong>Tipo:</strong> ${tipoFactura}</p>
        <p><strong>Empresa:</strong> Fundación por Futuro</p>
        <p><strong>RTN Empresa:</strong> 0801199912345</p>
        <p><strong>CAI:</strong> ${caiActivo.cai}</p>
        <p><strong>Rango válido:</strong> ${caiActivo.rango_desde} – ${caiActivo.rango_hasta}</p>
        <p><strong>Fecha Emisión:</strong> ${factura.fecha_emision.split('T')[0]}</p>
        <p><strong>Cliente:</strong> ${cliente.nombre || '—'}</p>
        <p><strong>RTN Cliente:</strong> ${factura.rtn || '—'}</p>
        <p><strong>Dirección:</strong> ${cliente.direccion || '—'}</p>
        <hr>
        <table border="1" width="100%" cellpadding="4" style="margin-bottom: 20px;">
          <tr>
            <th>Cant.</th><th>Descripción</th><th>P.Unit.</th><th>Total</th>
          </tr>
          ${filasDetalle}
        </table>
        <hr>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
          <div>
            <p><strong>Descuento otorgado:</strong> L. ${parseFloat(factura.descuento_otorgado).toFixed(2)}</p>
            <p><strong>Rebajas otorgadas:</strong> L. ${parseFloat(factura.rebajas_otorgadas).toFixed(2)}</p>
            <p><strong>Importe exento:</strong> L. ${parseFloat(factura.importe_exento).toFixed(2)}</p>
            <p><strong>Importe gravado 18%:</strong> L. ${parseFloat(factura.importe_gravado_18).toFixed(2)}</p>
            <p><strong>Importe gravado 15%:</strong> L. ${parseFloat(factura.importe_gravado_15).toFixed(2)}</p>
          </div>
          <div>
            <p><strong>Impuesto 18%:</strong> L. ${parseFloat(factura.impuesto_18).toFixed(2)}</p>
            <p><strong>Impuesto 15%:</strong> L. ${parseFloat(factura.impuesto_15).toFixed(2)}</p>
            <p><strong>Importe exonerado:</strong> L. ${parseFloat(factura.importe_exonerado).toFixed(2)}</p>
            <p><strong>Subtotal:</strong> L. ${parseFloat(factura.subtotal).toFixed(2)}</p>
            <p><strong>Total:</strong> L. ${parseFloat(factura.total_pago).toFixed(2)}</p>
          </div>
        </div>
        <div style="margin-top: 20px; display: flex; justify-content: space-between;">
          <a href="/facturas/pdf/${codFactura}" class="btn btn-primary" download>
            <i class="fas fa-download"></i> Descargar PDF
          </a>
          <button id="btnEnviarCorreo" class="btn btn-success">
            <i class="fas fa-envelope"></i> Enviar por correo
          </button>
          <button class="btn btn-secondary" onclick="document.getElementById('facturaGeneradaModal').style.display='none'">
            <i class="fas fa-times"></i> Cerrar
          </button>
        </div>
      </div>
    `;
    
    // Crear o actualizar el modal
    let modal = document.getElementById('facturaGeneradaModal');
    if (!modal) {
      modal = document.createElement('div');
      modal.id = 'facturaGeneradaModal';
      modal.className = 'modal';
      modal.style.display = 'none';
      document.body.appendChild(modal);
    }
    
    modal.innerHTML = html;
    modal.style.display = 'flex';
    
    // Configurar evento para cerrar modal
    modal.querySelector('.close').onclick = () => {
      modal.style.display = 'none';
    };
    
    // Configurar botón de enviar correo
    document.getElementById('btnEnviarCorreo').onclick = async () => {
      try {
        const result = await Swal.fire({
          title: '¿Enviar factura por correo?',
          text: `Se enviará al correo del cliente: ${cliente.correo || 'No tiene correo registrado'}`,
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: 'Enviar',
          cancelButtonText: 'Cancelar'
        });
        
        if (result.isConfirmed) {
          const response = await axios.post(`/facturas/${codFactura}/enviar-correo`);
          if (response.data.success) {
            Swal.fire('¡Éxito!', 'La factura ha sido enviada por correo', 'success');
          } else {
            throw new Error(response.data.message || 'Error al enviar el correo');
          }
        }
      } catch (error) {
        Swal.fire('Error', error.response?.data?.message || error.message || 'Error al enviar el correo', 'error');
      }
    };
    
    // Mostrar mensaje de éxito
    Swal.fire({
      icon: 'success',
      title: 'Factura generada',
      text: `La factura ${factura.numero_factura} se ha creado correctamente`,
      timer: 2000,
      showConfirmButton: false
    });
    
  } catch (error) {
    console.error('Error al mostrar modal de factura:', error);
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'Se generó la factura pero no se pudo mostrar el resumen. ' + (error.message || '')
    });
  }
}

// Añadir esto al DOMContentLoaded para crear el modal base si no existe
document.addEventListener('DOMContentLoaded', () => {
  if (!document.getElementById('facturaGeneradaModal')) {
    const modal = document.createElement('div');
    modal.id = 'facturaGeneradaModal';
    modal.className = 'modal';
    modal.style.display = 'none';
    document.body.appendChild(modal);
  }
});

function buildNextNumber(current) {
  if (!current || !current.includes('-')) {
    throw new Error(`Número inválido para siguienteNúmero: "${current}"`);
  }
  const [pre, num] = current.split('-');
  const nxt = String(Number(num) + 1).padStart(num.length, '0');
  return `${pre}-${nxt}`;
}

// ===== APLICAR DESCUENTO, REBAJA, EXENTO, IMPUESTOS, ETC. =====
function aplicar(tipoValor, tipoFactura) {
  const state = stateMap[tipoFactura];

  // subtotal bruto de items
  let bruto = 0;
  document.querySelectorAll(
    `#boletos-container-${tipoFactura} tr, #productos-container-${tipoFactura} tr`
  ).forEach(tr => {
    bruto += parseFloat(
      tr.querySelector('.total')?.textContent.replace(/L\.\s?/, '') || 0
    );
  });

  // descuentos, rebaja y exento
  const descAmt = bruto * (descuentosConfig.descuento / 100);
  const rebAmt = bruto * (descuentosConfig.rebaja / 100);
  const exentoAmt = bruto * (descuentosConfig.exento / 100);

  // helper para pintar un solo campo
  const set = (id, val) => {
    document.getElementById(`${id}-${tipoFactura}`).textContent =
      `L. ${val.toFixed(2)}`;
  };

  switch (tipoValor) {
    case 'descuento':
      state.hasDesc = true;
      set('descuento-valor', descAmt);
      break;

    case 'rebaja':
      state.hasReb = true;
      set('rebaja-valor', rebAmt);
      break;

    case 'exento':
      state.hasEx = true;
      set('exento-valor', exentoAmt);
      break;

    case 'exonerado':
      state.hasExo = true;
      state.exoAmt = Math.max(0, bruto - descAmt - rebAmt - exentoAmt) * 0.20;
      set('exonerado', state.exoAmt);
      break;

    case 'grabado18':
      state.gRate = 18;
      state.iRate = null;
      break;

    case 'grabado15':
      state.gRate = 15;
      state.iRate = null;
      break;

   case 'impuesto18':
  state.gRate = null;
  state.iRate = 18;
  break;

case 'impuesto15':
  state.gRate = null;
  state.iRate = 15;
  break;

  }

  recalcAll(tipoFactura);
}

// Validaciones y bloqueo de caracteres especiales
document.addEventListener('DOMContentLoaded', function () {
  function soloLetras(e) {
    const char = String.fromCharCode(e.which);
    if (!/^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]$/.test(char)) e.preventDefault();
  }
  
  function soloNumeros(e) {
    const char = String.fromCharCode(e.which);
    if (!/^\d$/.test(char)) e.preventDefault();
  }
  
  function soloCorreo(e) {
    const char = String.fromCharCode(e.which);
    if (!/[a-zA-Z0-9@._-]/.test(char)) e.preventDefault();
  }
  
  function soloDireccion(e) {
    const char = String.fromCharCode(e.which);
    if (!/[a-zA-Z0-9\s#.,áéíóúÁÉÍÓÚüÜñÑ-]/.test(char)) e.preventDefault();
  }

  const campos = [
    'new-nombre-recorrido', 'new-nombre-taquilla', 'new-nombre-eventos', 'new-nombre-libros', 'new-nombre-obras',
    'new-direccion-recorrido', 'new-direccion-taquilla', 'new-direccion-eventos', 'new-direccion-libros', 'new-direccion-obras',
    'new-correo-recorrido', 'new-correo-taquilla', 'new-correo-eventos', 'new-correo-libros', 'new-correo-obras',
    'new-telefono-recorrido', 'new-telefono-taquilla', 'new-telefono-eventos', 'new-telefono-libros', 'new-telefono-obras',
    'new-dni-recorrido', 'new-dni-taquilla', 'new-dni-eventos', 'new-dni-libros', 'new-dni-obras',
    'new-rtn-recorrido', 'new-rtn-taquilla', 'new-rtn-eventos', 'new-rtn-libros', 'new-rtn-obras'
  ];

  campos.forEach(id => {
    const input = document.getElementById(id);
    if (!input) return;
    
    if (id.includes('nombre')) {
      input.addEventListener('keypress', soloLetras);
      input.addEventListener('paste', e => e.preventDefault());
    }
    else if (id.includes('telefono') || id.includes('dni') || id.includes('rtn')) {
      input.addEventListener('keypress', soloNumeros);
      input.addEventListener('paste', e => e.preventDefault());
    }
    else if (id.includes('correo')) {
      input.addEventListener('keypress', soloCorreo);
    }
    else if (id.includes('direccion')) {
      input.addEventListener('keypress', soloDireccion);
    }
  });

  document.querySelectorAll('input[type="number"]').forEach(input => {
    input.addEventListener('keypress', function (e) {
      const char = String.fromCharCode(e.which);
      if (!/^\d$/.test(char) && char !== '.') e.preventDefault();
    });
  });

  campos.forEach(id => {
    const input = document.getElementById(id);
    if (!input) return;
    
    input.addEventListener('input', function () {
      let v = input.value;
      if (id.includes('nombre')) v = v.replace(/[^a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]/g, '').substring(0, 20);
    else if (id.includes('dni')) v = v.replace(/\D/g, '').substring(0, 13);
else if (id.includes('telefono')) v = v.replace(/\D/g, '').substring(0, 8);
else if (id.includes('rtn')) v = v.replace(/\D/g, '').substring(0, 14);

      else if (id.includes('correo')) v = v.replace(/[^a-zA-Z0-9@._-]/g, '').substring(0, 30);
      else if (id.includes('direccion')) v = v.replace(/[^a-zA-Z0-9\s#.,áéíóúÁÉÍÓÚüÜñÑ-]/g, '').substring(0, 30);
      
      input.value = v;
    });
  });
});

document.addEventListener('DOMContentLoaded', function () {
  [
    'nota-recorrido',
    'nota-taquilla',
    'nota-eventos',
    'nota-libros',
    'nota-obras'
  ].forEach(function (id) {
    const campo = document.getElementById(id);
    if (!campo) return;
    
    campo.addEventListener('keypress', function (e) {
      const char = String.fromCharCode(e.which);
      if (!/[a-zA-Z0-9\s.,;:áéíóúÁÉÍÓÚüÜñÑ¿?¡!'"()\-\_]/.test(char)) e.preventDefault();
    });
    
    campo.addEventListener('input', function () {
  campo.value = campo.value
    .replace(/[^a-zA-Z0-9\s.,;:áéíóúÁÉÍÓÚüÜñÑ¿?¡!'"()\-\_]/g, '')
    .substring(0, 20);
});

  });
});
document.addEventListener('DOMContentLoaded', () => {
  // Campo Nombre del Evento y límite de caracteres
  const evName = document.getElementById('nuevo-nombre-evento');
  if (evName) {
    evName.addEventListener('keydown', function(e) {
      // ...tu validación existente...
    });
    evName.addEventListener('paste', e => e.preventDefault());
    evName.setAttribute('maxlength', '20');
    evName.addEventListener('input', () => {
      if (evName.value.length > 20) {
        evName.value = evName.value.slice(0, 20);
      }
    });
  }

  // Límite de un solo dígito para duración de horas
  const evHoras = document.getElementById('nuevo-horas-evento');
  if (evHoras) {
    evHoras.setAttribute('maxlength', '2');
    evHoras.addEventListener('input', () => {
      if (evHoras.value.length > 1) {
        evHoras.value = evHoras.value.slice(0, 2);
      }
    });
  }
  // Descripciones de producto en Nuevo Evento
  const prodCont = document.getElementById('productos-container-nuevo-evento');
  if (prodCont) {
    prodCont.addEventListener('keydown', function(e) {
      if (e.target.matches('.desc')) {
        if (!/^[a-zA-Z0-9 ]$/.test(e.key) &&
            !['Backspace','Tab','Enter','ArrowLeft','ArrowRight','Delete'].includes(e.key)) {
          e.preventDefault();
        }
      }
    });
    prodCont.addEventListener('paste', function(e) {
      if (e.target.matches('.desc')) e.preventDefault();
    });
  }
});

// Valida que el correo sea @gmail.com al perder el foco
document.querySelectorAll('input[id^="new-correo-"]').forEach(input => {
  input.addEventListener('blur', function() {
    if (!/^[^\s@]+@gmail\.com$/.test(this.value)) {
      Swal.fire({
        icon: 'error',
        title: 'Correo inválido',
        text: 'Por favor introduce un correo válido con dominio @gmail.com'
      });
      this.value = '';
    }
  });
});

// ——— Limitar a YYYY-MM-DD con año de solo 4 dígitos ———
const evFechaInput = document.getElementById('nuevo-fecha-evento');
if (evFechaInput) {
  evFechaInput.addEventListener('input', function() {
    let v = this.value;
    if (!v) return;
    const parts = v.split('-');
    // Año: máximo 4 dígitos
    if (parts[0] && parts[0].length > 4) {
      parts[0] = parts[0].slice(0, 4);
    }
    // Mes: máximo 2 dígitos
    if (parts[1] && parts[1].length > 2) {
      parts[1] = parts[1].slice(0, 2);
    }
    // Día: máximo 2 dígitos
    if (parts[2] && parts[2].length > 2) {
      parts[2] = parts[2].slice(0, 2);
    }
    this.value = parts.join('-');
  });
}

// ——— Toggle Aplicar/Cancelar ———
document.addEventListener('DOMContentLoaded', () => {
  const tiposFactura = ['recorrido','taquilla','eventos','libros','obras'];
  const tiposValor   = ['descuento','rebaja','exento','exonerado','grabado18','grabado15','impuesto18','impuesto15'];
  const resetMap     = {
    descuento: 'descuento-valor',
    rebaja:    'rebaja-valor',
    exento:    'exento-valor',
    exonerado: 'exonerado'
  };

  tiposFactura.forEach(tf => {
    tiposValor.forEach(v => {
      // buscamos el botón inline original
      const btn = document.querySelector(
        `#form-factura-${tf} button[onclick="aplicar('${v}','${tf}')"]`
      );
      if (!btn) return;

      // lo “desincrustamos”
      btn.removeAttribute('onclick');
      btn.dataset.valor      = v;
      btn.dataset.factura    = tf;

      btn.addEventListener('click', () => {
        const valor    = btn.dataset.valor;
        const factura  = btn.dataset.factura;
        const st       = stateMap[factura];

        // ¿ya estaba aplicado?
        const aplicado = {
          descuento:  st.hasDesc,
          rebaja:     st.hasReb,
          exento:     st.hasEx,
          exonerado:  st.hasExo,
          grabado18:  st.gRate===18 && st.iRate===null,
          grabado15:  st.gRate===15 && st.iRate===null,
          impuesto18: st.iRate===18,
          impuesto15: st.iRate===15
        }[valor] || false;

        if (!aplicado) {
          // aplicarlo
          aplicar(valor, factura);
          btn.textContent = 'Cancelar';
        } else {
          // revertir estado
          switch (valor) {
            case 'descuento':  st.hasDesc = false;                       break;
            case 'rebaja':     st.hasReb  = false;                       break;
            case 'exento':     st.hasEx   = false;                       break;
            case 'exonerado':  st.hasExo  = false; st.exoAmt = 0;        break;
            case 'grabado18':
            case 'grabado15':  st.gRate   = null;                        break;
            case 'impuesto18':
            case 'impuesto15': st.iRate   = null; st.gRate = null;       break;
          }

          // recalcular totales y tasas
          recalcAll(factura);

          // resetear el span visual si es uno de los valores “L. 0.00”
          if (resetMap[valor]) {
            const span = document.getElementById(`${resetMap[valor]}-${factura}`);
            if (span) span.textContent = 'L. 0.00';
          }

          btn.textContent = 'Aplicar';
        }
      });
    });
  });
});

// ——— Máscara automática para DNI (4-4-5) y RTN (4-4-6) ———
document.addEventListener('DOMContentLoaded', () => {
  /**
   * Aplica una máscara tipo "DDDD-DDDD-DDDDD" donde D es dígito.
   * @param {HTMLInputElement} input 
   * @param {string} pattern — cadena con 'D' para dígitos y cualquier otro carácter fijo
   */
  function applyMask(input, pattern) {
    input.maxLength = pattern.length;
    input.addEventListener('input', () => {
      // extrae sólo dígitos y corta al máximo de dígitos
      const nums = input.value.replace(/\D/g, '');
      let result = '';
      let idx = 0;

      for (let i = 0; i < pattern.length && idx < nums.length; i++) {
        if (pattern[i] === 'D') {
          result += nums[idx++];
        } else {
          result += pattern[i];
        }
      }
      input.value = result;
    });
  }

  // Selecciona todos los campos de DNI (id que empiece por "new-dni-")
  document.querySelectorAll('input[id^="new-dni-"]').forEach(el => {
    applyMask(el, 'DDDD-DDDD-DDDDD'); // 4-4-5 = 13 dígitos + 2 guiones
    el.placeholder = '0801-0000-00000';
  });

  // Selecciona todos los campos de RTN (id que empiece por "new-rtn-")
  document.querySelectorAll('input[id^="new-rtn-"]').forEach(el => {
    applyMask(el, 'DDDD-DDDD-DDDDDD'); // 4-4-6 = 14 dígitos + 2 guiones
    el.placeholder = '0801-0000-00000';
  });
});
// === Botón "Agregar Adicional" para Recorrido ===
const btnAdRec = document.getElementById('agregar-adicional-recorrido');
if (btnAdRec) btnAdRec.onclick = () => agregarAdicionalRecorrido();


// === Botón "Añadir Obra" (Obras) — cantidad y precio fijos en 0 ===
const btnAddObra = document.getElementById('agregar-obra-obras');
if (btnAddObra) btnAddObra.onclick = () => agregarObraFila();

function agregarObraFila() {
  if (!canAddItem('obras')) return; // respeta límite global (5)

  const tbody = document.getElementById('productos-container-obras');
  if (!tbody) return;

  const tr = document.createElement('tr');
  tr.innerHTML = `
    <td>
      <input type="text"
             class="obra-nombre"
             placeholder="Nombre o promocion de la obra"
             required
             maxlength="30"
             style="width:100%;">
    </td>
    <td><input type="number" min="0" value="0" class="cantidad" required style="width:65px;" readonly></td>
    <td><input type="number" class="precio" min="0" step="0.01" value="0" required style="width:90px;" readonly></td>
    <td class="total">L. 0.00</td>
    <td><button type="button" class="btn-remove">×</button></td>
  `;

  tbody.appendChild(tr);

  const nombre = tr.querySelector('.obra-nombre');
  const btn    = tr.querySelector('.btn-remove');

  // Validaciones de nombre (sin especiales, sin pegar, máx 30)
  nombre.addEventListener('keydown', (e) => {
    const allowed = ['Backspace','Tab','Enter','ArrowLeft','ArrowRight','Delete','Home','End'];
    if (allowed.includes(e.key)) return;
    if (!/^[a-zA-Z0-9 ]$/.test(e.key)) e.preventDefault();
  });
  nombre.addEventListener('paste', e => e.preventDefault());
  nombre.addEventListener('input', () => {
    nombre.value = nombre.value.replace(/[^a-zA-Z0-9 ]/g, '').slice(0, 30);
  });

  btn.onclick = () => { tr.remove(); recalcTotales('obras'); };

  // Totales quedan en 0; actualizamos por consistencia
  recalcTotales('obras');
}

// === No permitir guardar si hay obras sin nombre ===
const btnGuardarObras = document.getElementById('guardar-factura-obras');
if (btnGuardarObras && !btnGuardarObras.dataset.obraPatch) {
  btnGuardarObras.dataset.obraPatch = '1';
  const prevHandler = btnGuardarObras.onclick;
  btnGuardarObras.onclick = () => {
    const faltaNombre = Array.from(document.querySelectorAll('#productos-container-obras .obra-nombre'))
      .some(inp => !inp.value.trim());
    if (faltaNombre) {
      Swal.fire({ icon:'error', title:'Nombre de obra requerido', text:'Completa el nombre de todas las obras.' });
      return;
    }
    prevHandler && prevHandler();
  };
}
