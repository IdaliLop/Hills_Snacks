<?php
// Perfil de la persona con sesión iniciada (cliente o administrador), con opción de editar sus datos.
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/database.php';
iniciarSesion();

$rol = $_SESSION['user_role'] ?? '';
$id  = (int) ($_SESSION['user_id'] ?? 0);
if ($id <= 0 || !in_array($rol, ['admin', 'cliente'], true)) {
    header('Location: login.php');
    exit;
}

$usuario = null;
$db = (new Database())->getConnection();
if ($db) {
    if ($rol === 'admin') {
        $stmt = $db->prepare("SELECT Nombre_D AS nombre, Apellido_D AS apellido, Correo_D AS correo, Telefono_D AS telefono, '' AS domicilio FROM `dueño` WHERE id = ?");
    } else {
        $stmt = $db->prepare("SELECT Nombre_UC AS nombre, Apellido_UC AS apellido, Correo_UC AS correo, Telefono_UC AS telefono, Domicilio_UC AS domicilio FROM usuario_cliente WHERE id = ?");
    }
    $stmt->execute([$id]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/Perfil.css" rel="stylesheet">
    <title>Mi Perfil - Hills Snacks</title>
</head>
<body>
    <div class="perfil-container">
        <h1>Mi Perfil</h1>

        <?php if ($usuario): ?>
            <div class="perfil-info" id="vista-perfil">
                <div class="info-item"><label>Nombre:</label><p><?= e($usuario['nombre'] . ' ' . $usuario['apellido']) ?></p></div>
                <div class="info-item"><label>Correo electrónico:</label><p><?= e($usuario['correo']) ?></p></div>
                <div class="info-item"><label>Teléfono:</label><p><?= e($usuario['telefono'] ?: 'No disponible') ?></p></div>
                <?php if ($rol === 'cliente'): ?>
                    <div class="info-item"><label>Dirección:</label><p><?= e($usuario['domicilio'] ?: 'No disponible') ?></p></div>
                <?php endif; ?>
            </div>

            <form id="form-perfil" style="display:none">
                <input type="hidden" name="funcion" value="actualizar">
                <div class="info-item"><label for="f-nombre">Nombre:</label><input id="f-nombre" name="nombre" maxlength="80" required value="<?= e($usuario['nombre']) ?>"></div>
                <div class="info-item"><label for="f-apellido">Apellido:</label><input id="f-apellido" name="apellido" maxlength="80" required value="<?= e($usuario['apellido']) ?>"></div>
                <div class="info-item"><label for="f-correo">Correo electrónico:</label><input id="f-correo" name="correo" type="email" maxlength="120" required value="<?= e($usuario['correo']) ?>"></div>
                <div class="info-item"><label for="f-telefono">Teléfono (10 dígitos):</label><input id="f-telefono" name="telefono" pattern="[0-9]{10}" required value="<?= e($usuario['telefono']) ?>"></div>
                <?php if ($rol === 'cliente'): ?>
                    <div class="info-item"><label for="f-domicilio">Dirección:</label><input id="f-domicilio" name="domicilio" maxlength="200" required value="<?= e($usuario['domicilio']) ?>"></div>
                <?php endif; ?>
                <div class="info-item"><label for="f-clave">Contraseña nueva (opcional):</label><input id="f-clave" name="contrasena" type="password" minlength="6" placeholder="Déjala vacía para no cambiarla"></div>
                <p id="msg-perfil" style="color:#b71c1c"></p>
                <button type="submit" class="btn-editar">Guardar cambios</button>
                <a href="perfil.php" class="btn-editar" style="background:#777">Cancelar</a>
            </form>

            <p id="msg-ok" style="color:#1b5e20;<?= isset($_GET['ok']) ? '' : 'display:none' ?>">Datos actualizados correctamente.</p>
            <a href="#" id="btn-editar" class="btn-editar">Editar Perfil</a>
            <a href="<?= $rol === 'admin' ? 'admin/indexAdmin.php' : '../index.php' ?>" class="btn-editar" style="background:#777">Volver</a>
        <?php else: ?>
            <p>No se encontró tu cuenta. Inicia sesión de nuevo.</p>
            <a href="login.php" class="btn-editar">Iniciar sesión</a>
        <?php endif; ?>
    </div>

    <script>
        var form = document.getElementById('form-perfil');
        if (form) {
            document.getElementById('btn-editar').addEventListener('click', function (ev) {
                ev.preventDefault();
                document.getElementById('vista-perfil').style.display = 'none';
                document.getElementById('msg-ok').style.display = 'none';
                this.style.display = 'none';
                form.style.display = 'block';
            });
            form.addEventListener('submit', function (ev) {
                ev.preventDefault();
                fetch('../Controllers/CuentaController.php', { method: 'POST', body: new FormData(form) })
                    .then(function (r) { return r.json(); })
                    .then(function (d) {
                        if (d.ok) { window.location.href = 'perfil.php?ok=1'; }
                        else { document.getElementById('msg-perfil').textContent = d.error || 'No se pudo guardar.'; }
                    })
                    .catch(function () { document.getElementById('msg-perfil').textContent = 'No se pudo conectar con el servidor.'; });
            });
        }
    </script>
</body>
</html>
