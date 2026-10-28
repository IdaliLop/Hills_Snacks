<?php
require_once __DIR__ . '/../config/helpers.php';
if (!isset($productos)) { header('Location: ../index.php'); exit; } // esta vista la carga ProductosController
// Variables que llegan desde ProductosController: $productos (lista) y $negocio (datos del negocio o null)
$idNegocioActual = $negocio['IdNegocio_N'] ?? 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/productos.css" rel="stylesheet">
    <link href="css/modal.css" rel="stylesheet">
    <link href="css/tienda.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Productos del Negocio</title>
    <script src="https://kit.fontawesome.com/81581fb069.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="productos">
        <?php if (!empty($negocio)): ?>
            <a class="productos__volver" href="index.php?action=mostrarNegociosPorCategoria&categoria=<?php echo urlencode($negocio['Tipo_N']); ?>">&larr; Volver a <?php echo e($negocio['Tipo_N']); ?></a>
            <h2 class="productos__title"><?php echo e($negocio['Nombre_N']); ?></h2>
            <p class="productos__subtitulo"><?php echo e($negocio['Direccion_N']); ?></p>
        <?php else: ?>
            <h2 class="productos__title">Productos del Negocio</h2>
        <?php endif; ?>

        <div class="productos__container">
            <?php if (!empty($productos)): ?>
                <?php foreach ($productos as $producto): ?>
                    <?php $img = rutaImagen($producto['Imagen_P'] ?? ''); ?>
                    <!-- Los datos del producto viajan en atributos data-*; el modal los lee de ahí -->
                    <div class="productos__item"
                         data-id="<?php echo (int) $producto['IdProducto_P']; ?>"
                         data-nombre="<?php echo e($producto['Nombre_P']); ?>"
                         data-precio="<?php echo e($producto['Precio_P']); ?>"
                         data-imagen="<?php echo e($img); ?>"
                         data-negocio="<?php echo (int) $producto['IdNegocio_N']; ?>"
                         onclick="abrirModal(this)">
                        <img src="<?php echo e($img); ?>"
                             alt="Imagen de <?php echo e($producto['Nombre_P']); ?>"
                             class="productos__image">
                        <h3><?php echo e($producto['Nombre_P']); ?></h3>
                        <p><strong>Precio:</strong> <?php echo number_format((float) $producto['Precio_P'], 2); ?> MXN</p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <h2 class="productos__empty">No hay productos disponibles para este negocio.</h2>
            <?php endif; ?>
        </div>
    </div>

    <!-- Ventana modal del producto -->
    <div id="modal" class="modal" onclick="if (event.target === this) cerrarModal()">
        <div class="modal-content">
            <button class="modal-close" onclick="cerrarModal()" aria-label="Cerrar">&times;</button>
            <img id="modal-image" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="Producto">
            <br><br>
            <h3 id="modal-name"></h3>
            <p><strong>Precio:</strong> <span id="modal-price"></span> MXN</p>

            <div class="cantidad-container">
                <button class="cantidad-btn" onclick="cambiarCantidad(-1)">-</button>
                <input type="number" id="modal-quantity" class="cantidad-input" value="1" min="1" readonly>
                <button class="cantidad-btn" onclick="cambiarCantidad(1)">+</button>
            </div>

            <button onclick="agregarAlCarrito()">Agregar al Carrito</button>
        </div>
    </div>

    <!-- Botón flotante para ir al carrito -->
    <a class="carrito-flotante" href="Views/carrito.php">Ver carrito <span class="carrito-contador"></span></a>

    <div class="whatsapp-float">
        <a href="https://wa.me/3318530145?text=Hola%2C%20estoy%20interesado%20en%20tus%20servicios" target="_blank">
            <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp" />
        </a>
    </div>

    <script src="js/carrito.js"></script>
    <script>
        // Producto que se está viendo en el modal
        var productoActual = null;

        function abrirModal(tarjeta) {
            productoActual = {
                id: parseInt(tarjeta.dataset.id, 10),
                nombre: tarjeta.dataset.nombre,
                precio: parseFloat(tarjeta.dataset.precio),
                imagen: tarjeta.dataset.imagen,
                idNegocio: parseInt(tarjeta.dataset.negocio, 10)
            };
            document.getElementById('modal-name').innerText = productoActual.nombre;
            document.getElementById('modal-price').innerText = productoActual.precio.toFixed(2);
            document.getElementById('modal-image').src = productoActual.imagen;
            document.getElementById('modal-quantity').value = 1;
            document.getElementById('modal').style.display = 'flex';
        }

        function cerrarModal() {
            document.getElementById('modal').style.display = 'none';
        }

        // Sube o baja la cantidad del modal (mínimo 1)
        function cambiarCantidad(cambio) {
            var input = document.getElementById('modal-quantity');
            var nueva = parseInt(input.value, 10) + cambio;
            if (nueva >= 1 && nueva <= 99) {
                input.value = nueva;
            }
        }

        function agregarAlCarrito() {
            if (!productoActual) return;
            var cantidad = parseInt(document.getElementById('modal-quantity').value, 10);
            var resultado = Carrito.agregar(productoActual, cantidad);

            // Un pedido es de un solo negocio: si ya hay productos de otro, se pregunta
            if (resultado === 'otro_negocio') {
                var seguir = confirm('Tu carrito tiene productos de otro negocio. ¿Quieres vaciarlo y empezar un pedido nuevo con este producto?');
                if (!seguir) return;
                Carrito.agregar(productoActual, cantidad, { reemplazar: true });
            }

            cerrarModal();
            Carrito.aviso(cantidad + ' × ' + productoActual.nombre + ' agregado al carrito');
        }
    </script>
</body>
</html>
