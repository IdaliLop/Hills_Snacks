
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

        <li class="sidebar_item"><a href="cerrar.php">
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
    <!-- OPCIÓN PARA VER LOS PEDIDOS -->
    <div class="pedidos-header">
        <h1 class="pedidos-title">Pedidos Recientes</h1>
        <div class="pedidos-filtros">
            <div class="filtro-fecha">
                <span class="filtro-texto">Fecha: <strong>28/09/2024 · 05/10/2024</strong></span>
                <i class="bx bx-pencil icono-edit"></i>
            </div>
            <div class="filtros-opciones">
                <select class="select-filtro">
                    <option>Estado del Pedido</option>
                    <option>Pendiente</option>
                    <option>Completado</option>
                    <option>Cancelado</option>
                </select>
                <div class="input-busqueda">
                    <input type="text" placeholder="Descargar historial por ID de pedido" class="input-texto" />
                    <i class="bx bx-search icono-buscar"></i>
                </div>
            </div>
        </div>
    </div>
    <h2 class="pedidos-subtitulo">Lista de Pedidos</h2>
    <div class="pedidos-menu">
        <button class="pedidos-boton">Solicitud de pedidos</button>
        <button class="pedidos-boton">Detalles del pedidio</button>
    </div>
    <div class="pedidos-contenido">
        <img src="../img/reloj.png" class="pedidos-imagen" alt="Reloj de espera" />
        <h3 class="pedidos-aviso">No tienes pedidos recientes</h3>
        <p class="pedidos-mensaje">Cuando hagan un pedido, aquí podrás darle seguimiento.</p>
    </div>
  </div>
  </div>

<!--OPCION HISTORIAL DE PEDIDOS-->
<div id="historial" class="content_section" style="display: none;">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Historial de Órdenes</h1>
        <div class="flex justify-between items-center mb-4">
            <div class="flex items-center">
                <label for="period" class="mr-2">Periodo:</label>
                <select id="period" class="border rounded p-1">
                    <option>Últimos 7 días</option>
                </select>
                <input type="text" placeholder="ID de la orden" class="border rounded p-1 ml-2" />
                <button class="btn-primary hover:bg-primary/80 ml-2">Descargar historial</button>
            </div>
            <button class="btn-primary hover:bg-primary/80 ml-2">Buscar</button>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full border-collapse border border-zinc-300">
                <thead>
                    <tr class="bg-zinc-100">
                        <th class="border border-zinc-300 p-2">ID</th>
                        <th class="border border-zinc-300 p-2">Ciudad</th>
                        <th class="border border-zinc-300 p-2">Tienda</th>
                        <th class="border border-zinc-300 p-2">Fecha de creación</th>
                        <th class="border border-zinc-300 p-2">Fecha de entrega</th>
                        <th class="border border-zinc-300 p-2">Total</th>
                        <th class="border border-zinc-300 p-2">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-zinc-300 p-2">2292458915</td>
                        <td class="border border-zinc-300 p-2">Guadalajara</td>
                        <td class="border border-zinc-300 p-2">Los Parrales, El Rosario</td>
                        <td class="border border-zinc-300 p-2">30/09/2024 10:06 pm</td>
                        <td class="border border-zinc-300 p-2">30/09/2024 10:58 pm</td>
                        <td class="border border-zinc-300 p-2">$578.08</td>
                        <td class="border border-zinc-300 p-2">
                            <span class="bg-green-200 text-green-800 rounded px-2">Entregado</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="border border-zinc-300 p-2">2292454216</td>
                        <td class="border border-zinc-300 p-2">Guadalajara</td>
                        <td class="border border-zinc-300 p-2">Los Parrales, El Rosario</td>
                        <td class="border border-zinc-300 p-2">30/09/2024 09:43 pm</td>
                        <td class="border border-zinc-300 p-2">30/09/2024 10:29 pm</td>
                        <td class="border border-zinc-300 p-2">$444.92</td>
                        <td class="border border-zinc-300 p-2">
                            <span class="bg-red-200 text-red-800 rounded px-2">Cancelado</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="flex justify-between items-center mt-4">
            <div>
                <label for="rows-per-page" class="mr-2">Filas Por Página:</label>
                <select id="rows-per-page" class="border rounded p-1">
                    <option>10</option>
                </select>
            </div>
        </div>
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

<!--OPCIONES PARA LA INFORMACIÓN DE LA CUENTA-->
  <div id="cuenta" class="content_section" style="display: none;">
    <h2>Información personal</h2>
    <div class="info-grid">
        <div class="info-field">
            <label>NOMBRE</label>
            <p> </p>
        </div>
        <div class="info-field">
            <label>APELLIDO</label>
            <p> </p>
        </div>
        <div class="info-field">
            <label>CORREO</label>
            <p> </p>
        </div>
        <div class="info-field phone-field">
            <label>TELÉFONO</label>
            <p> </p>
        </div>
        <div class="info-field">
            <label>CIUDAD</label>
            <p> </p>
        </div>
        <div class="info-field">
            <label>CONTRASEÑA</label>
            <p> </p>
        </div>
    </div>
    <button class="btn-cambio">Cambiar Datos</button>
</div>

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
<!-- OPCIÓN AÑADIR EMPLEADO -->
<div id="añadir" class="content_section" >
    <h2>EMPLEADOS</h2>
    <p style="color: var(--black2);">Añade un empleado para que tenga acceso a esta plataforma con los privilegios que tú le des.</p><br><br>
    
    <div class="text-center-emp">
        <img aria-hidden="true" src="../img/empleado.png" alt="Icono de empleado" />
        <div class="flex-1">
            <h2 class="text-lg font-semibold">Añadir un Empleado</h2>
            <p class="text-muted-foreground">Este empleado tendrá acceso a la página con los privilegios que le establezcas.</p>
        </div>
        <button class="btn-primary" onclick="mostrarFormularioEmpleado()">Agregar</button>
    </div><br><br>

    <!-- Modal para el formulario de agregar empleado -->
    <div id="formulario-empleado-modal" class="modal">
      <div class="modal-content">
        <span class="close" onclick="ocultarFormularioEmpleado()"><i class='bx bx-x'></i></span>
        <h2>Agregar Empleado</h2>
        <form action="agregarEmpleado.php" method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required autofocus>
            
            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="Apellido" required>

            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" required>

            <label for="domicilio">Domicilio:</label>
            <input type="text" id="domicilio" name="domicilio" required>

            <label for="correo">Correo Electrónico:</label>
            <input type="email" id="correo" name="correo" required>
            
            <button type="submit" class="btn-primary">Guardar Empleado</button>
            <button type="button" class="btn-secundary" onclick="ocultarFormularioEmpleado()">Cancelar</button>
        </form>
      </div>

    </div>

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