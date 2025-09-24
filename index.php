<?php
// index.php - Pantalla de bienvenida
$show_landing = true;

// Si el usuario hace clic en "Conocer oferta", mostramos el contenido principal
if (isset($_GET['action']) && $_GET['action'] === 'enter') {
    $show_landing = false;
    // Redirigir al home principal
    header('Location: home.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conexión Vocacional - SENA</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <
    <style>
        /* Estilos específicos para la landing page */
        .landing-hero {
            background: linear-gradient(135deg, var(--azul-gov) 0%, var(--azul-claro) 100%);
            color: var(--blanco);
            padding: 4rem 0;
            text-align: center;
            min-height: 80vh;
            display: flex;
            align-items: center;
        }

        .landing-content {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
        }

        .landing-title {
            font-size: 3rem;
            margin-bottom: 2rem;
            font-weight: bold;
            line-height: 1.2;
        }

        .landing-subtitle {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            line-height: 1.4;
            text-align:center;
        }

        .landing-features {
            text-align: left;
            background: rgba(255, 255, 255, 0.1);
            padding: 2rem;
            border-radius: 10px;
            margin: 2rem 0;
        }

        .landing-features ul {
            list-style: none;
            padding: 0;
        }

        .landing-features li {
            margin-bottom: 1rem;
            font-size: 1.2rem;
            padding-left: 2rem;
            position: relative;
        }

        .landing-features li:before {
            content: "•";
            color: var(--verde-check);
            font-size: 2rem;
            position: absolute;
            left: 0;
            top: -0.5rem;
        }

        .landing-cta {
            margin-top: 3rem;
        }

        .btn-landing {
            background: var(--verde-check);
            color: var(--blanco);
            padding: 1rem 2rem;
            font-size: 1.3rem;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }

        .btn-landing:hover {
            background: #218838;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .english-program {
            background: var(--verde-check);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: bold;
            margin-left: 0.5rem;
        }

        @media (max-width: 768px) {
            .landing-title {
                font-size: 2.2rem;
            }
            
            .landing-subtitle {
                font-size: 1.2rem;
            }
            
            .landing-features li {
                font-size: 1.1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Barra superior gov.co -->
    <div class="gov-bar">
        <div class="container">
            <div class="gov-links">
                <a href="index.php" class="active">Inicio</a>
                
            </div>
            <div class="auth-links">
                <a href="login.php" class="btn-auth">Admin</a>
                <!--<a href="home.php" class="btn-auth btn-register">Registrarme</a> Se quitó porque ya se encuentra abajo -->
            </div>
        </div>
    </div>

    <!-- Header principal -->
    <header class="main-header">
        <div class="container">
            <div class="header-content">
                <div class="logo-section">
                    <img src="assets/img/logo_sena_verde.png" alt="Logo SENA" class="logo">
                    <div class="title-section">
                        <h1>Conexión Vocacional</h1>
                        <p>Servicio Nacional de Aprendizaje - SENA</p>
                    </div>
                </div>
                <div class="header-actions">
                    <a href="home.php" class="btn btn-primary">Ir a programas</a>
                </div>
                <img src="assets/img/Logo_Conexión_SF.png" alt="Logo SENA" class="logo">
            </div>
        </div>
    </header>

    <!-- Sección de bienvenida -->
    <section class="landing-hero">
        <div class="container">
            <div class="landing-content">
                <h2 class="landing-title">¿Quieres impulsar<br>tu perfil profesional?</h2>
                
                <div class="landing-features">
                    <p class="landing-subtitle">
                      <strong> El SENA - Conexión Vocacional</strong><br>Tiene 17 Programas Técnicos</strong> en áreas como:
                    </p>
                    
                    <ul>
                        <li>
                            <strong>Tecnología, agro, turismo, artesanías y finanzas.</strong>
                        </li>
                        <li>
                            Además, fortalece tu inglés con el programa 
                            <span class="english-program">English Does Work</span>.
                        </li>
                    </ul>
                    <div style="text-align: center;">
                        <img decoding="async" src="assets/img/voka_SF.png" alt="Logo SENA" class="logo">
                    </div>
                  
                </div>
                
                <div class="landing-cta">
                    <a href="home.php" class="btn-landing">
                        Conoce toda la oferta tenemos para aquí
                    </a>
                </div>
            </div>
        </div>
    </section>

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
                    <p>Servicio Nacional de Aprendizaje - SENA </p>
                </div>
                <div class="footer-links">
                    <a href="#">Términos y condiciones</a>
                    <a href="#">Política de privacidad</a>
                    <a href="#">Contacto</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>