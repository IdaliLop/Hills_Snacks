<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/productos.css" rel="stylesheet">
    <link href="css/modal.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Productos del Negocio</title>
    <script src="https://kit.fontawesome.com/81581fb069.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="productos">
        <h2 class="productos__title">Productos del Negocio</h2>
        <div class="productos__container">
            <?php if (!empty($productos)): ?>
                <?php foreach ($productos as $producto): ?>
                    <div class="productos__item" onclick="openModal(<?php echo htmlspecialchars(json_encode($producto)); ?>)">
                        <!-- Mostrar imagen del producto -->
                        <?php if (!empty($producto['Imagen_P'])): ?>
                            <img src="<?php echo htmlspecialchars($producto['Imagen_P']); ?>" 
                                alt="Imagen de <?php echo htmlspecialchars($producto['Nombre_P']); ?>" 
                                class="productos__image">
                        <?php else: ?>
                            <img src="Util/img/default.png" 
                                alt="Imagen no disponible" 
                                class="productos__image">
                        <?php endif; ?>

                        <h3><?php echo htmlspecialchars($producto['Nombre_P']); ?></h3>
                        <p><strong>Precio:</strong> <?php echo htmlspecialchars($producto['Precio_P']); ?> MXN</p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <h2 class="productos__empty">No hay productos disponibles para este negocio.</h2>
            <?php endif; ?>
        </div>
    </div>

    <!-- Ventana Modal -->
<!-- Ventana Modal -->
<div id="modal" class="modal">
    <div class="modal-content">
        <button class="modal-close" onclick="closeModal()">×</button> <!-- Botón para cerrar la modal -->
        <img id="modal-image" src="" alt="Producto">
        <br><br>
        <h3 id="modal-name" data-producto-id=""></h3>
        <p><strong>Precio:</strong> <span id="modal-price"></span> MXN</p>
        
        <!-- Mostrar categoría -->
        <p><strong>Categoría:</strong> <span id="modal-category"></span></p> <!-- Aquí mostramos la categoría -->

        <!-- Contenedor para los botones de cantidad -->
        <div class="cantidad-container">
            <button class="cantidad-btn" onclick="cambiarCantidad(-1)">-</button>
            <input type="number" id="modal-quantity" class="cantidad-input" value="1" min="1" readonly>
            <button class="cantidad-btn" onclick="cambiarCantidad(1)">+</button>
        </div>

        <button onclick="agregarAlCarrito()">Agregar al Carrito</button>
    </div>
</div>


    <div class="whatsapp-float">
        <a href="https://wa.me/3318530145?text=Hola%2C%20estoy%20interesado%20en%20tus%20servicios" target="_blank">
            <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp" />
        </a>
    </div>

    <script>

        // Función para abrir la modal con los datos del producto
function openModal(producto) {
    // Asignar los datos del producto a la modal
    document.getElementById('modal-name').innerText = producto.Nombre_P;
    document.getElementById('modal-price').innerText = producto.Precio_P;
    document.getElementById('modal-image').src = producto.Imagen_P || 'Util/img/default.png';
    document.getElementById('modal').style.display = 'flex';
    document.getElementById('modal-quantity').value = 1; // Reiniciar la cantidad a 1
}

// Función para cerrar la modal
function closeModal() {
    document.getElementById('modal').style.display = 'none';
}

// Función para cambiar la cantidad (solo aumenta o disminuye dentro de un rango válido)
function cambiarCantidad(cambio) {
    let cantidadInput = document.getElementById('modal-quantity');
    let cantidadActual = parseInt(cantidadInput.value);
    let nuevaCantidad = cantidadActual + cambio;
    
    // Validar que la cantidad esté dentro de un rango válido
    if (nuevaCantidad > 0) {
        cantidadInput.value = nuevaCantidad;
    }
}

// Función para agregar el producto al carrito (aquí puedes agregar la lógica que necesites)
function agregarAlCarrito() {
    const cantidad = document.getElementById('modal-quantity').value;
    const productoId = document.getElementById('modal-name').getAttribute('data-producto-id');
    // Lógica para agregar al carrito
    alert(`Producto ${productoId} agregado al carrito con cantidad: ${cantidad}`);
    closeModal(); // Cerrar la modal después de agregar al carrito
}
// Función para obtener el carrito desde localStorage
function obtenerCarrito() {
    let carrito = JSON.parse(localStorage.getItem('carrito'));
    return carrito ? carrito : [];
}

// Función para guardar el carrito en localStorage
function guardarCarrito(carrito) {
    localStorage.setItem('carrito', JSON.stringify(carrito));
}

// Función para agregar un producto al carrito
// Función para agregar un producto al carrito
function agregarAlCarrito() {
    const cantidad = document.getElementById('modal-quantity').value;
    const productoId = document.getElementById('modal-name').getAttribute('data-producto-id');
    const productoNombre = document.getElementById('modal-name').innerText;
    const productoPrecio = parseFloat(document.getElementById('modal-price').innerText);
    const productoImagen = document.getElementById('modal-image').src;

    // Obtener el carrito actual
    let carrito = obtenerCarrito();

    // Buscar si el producto ya existe en el carrito
    const productoExistente = carrito.find(producto => producto.id == productoId);

    if (productoExistente) {
        // Si el producto ya existe, solo actualizamos la cantidad
        productoExistente.cantidad += parseInt(cantidad);
    } else {
        // Si el producto no existe, lo agregamos al carrito
        carrito.push({
            id: productoId,
            nombre: productoNombre,
            precio: productoPrecio,
            cantidad: parseInt(cantidad),
            imagen: productoImagen
        });
    }

    // Guardar el carrito actualizado en localStorage
    guardarCarrito(carrito);

    // Mostrar un mensaje de confirmación
    alert(`Producto "${productoNombre}" agregado al carrito con cantidad: ${cantidad}`);

    // Cerrar la modal automáticamente
    closeModal();

    // (Opcional) Llamar a una función para actualizar el carrito en la página si es necesario
    // mostrarCarrito();
}


// Función para mostrar los productos en el carrito
function mostrarCarrito() {
    const carrito = obtenerCarrito();
    const carritoContainer = document.getElementById('carrito-container');
    carritoContainer.innerHTML = ''; // Limpiar el contenido del carrito

    if (carrito.length === 0) {
        carritoContainer.innerHTML = '<p>No hay productos en el carrito.</p>';
        return;
    }

    let total = 0;

    carrito.forEach(producto => {
        total += producto.precio * producto.cantidad;
        carritoContainer.innerHTML += `
            <div class="carrito-item">
                <img src="${producto.imagen}" alt="${producto.nombre}" class="carrito-item-img">
                <h3>${producto.nombre}</h3>
                <p>Precio: ${producto.precio} MXN</p>
                <p>Cantidad: ${producto.cantidad}</p>
                <button onclick="eliminarDelCarrito(${producto.id})">Eliminar</button>
            </div>
        `;
    });

    // Mostrar total
    carritoContainer.innerHTML += `<p>Total: ${total} MXN</p>`;
}

// Función para eliminar un producto del carrito
function eliminarDelCarrito(id) {
    let carrito = obtenerCarrito();

    // Filtrar el carrito para eliminar el producto con el id correspondiente
    carrito = carrito.filter(producto => producto.id !== id);

    // Guardar el carrito actualizado
    guardarCarrito(carrito);

    // Volver a mostrar el carrito
    mostrarCarrito();
}

// Función para limpiar el carrito
function limpiarCarrito() {
    localStorage.removeItem('carrito');
    mostrarCarrito(); // Actualizar la vista
}

// Llamar a esta función para mostrar el carrito cuando la página cargue
window.onload = function() {
    mostrarCarrito();
};


    </script> <!-- Aquí enlazamos tu script de JS -->
</body>
</html>
