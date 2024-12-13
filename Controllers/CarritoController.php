<?php
include_once("../Models/Carrito.php");
include_once("../Models/Producto.php");

$carrito = new Carrito();
$productoModel = new Producto();

if (isset($_POST['funcion'])) {
    $funcion = $_POST['funcion'];

    switch ($funcion) {
        case 'agregar':
            // Verificar si el cliente está autenticado
            if (!isset($_SESSION['cliente_id'])) {
                echo json_encode(['error' => 'Debes iniciar sesión para agregar productos al carrito.']);
                exit;
            }

            $producto_id = $_POST['producto_id'] ?? '';
            $cantidad = $_POST['cantidad'] ?? 1;  // Por defecto, 1 si no se especifica cantidad

            if ($producto_id && $cantidad) {
                // Obtener el precio del producto desde la base de datos
                $producto = $productoModel->obtenerProductoPorId($producto_id);
                if ($producto) {
                    $precio = $producto['Precio_P']; // Precio del producto
                    $carrito->agregarAlCarrito($producto_id, $cantidad, $precio);
                    echo json_encode(['success' => true, 'message' => 'Producto agregado al carrito']);
                } else {
                    echo json_encode(['error' => 'Producto no encontrado']);
                }
            } else {
                echo json_encode(['error' => 'Producto y cantidad son requeridos']);
            }
            break;

        case 'eliminar':
            $producto_id = $_POST['producto_id'] ?? '';
            if ($producto_id) {
                $carrito->eliminarDelCarrito($producto_id);
                echo json_encode(['success' => true, 'message' => 'Producto eliminado del carrito']);
            } else {
                echo json_encode(['error' => 'Producto no especificado']);
            }
            break;

        case 'ver':
            $carritoContenido = $carrito->obtenerCarrito();
            $total = $carrito->obtenerTotal();
            echo json_encode(['carrito' => $carritoContenido, 'total' => $total]);
            break;

        case 'vaciar':
            $carrito->vaciarCarrito();
            echo json_encode(['success' => true, 'message' => 'Carrito vacío']);
            break;

        default:
            echo json_encode(['error' => 'Función no válida']);
            break;
    }
} else {
    echo json_encode(['error' => 'No se ha definido la función']);
}
?>
