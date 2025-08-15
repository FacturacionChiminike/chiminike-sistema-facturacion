// public/js/gestion-descuentos.js
document.addEventListener('DOMContentLoaded', () => {
  const API = '/api/descuentos';
  let currentId = null;

  // Captura el token CSRF que Laravel inyecta en la plantilla
  const CSRF_TOKEN = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute('content');

  const form  = document.getElementById('form-descuento');
  const tbody = document.getElementById('tabla-descuentos');

  // 1️⃣ cargar el registro único y rellenar tabla + formulario
  async function cargarDescuento() {
    tbody.innerHTML = '';
    try {
      const res = await fetch(API, { credentials: 'same-origin' });
      if (!res.ok) throw new Error(`HTTP ${res.status}`);
      const d = await res.json();            // { cod_descuento, descuento_otorgado, ... }
      currentId = d.cod_descuento;

      // pinta la fila
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>${parseFloat(d.descuento_otorgado).toFixed(2)}%</td>
        <td>${parseFloat(d.rebaja_otorgada).toFixed(2)}%</td>
        <td>${d.importe_exento}</td>
      `;
      tbody.appendChild(tr);

      // pre-rellena el formulario
      form.descuento.value = parseFloat(d.descuento_otorgado);
      form.rebaja.value    = parseFloat(d.rebaja_otorgada);
      form.importe.value   = d.importe_exento;

    } catch (err) {
      console.error(err);
      Swal.fire('Error', 'No se pudo cargar el descuento', 'error');
    }
  }

  // 2️⃣ al enviar el form: primero confirmación, luego PUT
  form.addEventListener('submit', e => {
    e.preventDefault();

    if (currentId === null) {
      return Swal.fire('Atención','No hay ningún descuento para actualizar','warning');
    }

    // SweetAlert de confirmación
    Swal.fire({
      title: '¿Seguro que quieres actualizar?',
      text: 'Se reemplazarán los valores actuales.',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Sí, actualizar',
      cancelButtonText: 'Cancelar'
    }).then(async result => {
      if (!result.isConfirmed) return;

      const payload = {
        descuento_otorgado: form.descuento.value,
        rebaja_otorgada:    form.rebaja.value,
        importe_exento:     form.importe.value
      };

      try {
        const res = await fetch(`${API}/${currentId}`, {
          method:      'PUT',
          credentials: 'same-origin',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN':  CSRF_TOKEN
          },
          body: JSON.stringify(payload)
        });
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        Swal.fire('¡Éxito!','Descuento actualizado correctamente','success');
        cargarDescuento();
      } catch (err) {
        console.error('guardarDescuento:', err);
        Swal.fire('Error','No se pudo guardar el descuento','error');
      }
    });
  });

  // 3️⃣ carga inicial
  cargarDescuento();

  // 4️⃣ Validación unificada para descuento, rebaja e importe (0–100, hasta 2 decimales)
  ['descuento','rebaja','importe'].forEach(name => {
    const inp = form.elements[name];
    inp.setAttribute('maxlength','6');      // e.g. "100.00"
    inp.setAttribute('inputmode','decimal');
    inp.addEventListener('input', e => {
      // 1) normalizar punto y eliminar todo menos dígitos y '.'
      let v = e.target.value.replace(/,/g,'.').replace(/[^0-9.]/g,'');
      // 2) sólo primer punto
      const parts = v.split('.');
      if (parts.length > 2) {
        v = parts.shift() + '.' + parts.join('');
      }
      // 3) limitar decimales a 2
      if (parts[1]) {
        parts[1] = parts[1].slice(0,2);
        v = parts.join('.');
      }
      // 4) convertir a número y clamp 0–100
      const num = parseFloat(v);
      if (!isNaN(num)) {
        if (num > 100) v = '100';
        else if (num < 0) v = '0';
      }
      e.target.value = v;
    });
  });
  
});
// 4️⃣ Limitar descuento/rebaja a 0–100 y máximo 2 dígitos (o "100")
[form.descuento, form.rebaja].forEach(input => {
  // forzamos máximo 3 caracteres y sólo dígitos
  input.setAttribute('maxlength', '3')
  input.setAttribute('inputmode', 'numeric')
  input.addEventListener('input', e => {
    let v = e.target.value.replace(/\D/g, '')    // quitamos no-dígitos
    if (v.length > 3) v = v.slice(0, 3)            // sólo hasta 3 caracteres

    // si son 3 dígitos y NO es "100", dejamos solo los dos primeros
    if (v.length === 3 && v !== '100') v = v.slice(0, 2)

    // clamp numérico: nunca >100
    if (parseInt(v, 10) > 100) v = '100'

    e.target.value = v
  })
})
