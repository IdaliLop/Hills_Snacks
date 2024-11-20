<!-- OPCIÓN INVENTARIO DE PRODUCTOS -->
<div class="invent-container">
  <h2 class="section-title">INVENTARIO DE PRODUCTOS</h2>
  <div class="flex items-center mb-4">
    <select class="border border-gray-300 rounded-lg p-2 mr-2">
      <option>Activo</option>
      <option>Inactivo</option>
    </select>
    <input type="text" placeholder="Buscar" class="border border-gray-300 rounded-lg p-2 flex-grow mr-2" />
    <button class="btn-add-product">
      <i class="bx bx-plus"></i> Agregar Producto
    </button>
  </div>

  <!-- Tabla de productos -->
  <table class="inventory-table">
    <thead>
      <tr>
        <th>PRODUCTO</th>
        <th>PRESENTACIÓN</th>
        <th>ID</th>
        <th>PRECIO</th>
        <th>ESTADO</th>
        <th>ACCIONES</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
          <img src="https://via.placeholder.com/40" alt="Producto" class="product-image">
          Jose Cuervo Tequila
        </td>
        <td>750 mL</td>
        <td>211410...</td>
        <td>$384.77</td>
        <td>
          <select class="status-dropdown">
            <option>Activo</option>
            <option>Inactivo</option>
          </select>
        </td>
        <td>
          <button class="btn-edit-product"><i class="bx bx-pencil"></i></button>
        </td>
      </tr>
      <!-- Agrega más filas según sea necesario -->
    </tbody>
  </table>
</div>
