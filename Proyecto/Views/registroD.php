<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../Util/css/registroD.css" rel="stylesheet"/>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Registro de negocio</title>

</head>

<body>
    <div class="wrapper">
    <form action="">
        <h1>REGISTRO DUEÑO</h1>
        <fieldset>
            <legend>Información del Dueño</legend>
        <div class="input-group">
            <div class="input-box">
                <i class='bx bx-user'></i>
                <input type="text" placeholder="Tu nombre" required>
            </div>
            <div class="input-box">
                <i class='bx bx-user'></i>
                <input type="text" placeholder="Tu Apellido" required>
            </div>
        </div>
    </fieldset>
    <fieldset>
        <legend>Informacion de Contacto</legend>
        <div class="input-box">
            <i class='bx bx-phone'></i>
            <input type="tel" pattern="[0-9]{10}" placeholder="Telefono" required> 
        </div>
        <div class="input-box">
            <i class='bx bx-envelope' ></i>
            <input type="email" placeholder="Correo" required>
        </div>
        <div class="input-box">
            <i class='bx bx-lock-alt'></i>
            <input type="password" placeholder="Crea una Contraseña" required> 
        </div>
    </fieldset>

    <div class="register-link"></divclass>
        <p>Al dar en continuar podras registrar tu negocio</p>
    </div>

        <button type="submit" onclick="Negocio()" class="btn">Contunuar</button>

        <div class="register-link">
            <p>Ya tienes cuenta? <a href="login.php">Iniciar Sesión</a></p>
        </div>
    </div>
    </form>

    <script>
        function Negocio(){
                window.location.href="registroN.php";
        }
    </script>

</body>
</html>