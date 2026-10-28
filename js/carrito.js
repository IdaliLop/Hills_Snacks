/* ============================================================
   Hills Snacks - módulo del carrito de compras
   El carrito vive en localStorage (clave "carrito"), así funciona
   sin necesidad de iniciar sesión hasta el momento de pedir.

   Cada producto del carrito tiene esta forma:
   { id: 1, nombre: "Hamburguesa", precio: 75, cantidad: 2,
     imagen: "Util/img/x.jpg", idNegocio: 3 }
   ============================================================ */
(function () {
    'use strict';

    var CLAVE = 'carrito';
    var CANTIDAD_MAXIMA = 99;

    function leer() {
        try {
            var datos = JSON.parse(localStorage.getItem(CLAVE));
            if (!Array.isArray(datos)) return [];
            // Se descartan entradas del formato anterior (sin id numérico o sin negocio)
            return datos.filter(function (p) {
                return p && Number(p.id) > 0 && Number(p.idNegocio) > 0 && Number(p.cantidad) > 0;
            });
        } catch (e) {
            return [];
        }
    }

    function guardar(carrito) {
        localStorage.setItem(CLAVE, JSON.stringify(carrito));
        actualizarContador();
    }

    function buscar(carrito, id) {
        id = Number(id);
        for (var i = 0; i < carrito.length; i++) {
            if (Number(carrito[i].id) === id) return carrito[i];
        }
        return null;
    }

    /**
     * Agrega un producto. Un pedido es de un solo negocio, así que si el carrito
     * ya tiene productos de otro negocio devuelve "otro_negocio" y no agrega nada,
     * a menos que se pase { reemplazar: true } (entonces vacía el carrito primero).
     * Devuelve "ok" cuando se agregó.
     */
    function agregar(producto, cantidad, opciones) {
        opciones = opciones || {};
        cantidad = parseInt(cantidad, 10) || 1;
        var carrito = leer();

        if (carrito.length > 0 && Number(carrito[0].idNegocio) !== Number(producto.idNegocio)) {
            if (!opciones.reemplazar) return 'otro_negocio';
            carrito = [];
        }

        var existente = buscar(carrito, producto.id);
        if (existente) {
            existente.cantidad = Math.min(CANTIDAD_MAXIMA, existente.cantidad + cantidad);
        } else {
            carrito.push({
                id: Number(producto.id),
                nombre: producto.nombre,
                precio: Number(producto.precio),
                cantidad: Math.min(CANTIDAD_MAXIMA, cantidad),
                imagen: producto.imagen,
                idNegocio: Number(producto.idNegocio)
            });
        }
        guardar(carrito);
        return 'ok';
    }

    /** Suma o resta unidades. Si la cantidad llega a 0 el producto sale del carrito. */
    function cambiar(id, delta) {
        var carrito = leer();
        var producto = buscar(carrito, id);
        if (!producto) return;
        producto.cantidad += delta;
        if (producto.cantidad <= 0) {
            carrito = carrito.filter(function (p) { return Number(p.id) !== Number(id); });
        } else if (producto.cantidad > CANTIDAD_MAXIMA) {
            producto.cantidad = CANTIDAD_MAXIMA;
        }
        guardar(carrito);
    }

    /** Fija una cantidad exacta (para cuando el cliente escribe el número). */
    function fijar(id, cantidad) {
        cantidad = parseInt(cantidad, 10);
        if (isNaN(cantidad)) return;
        var carrito = leer();
        var producto = buscar(carrito, id);
        if (!producto) return;
        if (cantidad <= 0) {
            carrito = carrito.filter(function (p) { return Number(p.id) !== Number(id); });
        } else {
            producto.cantidad = Math.min(CANTIDAD_MAXIMA, cantidad);
        }
        guardar(carrito);
    }

    function eliminar(id) {
        guardar(leer().filter(function (p) { return Number(p.id) !== Number(id); }));
    }

    function vaciar() {
        localStorage.removeItem(CLAVE);
        actualizarContador();
    }

    function total() {
        return leer().reduce(function (suma, p) { return suma + p.precio * p.cantidad; }, 0);
    }

    function cantidadTotal() {
        return leer().reduce(function (suma, p) { return suma + p.cantidad; }, 0);
    }

    function dinero(numero) {
        return '$' + Number(numero).toFixed(2) + ' MXN';
    }

    /** Pone el número de productos en todos los elementos con clase "carrito-contador". */
    function actualizarContador() {
        var n = cantidadTotal();
        var elementos = document.querySelectorAll('.carrito-contador');
        for (var i = 0; i < elementos.length; i++) {
            elementos[i].textContent = n;
            elementos[i].style.display = n > 0 ? 'inline-block' : 'none';
        }
    }

    /** Mensaje breve en pantalla (reemplaza los alert molestos). */
    function aviso(texto) {
        var caja = document.getElementById('aviso-tienda');
        if (!caja) {
            caja = document.createElement('div');
            caja.id = 'aviso-tienda';
            document.body.appendChild(caja);
        }
        caja.textContent = texto;
        caja.classList.add('visible');
        clearTimeout(aviso._t);
        aviso._t = setTimeout(function () { caja.classList.remove('visible'); }, 2200);
    }

    window.Carrito = {
        leer: leer, agregar: agregar, cambiar: cambiar, fijar: fijar,
        eliminar: eliminar, vaciar: vaciar, total: total,
        cantidadTotal: cantidadTotal, dinero: dinero,
        actualizarContador: actualizarContador, aviso: aviso
    };

    document.addEventListener('DOMContentLoaded', actualizarContador);
    // Si el carrito cambia en otra pestaña, se actualiza el contador aquí también.
    window.addEventListener('storage', function (ev) {
        if (ev.key === CLAVE) actualizarContador();
    });
})();
