<?php
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/database.php';
iniciarSesion();

// Si el cliente inició sesión, sus datos aparecen ya escritos en el formulario de entrega
$prefill = ['nombre' => '', 'telefono' => '', 'direccion' => ''];
if (($_SESSION['user_role'] ?? '') === 'cliente') {
    $db = (new Database())->getConnection();
    if ($db) {
        $stmt = $db->prepare("SELECT Nombre_UC, Apellido_UC, Telefono_UC, Domicilio_UC FROM usuario_cliente WHERE id = :id");
        $stmt->execute([':id' => $_SESSION['user_id']]);
        if ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $prefill['nombre'] = trim($fila['Nombre_UC'] . ' ' . $fila['Apellido_UC']);
            $prefill['telefono'] = $fila['Telefono_UC'];
            $prefill['direccion'] = $fila['Domicilio_UC'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Carrito de Compras</title>
    <link href="../css/productos.css" rel="stylesheet">
    <link href="../css/carrito.css" rel="stylesheet">
    <link href="../css/tienda.css" rel="stylesheet">
</head>
<body>
<header>
    <h1>Carrito de Compras</h1>
    <nav>
        <a href="../index.php">Volver a la tienda</a>
    </nav>
</header>

<main id="carrito-container" class="carrito-container">
    <p id="carrito-empty" class="carrito-empty">Tu carrito está vacío. <a href="../index.php">Elige algo rico</a>.</p>
    <div id="productos-carrito" class="productos-carrito">
        <!-- Aquí se muestran los productos -->
    </div>
    <div id="resumen-carrito" class="resumen-carrito">
        <p id="total-carrito">Total: $0.00 MXN</p>
        <button id="vaciar-carrito" class="btn vaciar-carrito" onclick="pedirVaciar()">Vaciar carrito</button>
    </div>
</main>

<!-- Datos de entrega y pago -->
<section id="datos-entrega" class="datos-entrega">
    <h2>Datos de entrega</h2>
    <label for="nombre">Nombre</label>
    <input type="text" id="nombre" maxlength="120" value="<?php echo e($prefill['nombre']); ?>" placeholder="Tu nombre">
    <label for="telefono">Teléfono</label>
    <input type="tel" id="telefono" maxlength="15" value="<?php echo e($prefill['telefono']); ?>" placeholder="10 dígitos">
    <label for="direccion">Dirección en Colinas de Tonalá</label>
    <input type="text" id="direccion" maxlength="200" value="<?php echo e($prefill['direccion']); ?>" placeholder="Calle, número y referencias">

    <div id="mensaje-error" class="mensaje-error"></div>

    <div class="acciones-pago">
        <button id="btn-efectivo" class="btn comprar-carrito" onclick="confirmarEfectivo()">Confirmar pedido (pago en efectivo al recibir)</button>
        <div id="paypal-button-container"></div>
    </div>
</section>

<!-- Pantalla de pedido realizado -->
<section id="pedido-ok" class="pedido-ok" style="display:none">
    <h2>¡Gracias por tu pedido!</h2>
    <p id="pedido-ok-texto"></p>
    <p><a href="../index.php">Volver a la tienda</a></p>
</section>

<div id="modal-confirmacion" class="modal">
    <div class="modal-content">
        <p>¿Estás seguro de que deseas vaciar tu carrito?</p>
        <button onclick="confirmarVaciar()">Sí, vaciar</button>
        <button onclick="cerrarModal()">Cancelar</button>
    </div>
</div>

<script src="../js/carrito.js"></script>
<script>
    var RUTA_PEDIDOS = '../Controllers/PedidoController.php';

    // Evita que un nombre de producto con símbolos rompa el HTML
    function esc(texto) {
        var d = document.createElement('div');
        d.textContent = texto;
        return d.innerHTML;
    }

    // Dibuja el carrito completo a partir de lo guardado en localStorage
    function mostrarCarrito() {
        var carrito = Carrito.leer();
        var vacio = carrito.length === 0;

        document.getElementById('carrito-empty').style.display = vacio ? 'block' : 'none';
        document.getElementById('resumen-carrito').style.display = vacio ? 'none' : 'flex';
        document.getElementById('datos-entrega').style.display = vacio ? 'none' : 'block';

        var html = '';
        carrito.forEach(function (p) {
            html += '<div class="producto-item" data-id="' + p.id + '">' +
                '<img src="../' + esc(p.imagen) + '" alt="' + esc(p.nombre) + '">' +
                '<div class="producto-info"><h3>' + esc(p.nombre) + '</h3>' +
                '<p>Precio: ' + Carrito.dinero(p.precio) + '</p></div>' +
                '<div class="cantidad-control">' +
                    '<button data-accion="menos" title="Quitar uno">-</button>' +
                    '<input type="number" class="cantidad" value="' + p.cantidad + '" min="1" max="99">' +
                    '<button data-accion="mas" title="Agregar uno">+</button>' +
                '</div>' +
                '<div class="producto-subtotal">' + Carrito.dinero(p.precio * p.cantidad) + '</div>' +
                '<button data-accion="eliminar">Eliminar</button>' +
                '</div>';
        });
        document.getElementById('productos-carrito').innerHTML = html;
        document.getElementById('total-carrito').innerText = 'Total: ' + Carrito.dinero(Carrito.total());
        Carrito.actualizarContador();
    }

    // Los botones +, - y Eliminar se manejan desde un solo lugar
    document.getElementById('productos-carrito').addEventListener('click', function (ev) {
        var boton = ev.target.closest('button[data-accion]');
        if (!boton) return;
        var id = boton.closest('.producto-item').dataset.id;
        var accion = boton.dataset.accion;
        if (accion === 'mas') Carrito.cambiar(id, 1);
        if (accion === 'menos') Carrito.cambiar(id, -1);   // al llegar a 0 el producto se quita
        if (accion === 'eliminar') Carrito.eliminar(id);
        mostrarCarrito();
    });
    document.getElementById('productos-carrito').addEventListener('change', function (ev) {
        if (!ev.target.classList.contains('cantidad')) return;
        Carrito.fijar(ev.target.closest('.producto-item').dataset.id, ev.target.value);
        mostrarCarrito();
    });

    // ----- Vaciar -----
    function pedirVaciar() { document.getElementById('modal-confirmacion').style.display = 'flex'; }
    function cerrarModal() { document.getElementById('modal-confirmacion').style.display = 'none'; }
    function confirmarVaciar() { Carrito.vaciar(); mostrarCarrito(); cerrarModal(); }

    // ----- Pedido -----
    function datosEntrega() {
        return {
            nombre: document.getElementById('nombre').value.trim(),
            telefono: document.getElementById('telefono').value.trim(),
            direccion: document.getElementById('direccion').value.trim()
        };
    }

    function mostrarError(texto) {
        document.getElementById('mensaje-error').innerText = texto || '';
    }

    // Revisión rápida antes de enviar (el servidor vuelve a validar todo)
    function formularioValido() {
        var d = datosEntrega();
        if (Carrito.leer().length === 0) { mostrarError('Tu carrito está vacío.'); return false; }
        if (!d.nombre) { mostrarError('Escribe tu nombre.'); return false; }
        if (!/^\+?[0-9\s\-()]{7,18}$/.test(d.telefono)) { mostrarError('Escribe un teléfono válido.'); return false; }
        if (!d.direccion) { mostrarError('Escribe la dirección de entrega.'); return false; }
        mostrarError('');
        return true;
    }

    // Envía el pedido al servidor; devuelve una promesa con la respuesta
    function enviarPedido(metodo, referencia) {
        var d = datosEntrega();
        return fetch(RUTA_PEDIDOS, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                funcion: 'crear',
                nombre: d.nombre, telefono: d.telefono, direccion: d.direccion,
                metodo: metodo, referencia: referencia || '',
                items: Carrito.leer().map(function (p) { return { id: p.id, cantidad: p.cantidad }; })
            })
        }).then(function (r) { return r.json(); });
    }

    function pedidoRealizado(respuesta) {
        Carrito.vaciar();
        document.getElementById('carrito-container').style.display = 'none';
        document.getElementById('datos-entrega').style.display = 'none';
        document.getElementById('pedido-ok').style.display = 'block';
        document.getElementById('pedido-ok-texto').innerText =
            'Tu pedido #' + respuesta.id + ' por ' + Carrito.dinero(respuesta.total) + ' fue enviado al negocio.';
    }

    function confirmarEfectivo() {
        if (!formularioValido()) return;
        var boton = document.getElementById('btn-efectivo');
        boton.disabled = true;
        enviarPedido('Efectivo').then(function (r) {
            if (r.ok) { pedidoRealizado(r); } else { mostrarError(r.error); boton.disabled = false; }
        }).catch(function () {
            mostrarError('No se pudo conectar con el servidor.');
            boton.disabled = false;
        });
    }

    window.onload = mostrarCarrito;
</script>

<!-- Pago con PayPal (necesita internet; si no carga, el pago en efectivo sigue funcionando) -->
<script src="https://www.paypal.com/sdk/js?client-id=AbFtqLAtfN8Jj-_2mkmzf2qBc7VAbohCysnUvB7B01fwkCAUQPB3r80hUl1vvmRjJzkm-2a5tA0FYNTE&currency=MXN"></script>
<script>
    if (window.paypal) {
        paypal.Buttons({
            onClick: function (data, actions) {
                return formularioValido() ? actions.resolve() : actions.reject();
            },
            createOrder: function (data, actions) {
                return actions.order.create({
                    purchase_units: [{ amount: { value: Carrito.total().toFixed(2) } }]
                });
            },
            onApprove: function (data, actions) {
                return actions.order.capture().then(function (orderData) {
                    var captura = orderData.purchase_units[0].payments.captures[0];
                    return enviarPedido('PayPal', captura.id).then(function (r) {
                        if (r.ok) {
                            pedidoRealizado(r);
                        } else {
                            mostrarError('Tu pago se realizó (referencia ' + captura.id + ') pero no pudimos registrar el pedido: ' + r.error);
                        }
                    });
                });
            },
            onError: function (err) {
                console.error(err);
                mostrarError('Ocurrió un error al procesar tu pago con PayPal.');
            }
        }).render('#paypal-button-container');
    }
</script>

</body>
</html>
