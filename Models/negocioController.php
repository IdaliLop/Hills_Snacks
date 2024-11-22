<?php
require_once 'Models/Negocio.php';

class NegociosController {
    public function mostrarNegocios() {
        $negocioModel = new Negocio();
        $negocios = $negocioModel->obtenerNegocios();
        require 'Views/negociosPorCategoria.php';
    }

    public function mostrarNegociosPorCategoria($categoria) {
        $negocioModel = new Negocio();
        $negocios = $negocioModel->obtenerNegociosPorCategoria($categoria);
        require 'Views/negociosPorCategoria.php';
    }
}



?>
