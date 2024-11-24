<!-- OPCIÓN INVENTARIO DE PRODUCTOS -->
<div class="invent-container">
  <h2 class="section-title" style="color: #154360; font-size: 35px">INVENTARIO DE PRODUCTOS</h2>

  <!-- Controles de filtro y búsqueda -->
  <div class="controls flex items-center mb-4">
    <select id="statusDropdown" class="border border-gray-300 rounded-lg p-2 mr-2">
      <option>Activo</option>
      <option>Inactivo</option>
    </select>
    <input 
      type="text" 
      id="searchBox" 
      placeholder="Buscar" 
      class="border border-gray-300 rounded-lg p-2 flex-grow mr-2" 
    />
    <button class="btn-add-product" id="openFormBtn">
      <i class='bx bx-plus-circle'></i> Agregar Producto
    </button>
  </div>

  <!-- Tabla de productos -->
  <table class="inventory-table">
    <thead>
      <tr>
        <th>IMAGEN</th>
        <th>PRODUCTO</th>
        <th>ID</th>
        <th>PRECIO</th>
        <th>ESTADO</th>
        <th>ACCIONES</th>
      </tr>
    </thead>
    <tbody>
      <?php if (isset($productos) && !empty($productos)): ?>
        <?php foreach ($productos as $producto): ?>
          <tr>
            <td>
              <!-- Imagen del producto -->
              <img src="<?= $producto['Imagen_P'] ?>" alt="Producto" class="product-image">
            </td>
            <td><?= $producto['Nombre_P'] ?></td>
            <td><?= $producto['IdProducto_P'] ?></td>
            <td>$<?= number_format($producto['Precio_P'], 2) ?></td>
            <td>
              <!-- Estado del producto (Activo/Inactivo) -->
              <select class="status-dropdown">
                <option <?= $producto['Disponibilidad_P'] == 'Activo' ? 'selected' : '' ?>>Activo</option>
                <option <?= $producto['Disponibilidad_P'] == 'Inactivo' ? 'selected' : '' ?>>Inactivo</option>
              </select>
            </td>
            <td>
              <!-- Botón de edición -->
              <button class="btn-edit-product"><i class="bx bx-pencil"></i></button>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="6">No hay productos disponibles.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>

  <!-- Formulario de agregar producto -->
  <div id="productForm" class="hidden">
    <h2>Agregar Producto</h2>
    <form id="addProductForm" enctype="multipart/form-data"> <!-- Aquí agregamos enctype -->
      <div>
        <label for="productName">Nombre del Producto:</label>
        <input type="text" id="productName" name="productName" required>
      </div>
      <div>
        <label for="productPrice">Precio:</label>
        <input type="number" id="productPrice" name="productPrice" step="0.01" required>
      </div>
      <div>
        <label for="productDis">Disponibilidad</label>
        <input type="number" id="productDis" name="productDis" required>
      </div>
      <div>
        <label for="productImage">Subir Imagen:</label>
        <input type="file" id="productImage" name="productImage" accept="image/*" required>
      </div>
      <div>
        <button type="submit">Guardar Producto</button>
        <button type="button" id="cancelFormBtn" class="btn-cancel">Cancelar</button>
      </div>
    </form>
  </div>
</div>
