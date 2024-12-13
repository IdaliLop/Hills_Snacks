<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Carrito de Compras</title>
    <link href="../css/productos.css" rel="stylesheet">
    <link href="../css/carrito.css" rel="stylesheet">
    <script src="../js/modal.js" defer></script>
</head>
<body>
<style>
        .paypal-container {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 20px;
    width: 100%;
}

#paypal-button-container {
    width: auto;
}
    </style>
<header>
    <h1>Carrito de Compras</h1>
    <nav>
        <a href="../index.php">Volver a la tienda</a>
    </nav>
</header>

<main id="carrito-container" class="carrito-container">
    <p id="carrito-empty" class="carrito-empty">Tu carrito está vacío.</p>
    <div id="productos-carrito" class="productos-carrito">
        <!-- Aquí se mostrarán los productos -->
    </div>
    <div id="resumen-carrito" class="resumen-carrito">
        <p id="total-carrito">Total: 0 MXN</p>
        <button id="vaciar-carrito" class="btn vaciar-carrito" onclick="limpiarCarrito()">Vaciar carrito</button>
    </div>
</main>

<div id="modal-confirmacion" class="modal">
    <div class="modal-content">
        <p>¿Estás seguro de que deseas vaciar tu carrito?</p>
        <button onclick="confirmarVaciar()">Sí, vaciar</button>
        <button onclick="cerrarModal()">Cancelar</button>
    </div>
</div>

<script>
    let total = 0;

    window.onload = function () {
        mostrarCarrito();
    };

    function obtenerCarrito() {
        return JSON.parse(localStorage.getItem('carrito')) || [];
    }

    function guardarCarrito(carrito) {
        localStorage.setItem('carrito', JSON.stringify(carrito));
    }

    function mostrarCarrito() {
        const carrito = obtenerCarrito();
        const productosCarrito = document.getElementById('productos-carrito');
        const carritoEmpty = document.getElementById('carrito-empty');
        const resumenCarrito = document.getElementById('resumen-carrito');

        productosCarrito.innerHTML = '';
        carritoEmpty.style.display = carrito.length === 0 ? 'block' : 'none';
        resumenCarrito.style.display = carrito.length === 0 ? 'none' : 'block';

        total = 0;
        carrito.forEach(producto => {
            total += producto.precio * producto.cantidad;
            productosCarrito.innerHTML += `
                <div class="producto-item">
                    <img src="${producto.imagen}" alt="${producto.nombre}">
                    <h3>${producto.nombre}</h3>
                    <p>Precio: ${producto.precio} MXN</p>
                    <div>
                        <label for="cantidad-${producto.id}">Cantidad:</label>
                        <button onclick="modificarCantidad(${producto.id}, -1)">-</button>
                        <input type="number" id="cantidad-${producto.id}" value="${producto.cantidad}" min="1" onchange="actualizarCantidad(${producto.id})">
                        <button onclick="modificarCantidad(${producto.id}, 1)">+</button>
                    </div>
                    <button onclick="eliminarDelCarrito(${producto.id})">Eliminar</button>
                </div>
            `;
        });

        document.getElementById('total-carrito').innerText = `Total: ${total.toFixed(2)} MXN`;
    }

    function modificarCantidad(id, cambio) {
        const carrito = obtenerCarrito();
        const producto = carrito.find(p => p.id === id);

        if (producto) {
            producto.cantidad += cambio;

            if (producto.cantidad < 1) {
                producto.cantidad = 1; // Evitar cantidades menores a 1
            }

            guardarCarrito(carrito);
            mostrarCarrito();
        }
    }

    function actualizarCantidad(id) {
        const carrito = obtenerCarrito();
        const producto = carrito.find(p => p.id === id);

        if (producto) {
            const cantidadInput = document.getElementById(`cantidad-${id}`).value;
            producto.cantidad = Math.max(1, parseInt(cantidadInput)); // Asegurarse de que sea al menos 1
            guardarCarrito(carrito);
            mostrarCarrito();
        }
    }

    function eliminarDelCarrito(id) {
        let carrito = obtenerCarrito();
        carrito = carrito.filter(producto => producto.id !== id);
        guardarCarrito(carrito);
        mostrarCarrito();
    }

    function limpiarCarrito() {
        const modal = document.getElementById('modal-confirmacion');
        modal.style.display = 'flex';
    }

    function confirmarVaciar() {
        localStorage.removeItem('carrito');
        mostrarCarrito();
        cerrarModal();
    }

    function cerrarModal() {
        const modal = document.getElementById('modal-confirmacion');
        modal.style.display = 'none';
    }
</script>

<div id="paypal-button-container"></div>
<script src="https://www.paypal.com/sdk/js?client-id=AbFtqLAtfN8Jj-_2mkmzf2qBc7VAbohCysnUvB7B01fwkCAUQPB3r80hUl1vvmRjJzkm-2a5tA0FYNTE&currency=MXN"></script>
<script>
    paypal.Buttons({
        createOrder: (data, actions) => {
            if (total <= 0) {
                alert("No hay productos en el carrito.");
                return;
            }
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: total.toFixed(2)
                    }
                }]
            });
        },
        onApprove: (data, actions) => {
            return actions.order.capture().then(orderData => {
                const transaction = orderData.purchase_units[0].payments.captures[0];
                alert(`Transacción ${transaction.status}: ${transaction.id}`);

                // Limpiar el carrito después de la compra
                localStorage.removeItem('carrito');
                mostrarCarrito();

                // Mostrar mensaje de agradecimiento
                document.getElementById('paypal-button-container').innerHTML = '<h3>¡Gracias por tu compra!</h3>';

                // Redirigir después de unos segundos
                setTimeout(() => window.location.href = '../index.php', 3000);
            });
        },
        onError: (err) => {
            console.error(err);
            alert('Ocurrió un error al procesar tu pago.');
        }
    }).render('#paypal-button-container');
</script>

</body>
</html>
