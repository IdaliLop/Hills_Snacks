<?php
require_once __DIR__ . '/../Models/Productos.php';
require_once __DIR__ . '/../Models/Negocio.php';

class ProductosController {
    public function mostrarProductosPorNegocio($idNegocio) {
        $productoModel = new Producto();
        $negocioModel = new Negocio();

        $productos = $productoModel->obtenerProductosPorNegocio($idNegocio);
        $negocio = $negocioModel->obtenerNegocioPorId($idNegocio);

        require __DIR__ . '/../Views/productos.php'; // Carga la vista de productos
    }
}
?>
