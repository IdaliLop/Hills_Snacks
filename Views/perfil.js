// Verificar si hay sesión activa y mostrar los datos del usuario
function obtenerDatosUsuario() {
    fetch('Controllers/UsuarioClienteController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'funcion=verificar_sesion'
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error al obtener los datos');
        }
        return response.json();
    })
    .then(data => {
        if (data.id) {
            // Mostrar los datos del usuario
            document.getElementById('nombre').textContent = data.nombre;
            document.getElementById('apellido').textContent = data.apellido;
            document.getElementById('correo').textContent = data.correo;
            document.getElementById('telefono').textContent = data.telefono || 'No disponible';
            document.getElementById('domicilio').textContent = data.domicilio || 'No disponible';
        } else {
            console.error('No hay sesión activa');
        }
    })
    .catch(error => console.error('Error:', error));
}

// Llamar a la función cuando se cargue la página
document.addEventListener('DOMContentLoaded', obtenerDatosUsuario);

// Función para cerrar sesión
function cerrarSesion() {
    fetch('Controllers/UsuarioClienteController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'funcion=cerrar_sesion'
    })
    .then(response => {
        if (response.ok) {
            window.location.href = 'index.php'; // Redirigir a la página de inicio
        } else {
            console.error('Error al cerrar la sesión');
        }
    })
    .catch(error => console.error('Error:', error));
}
