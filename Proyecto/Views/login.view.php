<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Util/css/login.css" rel="stylesheet" type="text/css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Login de hills snacks</title>    

</head>

<body>
    <!--Clase para el formulario -->
    <div class="wrapper">
        <!-- Formulario de registro -->
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" name="login">
        <h1>INICIO DE SESIÓN</h1>
        <!-- Perdir el usuario -->

        <div class="input-box">
            <i class='bx bx-user'></i>
            <input type="text" placeholder="Usuario" name="usuario" required>
        </div>
        <!-- Pedir Contraseña -->
        <div class="input-box">
            <i class='bx bx-lock-alt'></i>
            <input type="password" placeholder="Contraseña" name="pass" required> 
        </div>
    
        <!-- Opción de recordaar usuario -->
        <div class="remember-forgot">
            <label><input type="checkbox">Recordar usuario</label>
            <a href="#">Olvidaste tu Contraseña?</a>
        </div>

        <button type="submit" class="btn">Login</button>

        <div class="register-link">
            <p>No tienes cuenta? <a href="../registrateU.php">Registareme</a></p>
        </div>
        <div class="register-link">
            <p>Eres Negcio? <a href="RegistroD.html">Registrar mi Negocio</a></p>
        </div>
        

    </form>

    <!-- <script>
        function index(){
                window.location.href="../login_registro/contenido.php";
        }
    </script> -->

</body>
</html>