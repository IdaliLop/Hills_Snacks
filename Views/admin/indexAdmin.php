<?php
/*Inicia la sesión si aún no ha sido iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../login.html');
    exit();
}*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Links comunes de CSS -->
  <link rel="stylesheet" type="text/css" href="../../css/indexAd.css"/>
  <link rel="stylesheet" type="text/css" href="../../css/pedidos.css"/>
  <link rel="stylesheet" type="text/css" href="../../css/historial.css">
  <link rel="stylesheet" type="text/css" href="../../css/catalogo.css">
  <link rel="stylesheet" type="text/css" href="../../css/inventario.css">
  <link rel="stylesheet" type="text/css" href="../../css/cuenta.css">
  <link rel="stylesheet" type="text/css" href="../../css/agregar.css">
  <link rel="stylesheet" type="text/css" href="../../css/ayuda.css">

  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <title>ADMINISTRADOR</title>
</head>
<body>

<button class="menu-toggle" id="menu-toggle">
  <i class='bx bx-menu'></i>
</button>

<nav class="sidebar_nav" id="sidebar">
  <ul>
    <li class="sidebar__item"><a class="logo">
      <img src="../../Util/img/LogoHills.png" alt="LogoHills" width="100" height="100">
      <span class="nav_admin" style="color: var(--grey);">PERFIL ADMINISTRADOR <hr></span>
    </a></li>

    <li class="sidebar_title"><span class="nav_title" style="color: var(--grey);">Inicio <hr></span></li>

    <fieldset>
    <li class="sidebar_item" data-section="pedidos.php"><a href="#">
        <span class="icon"><i class='bx bx-cycling'></i></span>
        <span class="title">Pedidos</span>
      </a></li>
      <li class="sidebar_item" data-section="historial.php"><a href="#">
        <span class="icon"><i class='bx bx-folder'></i></span>
        <span class="title">Historial de órdenes</span>
      </a></li>
    </fieldset>

    <li class="sidebar_title"><span class="nav_title" style="color: var(--grey);">ADMINISTRAR PRODUCTOS <hr></span></li>

    <fieldset>
    <li class="sidebar_item" data-section="catalogo.php"><a href="#">
        <span class="icon"><i class='bx bx-basket'></i></span>
        <span class="title">Catálogo de productos</span>
      </a></li>
      <li class="sidebar_item" data-section="inventario.php"><a href="#">
        <span class="icon"><i class='bx bx-edit'></i></span>
        <span class="title">Inventario de productos</span>
      </a></li>
    </fieldset>

    <li class="sidebar_title"><span class="nav_title" style="color: var(--grey);" >Cuenta <hr></i></span></li>
    <fieldset>
      <li class="sidebar_item" data-section="cuenta.php"><a href="#">  
        <span class="icon"><i class='bx bx-id-card' ></i></span>
        <span class="title">Mi cuenta</span>
      </a></li>

      <li class="sidebar_item" data-section="ayuda.php"><a href="#">
        <span class="icon"><i class='bx bx-help-circle'></i></span>
        <span class="title">Centro de ayuda</span>
      </a></li>

      <li class="sidebar_item"><a href="cerrar.php">
        <span class="icon"><i class='bx bx-log-out'></i></span>
        <span class="title">Salir</span>
      </a></li>
      
    </fieldset>
  </ul>
</nav>

<!-- Contenido principal -->
<main id="main-content" class="main-content">
  <div id="content-placeholder">
    <h1>Selecciona la opción que deseas ver...</h1>
  </div>

  <div id="pedidos-section" class="content_section" style="display: none;">
  <!-- contenido de pedidos.php -->
  </div>

  <div id="historial-section" class="content_section" style="display: none;">
    <!-- contenido de historial.php -->
  </div>

  <div id="catalogo-section" class="content_section" style="display: none;">
    <!-- contenido de catalogo.php -->
  </div>

  <div id="inventario-section" class="content_section" style="display: none;">
    <!-- contenido de inventario.php -->
  </div>

  <div id="cuenta-section" class="content_section" style="display: none;">
    <!-- contenido de cuenta.php -->
  </div>

  <div id="ayuda-section" class="content_section" style="display: none;">
    <!-- contenido de ayuda.php -->
  </div>

</main>



<!-- Funciones comunes -->
<script src="../../js/funciones.js" defer></script>


</body>
</html>


