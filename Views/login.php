<?php
$error = null;
$exito = null;
if (isset($_GET['error'])) {
    $error = ($_GET['error'] === 'token')
        ? 'El enlace de verificación no es válido o ya fue usado.'
        : 'Correo o contraseña incorrectos.';
}
$mensajesExito = [
    'registro' => ['ok'      => 'Tu cuenta fue creada. Ya puedes iniciar sesión.',
                   'correo'  => 'Tu cuenta fue creada. Revisa tu correo para validarla.'],
    'validacion' => ['exitosa' => 'Cuenta validada. Ya puedes iniciar sesión.'],
    'negocio'  => ['ok'      => 'Tu negocio fue registrado. Inicia sesión para administrarlo.'],
];
foreach ($mensajesExito as $clave => $opciones) {
    if (isset($_GET[$clave], $opciones[$_GET[$clave]])) {
        $exito = $opciones[$_GET[$clave]];
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/estilosLog.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Login de Hills Snacks</title>
</head>

<body>
    <div class="wrapper">
        <!-- Mostrar mensajes de error si los hay -->
        <?php if ($exito): ?>
            <div id="successMessage" style="color: #1b5e20; text-align: center; margin-bottom: 10px;">
                <?= htmlspecialchars($exito) ?>
            </div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div id="errorMessage" style="color: red; text-align: center; margin-bottom: 10px;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <!-- Enviar datos al archivo controlador -->
        <form id="loginForm" method="POST" action="../index.php?action=login">
            <h1>INICIO DE SESIÓN</h1>

            <div class="input-box">
                <i class='bx bx-user'></i>
                <input type="email" name="email" placeholder="Correo que registraste" required autofocus>
            </div>

            <div class="input-box">
                <i class='bx bx-lock-alt'></i>
                <input type="password" name="password" placeholder="Contraseña" required>
            </div>

            <div class="remember-forgot">
                <label><input type="checkbox" name="remember"> Recordar usuario</label>
            </div>
            <div class="register-link">
                <p>¿No tienes cuenta? <a href="RegistroU.html">Crear cuenta</a></p>
            </div>

            <button type="submit" class="btn">Login</button>
        </form>
    </div>
<script>
    // "Recordar usuario": guarda solo el correo en este navegador
    (function () {
        var correo = document.querySelector('input[name=email]');
        var recordar = document.querySelector('input[name=remember]');
        try {
            var guardado = localStorage.getItem('correoRecordado');
            if (guardado) { correo.value = guardado; recordar.checked = true; }
            document.getElementById('loginForm').addEventListener('submit', function () {
                if (recordar.checked) { localStorage.setItem('correoRecordado', correo.value); }
                else { localStorage.removeItem('correoRecordado'); }
            });
        } catch (e) {}
    })();
</script>
</body>

</html>
