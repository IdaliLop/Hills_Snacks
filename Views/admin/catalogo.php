<?php
// Incluye la conexión a la base de datos
require_once __DIR__ . '/../../config/database.php';

// Crear instancia de la base de datos
$database = new Database();
$db = $database->getConnection();

// Consultar productos
$productos = [];
$consulta = "SELECT IdProducto_P, Nombre_P, Precio_P, Disponibilidad_P, Imagen_P FROM producto";

if ($resultado = $db->query($consulta)) {
    while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
        $productos[] = $fila;
    }
}
?>

<!-- OPCIONES PARA ADMINISTRAR PRODUCTO -->
<div class="cat-container">
    <div class="p-6 bg-white rounded-lg shadow-md">
      <h1 class="text-xl font-bold mb-4">Catálogo de Marca</h1>
      <div class="overflow-x-auto">
        <table class="min-w-full border-collapse border border-gray-300">
          <thead>
            <tr class="bg-gray-100 text-gray-700">
              <th class="border border-gray-300 p-2">Producto</th>
              <th class="border border-gray-300 p-2">Precio</th>
              <th class="border border-gray-300 p-2">Disponibilidad</th>
              <th class="border border-gray-300 p-2">ID</th>
              <th class="border border-gray-300 p-2">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($productos)): ?>
                <?php foreach ($productos as $producto): ?>
                    <tr class="hover:bg-gray-50" onclick="showModal('<?= htmlspecialchars($producto['Nombre_P']) ?>', '<?= htmlspecialchars($producto['IdProducto_P']) ?>', '<?= htmlspecialchars($producto['Precio_P']) ?>', '<?= htmlspecialchars($producto['Disponibilidad_P']) ?>', '<?= htmlspecialchars($producto['Imagen_P']) ?>')">
                      <td class="border border-gray-300 p-2"><?= htmlspecialchars($producto['Nombre_P']) ?></td>
                      <td class="border border-gray-300 p-2"><?= htmlspecialchars($producto['Precio_P']) ?></td>
                      <td class="border border-gray-300 p-2"><?= htmlspecialchars($producto['Disponibilidad_P']) ?></td>
                      <td class="border border-gray-300 p-2"><?= htmlspecialchars($producto['IdProducto_P']) ?></td>
                      <td class="border border-gray-300 p-2">
                        <button class="bg-blue-500 text-white p-1 rounded"><i class='bx bx-search-alt-2'></i></button>
                      </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No hay productos disponibles.</td>
                </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
</div>

<!-- Modal para ver la información del producto -->
<div id="modal-container" class="unique-modal" style="display: none;">
  <div class="unique-modal-content">
    <h2>Detalle de Producto</h2>
    <h3 id="product-name" class="text-xl font-semibold mb-2"></h3>
    <img id="product-image" src="../Util/img/<?= htmlspecialchars($producto['Imagen_P']) ?>" alt="Imagen del producto" class="mb-4 mx-auto" />


    <div class="text-sm">
      <p><strong>ID:</strong> <span id="product-id"></span></p>
      <p><strong>Precio:</strong> <span id="product-precio"></span></p>
      <p><strong>Disponibilidad:</strong> <span id="product-availability"></span></p>
    </div>
  </div>
</div>
