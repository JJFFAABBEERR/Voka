<?php
// home.php - Página principal del sistema
require_once 'config/db.php';
//require_once 'config/session.php';

// Obtener todos los programas activos
$stmt = $pdo->query("SELECT * FROM programas WHERE activo = TRUE ORDER BY nombre");
$programas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Crear categorías basadas en los programas existentes
$categorias = [
    'todos' => [
        'nombre' => 'Todos los Programas',
        'programas' => $programas
    ],
    'tecnologia' => [
        'nombre' => 'Tecnología',
        'programas' => array_filter($programas, function($programa) {
            return stripos($programa['nombre'], 'programación') !== false || 
                   stripos($programa['nombre'], 'tecnología') !== false ||
                   stripos($programa['nombre'], 'software') !== false ||
                   stripos($programa['nombre'], 'web') !== false;
        })
    ],
    'diseno' => [
        'nombre' => 'Diseño',
        'programas' => array_filter($programas, function($programa) {
            return stripos($programa['nombre'], 'diseño') !== false || 
                   stripos($programa['nombre'], 'gráfico') !== false ||
                   stripos($programa['nombre'], 'multimedia') !== false;
        })
    ],
    'ingenieria' => [
        'nombre' => 'Ingeniería',
        'programas' => array_filter($programas, function($programa) {
            return stripos($programa['nombre'], 'electricidad') !== false || 
                   stripos($programa['nombre'], 'mecánica') !== false ||
                   stripos($programa['nombre'], 'automotriz') !== false ||
                   stripos($programa['nombre'], 'mantenimiento') !== false;
        })
    ],
    'gastronomia' => [
        'nombre' => 'Gastronomía',
        'programas' => array_filter($programas, function($programa) {
            return stripos($programa['nombre'], 'gastronomía') !== false || 
                   stripos($programa['nombre'], 'culinaria') !== false ||
                   stripos($programa['nombre'], 'alimentos') !== false;
        })
    ]
];

// Si alguna categoría queda vacía, la eliminamos
$categorias = array_filter($categorias, function($categoria) {
    return !empty($categoria['programas']) || $categoria['nombre'] === 'Todos los Programas';
});
?>

<?php include 'includes/header.php'; ?>

<main>
    <!-- Sección de búsqueda principal -->
    <section class="search-section">
        <div class="container">
            <h2>¿Qué te gustaría aprender?</h2>
            
            <div class="search-options">
                <label class="option-checkbox">
                    <input type="checkbox" name="categoria" value="tecnologia">
                    Tecnología
                </label>
                <label class="option-checkbox">
                    <input type="checkbox" name="categoria" value="diseno">
                    Diseño
                </label>
                <label class="option-checkbox">
                    <input type="checkbox" name="categoria" value="ingenieria">
                    Ingeniería
                </label>
            </div>
            
            <div class="search-actions">
                <a href="registro.php" class="btn btn-primary">Explorar programas</a>
                <a href="#carrusel-programas" class="btn btn-secondary">Ver todos los programas</a>
            </div>
        </div>
    </section>

    <!-- Carrusel de programas -->
    <section class="carrusel-programas-section" id="carrusel-programas">
        <div class="container">
            <h2>Nuestros Programas Técnicos</h2>
            <p class="section-subtitle">Descubre los 17 programas técnicos disponibles para tu formación profesional</p>
            
            <!-- Navegación por pestañas -->
            <div class="categorias-tabs">
                <?php foreach ($categorias as $key => $categoria): ?>
                <button class="tab-btn <?php echo $key === 'todos' ? 'active' : ''; ?>" 
                        data-categoria="<?php echo $key; ?>">
                    <?php echo htmlspecialchars($categoria['nombre']); ?>
                    <span class="badge"><?php echo count($categoria['programas']); ?></span>
                </button>
                <?php endforeach; ?>
            </div>
            
            <!-- Contenido de cada categoría -->
            <div class="categorias-content">
                <?php foreach ($categorias as $key => $categoria): ?>
                <div class="categoria-panel <?php echo $key === 'todos' ? 'active' : ''; ?>" 
                     id="panel-<?php echo $key; ?>">
                    
                    <?php if (count($categoria['programas']) > 0): ?>
                    <div class="carrusel-container">
                        <button class="carrusel-prev" data-categoria="<?php echo $key; ?>">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M15 18l-6-6 6-6"/>
                            </svg>
                        </button>
                        
                        <div class="carrusel-programas" id="carrusel-<?php echo $key; ?>">
                            <?php foreach ($categoria['programas'] as $programa): ?>
                            <div class="programa-item">
                                <div class="programa-card">
                                    <div class="programa-imagen">
                                        <img src="assets/img/<?php echo htmlspecialchars($programa['imagen']); ?>" 
                                             alt="<?php echo htmlspecialchars($programa['nombre']); ?>"
                                             onerror="this.src='assets/img/voka33.png'"
                                             class="clickable-image"
                                             data-id="<?php echo $programa['id']; ?>"
                                             data-nombre="<?php echo htmlspecialchars($programa['nombre']); ?>"
                                             data-descripcion="<?php echo htmlspecialchars($programa['descripcion']); ?>"
                                             data-imagen="<?php echo htmlspecialchars($programa['imagen']); ?>">
                                        <div class="programa-overlay">
                                            <button class="btn-ver-detalles"
                                                    data-id="<?php echo $programa['id']; ?>"
                                                    data-nombre="<?php echo htmlspecialchars($programa['nombre']); ?>"
                                                    data-descripcion="<?php echo htmlspecialchars($programa['descripcion']); ?>"
                                                    data-imagen="<?php echo htmlspecialchars($programa['imagen']); ?>">
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                                    <circle cx="12" cy="12" r="3"/>
                                                </svg>
                                                Ver detalles
                                            </button>
                                        </div>
                                    </div>
                                    <div class="programa-info">
                                        <h4><?php echo htmlspecialchars($programa['nombre']); ?></h4>
                                        <p><?php echo htmlspecialchars(substr($programa['descripcion'], 0, 80) . '...'); ?></p>
                                        <div class="programa-actions">
                                            <button class="btn btn-small ver-detalles"
                                                    data-id="<?php echo $programa['id']; ?>"
                                                    data-nombre="<?php echo htmlspecialchars($programa['nombre']); ?>"
                                                    data-descripcion="<?php echo htmlspecialchars($programa['descripcion']); ?>"
                                                    data-imagen="<?php echo htmlspecialchars($programa['imagen']); ?>">
                                                Ver detalles
                                            </button>
                                            <button class="btn btn-small btn-primary agregar-interes"
                                                    data-programa="<?php echo $programa['id']; ?>"
                                                    data-nombre="<?php echo htmlspecialchars($programa['nombre']); ?>">
                                                Me interesa
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <button class="carrusel-next" data-categoria="<?php echo $key; ?>">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 18l6-6-6-6"/>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Indicadores de posición -->
                    <div class="carrusel-indicators" id="indicators-<?php echo $key; ?>">
                        <!-- Los indicadores se generan dinámicamente con JavaScript -->
                    </div>
                    <?php else: ?>
                    <div class="no-programas">
                        <p>No hay programas disponibles en esta categoría actualmente.</p>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Sección de estadísticas -->
    <section class="estadisticas-section">
        <div class="container">
            <div class="estadisticas-grid">
                <div class="estadistica-item">
                    <div class="estadistica-number">17</div>
                    <div class="estadistica-label">Programas Técnicos</div>
                </div>
                <div class="estadistica-item">
                    <div class="estadistica-number">100%</div>
                    <div class="estadistica-label">Gratuitos</div>
                </div>
                <div class="estadistica-item">
                    <div class="estadistica-number">Modalidad</div>
                    <div class="estadistica-label">Presencial</div>
                </div>
                <div class="estadistica-item">
                    <div class="estadistica-number">Certificación</div>
                    <div class="estadistica-label">SENA</div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>

<!-- Modal para detalles del programa -->
<div id="modal-programa" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div id="modal-body">
            <!-- Contenido dinámico -->
        </div>
    </div>
</div>

<script>
// Configuración principal del carrusel
document.addEventListener('DOMContentLoaded', function() {
    // Navegación entre pestañas
    const tabBtns = document.querySelectorAll('.tab-btn');
    const categoriaPanels = document.querySelectorAll('.categoria-panel');
    
    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const categoria = this.getAttribute('data-categoria');
            
            // Remover clase active de todos
            tabBtns.forEach(b => b.classList.remove('active'));
            categoriaPanels.forEach(p => p.classList.remove('active'));
            
            // Agregar clase active al actual
            this.classList.add('active');
            document.getElementById(`panel-${categoria}`).classList.add('active');
            
            // Re-inicializar el carrusel de la categoría activa
            inicializarCarrusel(categoria);
        });
    });
    
    // Inicializar carruseles para cada categoría
    function inicializarCarrusel(categoria) {
        const carrusel = document.getElementById(`carrusel-${categoria}`);
        const prevBtn = document.querySelector(`.carrusel-prev[data-categoria="${categoria}"]`);
        const nextBtn = document.querySelector(`.carrusel-next[data-categoria="${categoria}"]`);
        const indicators = document.getElementById(`indicators-${categoria}`);
        
        if (!carrusel) return;
        
        const items = carrusel.querySelectorAll('.programa-item');
        const itemWidth = items[0]?.offsetWidth + 24; // width + gap
        const visibleItems = Math.floor(carrusel.offsetWidth / itemWidth);
        const totalItems = items.length;
        let currentPosition = 0;
        let maxPosition = Math.max(0, totalItems - visibleItems);
        
        // Crear indicadores
        if (indicators && totalItems > visibleItems) {
            indicators.innerHTML = '';
            const totalPages = Math.ceil(totalItems / visibleItems);
            
            for (let i = 0; i < totalPages; i++) {
                const indicator = document.createElement('button');
                indicator.className = `indicator ${i === 0 ? 'active' : ''}`;
                indicator.addEventListener('click', () => {
                    currentPosition = i * visibleItems;
                    updateCarrusel();
                });
                indicators.appendChild(indicator);
            }
        }
        
        // Función para actualizar la posición del carrusel
        function updateCarrusel() {
            carrusel.scrollTo({
                left: currentPosition * itemWidth,
                behavior: 'smooth'
            });
            
            // Actualizar indicadores
            if (indicators) {
                const indicatorsList = indicators.querySelectorAll('.indicator');
                const currentPage = Math.floor(currentPosition / visibleItems);
                indicatorsList.forEach((indicator, index) => {
                    indicator.classList.toggle('active', index === currentPage);
                });
            }
            
            // Actualizar estado de los botones
            prevBtn.disabled = currentPosition === 0;
            nextBtn.disabled = currentPosition >= maxPosition;
        }
        
        // Event listeners para botones de navegación
        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                if (currentPosition > 0) {
                    currentPosition--;
                    updateCarrusel();
                }
            });
        }
        
        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                if (currentPosition < maxPosition) {
                    currentPosition++;
                    updateCarrusel();
                }
            });
        }
        
        // Inicializar
        updateCarrusel();
        
        // Recalcular en resize
        let resizeTimeout;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                const newVisibleItems = Math.floor(carrusel.offsetWidth / itemWidth);
                maxPosition = Math.max(0, totalItems - newVisibleItems);
                if (currentPosition > maxPosition) {
                    currentPosition = maxPosition;
                }
                updateCarrusel();
            }, 250);
        });
    }
    
    // Inicializar el carrusel de la categoría activa
    const categoriaActiva = document.querySelector('.tab-btn.active').getAttribute('data-categoria');
    inicializarCarrusel(categoriaActiva);
    
    // Modal para detalles del programa
    const modal = document.getElementById('modal-programa');
    const closeBtn = document.querySelector('.close');
    const modalBody = document.getElementById('modal-body');
    
    // Función para abrir modal con detalles
    function abrirModalPrograma(programaData) {
        modalBody.innerHTML = `
            <div class="modal-programa-detalles">
                <div class="modal-header">
                    <h2>${programaData.nombre}</h2>
                    <span class="modal-badge">Programa Técnico</span>
                </div>
                
                <div class="modal-content-grid">
                    <div class="modal-imagen">
                        <img src="assets/img/${programaData.imagen}" alt="${programaData.nombre}" 
                             onerror="this.src='assets/img/voka33.png'">
                    </div>
                    
                    <div class="modal-info">
                        <div class="info-section">
                            <h3>Descripción del Programa</h3>
                            <p>${programaData.descripcion}</p>
                        </div>
                        
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-icon">⏱️</div>
                                <div>
                                    <strong>Duración</strong>
                                    <span>6 - 12 meses</span>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-icon">🎓</div>
                                <div>
                                    <strong>Modalidad</strong>
                                    <span>Presencial</span>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-icon">📚</div>
                                <div>
                                    <strong>Nivel</strong>
                                    <span>Técnico</span>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-icon">✅</div>
                                <div>
                                    <strong>Certificación</strong>
                                    <span>SENA</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="info-section">
                            <h3>¿Qué aprenderás?</h3>
                            <ul class="aprendizaje-list">
                                <li>Habilidades técnicas especializadas</li>
                                <li>Conocimientos prácticos aplicables</li>
                                <li>Desarrollo de competencias laborales</li>
                                <li>Uso de herramientas profesionales</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="modal-actions">
                    <button class="btn btn-primary btn-large" onclick="registrarInteres(${programaData.id})">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                        </svg>
                        Me interesa este programa
                    </button>
                    <button class="btn btn-secondary" onclick="window.open('registro.php?programa=${programaData.id}', '_blank')">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="8.5" cy="7" r="4"/>
                            <line x1="20" y1="8" x2="20" y2="14"/>
                            <line x1="23" y1="11" x2="17" y2="11"/>
                        </svg>
                        Registrarme ahora
                    </button>
                    <button class="btn btn-outline" onclick="cerrarModal()">
                        Cerrar
                    </button>
                </div>
            </div>
        `;
        
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }
    
    // Event listeners para abrir modal
    function setupModalListeners() {
        // Botones "Ver detalles"
        const verDetallesBtns = document.querySelectorAll('.ver-detalles, .btn-ver-detalles');
        verDetallesBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const programaData = {
                    id: this.getAttribute('data-id'),
                    nombre: this.getAttribute('data-nombre'),
                    descripcion: this.getAttribute('data-descripcion'),
                    imagen: this.getAttribute('data-imagen')
                };
                abrirModalPrograma(programaData);
            });
        });
        
        // Imágenes clickeables
        const clickableImages = document.querySelectorAll('.clickable-image');
        clickableImages.forEach(img => {
            img.addEventListener('click', function() {
                const programaData = {
                    id: this.getAttribute('data-id'),
                    nombre: this.getAttribute('data-nombre'),
                    descripcion: this.getAttribute('data-descripcion'),
                    imagen: this.getAttribute('data-imagen')
                };
                abrirModalPrograma(programaData);
            });
        });
        
        // Botones "Me interesa"
        const interesBtns = document.querySelectorAll('.agregar-interes');
        interesBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const programaId = this.getAttribute('data-programa');
                const programaNombre = this.getAttribute('data-nombre');
                registrarInteres(programaId, programaNombre);
            });
        });
    }
    
    // Cerrar modal
    function setupModalClose() {
        closeBtn.addEventListener('click', cerrarModal);
        
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                cerrarModal();
            }
        });
        
        // Cerrar con ESC
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                cerrarModal();
            }
        });
    }
    
    // Inicializar
    setupModalListeners();
    setupModalClose();
});

// Funciones globales
function cerrarModal() {
    document.getElementById('modal-programa').style.display = 'none';
    document.body.style.overflow = 'auto';
}

function registrarInteres(programaId, programaNombre = '') {
    // Guardar en localStorage
    let programasInteres = JSON.parse(localStorage.getItem('programasInteres') || '[]');
    if (!programasInteres.includes(programaId)) {
        programasInteres.push(programaId);
        localStorage.setItem('programasInteres', JSON.stringify(programasInteres));
        
        // Mostrar notificación
        showNotification(`"${programaNombre}" agregado a tus intereses`);
    }
    
    // Redirigir después de un breve tiempo
    setTimeout(() => {
        window.location.href = `registro.php?programa=${programaId}`;
    }, 1500);
}

function showNotification(mensaje) {
    const notification = document.createElement('div');
    notification.className = 'notification';
    notification.innerHTML = `
        <div class="notification-content">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                <polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
            <span>${mensaje}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.add('show');
    }, 100);
    
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}
</script>