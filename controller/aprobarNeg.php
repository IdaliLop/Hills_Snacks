<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';


// Habilitar la visualización de errores para depuración
ini_set('display_errors', 1);
error_reporting(E_ALL);

$database = new Database();
$db = $database->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica si los parámetros existen
    $idNegocio = isset($_POST['idNegocio_N']) ? $_POST['idNegocio_N'] : null;
    $accion = isset($_POST['accion']) ? $_POST['accion'] : null;

    // Verifica que los parámetros necesarios estén presentes
    if ($idNegocio && ($accion == 'aprobar' || $accion == 'rechazar')) {
        // Validar la acción (1 para aprobado, 0 para rechazado)
        $estadoValidacion = ($accion == 'aprobar') ? 1 : 0;

        try {
            // Preparar la consulta
            $query = "UPDATE negocio SET validado = :validado WHERE IdNegocio_N = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':validado', $estadoValidacion, PDO::PARAM_INT);
            $stmt->bindParam(':id', $idNegocio, PDO::PARAM_INT);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                // Redirigir si la consulta es exitosa
                header("Location: ././validNeg.php?status=success");
                exit();
            } else {
                // Redirigir si la consulta falla
                header("Location: ././validNeg.php?status=success");
                exit();
            }
        } catch (PDOException $e) {
            // Capturar cualquier error de la base de datos
            header("Location: ././validNeg.php?status=error&message=" . urlencode($e->getMessage()));
            exit();
        }
    } else {
        // Si no se recibieron los datos correctamente
        header("Location: ././validNeg.php?status=success");
        exit();
    }
}
?>
