<?php
    include_once __DIR__ . '/Views/layouts/header.php';
?>
<main class="home">
        <div class="home__wrapper">
            <div class="home__img-container">
                <img src="Util/img/LogoHills.png" class="home__img" alt="logotipo">
            </div>
            <div class="home__data-container">
                <div class="home__data">
                    <div class="home__description">
                        <h1>¿Que es HILLS SNACKS?</h1>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur dolor ad nobis obcaecati autem tenetur deserunt rem, consectetur suscipit dolore maxime voluptas sed saepe eius magni architecto vel, voluptates ipsam.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <section class="negocios">
        <h2 class="negocios__title">CATEGORIAS</h2>
        <hr>
        <div class="negocios__container">
            <a href="hamburguesa.html" class="negocios__type" id="hamburguesa">
                <h2 class="negocios__type-name">HAMBURGUESA</h2>
            </a>
            <div class="negocios__type" id="alitas">
                <h2 class="negocios__type-name">ALITAS</h2>
            </div>
            <div class="negocios__type" id="chilaquiles">
                <h2 class="negocios__type-name">CHILAQUILES</h2>
            </div>
            <div class="negocios__type" id="pizza">
                <h2 class="negocios__type-name">PIZZA</h2>
            </div>
            <div class="negocios__type" id="pollo">
                <h2 class="negocios__type-name">POLLO</h2>
            </div>
            <div class="negocios__type" id="pozole">
                <h2 class="negocios__type-name">CENADURIA</h2>
            </div>
            <div class="negocios__type" id="tacos">
                <h2 class="negocios__type-name">TACOS</h2>
            </div>
            <div class="negocios__type" id="tapioca">
                <h2 class="negocios__type-name">TAPIOCA</h2>
            </div>
        </div>
    </section>
<?php include_once __DIR__ . '/Views/layouts/footer.php'?>