<?php
session_start();
require_once 'config/database.php';

class Carrito {

    // Función para agregar un producto al carrito
    public function agregarAlCarrito($producto_id, $cantidad, $precio) {
        if (isset($_SESSION['carrito'])) {
            $carrito = $_SESSION['carrito'];
        } else {
            $carrito = [];
        }

        // Si el producto ya está en el carrito, actualizar la cantidad y el precio
        if (isset($carrito[$producto_id])) {
            $carrito[$producto_id]['cantidad'] += $cantidad;
        } else {
            // Si el producto no está, agregarlo al carrito con su precio
            $carrito[$producto_id] = ['producto_id' => $producto_id, 'cantidad' => $cantidad, 'precio' => $precio];
        }

        // Guardar el carrito en la sesión
        $_SESSION['carrito'] = $carrito;
    }

    // Función para eliminar un producto del carrito
    public function eliminarDelCarrito($producto_id) {
        if (isset($_SESSION['carrito'][$producto_id])) {
            unset($_SESSION['carrito'][$producto_id]);
        }
    }

    // Función para obtener el carrito
    public function obtenerCarrito() {
        return isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];
    }

    // Función para vaciar el carrito
    public function vaciarCarrito() {
        unset($_SESSION['carrito']);
    }

    // Función para obtener el total de productos en el carrito
    public function obtenerTotal() {
        $total = 0;
        foreach ($this->obtenerCarrito() as $producto) {
            // Calcular el total multiplicando cantidad por el precio
            $total += $producto['cantidad'] * $producto['precio'];
        }
        return $total;
    }
}
?>
