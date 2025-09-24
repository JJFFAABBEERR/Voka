// Funcionalidad del panel de administración
document.addEventListener('DOMContentLoaded', function() {
    // Modal para detalles del estudiante
    const modal = document.getElementById('modal-estudiante');
    
    if (modal) {
        const modalBody = document.getElementById('modal-body');
        const closeBtn = modal.querySelector('.close');
        
        // Botones para ver detalles del estudiante
        const verDetallesBtns = document.querySelectorAll('.ver-detalles');
        
        verDetallesBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const estudianteId = this.getAttribute('data-id');
                cargarDetallesEstudiante(estudianteId);
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
        
        // Función para cargar detalles del estudiante
        async function cargarDetallesEstudiante(id) {
            modalBody.innerHTML = '<div class="loading">Cargando información del estudiante...</div>';
            modal.style.display = 'block';
            
            try {
                // Simulamos la carga de datos (en un sistema real, haríamos una petición AJAX)
                setTimeout(() => {
                    modalBody.innerHTML = `
                        <h3>Detalles del Estudiante</h3>
                        <div class="student-details">
                            <p><strong>ID:</strong> ${id}</p>
                            <p><strong>Nombre:</strong> Estudiante Ejemplo</p>
                            <p><strong>Documento:</strong> 123456789</p>
                            <p><strong>Colegio:</strong> Colegio Nacional</p>
                            <p><strong>Grado:</strong> 11°</p>
                            <p><strong>Teléfono:</strong> 3001234567</p>
                            <p><strong>Contacto:</strong> Padre/Madre - 3007654321</p>
                            
                            <h4>Preferencias de Programas</h4>
                            <ol>
                                <li>Técnico en Programación</li>
                                <li>Técnico en Diseño Gráfico</li>
                                <li>Técnico en Electricidad</li>
                            </ol>
                            
                            <p><strong>Fecha de Registro:</strong> ${new Date().toLocaleDateString()}</p>
                        </div>
                        <div class="modal-actions">
                            <button class="btn btn-primary" onclick="window.print()">Imprimir</button>
                            <button class="btn btn-secondary" onclick="cerrarModal()">Cerrar</button>
                        </div>
                    `;
                }, 1000);
            } catch (error) {
                modalBody.innerHTML = '<div class="error">Error al cargar los detalles del estudiante</div>';
            }
        }
    }
    
    // Confirmación para acciones críticas
    const deleteButtons = document.querySelectorAll('.btn-danger');
    deleteButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            if (!confirm('¿Está seguro de que desea realizar esta acción? Esta acción no se puede deshacer.')) {
                e.preventDefault();
            }
        });
    });
    
    // Validación de formularios en admin
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let valid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    valid = false;
                    field.style.borderColor = 'red';
                } else {
                    field.style.borderColor = '';
                }
            });
            
            if (!valid) {
                e.preventDefault();
                alert('Por favor complete todos los campos obligatorios.');
            }
        });
    });
    
    // Funcionalidad de búsqueda en tiempo real
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    }
});

// Funciones globales
function cerrarModal() {
    const modal = document.getElementById('modal-estudiante');
    if (modal) {
        modal.style.display = 'none';
    }
}

function toggleFiltros() {
    const filtros = document.getElementById('filtros-avanzados');
    if (filtros) {
        filtros.style.display = filtros.style.display === 'none' ? 'block' : 'none';
    }
}