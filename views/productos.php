<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/productos.css" rel="stylesheet" >
    <title>Productos del Negocio</title>
    <script
        src="https://kit.fontawesome.com/81581fb069.js"
        crossorigin="anonymous"
    ></script>
</head>
<body>
    <div class="productos">
        <h2 class="productos__title">Productos del Negocio</h2>
        <div class="productos__container">
            <?php if (!empty($productos)): ?>
                <?php foreach ($productos as $producto): ?>
                    <div class="productos__item">
                        <!-- Mostrar imagen del producto -->
                        <?php if (!empty($producto['Imagen_P'])): ?>
                            <!-- Si la imagen existe, se muestra -->
                            <img src="<?php echo htmlspecialchars($producto['Imagen_P']); ?>" 
                                alt="Imagen de <?php echo htmlspecialchars($producto['Nombre_P']); ?>" 
                                class="productos__image">
                        <?php else: ?>
                            <!-- Imagen por defecto si no hay imagen en la base de datos -->
                            <img src="Util/img/default.png" 
                                alt="Imagen no disponible" 
                                class="productos__image">
                        <?php endif; ?>

                        <h3><?php echo htmlspecialchars($producto['Nombre_P']); ?></h3>
                        <p><strong>Precio:</strong> <?php echo htmlspecialchars($producto['Precio_P']); ?> MXN</p>
                        <!-- Agregar al carrito si es necesario -->
                        <!-- <span><i class="fa-solid fa-basket-shopping">Agregar al Carrito</i></span> -->
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <h2 class="productos__empty">No hay productos disponibles para este negocio.</h2>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
