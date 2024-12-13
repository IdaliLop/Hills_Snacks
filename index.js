verificar_sesion();

function verificar_sesion() {
    fetch('Controllers/UsuarioClienteController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'funcion=verificar_sesion',
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en la solicitud al servidor');
        }
        return response.json();
    })
    .then(data => {
        if (data.id) {
            // Sesión activa: muestra enlaces relevantes
            document.getElementById('login-link').style.display = 'none';
            document.getElementById('registro-link').style.display = 'none';
            document.getElementById('cerrar-link').style.display = 'block';
            document.getElementById('carrito-link').style.display = 'block';
            document.getElementById('perfil-link').style.display = 'block';
            console.log("Sesión activa:", data);
        } else {
            // No hay sesión activa: oculta elementos protegidos
            document.getElementById('cerrar-link').style.display = 'none';
            document.getElementById('carrito-link').style.display = 'none';
            document.getElementById('perfil-link').style.display = 'none';
            console.log("No hay sesión activa");
        }
    })
    .catch(error => console.error('Error al verificar la sesión:', error));
}



