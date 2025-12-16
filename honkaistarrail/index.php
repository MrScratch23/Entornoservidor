<?php
session_start();
require_once 'includes/config.php';
require_once APP_ROOT . "/models/LoginModel.php";

$loginModel = new LoginModel();

// Si el usuario está logueado, mostrar info
$usuario_actual = null;
if (isset($_SESSION['usuario_id'])) {
    $usuario_actual = $loginModel->obtenerUsuarioPorId($_SESSION['usuario_id']);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToTheStarts - Honkai Star Rail</title>
    <!-- Font Awesome para íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- CSS del diseño principal -->
    <link rel="stylesheet" href="paginaprincipal.css">
    <!-- CSS específico para la página principal -->
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <!-- Header -->
    <header class="header-container">
        <div class="left-text">Hacia las estrellas</div>

        <img
            src="./honkai-star-rail-logo.png"
            alt="Logo principal"
            class="center-image"
        />

        <div class="header-right">
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <div class="user-info">
                    <span class="user-welcome">
                        <i class="fas fa-user-circle"></i>
                        <?php echo htmlspecialchars($usuario_actual['nombre'] ?? $_SESSION['usuario_nombre'] ?? 'Usuario'); ?>
                    </span>
                    <a href="logout.php" class="btn-logout">
                        <i class="fas fa-sign-out-alt"></i> Salir
                    </a>
                </div>
            <?php else: ?>
                <div class="auth-buttons">
                    <a href="login.php" class="btn-login">
                        <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                    </a>
                    <a href="registro.php" class="btn-register">
                        <i class="fas fa-user-plus"></i> Registrarse
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </header>

    <main>
        <!-- Menú de navegación -->
        <nav class="menu-categorias">
            <ul>
                <li>
                    <a href="index.php" class="active"><i class="fas fa-home"></i> Principal</a>
                </li>
                <li>
                    <a href="personajes.php"><i class="fas fa-users"></i> Personajes</a>
                </li>
                <li>
                    <a href="tierlist.php"><i class="fas fa-chart-bar"></i> Tier list</a>
                </li>
                <li>
                    <a href="memoriacaos.php"><i class="fas fa-brain"></i> Memoria del Caos</a>
                </li>
                <li>
                    <a href="puraficcion.php"><i class="fab fa-twitter"></i> Pura Ficción</a>
                </li>
                <li>
                    <a href="aposhadow.php"><i class="fas fa-radiation-alt"></i> Apocalyptic Shadow</a>
                </li>
                <li>
                    <a href="conosluz.php"><i class="fas fa-cube"></i> Conos de Luz</a>
                </li>
                <li>
                    <a href="artefactos.php"><i class="fas fa-dice"></i> Artefactos</a>
                </li>

                <li class="separator"></li>

                <li>
                    <a href="#"><i class="fas fa-book"></i> Guías</a>
                </li>
                <li>
                    <a href="#"><i class="fas fa-tools"></i> Herramientas</a>
                </li>

                <li class="separator"></li>

                <li>
                    <a href="https://github.com/MrScratch23" id="github-link">
                        <i class="fas fa-blog"></i> Github del creador
                    </a>
                </li>

                <li>
                    <a href="#" class="play-mac">
                        <i class="fab fa-apple"></i> Juega en Mac
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Contenido principal -->
        <div class="contenido-principal">
            <section class="main-title-section">
                <h1>
                    ToTheStarts es una página web creada por Rubén Daniel Ternero
                    Molina, futuro proyecto de DAW y personal de cara al futuro.
                </h1>
                <p>
                    Página creada para otorgar información, guía, consejo y ayuda extra
                    a todos los nuevos jugadores así como los ya existentes del
                    videojuego Honkai: Star Rail, creado por HoYoverse. En esta web
                    encontrarás traducciones directamente de las guías de
                    <a href="https://www.prydwen.gg/star-rail/" target="_blank">Prydwen</a>
                    así como opiniones propias, junto a comentarios de usuarios sobre ellas.
                </p>
            </section>

            <!-- Códigos activos -->
            <section class="active-codes-section">
                <h2><span class="blue-dot"></span> CÓDIGOS ACTIVOS</h2>
                <div class="codes-container">
                    <div class="code-card">
                        <strong>STARRAILGIFT</strong>
                        <p>50 Stellar Jades + materiales EXP</p>
                        <em>Lanzado el 26.04.2023</em>
                        <button class="copy-code" data-code="STARRAILGIFT">
                            <i class="far fa-copy"></i> Copiar
                        </button>
                    </div>
                    <div class="code-card">
                        <strong>CREATIONNYMPH</strong>
                        <p>60 Stellar Jades + materiales EXP</p>
                        <em>Lanzado el 07.07.2025</em>
                        <button class="copy-code" data-code="CREATIONNYMPH">
                            <i class="far fa-copy"></i> Copiar
                        </button>
                    </div>
                    <div class="code-card">
                        <strong>FAREWELL</strong>
                        <p>60 Stellar Jades + materiales EXP</p>
                        <em>Lanzado el 07.07.2025</em>
                        <button class="copy-code" data-code="FAREWELL">
                            <i class="far fa-copy"></i> Copiar
                        </button>
                    </div>
                    <div class="code-card">
                        <strong>IFYOUAREREADINGTHIS</strong>
                        <p>50 Stellar Jades + materiales EXP</p>
                        <em>Lanzado el 07.07.2025</em>
                        <button class="copy-code" data-code="IFYOUAREREADINGTHIS">
                            <i class="far fa-copy"></i> Copiar
                        </button>
                    </div>
                    <div class="code-card">
                        <strong>3S3RGX2PGL7P</strong>
                        <p>50 Stellar Jades + materiales EXP</p>
                        <em>Lanzado el 24.09.2025</em>
                        <button class="copy-code" data-code="3S3RGX2PGL7P">
                            <i class="far fa-copy"></i> Copiar
                        </button>
                    </div>
                </div>
            </section>

            <!-- Noticias o actualizaciones -->
            <section class="news-section">
                <h2><i class="fas fa-newspaper"></i> Últimas Actualizaciones</h2>
                <div class="news-container">
                    <article class="news-card">
                        <div class="news-date">V2.5</div>
                        <h3>Nuevo Personaje: [Próximo Lanzamiento]</h3>
                        <p>Próximamente se añadirá un nuevo personaje a la base de datos. Mantente atento a las actualizaciones.</p>
                        <a href="personajes.php" class="news-link">Ver Personajes</a>
                    </article>
                    <article class="news-card">
                        <div class="news-date">Reciente</div>
                        <h3>Sistema de Comentarios</h3>
                        <p>¡Ya puedes comentar sobre cada personaje! Haz click en cualquier personaje para ver y agregar comentarios.</p>
                        <a href="personajes.php" class="news-link">Comentar ahora</a>
                    </article>
                    <article class="news-card">
                        <div class="news-date">Siempre</div>
                        <h3>Base de Datos Actualizada</h3>
                        <p>Todos los personajes están actualizados con sus últimas estadísticas y habilidades a dia 15/12/2025.</p>
                        <a href="personajes.php" class="news-link">Explorar</a>
                    </article>
                </div>
            </section>
        </div>
    </main>

    <footer class="footer">
        <p>
            &copy; 2025 Rubén Daniel Ternero Molina. Este sitio es un proyecto
            personal sin fines comerciales. Honkai: Star Rail y todo su contenido
            son propiedad de miHoYo / HoYoverse.
        </p>
        <?php if (isset($_SESSION['usuario_id'])): ?>
            <p>
                <i class="fas fa-user"></i> Conectado como: 
                <?php echo htmlspecialchars($usuario_actual['nombre'] ?? $_SESSION['usuario_nombre'] ?? 'Usuario'); ?>
            </p>
        <?php endif; ?>
    </footer>

    <!-- Script para copiar códigos -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Copiar códigos al portapapeles
            document.querySelectorAll('.copy-code').forEach(button => {
                button.addEventListener('click', function() {
                    const code = this.getAttribute('data-code');
                    navigator.clipboard.writeText(code).then(() => {
                        const originalText = this.innerHTML;
                        this.innerHTML = '<i class="fas fa-check"></i> Copiado!';
                        this.style.background = '#4CAF50';
                        
                        setTimeout(() => {
                            this.innerHTML = originalText;
                            this.style.background = '';
                        }, 2000);
                    });
                });
            });
        });
    </script>
</body>
</html>