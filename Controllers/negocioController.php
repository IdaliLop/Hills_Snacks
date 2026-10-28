<?php
require_once __DIR__ . '/../Models/Negocio.php';

class NegociosController {
    public function mostrarNegocios() {
        $negocioModel = new Negocio();
        $negocios = $negocioModel->obtenerNegocios();
        require __DIR__ . '/../Views/negociosPorCategoria.php';
    }

    public function mostrarNegociosPorCategoria($categoria) {
        $negocioModel = new Negocio();
        $negocios = $negocioModel->obtenerNegociosPorCategoria($categoria);
        require __DIR__ . '/../Views/negociosPorCategoria.php';
    }
}



?>