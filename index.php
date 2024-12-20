<?php
include_once __DIR__ . '/Views/layouts/header.php';

require_once 'Controllers/negocioController.php';
require_once 'Controllers/ProductosControler.php';


$action = $_GET['action'] ?? 'inicio';
$categoria = $_GET['categoria'] ?? null;
$idNegocio = $_GET['idNegocio'] ?? null;


switch ($action) {
    case 'mostrarNegocios':
        $controller = new NegociosController();
        $controller->mostrarNegocios();
        break;

    case 'mostrarNegociosPorCategoria':
        if ($categoria) {
            $controller = new NegociosController();
            $controller->mostrarNegociosPorCategoria($categoria);
        } else {
            echo "<p>Error: Categoría no especificada.</p>";
        }
        break;

    case 'mostrarProductosPorNegocio':
            if ($idNegocio) {
                $controller = new ProductosController();
                $controller->mostrarProductosPorNegocio($idNegocio);
            } else {
                echo "<p>Error: ID del negocio no especificado.</p>";
            }
            break;

    default:
        // Contenido de la página principal cuando no hay acciones
        
        ?>
<main class="home">
            <div class="home__wrapper">
                <div class="home__img-container">
                    <img src="Util/img/LogoHills.png" class="home__img" alt="logotipo">
                </div>
                <div class="home__data-container">
                    <div class="home__data">
                        <div class="home__description">
                            <h1>¿Qué es HILLS SNACKS?</h1>
                            <p>Somos una plataforma de delivery diseñada para negocios de comida en Colinas de Tonalá. Que te 
                                permite realizar pedidos a domicilio de manera rápida, cómoda y con tiempos de espera cortos, dentro de tu fraccionamiento.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <section class="negocios">
            <h2 class="negocios__title">CATEGORÍAS</h2>
            <hr>
            <div class="negocios__container">
                <a href="index.php?action=mostrarNegociosPorCategoria&categoria=Hamburguesas" class="negocios__type" id="hamburguesa">
                    <h2 class="negocios__type-name">HAMBURGUESA</h2>
                </a>
                <a href="index.php?action=mostrarNegociosPorCategoria&categoria=Alitas" class="negocios__type" id="alitas">
                    <h2 class="negocios__type-name">ALITAS</h2>
                </a>
                <a href="index.php?action=mostrarNegociosPorCategoria&categoria=Chilaquiles" class="negocios__type" id="chilaquiles">
                    <h2 class="negocios__type-name">CHILAQUILES</h2>
                </a>
                <a href="index.php?action=mostrarNegociosPorCategoria&categoria=Pizza" class="negocios__type" id="pizza">
                    <h2 class="negocios__type-name">PIZZA</h2>
                </a>
                <a href="index.php?action=mostrarNegociosPorCategoria&categoria=Pollo" class="negocios__type" id="pollo">
                    <h2 class="negocios__type-name">POLLO</h2>
                </a>
                <a href="index.php?action=mostrarNegociosPorCategoria&categoria=Cenaduria" class="negocios__type" id="cenaduria">
                    <h2 class="negocios__type-name">CENADURIA</h2>
                </a>
                <a href="index.php?action=mostrarNegociosPorCategoria&categoria=Tacos" class="negocios__type" id="tacos">
                    <h2 class="negocios__type-name">TACOS</h2>
                </a>
                <a href="index.php?action=mostrarNegociosPorCategoria&categoria=Postres" class="negocios__type" id="tapioca">
                    <h2 class="negocios__type-name">POSTRES</h2>
                </a>
            </div>
        </section>
        <?php
        break;
}
?>
<script src="index.js"></script>
<?php include_once __DIR__ . '/Views/layouts/footer.php'; ?>