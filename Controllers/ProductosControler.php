<?php
require_once 'Models/Productos.php';

class ProductosController {
    public function mostrarProductosPorNegocio($idNegocio) {
        $productoModel = new Producto();
        $productos = $productoModel->obtenerProductosPorNegocio($idNegocio);

        require 'Views/productos.php'; // Carga la vista de productos
    }
}
?>