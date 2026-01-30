// Validaciones Frontend

document.addEventListener('DOMContentLoaded', function() {

    // Validación formulario de login
    const formLogin = document.getElementById('form-login');
    if (formLogin) {
        formLogin.addEventListener('submit', function(e) {
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;

            if (!email || !password) {
                e.preventDefault();
                alert('Todos los campos son obligatorios');
                return;
            }

            if (!validarEmail(email)) {
                e.preventDefault();
                alert('Por favor ingresa un email válido');
                return;
            }
        });
    }

    // Validación formulario de registro
    const formRegistro = document.getElementById('form-registro');
    if (formRegistro) {
        formRegistro.addEventListener('submit', function(e) {
            const nombre = document.getElementById('nombre').value.trim();
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            const passwordConfirm = document.getElementById('password_confirm').value;

            if (!nombre || !email || !password || !passwordConfirm) {
                e.preventDefault();
                alert('Todos los campos son obligatorios');
                return;
            }

            if (nombre.length < 3) {
                e.preventDefault();
                alert('El nombre debe tener al menos 3 caracteres');
                return;
            }

            if (!validarEmail(email)) {
                e.preventDefault();
                alert('Por favor ingresa un email válido');
                return;
            }

            if (password.length < 6) {
                e.preventDefault();
                alert('La contraseña debe tener al menos 6 caracteres');
                return;
            }

            if (password !== passwordConfirm) {
                e.preventDefault();
                alert('Las contraseñas no coinciden');
                return;
            }
        });
    }

    // Validación formulario de libro
    const formLibro = document.getElementById('form-libro');
    if (formLibro) {
        formLibro.addEventListener('submit', function(e) {
            const titulo = document.getElementById('titulo').value.trim();
            const autor = document.getElementById('autor').value.trim();
            const descripcion = document.getElementById('descripcion').value.trim();
            const genero = document.getElementById('genero').value;
            const anio = document.getElementById('anio').value;

            if (!titulo || !autor || !descripcion || !genero || !anio) {
                e.preventDefault();
                alert('Todos los campos son obligatorios');
                return;
            }

            const anioNum = parseInt(anio);
            const anioActual = new Date().getFullYear();
            if (anioNum < 1000 || anioNum > anioActual) {
                e.preventDefault();
                alert('El año debe estar entre 1000 y ' + anioActual);
                return;
            }
        });
    }

    // Validación formulario de comentario
    const formComentario = document.querySelector('.form-comentario');
    if (formComentario) {
        formComentario.addEventListener('submit', function(e) {
            const contenido = formComentario.querySelector('textarea').value.trim();

            if (!contenido) {
                e.preventDefault();
                alert('El comentario no puede estar vacío');
                return;
            }
        });
    }

});

// Función para validar email
function validarEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}
