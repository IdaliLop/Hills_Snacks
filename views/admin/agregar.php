
<!-- OPCION AÑADIR EMPLEADO-->
<div class="agregar-container">
  <div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">EMPLEADOS</h1>
    <p style="color: var(--black2);">Añade un empleado para que tenga acceso a esta plataforma con los privilegios que tú le des.</p><br><br>

    <div class="text-center-emp">
      <img aria-hidden="true" src="../../img/empleado.png" alt="Icono de empleado" />
      <div class="flex-1">
        <h2 class="text-lg font-semibold">Añadir un Empleado</h2>
        <p class="text-muted-foreground">Este empleado tendrá acceso a la página con los privilegios que le establezcas.</p>
      </div>
      <button class="btn-primary" onclick="mostrarFormularioEmpleado()">Agregar</button>
    </div><br><br>
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

</div>
