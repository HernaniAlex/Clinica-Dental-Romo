// =====================
// HEADER SCROLL
// =====================
function initHeaderScroll() {
    const header = document.getElementById('header');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 80) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });
}

// =====================
// MENÚ MÓVIL
// =====================
function initMenuMovil() {
    const toggle = document.getElementById('menuToggle');
    const nav    = document.getElementById('navPrincipal');
    if (toggle && nav) {
        toggle.addEventListener('click', () => {
            toggle.classList.toggle('activo');
            nav.classList.toggle('abierto');
        });

        // Cerrar menú al hacer clic en un enlace
        document.querySelectorAll('.nav-link, .boton-nav').forEach(link => {
            link.addEventListener('click', () => {
                toggle.classList.remove('activo');
                nav.classList.remove('abierto');
            });
        });
    }
}

// =====================
// ANIMACIÓN DE CONTADORES (HERO STATS)
// =====================
function initContadores() {
    const contadores = document.querySelectorAll('.stat-numero');
    if (!contadores.length) return;

    let contados = false;

    function iniciarContadores() {
        if (contados) return;
        
        contadores.forEach(contador => {
            const texto = contador.innerText;
            const esNumero = /^[\d\.\+\-]+$/.test(texto);
            if (!esNumero) return;
            
            let valorFinal;
            if (texto.includes('+')) {
                valorFinal = parseInt(texto);
            } else {
                valorFinal = parseFloat(texto);
            }
            
            if (isNaN(valorFinal)) return;
            
            let valorActual = 0;
            const duracion = 1500;
            const incremento = valorFinal / (duracion / 16);
            
            const actualizarContador = () => {
                valorActual += incremento;
                if (valorActual < valorFinal) {
                    if (texto.includes('.')) {
                        contador.innerText = valorActual.toFixed(1);
                    } else {
                        contador.innerText = Math.floor(valorActual);
                    }
                    requestAnimationFrame(actualizarContador);
                } else {
                    contador.innerText = texto;
                }
            };
            
            requestAnimationFrame(actualizarContador);
        });
        
        contados = true;
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                iniciarContadores();
                observer.disconnect();
            }
        });
    }, { threshold: 0.5 });

    const heroStats = document.querySelector('.hero-stats');
    if (heroStats) observer.observe(heroStats);
}

// =====================
// ANIMACIÓN DE ENTRADA DE BLOQUES (fade-up, fade-left, fade-right)
// =====================
function initAnimacionesEntrada() {
    // Añadir clases de animación a los elementos
    const heroContenido = document.querySelector('.hero-contenido');
    if (heroContenido) {
        heroContenido.classList.add('fade-up');
        heroContenido.style.animationDelay = '0.2s';
    }

    // Añadir clase fade-left a elementos de la izquierda
    const clinicaImagen = document.querySelector('.clinica-imagen-wrapper');
    if (clinicaImagen) clinicaImagen.classList.add('fade-left');

    // Añadir clase fade-right a elementos de la derecha
    const clinicaTexto = document.querySelector('.clinica-texto');
    if (clinicaTexto) clinicaTexto.classList.add('fade-right');

    // Añadir fade-up a las tarjetas de razones
    document.querySelectorAll('.razon-card').forEach((card, index) => {
        card.classList.add('fade-up');
        card.style.transitionDelay = `${index * 0.1}s`;
    });

    // Añadir fade-up a los testimonios
    document.querySelectorAll('.testimonio-card').forEach((card, index) => {
        card.classList.add('fade-up');
        card.style.transitionDelay = `${index * 0.1}s`;
    });

    // Añadir fade-up a los valores de la clínica
    document.querySelectorAll('.valor-item').forEach((item, index) => {
        item.classList.add('fade-left');
        item.style.transitionDelay = `${index * 0.1}s`;
    });

    // Añadir fade-up a las galerías
    const galeriaItems = document.querySelectorAll('.galeria-item');
    galeriaItems.forEach((item, index) => {
        item.classList.add('fade-up');
        item.style.transitionDelay = `${index * 0.08}s`;
    });

    // Añadir fade-up al CTA
    const ctaInner = document.querySelector('.cta-inner');
    if (ctaInner) ctaInner.classList.add('fade-up');
}

// =====================
// INTERSECTION OBSERVER PARA ANIMACIONES
// =====================
function initObserverAnimaciones() {
    const elementos = document.querySelectorAll('.fade-up, .fade-left, .fade-right');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.15, rootMargin: '0px 0px -50px 0px' });
    
    elementos.forEach(el => observer.observe(el));
}

// =====================
// ANIMACIÓN DE LAS IMÁGENES DE GALERÍA (hover ya está en CSS)
// =====================
function initGaleriaHover() {
    const galeriaItems = document.querySelectorAll('.galeria-item');
    galeriaItems.forEach(item => {
        item.addEventListener('mouseenter', () => {
            galeriaItems.forEach(other => {
                if (other !== item) {
                    other.style.opacity = '0.7';
                    other.style.transition = 'opacity 0.3s ease';
                }
            });
        });
        item.addEventListener('mouseleave', () => {
            galeriaItems.forEach(other => {
                other.style.opacity = '1';
            });
        });
    });
}

// =====================
// INICIALIZAR TODO
// =====================
document.addEventListener('DOMContentLoaded', () => {
    initHeaderScroll();
    initMenuMovil();
    initContadores();
    initAnimacionesEntrada();
    initObserverAnimaciones();
    initGaleriaHover();
});