<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/header.css" rel="stylesheet" >
    <link href="css/footer.css" rel="stylesheet" >
    <title>HILLS SNACKS</title>
</head>
<body>
    <header>
        <nav class="navbar">
            <img src="Util/img/LogoHills.png" class="nav-logo" alt="">
            
            <ul class="nav-menu">
                <li class="nav-item"><a href="index.php" class="nav-link">INICIO</a></li>
                <li class="nav-item" id="perfil-link"><a href="Views/perfil.php" class="nav-link">PERFIL</a></li>
                <li class="nav-item" id="cerrar-link"><a href="Controllers/UsuarioClienteController.php" class="nav-link">CERRAR SESIÓN</a></li>
                <li class="nav-item" id="login-link"><a href="Views/login.html" class="nav-link">INICIAR SESIÓN</a></li>
                <li class="nav-item" id="registro-link"><a href="Views/RegistroU.html" class="nav-link">REGISTRO</a></li>
                <li class="nav-item" id="carrito-link"><a href="Views/carrito.php" class="nav-link">CARRITO</a></li>
            </ul>
            <div class="hamburger">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </nav>
    </header>
    <script src="Views/layouts/header.js"></script>