// Funcionalidad del carrusel de programas
document.addEventListener('DOMContentLoaded', function() {
    // Modal para detalles de programas
    const modal = document.getElementById('modal-programa');
    const closeBtn = document.querySelector('.close');
    const modalBody = document.getElementById('modal-body');
    
    // Botones para ver detalles
    const verDetallesBtns = document.querySelectorAll('.ver-detalles');
    
    verDetallesBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const programaId = this.getAttribute('data-id');
            const programaNombre = this.getAttribute('data-nombre');
            const programaDescripcion = this.getAttribute('data-descripcion');
            const programaImagen = this.getAttribute('data-imagen');
            
            mostrarDetallesPrograma(programaId, programaNombre, programaDescripcion, programaImagen);
        });
    });
    
    // Cerrar modal
    closeBtn.addEventListener('click', function() {
        modal.style.display = 'none';
    });
    
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
    
    // Función para mostrar detalles del programa
    function mostrarDetallesPrograma(id, nombre, descripcion, imagen) {
        modalBody.innerHTML = `
            <h2>${nombre}</h2>
            <img src="assets/img/${imagen}" alt="${nombre}" style="max-width: 100%; margin-bottom: 1rem;" onerror="this.src='assets/img/programacion.jpg'">
            <p>${descripcion}</p>
        `;
        modal.style.display = 'block';
    }
    
    // Validación de formulario de registro
    const formRegistro = document.querySelector('.form-registro');
    if (formRegistro) {
        // Validación de programas no repetidos en tiempo real
        const selects = document.querySelectorAll('.select-programa');
        
        selects.forEach(select => {
            select.addEventListener('change', function() {
                actualizarOpcionesDisponibles();
                validarEstadoFormulario();
            });
        });
        
        function actualizarOpcionesDisponibles() {
            const valoresSeleccionados = [];
            
            // Obtener valores seleccionados
            selects.forEach(select => {
                if (select.value) {
                    valoresSeleccionados.push(select.value);
                }
            });
            
            // Actualizar opciones en cada select
            selects.forEach(select => {
                const valorActual = select.value;
                const opciones = select.querySelectorAll('option');
                
                opciones.forEach(opcion => {
                    if (opcion.value === '') {
                        // Siempre mantener la opción vacía disponible
                        opcion.disabled = false;
                    } else if (valoresSeleccionados.includes(opcion.value) && opcion.value !== valorActual) {
                        // Deshabilitar opciones ya seleccionadas en otros selects
                        opcion.disabled = true;
                        
                        // Si esta opción estaba seleccionada en este select, limpiarla
                        if (select.value === opcion.value && valorActual !== '') {
                            // Encontrar una opción disponible alternativa
                            const opcionesDisponibles = Array.from(opciones).filter(opt => 
                                !opt.disabled && opt.value !== '');
                            
                            if (opcionesDisponibles.length > 0) {
                                select.value = opcionesDisponibles[0].value;
                            } else {
                                select.value = '';
                            }
                        }
                    } else {
                        // Habilitar opciones no seleccionadas
                        opcion.disabled = false;
                    }
                });
            });
        }
        
        function validarEstadoFormulario() {
            const programa1 = document.getElementById('programa_1').value;
            const programa2 = document.getElementById('programa_2').value;
            const programa3 = document.getElementById('programa_3').value;
            const btnSubmit = document.querySelector('button[type="submit"]');
            
            // Verificar si las tres opciones están seleccionadas y son diferentes
            const programasSeleccionados = [programa1, programa2, programa3].filter(Boolean);
            const programasUnicos = new Set(programasSeleccionados);
            
            if (programasSeleccionados.length === 3 && programasUnicos.size === 3) {
                btnSubmit.disabled = false;
            } else {
                btnSubmit.disabled = true;
            }
        }
        
        // Validación al enviar el formulario
        formRegistro.addEventListener('submit', function(e) {
            const programa1 = document.getElementById('programa_1').value;
            const programa2 = document.getElementById('programa_2').value;
            const programa3 = document.getElementById('programa_3').value;
            
            // Validar que las tres opciones estén seleccionadas
            if (!programa1 || !programa2 || !programa3) {
                e.preventDefault();
                alert('Debe seleccionar las tres opciones de programas');
                return false;
            }
            
            // Validar que no haya programas duplicados
            const programasSeleccionados = [programa1, programa2, programa3];
            const programasUnicos = new Set(programasSeleccionados);
            
            if (programasSeleccionados.length !== programasUnicos.size) {
                e.preventDefault();
                alert('No puede seleccionar programas duplicados');
                return false;
            }
        });
        
        // Inicializar la validación
        actualizarOpcionesDisponibles();
        validarEstadoFormulario();
    }
});