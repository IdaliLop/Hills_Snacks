<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Negocios - Categoría: <?php echo htmlspecialchars($categoria); ?></title>
</head>
<body>
    <div class="negocios">
        <h2 class="negocios__title">Negocios de la Categoría: <?php echo htmlspecialchars($categoria); ?></h2>
        <div class="negocios__container">
            <?php if (!empty($negocios)): ?>
                <?php foreach ($negocios as $negocio): ?>
                    <script>
                        verificar_sesion();
                            function verificar_sesion(){
                                fetch('Controllers/UsuarioClienteController.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded',
                                },
                                body: 'funcion=verificar_sesion'
                            })
                            .then(response => {
                                console.log('Response:', response);  
                                return response.json();  
                            })
                            .then(data => {
                                console.log('Data:', data);
                                if (data.id) {
                                    document.getElementById('login-link').style.display = 'none';
                                    console.log("login");
                                    console.log("Hay una sesion activa");
                                }
                                else{
                                    console.log("No hay una sesion activa");
                                    window.location.href = 'Views/login.html';

                                }
                            })
                            .catch(error => console.log('Error:', error));
                            }
                    </script>
                    <a class="negocios__type" href="index.php?action=mostrarProductosPorNegocio&idNegocio=<?php echo urlencode($negocio['IdNegocio_N']); ?>">
                        <div class="negocios__info">
                            <!-- Mostrar imagen del negocio -->
                            <?php if (!empty($negocio['Imagen_N'])): ?>
                                <!-- Mostrar imagen si la ruta existe en la base de datos -->
                                <img src="<?php echo htmlspecialchars($negocio['Imagen_N']); ?>" 
                                    alt="Imagen de <?php echo htmlspecialchars($negocio['Nombre_N']); ?>" 
                                    class="negocios__image">
                            <?php else: ?>
                                <!-- Imagen por defecto si no hay imagen en la base de datos -->
                                <img src="<?php echo htmlspecialchars($negocio['Imagen_N']); ?>" 
                                    alt="Imagen no disponible" 
                                    class="negocios__image">
                            <?php endif; ?>

                            <!-- Mostrar información del negocio -->
                            <div class="negocios__text">
                                <h2><?php echo htmlspecialchars($negocio['Nombre_N']); ?></h2>
                                <p><strong>Dirección:</strong> <?php echo htmlspecialchars($negocio['Direccion_N']); ?></p>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <h2 class="productos__empty">No hay negocios disponibles para esta categoría.</h2>
            <?php endif; ?>
        </div>
    </div>
    <script src="negocioPorCategoria.js"></script>
</body>
</html>
