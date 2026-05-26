<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Clínica Dental Romo | Getxo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="estilos.css">
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
                <a href="index.php" class="logo-enlace">
                    <img src="assets/images/logo.png" alt="Clínica Dental Romo" class="logo-imagen">
                </a>
            </div>
            <button class="menu-toggle" id="menuToggle" aria-label="Abrir menú">
                <span></span><span></span><span></span>
            </button>
            <nav class="nav-principal" id="navPrincipal">
                <ul>
                    <li><a href="index.php" class="nav-link activo">Inicio</a></li>
                    <li><a href="paginas/paginaServicios.php" class="nav-link">Servicios</a></li>
                </ul>
                <a href="#contacto" class="boton-nav">Pedir cita</a>
            </nav>
        </div>
    </header>

    <main>

        <!-- HERO PARALLAX -->
        <section class="hero" id="hero">
            <div class="hero-parallax" id="heroParallax"></div>
            <div class="hero-overlay"></div>
            <div class="hero-contenido">
                <div class="hero-badge">
                    <i class="fas fa-star"></i> Más de 25 años de experiencia
                </div>
                <h1 class="hero-titulo">
                    Tu sonrisa<br>
                    <span class="titulo-destacado">merece lo mejor</span>
                </h1>
                <div class="hero-botones">
                    <a href="#contacto" class="boton-primario">
                        <i class="fas fa-calendar-alt"></i> Pedir cita ahora
                    </a>
                    <a href="#nosotros" class="boton-secundario">
                        Conoce la clínica <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="hero-stats">
                    <div class="stat">
                        <span class="stat-numero">25+</span>
                        <span class="stat-label">Años de experiencia</span>
                    </div>
                    <div class="stat-divider"></div>
                    <div class="stat">
                        <span class="stat-numero">5.0</span>
                        <span class="stat-label">Valoración Google</span>
                    </div>
                    <div class="stat-divider"></div>
                    <div class="stat">
                        <span class="stat-numero">33</span>
                        <span class="stat-label">Reseñas positivas</span>
                    </div>
                </div>
            </div>
            <div class="hero-scroll">
                <span>Descubre más</span>
                <div class="scroll-icono"><i class="fas fa-chevron-down"></i></div>
            </div>
        </section>

        <!-- SECCIÓN: NUESTRA CLÍNICA (reemplaza servicios) -->
        <section class="nuestra-clinica" id="nosotros">
            <div class="contenedor">
                <div class="clinica-grid">
                    <div class="clinica-imagen-wrapper">
                        <div class="clinica-imagen-principal">
                            <img src="assets/images/sala.jpg" 
                                 alt="Interior de la Clínica Dental Romo"
                                 onerror="this.parentElement.classList.add('imagen-placeholder')">
                        </div>
                        <div class="clinica-imagen-flotante">
                            <img src="assets/images/material.jpg" 
                                 alt="Equipo dental profesional"
                                 onerror="this.parentElement.classList.add('imagen-placeholder')">
                        </div>
                        <div class="clinica-badge-flotante">
                            <i class="fas fa-award"></i>
                            <div>
                                <strong>Colegiada</strong>
                                <span>Nº 778</span>
                            </div>
                        </div>
                    </div>
                    <div class="clinica-texto">
                        <div class="etiqueta-seccion">Sobre nosotros</div>
                        <h2 class="titulo-seccion">Una clínica de confianza <em>en Getxo</em></h2>
                        <p class="texto-intro">
                            Llevamos más de 25 años cuidando la salud bucodental de las familias de Getxo y alrededores. 
                            Nuestro compromiso es ofrecerte una atención personalizada, honesta y de la más alta calidad.
                        </p>
                        <div class="clinica-valores">
                            <div class="valor-item">
                                <div class="valor-icono">
                                    <i class="fas fa-heart"></i>
                                </div>
                                <div class="valor-texto">
                                    <h4>Trato cercano</h4>
                                    <p>Cada paciente es único. Te atendemos con la dedicación que mereces.</p>
                                </div>
                            </div>
                            <div class="valor-item">
                                <div class="valor-icono">
                                    <i class="fas fa-microscope"></i>
                                </div>
                                <div class="valor-texto">
                                    <h4>Tecnología avanzada</h4>
                                    <p>Equipados con escáner 3D CBCT y la última tecnología dental.</p>
                                </div>
                            </div>
                            <div class="valor-item">
                                <div class="valor-icono">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <div class="valor-texto">
                                    <h4>Materiales premium</h4>
                                    <p>Solo utilizamos materiales de la máxima calidad para garantizar los mejores resultados.</p>
                                </div>
                            </div>
                        </div>
                        <a href="paginas/paginaServicios.php" class="boton-primario">
                            Ver todos los servicios <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- PARALLAX INTERMEDIO -->
        <section class="parallax-cta" id="parallaxCta">
            <div class="parallax-cta-fondo" id="parallaxCtaFondo"></div>
            <div class="parallax-cta-overlay"></div>
            <div class="parallax-cta-contenido">
                <div class="contenedor">
                    <div class="cta-inner">
                        <div class="cta-texto">
                            <div class="etiqueta-seccion etiqueta-clara">Tu sonrisa importa</div>
                            <h2>¿Listo para transformar tu sonrisa?</h2>
                            <p>Pide tu primera visita sin compromiso. Te asesoramos y diseñamos el tratamiento perfecto para ti.</p>
                        </div>
                        <div class="cta-accion">
                            <a href="#contacto" class="boton-cta-grande">
                                <i class="fas fa-calendar-check"></i>
                                <span>
                                    <strong>Pedir cita</strong>
                                    <small>Sin compromiso</small>
                                </span>
                            </a>
                            <a href="tel:944800036" class="boton-telefono">
                                <i class="fas fa-phone-alt"></i>
                                <span>
                                    <strong>Llamar ahora</strong>
                                    <small>94 480 00 36</small>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- RAZONES -->
        <section class="razones" id="razones">
            <div class="contenedor">
                <div class="seccion-cabecera centrada">
                    <div class="etiqueta-seccion">¿Por qué elegirnos?</div>
                    <h2 class="titulo-seccion">3 razones para confiar en<br><em>Clínica Dental Romo</em></h2>
                </div>
                <div class="razones-grid">
                    <div class="razon-card" data-delay="0">
                        <div class="razon-numero">01</div>
                        <div class="razon-icono-wrap">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <h3>Profesionales con experiencia</h3>
                        <p>Contamos con profesionales con más de 25 años de experiencia demostrable, siempre actualizados con las últimas técnicas.</p>
                        <div class="razon-linea"></div>
                    </div>
                    <div class="razon-card destacada" data-delay="150">
                        <div class="razon-numero">02</div>
                        <div class="razon-icono-wrap">
                            <i class="fas fa-gem"></i>
                        </div>
                        <h3>Calidad de los materiales</h3>
                        <p>Solo empleamos los mejores materiales del mercado. Calidad superior a tu alcance, sin compromisos.</p>
                        <div class="razon-linea"></div>
                    </div>
                    <div class="razon-card" data-delay="300">
                        <div class="razon-numero">03</div>
                        <div class="razon-icono-wrap">
                            <i class="fas fa-microchip"></i>
                        </div>
                        <h3>Equipamiento de vanguardia</h3>
                        <p>La clínica cuenta con los equipos más avanzados, incluyendo el escáner 3D CBCT para diagnósticos precisos.</p>
                        <div class="razon-linea"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- GALERIA VISUAL -->
        <section class="galeria-visual">
            <div class="galeria-grid">
                <div class="galeria-item grande" style="background-image: url('assets/images/fachada.jpg')">
                    <div class="galeria-overlay">
                        <span>Instalaciones modernas</span>
                    </div>
                </div>
                <div class="galeria-columna">
                    <div class="galeria-item" style="background-image: url('assets/images/gabinete2.jpg')">
                        <div class="galeria-overlay">
                            <span>Tecnología avanzada</span>
                        </div>
                    </div>
                    <div class="galeria-item" style="background-image: url('assets/images/gabinete1.jpg')">
                        <div class="galeria-overlay">
                            <span>Equipo profesional</span>
                        </div>
                    </div>
                </div>
                <div class="galeria-columna">
                    <div class="galeria-item" style="background-image: url('assets/images/sala.jpg')">
                        <div class="galeria-overlay">
                            <span>Resultados excepcionales</span>
                        </div>
                    </div>
                    <div class="galeria-item" style="background-image: url('assets/images/despacho.jpg')">
                        <div class="galeria-overlay">
                            <span>Atención personalizada</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- TESTIMONIOS -->
        <section class="testimonios" id="testimonios">
            <div class="testimonios-parallax" id="testimoniosParallax"></div>
            <div class="testimonios-overlay"></div>
            <div class="contenedor testimonios-contenido">
                <div class="seccion-cabecera centrada cabecera-clara">
                    <div class="etiqueta-seccion etiqueta-clara">Opiniones reales</div>
                    <h2 class="titulo-seccion titulo-claro">Lo que dicen nuestros pacientes</h2>
                    <div class="google-rating">
                        <div class="estrellas-google">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <span class="rating-numero">5.0</span>
                        <span class="rating-texto">· 33 reseñas en Google</span>
                    </div>
                </div>
                <div class="testimonios-grid">
                    <div class="testimonio-card">
                        <div class="testimonio-estrellas">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i>
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <p class="testimonio-texto">"Un equipo profesional y amable. La atención es cuidadosa, explican todo con claridad y transmiten mucha confianza. Excelente."</p>
                        <div class="testimonio-autor">
                            <div class="autor-avatar">NG</div>
                            <div class="autor-info">
                                <strong>Nahia González</strong>
                                <span>Paciente</span>
                            </div>
                        </div>
                    </div>
                    <div class="testimonio-card">
                        <div class="testimonio-estrellas">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i>
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <p class="testimonio-texto">"Muy buenos profesionales y trato genial. Desde luego es para recomendar a toda la familia."</p>
                        <div class="testimonio-autor">
                            <div class="autor-avatar">CN</div>
                            <div class="autor-info">
                                <strong>Cristina Noriega</strong>
                                <span>Paciente</span>
                            </div>
                        </div>
                    </div>
                    <div class="testimonio-card">
                        <div class="testimonio-estrellas">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i>
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <p class="testimonio-texto">"Excelente trato y trabajos eficientes. Servicio serio y de confianza absoluta."</p>
                        <div class="testimonio-autor">
                            <div class="autor-avatar">ÍL</div>
                            <div class="autor-info">
                                <strong>Íñigo Linbo</strong>
                                <span>Paciente</span>
                            </div>
                        </div>
                    </div>
                    <div class="testimonio-card">
                        <div class="testimonio-estrellas">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i>
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <p class="testimonio-texto">"Soy paciente desde hace 20 años. No cambiaría ni por nada del mundo. Profesionales de categoría."</p>
                        <div class="testimonio-autor">
                            <div class="autor-avatar">IL</div>
                            <div class="autor-info">
                                <strong>Itziar Landea</strong>
                                <span>Paciente fiel</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- FOOTER -->
    <footer class="footer" id="contacto">
        <div class="footer-superior">
            <div class="contenedor">
                <div class="footer-grid">
                    <div class="footer-columna">
                        <div class="footer-logo">
                            <a href="index.php" class="logo-enlace">
                                <img src="assets/images/logo.png" alt="Clínica Dental Romo" class="logo-imagen-footer">
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
                        <form action="controllers/contacto_controller.php" method="POST" id="formContacto">
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
        <!-- Enlace oculto admin -->
        <div style="text-align: center; margin-top: 1rem;">
            <a href="admin/login.php" style="color: transparent; text-decoration: none;">.</a>
        </div>
    </footer>

    <script src="assets/js/contacto.js"></script>
    <script src="assets/js/index.js"></script>
</body>
</html>