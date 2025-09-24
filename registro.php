<?php
require_once 'config/db.php';
//require_once 'config/session.php';

// Obtener colegios y programas
$colegios = $pdo->query("SELECT * FROM colegios WHERE activo = TRUE")->fetchAll();
$programas = $pdo->query("SELECT * FROM programas WHERE activo = TRUE")->fetchAll();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ... (código de procesamiento del formulario se mantiene igual)
    // Solo cambia la estructura HTML
}
?>

<?php include 'includes/header.php'; ?>

<main>
    <section class="form-section">
        <div class="container">
            <div class="form-container">
                <h2>Registro de Estudiante</h2>
                
                <?php if ($error): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                <?php endif; ?>
                
                <form method="POST" class="form-registro" id="form-registro" novalidate>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nombre_completo">Nombre completo *</label>
                            <input type="text" id="nombre_completo" name="nombre_completo" required 
                                   value="<?php echo isset($_POST['nombre_completo']) ? htmlspecialchars($_POST['nombre_completo']) : ''; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="documento">Documento de identidad *</label>
                            <input type="text" id="documento" name="documento" required 
                                   value="<?php echo isset($_POST['documento']) ? htmlspecialchars($_POST['documento']) : ''; ?>">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="colegio_id">Colegio *</label>
                            <select id="colegio_id" name="colegio_id" required>
                                <option value="">Seleccione su colegio</option>
                                <?php foreach ($colegios as $colegio): ?>
                                <option value="<?php echo $colegio['id']; ?>" 
                                    <?php echo (isset($_POST['colegio_id']) && $_POST['colegio_id'] == $colegio['id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($colegio['nombre']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="grado">Grado *</label>
                            <select id="grado" name="grado" required>
                                <option value="">Seleccione su grado</option>
                                <option value="9A" <?php echo (isset($_POST['grado']) && $_POST['grado'] == '9A') ? 'selected' : ''; ?>>9A</option>
                                <option value="9B" <?php echo (isset($_POST['grado']) && $_POST['grado'] == '9B') ? 'selected' : ''; ?>>9B</option>
                                <option value="9C" <?php echo (isset($_POST['grado']) && $_POST['grado'] == '9C') ? 'selected' : ''; ?>>9C</option>
                                <option value="9D" <?php echo (isset($_POST['grado']) && $_POST['grado'] == '9D') ? 'selected' : ''; ?>>9D</option>
                                <option value="9E" <?php echo (isset($_POST['grado']) && $_POST['grado'] == '9E') ? 'selected' : ''; ?>>9E</option>
                                
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="telefono">Teléfono / WhatsApp *</label>
                        <input type="tel" id="telefono" name="telefono" required 
                               value="<?php echo isset($_POST['telefono']) ? htmlspecialchars($_POST['telefono']) : ''; ?>">
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nombre_contacto">Nombre de contacto (acudiente) *</label>
                            <input type="text" id="nombre_contacto" name="nombre_contacto" required 
                                   value="<?php echo isset($_POST['nombre_contacto']) ? htmlspecialchars($_POST['nombre_contacto']) : ''; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="telefono_contacto">Teléfono de contacto *</label>
                            <input type="tel" id="telefono_contacto" name="telefono_contacto" required 
                                   value="<?php echo isset($_POST['telefono_contacto']) ? htmlspecialchars($_POST['telefono_contacto']) : ''; ?>">
                        </div>
                    </div>
                    
                    <div class="programas-section">
                        <label>Selección de programas (en orden de prioridad) *</label>
                        
                        <div class="programas-opciones">
                            <div class="opcion-programa">
                                <label for="programa_1">Primera opción *</label>
                                <select id="programa_1" name="programa_1" required class="select-programa" data-prioridad="1">
                                    <option value="">Seleccione su primera opción</option>
                                    <?php foreach ($programas as $programa): ?>
                                    <option value="<?php echo $programa['id']; ?>" 
                                        <?php echo (isset($_POST['programa_1']) && $_POST['programa_1'] == $programa['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($programa['nombre']); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="opcion-programa">
                                <label for="programa_2">Segunda opción *</label>
                                <select id="programa_2" name="programa_2" required class="select-programa" data-prioridad="2">
                                    <option value="">Seleccione su segunda opción</option>
                                    <?php foreach ($programas as $programa): ?>
                                    <option value="<?php echo $programa['id']; ?>" 
                                        <?php echo (isset($_POST['programa_2']) && $_POST['programa_2'] == $programa['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($programa['nombre']); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="opcion-programa">
                                <label for="programa_3">Tercera opción *</label>
                                <select id="programa_3" name="programa_3" required class="select-programa" data-prioridad="3">
                                    <option value="">Seleccione su tercera opción</option>
                                    <?php foreach ($programas as $programa): ?>
                                    <option value="<?php echo $programa['id']; ?>" 
                                        <?php echo (isset($_POST['programa_3']) && $_POST['programa_3'] == $programa['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($programa['nombre']); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <small class="form-help">Debe seleccionar tres programas diferentes, en orden de prioridad.</small>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary" id="btn-submit">Enviar registro</button>
                        <button type="reset" class="btn btn-secondary">Limpiar formulario</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>

<script>
// Validación de programas no repetidos en tiempo real
document.addEventListener('DOMContentLoaded', function() {
    const selects = document.querySelectorAll('.select-programa');
    
    selects.forEach(select => {
        select.addEventListener('change', function() {
            actualizarOpcionesDisponibles();
            validarEstadoFormulario();
        });
    });
    
    function actualizarOpcionesDisponibles() {
        const valoresSeleccionados = [];
        
        selects.forEach(select => {
            if (select.value) {
                valoresSeleccionados.push(select.value);
            }
        });
        
        selects.forEach(select => {
            const valorActual = select.value;
            const opciones = select.querySelectorAll('option');
            
            opciones.forEach(opcion => {
                if (opcion.value === '') {
                    opcion.disabled = false;
                } else if (valoresSeleccionados.includes(opcion.value) && opcion.value !== valorActual) {
                    opcion.disabled = true;
                    
                    if (select.value === opcion.value && valorActual !== '') {
                        const opcionesDisponibles = Array.from(opciones).filter(opt => 
                            !opt.disabled && opt.value !== '');
                        
                        if (opcionesDisponibles.length > 0) {
                            select.value = opcionesDisponibles[0].value;
                        } else {
                            select.value = '';
                        }
                    }
                } else {
                    opcion.disabled = false;
                }
            });
        });
    }
    
    function validarEstadoFormulario() {
        const programa1 = document.getElementById('programa_1').value;
        const programa2 = document.getElementById('programa_2').value;
        const programa3 = document.getElementById('programa_3').value;
        const btnSubmit = document.getElementById('btn-submit');
        
        const programasSeleccionados = [programa1, programa2, programa3].filter(Boolean);
        const programasUnicos = new Set(programasSeleccionados);
        
        if (programasSeleccionados.length === 3 && programasUnicos.size === 3) {
            btnSubmit.disabled = false;
        } else {
            btnSubmit.disabled = true;
        }
    }
    
    actualizarOpcionesDisponibles();
    validarEstadoFormulario();
});
</script>