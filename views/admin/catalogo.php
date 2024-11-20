<!-- OPCIONES PARA ADMINISTRAR PRODUCTO -->
<div class="cat-container">
    <div class="p-6 bg-white rounded-lg shadow-md">
      <h1 class="text-xl font-bold mb-4">Catálogo de Marca</h1>
      <a href="#" class="text-green-500 hover:underline mb-4 inline-block">Ver estado de solicitudes</a>
      <div class="overflow-x-auto">
        <table class="min-w-full border-collapse border border-gray-300">
          <thead>
            <tr class="bg-gray-100 text-gray-700">
              <th class="border border-gray-300 p-2">Producto</th>
              <th class="border border-gray-300 p-2">Presentación</th>
              <th class="border border-gray-300 p-2">Categoría</th>
              <th class="border border-gray-300 p-2">ID</th>
              <th class="border border-gray-300 p-2">SKU</th>
              <th class="border border-gray-300 p-2">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr class="hover:bg-gray-50" onclick="showModal('Jose Cuervo Tequila Tradicional Plata', '2114108303', '7501035012219', 'losparrales_7501035012219', 'Jose Cuervo')">
              <td class="border border-gray-300 p-2">Jose Cuervo Tequila ...</td>
              <td class="border border-gray-300 p-2">750mL</td>
              <td class="border border-gray-300 p-2">Tequilas</td>
              <td class="border border-gray-300 p-2">2114108303</td>
              <td class="border border-gray-300 p-2">losparrales_7501035012219</td>
              <td class="border border-gray-300 p-2">
                <button class="bg-blue-500 text-white p-1 rounded"><i class='bx bx-search-alt-2'></i></button>
              </td>
            </tr>
            <!-- Añade más filas aquí si es necesario -->
          </tbody>
        </table>
      </div>
    </div>
</div>


<!-- MODAL PARA VER LA INFORMACION DEL PRODUCTO -->
<div id="modal-container" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50" style="display: none;">
  <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm w-full relative">
    <button id="close-modal" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">&times;</button>
    <h2 class="text-lg font-bold mb-4">Detalle de Producto</h2>
    <h3 id="product-name" class="text-xl font-semibold mb-2"></h3>
    <img id="product-image" src="https://via.placeholder.com/150" alt="Imagen del producto" class="mb-4 mx-auto" />
    <div class="text-sm">
      <p><strong>ID:</strong> <span id="product-id"></span></p>
      <p><strong>EAN:</strong> <span id="product-ean"></span></p>
      <p><strong>SKU:</strong> <span id="product-sku"></span></p>
      <p><strong>Marca del Producto:</strong> <span id="product-brand"></span></p>
    </div>
  </div>
</div>

<script>
  // Función para mostrar el modal con datos dinámicos
  function showModal(name, id, ean, sku, brand) {
    document.getElementById('product-name').textContent = name;
    document.getElementById('product-id').textContent = id;
    document.getElementById('product-ean').textContent = ean;
    document.getElementById('product-sku').textContent = sku;
    document.getElementById('product-brand').textContent = brand;
    document.getElementById('modal-container').style.display = 'flex';
  }

  // Cerrar modal al hacer clic en el botón de cerrar
  document.getElementById('close-modal').addEventListener('click', () => {
    document.getElementById('modal-container').style.display = 'none';
  });

  // Cerrar modal al hacer clic fuera del contenido
  document.getElementById('modal-container').addEventListener('click', (e) => {
    if (e.target === document.getElementById('modal-container')) {
      document.getElementById('modal-container').style.display = 'none';
    }
  });
</script>
