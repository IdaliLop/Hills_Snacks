<?php
require_once __DIR__ . '/../../config/helpers.php';
exigirAdminParcial();
require_once __DIR__ . '/../../config/database.php';

$db = (new Database())->getConnection();

// Productos con el nombre de su negocio
$productos = [];
$consulta = "SELECT p.Imagen_P, p.Nombre_P, p.IdProducto_P, p.Precio_P, p.Disponibilidad_P, n.Nombre_N
             FROM producto p
             JOIN negocio n ON n.IdNegocio_N = p.IdNegocio_N
             ORDER BY n.Nombre_N, p.Nombre_P";
if ($resultado = $db->query($consulta)) {
    while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
        $productos[] = $fila;
    }
}

// Negocios para el formulario de "Agregar producto"
$negocios = [];
if ($resultado = $db->query("SELECT IdNegocio_N, Nombre_N FROM negocio ORDER BY Nombre_N")) {
    $negocios = $resultado->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!-- Aquí empieza el HTML -->
<div class="invent-container">
  <h2 class="section-title" style="color: #154360; font-size: 35px">INVENTARIO DE PRODUCTOS</h2>

  <!-- Controles de filtro y búsqueda -->
  <div class="controls flex items-center mb-4">
    <select id="statusDropdown" class="border border-gray-300 rounded-lg p-2 mr-2" onchange="filtrarInventario()">
      <option value="">Todos</option>
      <option value="Activo">Activo</option>
      <option value="Inactivo">Inactivo</option>
    </select>
    <input
      type="text"
      id="searchBox"
      placeholder="Buscar"
      class="border border-gray-300 rounded-lg p-2 flex-grow mr-2"
      oninput="filtrarInventario()"
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
        <th>NEGOCIO</th>
        <th>ID</th>
        <th>PRECIO</th>
        <th>ESTADO</th>
        <th>ACCIONES</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($productos)): ?>
        <?php foreach ($productos as $producto): ?>
          <tr class="fila-producto" data-estado="<?= e($producto['Disponibilidad_P']) ?>" data-texto="<?= e(mb_strtolower($producto['Nombre_P'] . ' ' . $producto['Nombre_N'])) ?>">
            <td>
              <img src="<?= e(rutaImagen($producto['Imagen_P'], '../../')) ?>" alt="Producto" class="product-image">
            </td>
            <td><?= e($producto['Nombre_P']) ?></td>
            <td><?= e($producto['Nombre_N']) ?></td>
            <td><?= (int) $producto['IdProducto_P'] ?></td>
            <td>$<?= e(number_format((float) $producto['Precio_P'], 2)) ?></td>
            <td>
              <!-- Al cambiar el estado se guarda en la base de datos -->
              <select class="status-dropdown" onchange="cambiarDisponibilidad(<?= (int) $producto['IdProducto_P'] ?>, this)">
                <option <?= $producto['Disponibilidad_P'] === 'Activo' ? 'selected' : '' ?>>Activo</option>
                <option <?= $producto['Disponibilidad_P'] === 'Inactivo' ? 'selected' : '' ?>>Inactivo</option>
              </select>
            </td>
            <td>
              <button class="btn-edit-product"><i class="bx bx-pencil"></i></button>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="7" class="admin-vacio">No hay productos disponibles.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>

  <!-- Formulario de agregar producto -->
  <div id="productForm" class="hidden">
  <h2>Agregar Producto</h2>
  <form id="addProductForm" enctype="multipart/form-data" method="POST">
    <div>
      <label for="negocio">Negocio:</label>
      <select id="negocio" name="negocio" required>
        <option value="" disabled selected>Elige un negocio</option>
        <?php foreach ($negocios as $negocio): ?>
          <option value="<?= (int) $negocio['IdNegocio_N'] ?>"><?= e($negocio['Nombre_N']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div>
      <label for="productName">Nombre del Producto:</label>
      <input type="text" id="productName" name="productName" maxlength="100" required>
    </div>
    <div>
      <label for="productPrice">Precio:</label>
      <input type="number" id="productPrice" name="productPrice" step="0.01" min="0.01" required>
    </div>
    <div>
      <label for="productDis">Disponibilidad:</label>
      <select id="productDis" name="productDis" required>
        <option value="Activo" selected>Activo</option>
        <option value="Inactivo">Inactivo</option>
      </select>
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
