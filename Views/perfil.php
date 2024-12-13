<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: index.php'); // Redirige al inicio si no hay sesión
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/Perfil.css" rel="stylesheet" >
    <title>Mi Perfil - Hills Snacks</title>
</head>
<body>
    <div class="perfil-container">
        <h1>Mi Perfil</h1>

        <?php if (isset($usuario) && $usuario): ?>
            <div class="perfil-info">
                <div class="info-item">
                    <label for="nombre">Nombre:</label>
                    <p id="nombre"><?php echo htmlspecialchars($usuario['Nombre_UC']); ?></p>
                </div>
                <div class="info-item">
                    <label for="email">Correo electrónico:</label>
                    <p id="email"><?php echo htmlspecialchars($usuario['Correo_UC']); ?></p>
                </div>
                <div class="info-item">
                    <label for="telefono">Teléfono:</label>
                    <p id="telefono"><?php echo htmlspecialchars($usuario['Telefono_UC']); ?></p>
                </div>
                <div class="info-item">
                    <label for="direccion">Dirección:</label>
                    <p id="direccion"><?php echo htmlspecialchars($usuario['Direccion_UC']); ?></p>
                </div>
            </div>

            <a href="editar_perfil.php" class="btn-editar">Editar Perfil</a>
        <?php else: ?>
            <p>Usuario no encontrado. Por favor, verifica tu sesión.</p>
        <?php endif; ?>
    </div>
</body>
</html>
