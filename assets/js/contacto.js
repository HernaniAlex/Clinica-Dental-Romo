document.addEventListener('DOMContentLoaded', function() {
    const formContacto = document.getElementById('formContacto');
    
    if (formContacto) {
        formContacto.addEventListener('submit', function(event) {

            // validaciones de seguridad
            const nombre = this.querySelector('input[name="nombre"]');
            const email = this.querySelector('input[name="email"]');
            const mensaje = this.querySelector('textarea[name="mensaje"]');
            let errores = [];
            
            // Limpiar estilos previos
            document.querySelectorAll('.campo-form').forEach(campo => {
                campo.classList.remove('error');
            });
            
            // Validación visual de nombre
            if (nombre.value.trim().length < 2) {
                errores.push('El nombre debe tener al menos 2 caracteres');
                nombre.closest('.campo-form').classList.add('error');
            }
            
            // Validación visual de email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email.value)) {
                errores.push('Introduce un email válido');
                email.closest('.campo-form').classList.add('error');
            }
            
            // Validación visual de mensaje
            if (mensaje.value.trim().length < 10) {
                errores.push('El mensaje debe tener al menos 10 caracteres');
                mensaje.closest('.campo-form').classList.add('error');
            }
            
            if (errores.length > 0) {
                event.preventDefault();
                alert('Por favor corrige los siguientes errores:\n- ' + errores.join('\n- '));
            }
        });
    }
});