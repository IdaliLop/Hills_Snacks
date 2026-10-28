<?php
// Controllers/UsuarioClienteController.php
// - POST funcion=verificar_sesion -> responde con los datos de la sesión actual (lo usa index.js)
// - GET (enlace "CERRAR SESIÓN" del menú) -> cierra la sesión y vuelve al inicio
require_once __DIR__ . '/../config/helpers.php';
iniciarSesion();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $_SESSION = [];
    session_destroy();
    header('Location: ../index.php');
    exit;
}

header('Content-Type: application/json; charset=utf-8');

if (($_POST['funcion'] ?? '') === 'verificar_sesion') {
    if (isset($_SESSION['user_id'])) {
        echo json_encode([
            'id'     => $_SESSION['user_id'],
            'rol'    => $_SESSION['user_role'] ?? 'cliente',
            'nombre' => $_SESSION['nombre'] ?? ''
        ]);
    } else {
        echo json_encode(new stdClass()); // objeto vacío: no hay sesión
    }
    exit;
}

echo json_encode(['error' => 'Función no válida']);
