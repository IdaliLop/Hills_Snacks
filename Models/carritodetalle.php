<?php

require_once 'config/database.php';

class CarritoDetalle {
    public static function buscarProductoEnCarrito($id_carrito, $id_producto) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM carrito_detalle WHERE id_carrito = ? AND id_producto = ?");
        $stmt->execute([$id_carrito, $id_producto]);
        return $stmt->fetchObject();
    }

    public static function agregarProducto($id_carrito, $id_producto, $cantidad) {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO carrito_detalle (id_carrito, id_producto, cantidad) VALUES (?, ?, ?)");
        $stmt->execute([$id_carrito, $id_producto, $cantidad]);
    }

    public static function actualizarCantidad($id_detalle, $cantidad) {
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE carrito_detalle SET cantidad = ? WHERE id_detalle = ?");
        $stmt->execute([$cantidad, $id_detalle]);
    }

    public static function finalizarCompra($id_carrito) {
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE carrito_detalle SET fecha_compra = NOW() WHERE id_carrito = ?");
        $stmt->execute([$id_carrito]);
    }

    public static function eliminarProducto($id_detalle) {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM carrito_detalle WHERE id_detalle = ?");
        $stmt->execute([$id_detalle]);
    }

    public static function productosEnCarrito($id_carrito) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT COUNT(*) FROM carrito_detalle WHERE id_carrito = ?");
        $stmt->execute([$id_carrito]);
        return $stmt->fetchColumn() > 0;
    }
}
