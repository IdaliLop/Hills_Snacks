<?php
//session_start(); // Iniciar la sesión.

//if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    //header("Location: ../views/login.html"); // Redirigir a login si no está logueado o no es un dueño.
    //exit();
//}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="../css/indexAd.css"/>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <title>ADMINISTRADOR</title>
</head>
<body>

  <nav class="sidebar_nav">
    <ul>
      <li class="sidebar_item"><a href="#" class="logo">
        <img src="../img/LogoHills.png" alt="LogoHills" width="100" height="100">
        <span class="nav_title">PERFIL ADMINISTRADOR <hr></span>
      </a></li>

      <li class="sidebar_title">
        <span class="nav_title" style="color: var(--black2);">Inicio <hr></i></span>
      </li>

      <fieldset>
        <li class="sidebar_item" onclick="showContent('pedidos')"><a href="#">
          <span class="icon"><i class='bx bx-cycling'></i></span>
          <span class="title">Pedidos</span>
        </a></li>

        <li class="sidebar_item" onclick="showContent('historial')" ><a href="#">
          <span class="icon"><i class='bx bx-folder'></i></span>
          <span class="title">Historial de órdenes</span>
        </a></li>

        <li class="sidebar_item" onclick="showContent('estado')"><a href="#">
          <span class="icon"><i class='bx bx-time-five'></i></span>
          <span class="title">Estado de Solicitudes</span>
        </a></li>
      </fieldset>

      <li class="sidebar_title">
        <span class="nav_title" style="color: var(--black2);" >ADMINISTRAR PRODUCTOS <hr></span>
      </li>

      <fieldset>
        <li class="sidebar_item" onclick="showContent('combos')"><a href="#">
          <span class="icon"><i class='bx bx-food-menu'></i></span>
          <span class="title">Combos</span>
          
        </a></li>
        <li class="sidebar_item" onclick="showContent('catalogo')"><a href="#">
          <span class="icon"><i class='bx bx-basket'></i></span>
          <span class="title">Catálogo de productos</span>
        </a></li>
        <li class="sidebar_item" onclick="showContent('inventario')"><a href="#">
          <span class="icon"><i class='bx bx-edit'></i></span>
          <span class="title">Inventario de productos</span>
        </a></li>
      </fieldset>

      <li class="sidebar_title">
        <span class="nav_title" style="color: var(--black2);" >Cuenta <hr></i></span>
      </li>
      
      <fieldset>
        <li class="sidebar_item" onclick="showContent('cuenta')"><a href="#">
          <span class="icon"><i class='bx bx-id-card' ></i></span>
          <span class="title">Mi cuenta</span>
        </a></li>
        <li class="sidebar_item" onclick="showContent('ayuda')"><a href="#">
          <span class="icon"><i class='bx bx-help-circle'></i></span>
          <span class="title">Centro de ayuda</span>
        </a></li>
        <li class="sidebar_item" onclick="showContent('añadir')"><a href="#">
          <span class="icon"><i class='bx bx-user-plus'></i></i></span>
          <span class="title">Añadir Empleado</span>
        </a></li>

        <li class="sidebar_item"><a href="../controller/cerrar.php">
        <span class="icon"><i class='bx bx-log-out'></i></span>
        <span class="title">Salir</span>
        </a></li>

      </fieldset>

    </ul>
  </nav>

  <!--MENU DE OPCIONES DEL NAV -->
  <!-- AQUI ESTAN LAS SECCIONES DEL CONTENIDO -->
   <main>
<!-- OPCIONES DE INICIO-->
  <div id="pedidos" class="content_section" style="display: none;">
    <h2>Pedidos</h2>
    <p>Lista de pedidos recientes.</p>
  </div>

  <div id="historial" class="content_section" style="display: none;">
    <h2>Historial de Órdenes</h2>
    <p>Aquí puedes ver todas las órdenes anteriores.</p>
  </div>

  <!--OPCION PARA VER EL ESTADO DE SOLICITUDES-->
  <div id="estado" class="content_section" style="display: none;">
    <div class="estado-header">
      <h1 class="estado-title">Estado de solicitudes</h1>
      <div class="estado-filtros">
        <div class="filtro-fecha">
          <span class="filtro-texto">Fecha: <strong>28/09/2024 · 05/10/2024</strong></span>
          <i class="bx bx-pencil icono-edit"></i>
        </div>
        <div class="filtros-opciones">
          <select class="select-filtro">
            <option>Tipo de solicitud</option>
            <option>Opción 1</option>
            <option>Opción 2</option>
          </select>
          <select class="select-filtro">
            <option>Estado</option>
            <option>Opción 1</option>
            <option>Opción 2</option>
          </select>
          <select class="select-filtro">
            <option>Seleccionar</option>
            <option>Opción 1</option>
            <option>Opción 2</option>
          </select>
          <div class="input-busqueda">
            <input type="text" placeholder="Buscar" class="input-texto" />
            <i class="bx bx-search icono-buscar"></i>
          </div>
        </div>
      </div>
    </div>
    <h2 class="estado-subtitulo">Historial de órdenes</h2>
    <div class="estado-menu">
      <button class="estado-boton">Productos</button>
      <button class="estado-boton">Soporte</button>
    </div>
    <div class="estado-contenido">
      <img src="../img/reloj.png" class="estado-imagen" />
      <h3 class="estado-aviso">No tienes solicitudes pendientes</h3>
      <p class="estado-mensaje">Cuando crees una solicitud, aquí podrás darle seguimiento.</p>
    </div>
  </div>
  

  <!--OPCIONES PARA ADMINISTRAR PRODUCTO-->
  <div id="combos" class="content_section" style="display: none;">
    <h2>COMBOS DEL NEGOCIO</h2>
    <p>Combos de comida que tiene el negocio</p>
  </div>

  <div id="catalogo" class="content_section" style="display: none;">
    <h2>CATALOGO DE PRODUCTOS</h2>
    <p>Aqui estaran todos los productos del negocio</p>
  </div>

  <div id="inventario" class="content_section" style="display: none;">
    <h2>INVENTARIO DE PRODUCTOS</h2>
    <p>Combos de comida que tiene el negocio</p>
  </div>

  <div id="cuenta" class="content_section" style="display: none;">
    <h2>INFORMACION DE MI CUENTA</h2>
    <p>Aqui la informacion de la cuenta</p>
  </div>

  <!--OPCION PREGUNTAS FRECUENTES-->
  <div id="ayuda" class="content_section" style="display: none;">
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">PREGUNTAS FRECUENTES</h1><br><br><br>
        <div class="flex justify-between mb-6">

            <div class="text-center" onclick="showFAQ('pago')">
                <img src="../img/pago.png" alt="Método de Pago" class="w-16 h-16 mx-auto" />
                <p>Pagos</p>
            </div>


            <div class="text-center" onclick="showFAQ('orden')">
              <img src="../img/orden.png" alt="orden" class="w-16 h-16 mx-auto" />
              <p>Órdenes</p>
          </div>

            <div class="text-center" onclick="showFAQ('producto')">
                <img src="../img/producto.png" alt="producto" class="w-16 h-16 mx-auto" />
                <p>Productos</p>
            </div>

              <div class="text-center" onclick="showFAQ('seguridad')">
                
                <img src="../img/seguridad.png" alt="Seguridad" class="w-16 h-16 mx-auto" />
                <p>Seguridad</p>
            </div>

            <div class="text-center" onclick="showFAQ('cuentas')">
                <img src="../img/cuenta.png" alt="Cuentas" class="w-16 h-16 mx-auto" />
                <p>Cuentas y accesos</p>
            </div>

        </div>

        <!-- CONTENEDOR EN DONDE ESTAN LAS PREGUNTAS FECUENTES -->
        <div id="faqContent" class="border border-zinc-300 rounded-lg p-4 mb-4">
            <!-- Aquí es donde se mostrarán las preguntas dinámicamente -->
        </div>
    </div>
</div>



<!--OPCION AÑADIR EMPLEADO-->
  <div id="añadir" class="content_section ">
    <h2>EMPLEADOS</h2>
    <p style="color: var(--black2); ">Añade un empleado para que tenga acceso a esta plataforma con los privilegios que tú le des.</p><br><br>
    <div class="text-center-emp">
        <img aria-hidden="true" src="../img/empleado.png" alt="Icono de empleado" />
        <div class="flex-1">
            <h2 class="text-lg font-semibold">Añadir un Empleado</h2>
            <p class="text-muted-foreground">Este empleado tendrá acceso a la página con los privilegios que le establezcas.</p>
        </div>
        <button class="btn-primary">Agregar</button>
    </div><br><br>
    <form action="agregarRol.php"></form>

    <div class="p-6 bg-background rounded-lg shadow-md">
      <!-- Título principal -->
      <h1 class="text-2xl font-bold mb-4">Total de usuarios con sus roles</h1><br>
      <p class="text-muted-foreground mb-6">Encuentra todas las cuentas de tu negocio y sus roles asociados</p><br><br>
    
      <!-- Sección para filtrar la cantidad de elementos mostrados -->
      <div class="flex justify-between mb-4">
        <div class="flex items-center">
          <label for="show" class="mr-2">Mostrar</label>
          <select id="show" class="border border-border rounded p-2">
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="50">50</option>
          </select>
        </div>
      </div>
    
      <!-- Tabla de usuarios -->
      <div class="overflow-x-auto">
        <table class="min-w-full border-collapse border border-border">
          <thead>
            <tr class="bg-muted">
              <th class="border border-border p-2">USUARIO</th>
              <th class="border border-border p-2">CORREO ELECTRÓNICO</th>
              <th class="border border-border p-2">ROL</th>
              <th class="border border-border p-2">ESTADO</th>
              <th class="border border-border p-2">ACCIONES</th>
            </tr>
          </thead>
          <tbody>
            <!-- Fila de usuario -->
            <tr class="border-b border-border">
              <td class="p-4">
                <input type="checkbox" class="mr-2" />
                <span class="flex items-center">
                  <img src="https://openui.fly.dev/openui/24x24.svg?text=👤" alt="User Avatar" class="w-8 h-8 rounded-full mr-2" />
                  <!-- Nombre del empleado -->
                  <div>
                    <span>Nombre empleado</span><br>
                    <span class="text-muted text-sm">Nombre usuario</span>
                  </div>
                </span>
              </td>
              <td class="p-4 text-muted">correo del empleado</td>
              <td class="p-4 text-muted">rol del empleado</td>
              <td class="p-4">
                <span class="bg-accent text-accent-foreground py-1 px-2 rounded-full">estado del empleado</span>
              </td>
              <td class="p-4">
                <!-- Botones de acción -->
                <button class="text-muted hover:text-muted-foreground mr-2">
                  <img src="https://openui.fly.dev/openui/24x24.svg?text=🗑️" alt="Delete" />
                </button>
                <button class="text-muted hover:text-muted-foreground mr-2">
                  <img src="https://openui.fly.dev/openui/24x24.svg?text=👁️" alt="View" />
                </button>
                <button class="text-muted hover:text-muted-foreground">
                  <img src="https://openui.fly.dev/openui/24x24.svg?text=⋮" alt="More Options" />
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    

  </div>


  </main> <!--FIN DE OPCIONES DE NAV-->


  <!--LLAMDA A FUNCIONES DE JS-->
  <script src="../js/funciones.js"></script>

</body>
</html>