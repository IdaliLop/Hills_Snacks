<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Util/css/registroU.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Registro de negocio</title>

</head>

<body>
    <div class="wrapper">
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" name="login">
        <h1>REGISTRO USUARIO</h1>
        <div class="input-group">
            <div class="input-box">
                <i class='bx bx-user'></i>
                <input type="text" placeholder="Tu nombre" name="usuario" required>
            </div>
            <div class="input-box">
                <i class='bx bx-user'></i>
                <input type="text" placeholder="Tu Apellido" name="apellido" required>
            </div>
        </div>
        <div class="input-box">
            <i class='bx bx-phone'></i>
            <input type="tel" pattern="[0-9]{10}" name="telefono" placeholder="Telefono" required> 
        </div>
        <div class="input-group">
            <div class="input-box">
                <i class='bx bx-map'></i>
                <input type="text" placeholder="Dirección" name="direc" required>
            </div>
        </div>
        <div class="input-box">
            <i class='bx bx-envelope' ></i>
            <input type="email" placeholder="Correo electronico" name="correo" required>
        </div>
        <div class="input-box">
            <i class='bx bx-lock-alt'></i>
            <input type="password" placeholder="Crea una Contraseña" name="pass" required> 
        </div> 

        <button type="submit"   class="btn">Continuar</button>

        <div class="register-link">
            <p>Ya tienes cuenta? <a href="login.php">Iniciar Sesión</a></p>
        </div>
        <!-- <div class="register-link">
            <p>Eres Negocio? <a href="../login_registro/views/RegistrateD.view.php">Registrar Negocio</a></p>
        </div> -->

    </form>
</body>
</html>
        