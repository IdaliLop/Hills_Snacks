<!--OPCIONES PARA LA INFORMACIÓN DE LA CUENTA-->
<div class="shadow-container">
    <h1 style="color: #154360; font-size: 35px">Información personal</h1>
    <form id="info-form">
        <div class="info-grid">
            <div class="info-field">
                <label>NOMBRE</label>
                <input type="text" id="nombre" name="nombre" value="" readonly>
            </div>
            <div class="info-field">
                <label>APELLIDO</label>
                <input type="text" id="apellido" name="apellido" value="" readonly>
            </div>
            <div class="info-field">
                <label>CORREO</label>
                <input type="email" id="correo" name="correo" value="" readonly>
            </div>
            <div class="info-field phone-field">
                <label>TELÉFONO</label>
                <input type="text" id="telefono" name="telefono" value="" readonly>
            </div>
            <div class="info-field">
                <label>CONTRASEÑA</label>
                <input type="password" id="contrasena" name="contrasena" value="" readonly>
            </div>
        </div>
        <button type="button" class="btn-cambio" onclick="habilitarEdicion()">Cambiar Datos</button>
        <button type="submit" class="btn-guardar" style="display: none;">Guardar Cambios</button>
    </form>
    <p id="mensaje" style="color: green; display: none;">Datos actualizados correctamente</p>
</div>


