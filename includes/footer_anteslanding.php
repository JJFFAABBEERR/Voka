<?php
// includes/footer.php
?>
    <!-- Nota importante -->
    <div class="container">
        <div class="important-note">
            <strong>Importante:</strong>
            <p>Esta plataforma es únicamente para servicios de oferta e inscripción. Para servicios administrativos, visite SOFIA Plus.</p>
        </div>
    </div>

    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-info">
                    <p>&copy; <?php echo date('Y'); ?> SENA - Conexión Vocacional. Todos los derechos reservados.</p>
                    <p>Servicio Nacional de Aprendizaje - SENA</p>
                </div>
                <div class="footer-links">
                    <a href="#">Términos y condiciones</a>
                    <a href="#">Política de privacidad</a>
                    <a href="#">Contacto</a>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Modal para detalles del programa -->
    <div id="modal-programa" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="modal-body"></div>
        </div>
    </div>
    
    <script src="assets/js/main.js"></script>
</body>
</html>