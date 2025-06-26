// userpermiso.js mejorado
document.addEventListener('DOMContentLoaded', () => {
    loadPermissions();
    
    // Event listeners
    document.getElementById('btn-refresh').addEventListener('click', loadPermissions);
    document.getElementById('search-input').addEventListener('input', filterUsers);
    document.getElementById('btn-export').addEventListener('click', exportToExcel);
    document.getElementById('btn-help').addEventListener('click', showHelpModal);
});

function loadPermissions() {
    showLoading();
    
    fetch('/permisos-usuarios')
        .then(response => response.json())
        .then(data => {
            renderPermisos(data.usuarios, data.objetos);
            updateUserCount(data.usuarios.length);
        })
        .catch(error => {
            console.error('Error al cargar permisos:', error);
            showError('Error al cargar los permisos. Intente nuevamente.');
        })
        .finally(() => hideLoading());
}

function renderPermisos(usuarios, objetos) {
    const thead = document.querySelector('.thead-permisos');
    const tbody = document.querySelector('.tbody-permisos');

    
    thead.innerHTML = '';
    tbody.innerHTML = '';

    
    const objetosMap = {};
    objetos.forEach((obj, index) => {
        objetosMap[obj] = index + 1; 
    });

  
    let header1 = '<tr><th rowspan="2" class="text-start ps-4">Usuario</th><th rowspan="2">Rol</th>';
    objetos.forEach(obj => {
        header1 += `<th colspan="4">${obj}</th>`;
    });
    header1 += '</tr>';

    let header2 = '<tr>';
    objetos.forEach(() => {
        header2 += `
            <th class="bg-c"><i class="fas fa-plus"></i></th>
            <th class="bg-r"><i class="fas fa-eye"></i></th>
            <th class="bg-u"><i class="fas fa-edit"></i></th>
            <th class="bg-d"><i class="fas fa-trash"></i></th>
        `;
    });
    header2 += '</tr>';

    thead.innerHTML = header1 + header2;

   
    usuarios.forEach(usuario => {
        let row = `<tr data-username="${usuario.nombre_usuario.toLowerCase()}">
            <td class="text-start ps-4 fw-medium">${usuario.nombre_usuario}</td>
            <td><span class="badge bg-secondary">${usuario.rol}</span></td>`;

        objetos.forEach(obj => {
            const permisos = usuario.permisos[obj] || { crear: 0, mostrar: 0, modificar: 0, eliminar: 0 };
            const codObjeto = objetosMap[obj];
            const codRol = usuario.cod_rol; 

            row += `
                <td class="bg-c"><input type="checkbox" class="permiso-checkbox" data-cod-rol="${codRol}" data-cod-objeto="${codObjeto}" data-permiso="crear" ${permisos.crear ? 'checked' : ''}></td>
                <td class="bg-r"><input type="checkbox" class="permiso-checkbox" data-cod-rol="${codRol}" data-cod-objeto="${codObjeto}" data-permiso="mostrar" ${permisos.mostrar ? 'checked' : ''}></td>
                <td class="bg-u"><input type="checkbox" class="permiso-checkbox" data-cod-rol="${codRol}" data-cod-objeto="${codObjeto}" data-permiso="modificar" ${permisos.modificar ? 'checked' : ''}></td>
                <td class="bg-d"><input type="checkbox" class="permiso-checkbox" data-cod-rol="${codRol}" data-cod-objeto="${codObjeto}" data-permiso="eliminar" ${permisos.eliminar ? 'checked' : ''}></td>
            `;
        });

        row += '</tr>';
        tbody.innerHTML += row;
    });
}


function filterUsers() {
    const searchTerm = document.getElementById('search-input').value.toLowerCase();
    const rows = document.querySelectorAll('.tbody-permisos tr');
    let visibleCount = 0;
    
    rows.forEach(row => {
        const username = row.getAttribute('data-username');
        if (username.includes(searchTerm)) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });
    
    updateUserCount(visibleCount);
}

function updateUserCount(count) {
    document.getElementById('user-count').textContent = count;
}

//EXPORTAR EXCEL COMPLETO 
function exportToExcel() {
    try {
        const tabla = document.getElementById('tabla-permisos');
        if (!tabla) {
            Swal.fire('Error', 'No se encontró la tabla para exportar.', 'error');
            return;
        }

       
        const data = [];
        
        
        const header1 = ['Usuario', 'Rol'];
        const objetos = [];
        
       
        const ths = tabla.querySelectorAll('thead tr:first-child th');
        ths.forEach((th, index) => {
            if (index >= 2) { 
                const objeto = th.textContent.trim();
                objetos.push(objeto);
               
                header1.push(objeto, '', '', '');
            }
        });
        data.push(header1);
        
        
        const header2 = ['', '']; 
        objetos.forEach(() => {
            header2.push('Crear', 'Leer', 'Actualizar', 'Eliminar');
        });
        data.push(header2);
        
        
        const filasUsuarios = tabla.querySelectorAll('tbody tr');
        filasUsuarios.forEach(fila => {
            const filaData = [];
            
            
            const usuario = fila.querySelector('td:first-child').textContent.trim();
            filaData.push(usuario);
            
           
            const rol = fila.querySelector('td:nth-child(2)').textContent.trim();
            filaData.push(rol);
            
            
            const checks = fila.querySelectorAll('input[type="checkbox"]');
            checks.forEach(check => {
                filaData.push(check.checked ? 'Sí' : 'No');
            });
            
            data.push(filaData);
        });

        
        const wb = XLSX.utils.book_new();
        const ws = XLSX.utils.aoa_to_sheet(data);

        
        const mergeRanges = [];
        let colIndex = 2; 
        
        objetos.forEach(() => {
            mergeRanges.push({
                s: { r: 0, c: colIndex }, 
                e: { r: 0, c: colIndex + 3 } 
            });
            colIndex += 4;
        });

        ws["!merges"] = mergeRanges;

        
        ws["!cols"] = [
            { wch: 25 }, 
            { wch: 20 }, 
            ...Array(objetos.length * 4).fill({ wch: 10 }) 
        ];

        
        const header1Style = {
            font: { bold: true, color: { rgb: "FFFFFF" } },
            fill: { fgColor: { rgb: "006633" } }, 
            alignment: { horizontal: "center" }
        };
        
        const header2Style = {
            font: { bold: true },
            fill: { fgColor: { rgb: "FFCC00" } }, 
            alignment: { horizontal: "center" }
        };

        
        for (let c = 0; c < data[0].length; c++) {
            
            const cellRef1 = XLSX.utils.encode_cell({ r: 0, c });
            if (!ws[cellRef1]) ws[cellRef1] = {};
            ws[cellRef1].s = header1Style;
            
            
            const cellRef2 = XLSX.utils.encode_cell({ r: 1, c });
            if (!ws[cellRef2]) ws[cellRef2] = {};
            ws[cellRef2].s = header2Style;
        }

        XLSX.utils.book_append_sheet(wb, ws, 'Permisos de Usuario');

        
        const fecha = new Date();
        const fechaStr = fecha.toLocaleDateString('es-HN', {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit'
        }).replace(/\//g, '-');
        
        XLSX.writeFile(wb, `Permisos_Usuarios_${fechaStr}.xlsx`);
        
        Swal.fire('Éxito', 'El archivo Excel se ha generado correctamente.', 'success');
        
    } catch (error) {
        console.error('Error al exportar a Excel:', error);
        Swal.fire('Error', 'Ocurrió un error al generar el archivo Excel.', 'error');
    }
}


function showHelpModal() {
    // El modal se muestra automáticamente por Bootstrap
}

function showLoading() {
    // Implementar spinner de carga
}

function hideLoading() {
    // Ocultar spinner de carga
}

function showError(message) {
    // Implementar notificación de error
    alert(message);
}

// Activar checkboxes para actualizar permisos dinámicamente
document.addEventListener('change', function (e) {
    if (e.target && e.target.matches('.permiso-checkbox')) {
        const checkbox = e.target;
        const codRol = checkbox.dataset.codRol;
        const codObjeto = checkbox.dataset.codObjeto;
        const permiso = checkbox.dataset.permiso;
        const valor = checkbox.checked ? 1 : 0;

        fetch('/permisos/actualizar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ cod_rol: codRol, cod_objeto: codObjeto, permiso, valor })
        })
        .then(res => res.json())
        .then(data => {
            Swal.fire({
                icon: 'success',
                title: 'Permiso actualizado',
                text: data.mensaje,
                timer: 1200,
                showConfirmButton: false
            }).then(() => location.reload());
        })
        .catch(err => {
            console.error('Error al actualizar permiso:', err);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo actualizar el permiso'
            });
        });
    }
});
