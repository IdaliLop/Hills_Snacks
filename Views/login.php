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
        <?php if (isset($error)): ?>
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
                <a href="#">¿Olvidaste tu contraseña?</a>
            </div>
            <div class="register-link">
                <p>¿No tienes cuenta? <a href="RegistroU.html">Crear cuenta</a></p>
            </div>

            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</body>

</html>
