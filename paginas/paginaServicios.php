<?php
// Pagina de servicios dinamica desde BD

// Incluir conexion a la base de datos
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Servicio.php';

$database = new Database();
$db = $database->getConnection();
$servicioModel = new Servicio($db);

// Obtener solo servicios activos (activo = 1)
$stmt = $servicioModel->obtenerActivos();
$totalServicios = $stmt->rowCount();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Servicios - Clínica Dental Romo | Getxo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>

    <!-- BARRA SUPERIOR DE CONTACTO -->
    <div class="barra-superior">
        <div class="contenedor-barra">
            <div class="barra-izquierda">
                <span>94 480 00 36 <i class="fas fa-phone-alt"></i></span>
                <span>clinica@clinicadentalromo.com <i class="fas fa-envelope"></i></span>
            </div>
            <div class="barra-derecha">
                <span><i class="fas fa-map-marker-alt"></i> Lope de Vega 13 · Las Arenas, Getxo</span>
            </div>
        </div>
    </div>

    <!-- HEADER -->
    <header class="header" id="header">
        <div class="contenedor-header">
            <div class="logo">
                <a href="../index.php" class="logo-enlace">
                    <img src="../assets/images/logo.png" alt="Clínica Dental Romo" class="logo-imagen">
                </a>
            </div>
            <button class="menu-toggle" id="menuToggle" aria-label="Abrir menú">
                <span></span><span></span><span></span>
            </button>
            <nav class="nav-principal" id="navPrincipal">
                <ul>
                    <li><a href="../index.php" class="nav-link">Inicio</a></li>
                    <li><a href="paginaServicios.php" class="nav-link activo">Servicios</a></li>
                </ul>
                <a href="#contacto" class="boton-nav">Pedir cita</a>
            </nav>
        </div>
    </header>

    <main>

        <!-- HERO SERVICIOS -->
        <section class="hero-servicios">
            <div class="hero-servicios-fondo"></div>
            <div class="hero-servicios-overlay"></div>
            <div class="hero-servicios-contenido">
                <div class="hero-badge">
                    <i class="fas fa-tooth"></i> Tratamientos de calidad
                </div>
                <h1 class="hero-titulo">
                    Nuestros<br>
                    <span class="titulo-destacado">Servicios</span>
                </h1>
                <p class="hero-subtitulo">
                    Ofrecemos una amplia gama de tratamientos dentales personalizados 
                    para toda la familia, utilizando la última tecnología y los mejores materiales.
                </p>
            </div>
        </section>

        <!-- SECCION SERVICIOS DESTACADOS -->
        <section class="servicios-destacados">
            <div class="contenedor">
                <div class="seccion-cabecera centrada">
                    <div class="etiqueta-seccion">Tratamientos</div>
                    <h2 class="titulo-seccion">Amplio abanico de <em>servicios</em></h2>
                    <p class="seccion-descripcion">
                        En Clínica Dental Romo encontrarás todos los tratamientos que necesitas para cuidar tu sonrisa, 
                        desde revisiones hasta tratamientos especializados.
                    </p>
                </div>

                <div class="servicios-grid">
                    <?php if ($totalServicios > 0): ?>
                        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                            <div class="servicio-card">
                                <div class="servicio-icono">
                                    <i class="<?php echo htmlspecialchars($row['icono']); ?>"></i>
                                </div>
                                <h3><?php echo htmlspecialchars($row['nombre']); ?></h3>
                                <p><?php echo htmlspecialchars($row['descripcion']); ?></p>
                                <div class="servicio-linea"></div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="sin-servicios">
                            <p>No hay servicios disponibles en este momento.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- SECCION TECNOLOGIA -->
        <section class="tecnologia-cta">
            <div class="contenedor">
                <div class="tecnologia-grid">
                    <div class="tecnologia-texto">
                        <div class="etiqueta-seccion">Tecnología avanzada</div>
                        <h2 class="titulo-seccion">Equipamiento de <em>vanguardia</em></h2>
                        <p>Dotamos a la Clínica Dental Romo de los equipos más avanzados para garantizar diagnósticos precisos y tratamientos eficaces.</p>
                        <ul class="tecnologia-lista">
                            <li><i class="fas fa-check-circle"></i> Escáner 3D CBCT</li>
                            <li><i class="fas fa-check-circle"></i> Radiografía digital</li>
                            <li><i class="fas fa-check-circle"></i> Láser dental</li>
                            <li><i class="fas fa-check-circle"></i> Microscopio quirúrgico</li>
                        </ul>
                    </div>
                    <div class="tecnologia-imagen">
                        <div class="tecnologia-img-wrapper">
                            <img src="../assets/images/gabinete2.jpg" alt="Tecnología dental avanzada" onerror="this.parentElement.classList.add('imagen-placeholder')">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CITA RAPIDA -->
        <section class="cita-rapida" id="contacto">
            <div class="contenedor">
                <div class="cita-rapida-inner">
                    <div class="cita-rapida-texto">
                        <h3>¿Necesitas más información?</h3>
                        <p>Pide tu primera visita sin compromiso y descubre cómo podemos ayudarte a conseguir la sonrisa que siempre has deseado.</p>
                    </div>
                    <div class="cita-rapida-botones">
                        <a href="tel:944800036" class="boton-telefono-grande">
                            <i class="fas fa-phone-alt"></i>
                            <span>Llamar ahora</span>
                        </a>
                        <a href="#contacto" class="boton-primario">
                            <i class="fas fa-calendar-alt"></i> Pedir cita
                        </a>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- FOOTER -->
    <footer class="footer" id="footer">
        <div class="footer-superior">
            <div class="contenedor">
                <div class="footer-grid">
                    <div class="footer-columna">
                        <div class="footer-logo">
                            <a href="../index.php" class="logo-enlace">
                                <img src="../assets/images/logo-clinica-blanco.png" alt="Clínica Dental Romo" class="logo-imagen-footer">
                            </a>
                        </div>
                        <p class="footer-desc">Cuidando tu sonrisa en Getxo desde hace más de 25 años con profesionalidad, calidad y dedicación.</p>
                        <div class="footer-contacto-info">
                            <a href="https://maps.google.com" target="_blank" class="footer-dato">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Lope de Vega 13<br>48993 - Areeta (GETXO)</span>
                            </a>
                            <a href="tel:944800036" class="footer-dato">
                                <i class="fas fa-phone-alt"></i>
                                <span>94 480 00 36</span>
                            </a>
                            <a href="mailto:clinica@clinicadentalromo.com" class="footer-dato">
                                <i class="fas fa-envelope"></i>
                                <span>clinica@clinicadentalromo.com</span>
                            </a>
                        </div>
                        <p class="colegiada">Colegiada Nº 778</p>
                    </div>

                    <div class="footer-columna">
                        <h4 class="footer-titulo">Horario de atención</h4>
                        <div class="horario-lista">
                            <div class="horario-item">
                                <span class="horario-dia">Lunes</span>
                                <span class="horario-horas">9:30-13:30 · 15:00-19:00</span>
                            </div>
                            <div class="horario-item">
                                <span class="horario-dia">Martes</span>
                                <span class="horario-horas">14:30-18:00</span>
                            </div>
                            <div class="horario-item">
                                <span class="horario-dia">Miércoles</span>
                                <span class="horario-horas">9:30-13:30 · 15:00-19:00</span>
                            </div>
                            <div class="horario-item">
                                <span class="horario-dia">Jueves</span>
                                <span class="horario-horas">9:30-13:30 · 15:00-19:00</span>
                            </div>
                            <div class="horario-item">
                                <span class="horario-dia">Viernes</span>
                                <span class="horario-horas">9:30-13:30</span>
                            </div>
                            <div class="horario-item cerrado">
                                <span class="horario-dia">Sáb - Dom</span>
                                <span class="horario-horas">Cerrado</span>
                            </div>
                        </div>
                    </div>

                    <div class="footer-columna footer-formulario-col">
                        <h4 class="footer-titulo">¿Tienes alguna duda?</h4>
                        <p class="footer-formulario-desc">Escríbenos y te responderemos lo antes posible.</p>
                        <form action="../controllers/contacto_controller.php" method="POST" id="formContacto">
                            <div class="campo-form">
                                <input type="text" name="nombre" placeholder="Nombre completo *" required>
                            </div>
                            <div class="campo-form">
                                <input type="email" name="email" placeholder="Correo electrónico *" required>
                            </div>
                            <div class="campo-form">
                                <input type="tel" name="telefono" placeholder="Teléfono (opcional)">
                            </div>
                            <div class="campo-form">
                                <textarea name="mensaje" placeholder="¿En qué podemos ayudarte? *" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="boton-enviar">
                                <i class="fas fa-paper-plane"></i> Enviar mensaje
                            </button>
                        </form>
                        <div id="mensajeContactoRespuesta"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-inferior">
            <div class="contenedor">
                <p>&copy; 2025 Clínica Dental Romo · Todos los derechos reservados</p>
                <div class="footer-links">
                    <a href="#">Política de privacidad</a>
                    <a href="#">Aviso legal</a>
                </div>
            </div>
        </div>
        <div style="text-align: center; margin-top: 1rem;">
            <a href="../admin/login.php" style="color: transparent; text-decoration: none;">.</a>
        </div>
    </footer>

    <script src="../assets/js/contacto.js"></script>
    <script src="../assets/js/index.js"></script>
</body>
</html>