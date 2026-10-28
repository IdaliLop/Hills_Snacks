<?php require_once __DIR__ . '/../config/helpers.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Negocios - Categoría: <?php echo e($categoria ?? 'Todos'); ?></title>
</head>
<body>
    <div class="negocios">
        <h2 class="negocios__title">Negocios de la Categoría: <?php echo e($categoria ?? 'Todos'); ?></h2>
        <div class="negocios__container">
            <?php if (!empty($negocios)): ?>
                <?php foreach ($negocios as $negocio): ?>
                    <a class="negocios__type" href="index.php?action=mostrarProductosPorNegocio&idNegocio=<?php echo urlencode($negocio['IdNegocio_N']); ?>">
                        <div class="negocios__info">
                            <!-- Mostrar imagen del negocio -->
                            <!-- rutaImagen() usa la imagen del negocio o una por defecto si no tiene -->
                            <img src="<?php echo e(rutaImagen($negocio['Imagen_N'] ?? '')); ?>"
                                 alt="Imagen de <?php echo e($negocio['Nombre_N']); ?>"
                                 class="negocios__image">

                            <!-- Mostrar información del negocio -->
                            <div class="negocios__text">
                                <h2><?php echo e($negocio['Nombre_N']); ?></h2>
                                <p><strong>Dirección:</strong> <?php echo e($negocio['Direccion_N']); ?></p>
                            </div>
                            
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <h2 class="productos__empty">No hay negocios disponibles para esta categoría.</h2>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
