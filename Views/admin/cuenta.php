<?php
require_once __DIR__ . '/../../config/helpers.php';
exigirAdminParcial();
require_once __DIR__ . '/../../config/database.php';

$db = (new Database())->getConnection();
$stmt = $db->prepare("SELECT Nombre_D, Apellido_D, Correo_D, Telefono_D FROM `dueño` WHERE id = ?");
$stmt->execute([(int) $_SESSION['user_id']]);
$d = $stmt->fetch(PDO::FETCH_ASSOC) ?: ['Nombre_D' => '', 'Apellido_D' => '', 'Correo_D' => '', 'Telefono_D' => ''];
?>
<!--OPCIONES PARA LA INFORMACIÓN DE LA CUENTA-->
<div class="shadow-container">
    <h1 style="color: #154360; font-size: 35px">Información personal</h1>
    <form id="info-form">
        <input type="hidden" name="funcion" value="actualizar">
        <div class="info-grid">
            <div class="info-field">
                <label>NOMBRE</label>
                <input type="text" id="nombre" name="nombre" maxlength="80" required value="<?= e($d['Nombre_D']) ?>" readonly>
            </div>
            <div class="info-field">
                <label>APELLIDO</label>
                <input type="text" id="apellido" name="apellido" maxlength="80" required value="<?= e($d['Apellido_D']) ?>" readonly>
            </div>
            <div class="info-field">
                <label>CORREO</label>
                <input type="email" id="correo" name="correo" maxlength="120" required value="<?= e($d['Correo_D']) ?>" readonly>
            </div>
            <div class="info-field phone-field">
                <label>TELÉFONO (10 dígitos)</label>
                <input type="text" id="telefono" name="telefono" pattern="[0-9]{10}" required value="<?= e($d['Telefono_D']) ?>" readonly>
            </div>
            <div class="info-field">
                <label>CONTRASEÑA NUEVA</label>
                <input type="password" id="contrasena" name="contrasena" minlength="6" placeholder="Vacía = no cambiar" value="" readonly>
            </div>
        </div>
        <button type="button" class="btn-cambio" onclick="habilitarEdicion()">Cambiar Datos</button>
        <button type="submit" class="btn-guardar" style="display: none;">Guardar Cambios</button>
    </form>
    <p id="mensaje" style="color: green; display: none;">Datos actualizados correctamente</p>
    <p id="mensaje-error" style="color: #b71c1c; display: none;"></p>
</div>
