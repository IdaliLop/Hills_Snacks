<?php
// config/helpers.php
// Funciones pequeñas que se reutilizan en varias vistas.

/**
 * Devuelve la ruta de una imagen lista para usarse en un <img src>.
 * En la BD las rutas se guardaron de varias formas ("Util/img/x.jpg", "../Util/img/x.jpg"
 * o solo "x.jpg"), así que se normaliza todo a "<prefijo>Util/img/<archivo>".
 *
 * @param string|null $ruta    Valor guardado en la BD.
 * @param string      $prefijo Prefijo según desde dónde se ve la página ('' en la raíz, '../../' en Views/admin).
 */
function rutaImagen($ruta, $prefijo = '') {
    if (empty($ruta)) {
        return $prefijo . 'Util/img/default.jpg';
    }
    if (preg_match('#^https?://#i', $ruta)) {
        return $ruta;
    }
    return $prefijo . 'Util/img/' . basename($ruta);
}

/** Escapa texto para imprimirlo de forma segura en HTML. */
function e($texto) {
    return htmlspecialchars((string) $texto, ENT_QUOTES, 'UTF-8');
}

/** Inicia la sesión solo si todavía no está iniciada. */
function iniciarSesion() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

/** Devuelve true si hay un administrador (dueño) con sesión iniciada. */
function esAdmin() {
    iniciarSesion();
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

/**
 * Para las secciones del panel admin que se cargan con fetch (catalogo.php, pedidos.php...):
 * si no hay un administrador con sesión, responde 403 y termina.
 */
function exigirAdminParcial() {
    if (!esAdmin()) {
        http_response_code(403);
        echo '<p>Debes iniciar sesión como administrador para ver esta sección.</p>';
        exit;
    }
}

/** Convierte una fecha de la BD a formato legible (ej. 25/10/2026 08:30 pm). */
function fechaLegible($fecha) {
    return $fecha ? date('d/m/Y h:i a', strtotime($fecha)) : '—';
}
