<?php
require_once __DIR__ . '/../../config/helpers.php';
exigirAdminParcial();
require_once __DIR__ . '/../../config/database.php';

$db = (new Database())->getConnection();

// Consultar productos junto con el negocio al que pertenecen
$productos = [];
$consulta = "SELECT p.IdProducto_P, p.Nombre_P, p.Precio_P, p.Disponibilidad_P, p.Imagen_P, n.Nombre_N
             FROM producto p
             JOIN negocio n ON n.IdNegocio_N = p.IdNegocio_N
             ORDER BY n.Nombre_N, p.Nombre_P";

if ($resultado = $db->query($consulta)) {
    while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
        $productos[] = $fila;
    }
}
?>

<!-- OPCIONES PARA ADMINISTRAR PRODUCTO -->
<div class="cat-container">
    <div class="p-6 bg-white rounded-lg shadow-md">
      <h1 class="text-xl font-bold mb-4" style="color: #154360; font-size: 35px">Catálogo de Marca</h1>
      <div class="overflow-x-auto">
        <table class="min-w-full border-collapse border border-gray-300">
          <thead>
            <tr class="bg-gray-100 text-gray-700">
              <th class="border border-gray-300 p-2">Producto</th>
              <th class="border border-gray-300 p-2">Negocio</th>
              <th class="border border-gray-300 p-2">Precio</th>
              <th class="border border-gray-300 p-2">Disponibilidad</th>
              <th class="border border-gray-300 p-2">ID</th>
              <th class="border border-gray-300 p-2">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($productos)): ?>
                <?php foreach ($productos as $producto): ?>
                    <!-- Los datos van en atributos data-* para que nombres con comillas no rompan el JavaScript -->
                    <tr class="hover:bg-gray-50" style="cursor:pointer"
                        data-nombre="<?= e($producto['Nombre_P']) ?>"
                        data-id="<?= (int) $producto['IdProducto_P'] ?>"
                        data-precio="$<?= e(number_format((float) $producto['Precio_P'], 2)) ?>"
                        data-disp="<?= e($producto['Disponibilidad_P']) ?>"
                        data-imagen="<?= e(rutaImagen($producto['Imagen_P'], '../../')) ?>"
                        onclick="showModal(this.dataset.nombre, this.dataset.id, this.dataset.precio, this.dataset.disp, this.dataset.imagen)">
                      <td class="border border-gray-300 p-2"><?= e($producto['Nombre_P']) ?></td>
                      <td class="border border-gray-300 p-2"><?= e($producto['Nombre_N']) ?></td>
                      <td class="border border-gray-300 p-2">$<?= e(number_format((float) $producto['Precio_P'], 2)) ?></td>
                      <td class="border border-gray-300 p-2"><?= e($producto['Disponibilidad_P']) ?></td>
                      <td class="border border-gray-300 p-2"><?= (int) $producto['IdProducto_P'] ?></td>
                      <td class="border border-gray-300 p-2">
                        <button class="bg-blue-500 text-white p-1 rounded"><i class='bx bx-search-alt-2'></i></button>
                      </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="admin-vacio">No hay productos disponibles.</td>
                </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
</div>

<!-- Modal para ver la información del producto (haz clic fuera de la ventana para cerrarla) -->
<div id="modal-container" class="unique-modal" style="display: none;">
  <div class="unique-modal-content">
    <h2>Detalle de Producto</h2>
    <h3 id="product-name" class="text-xl font-semibold mb-2"></h3>
    <img id="product-image" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="Imagen del producto" class="mb-4 mx-auto" />

    <div class="text-sm">
      <p><strong>ID:</strong> <span id="product-id"></span></p>
      <p><strong>Precio:</strong> <span id="product-precio"></span></p>
      <p><strong>Disponibilidad:</strong> <span id="product-availability"></span></p>
    </div>
  </div>
</div>
