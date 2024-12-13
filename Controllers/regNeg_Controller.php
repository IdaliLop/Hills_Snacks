<?php
require_once '../Models/AgNegocio.php';
require_once '../config/database.php';

// Configuración de la base de datos
$database = new Database();
$db = $database->getConnection();

// Instanciamos el modelo
$negocioModel = new NegocioModel($db);

// Verificamos si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibimos los datos del formulario
    $nombreNegocio = $_POST['nombreNegocio'];
    $direccion = $_POST['direccion'];
    $telefonoNegocio = $_POST['telefonoNegocio'];
    $tipoNegocio = $_POST['tipoNegocio'];
    $tipoEnvio = $_POST['tipoEnvio'];

    // Ruta para guardar la imagen
    $uploadDir = '../Util/img/';
    
    // Verificar si la carpeta existe y si tiene permisos de escritura
    if (!is_dir($uploadDir)) {
        // Si la carpeta no existe, intentar crearla
        mkdir($uploadDir, 0777, true);  // 0777 da permisos de lectura, escritura y ejecución para todos
    }

    // Verificar si la carpeta tiene permisos de escritura
    if (is_writable($uploadDir)) {
        // Manejo de la imagen
        if (isset($_FILES['imagenNegocio']) && $_FILES['imagenNegocio']['error'] === UPLOAD_ERR_OK) {
            $imagenTmp = $_FILES['imagenNegocio']['tmp_name'];
            $imagenNombre = $_FILES['imagenNegocio']['name'];
            $imagenRuta = $uploadDir . $imagenNombre;

            // Movemos la imagen a la carpeta de destino
            if (move_uploaded_file($imagenTmp, $imagenRuta)) {
                // Registramos el negocio en la base de datos
                $resultado = $negocioModel->registrarNegocio($nombreNegocio, $direccion, $telefonoNegocio, $tipoNegocio, $tipoEnvio, $imagenRuta);

                if ($resultado) {
                    echo "Negocio registrado con éxito.";
                    // Redirigir a otra página si es necesario
                    header("Location: ../Views/admin/indexAdmin.php");
                } else {
                    echo "Error al registrar el negocio.";
                }
            } else {
                echo "Error al subir la imagen.";
            }
        } else {
            echo "No se ha seleccionado una imagen.";
        }
    } else {
        echo "La carpeta no tiene permisos de escritura. Intenta cambiar los permisos de la carpeta 'Util/img'.";
    }
}
?>
