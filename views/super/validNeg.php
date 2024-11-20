<?php
// Supongamos que ya tienes una conexión a la base de datos establecida
require_once '../../config/database.php';

$database = new Database();
$db = $database->getConnection();

// Consulta de negocios pendientes de validación
$query = "SELECT IdNegocio_N, Nombre_N, Direccion_N, Tipo_N, Telefono_N, imagen_N FROM negocio WHERE validado = 0";
$stmt = $db->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Validación de Negocios</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        img {
            width: 100px;
            height: auto;
        }
        button {
            padding: 8px 16px;
            margin: 4px;
        }
    </style>
</head>
<body>
    <h1>Negocios Pendientes de Validación</h1>

    <?php
    // Mostrar el mensaje de estado si está presente
    if (isset($_GET['status'])) {
        $status = $_GET['status'];
        if ($status == 'success') {
            echo "<p>Operación realizada con éxito.</p>";
        } elseif ($status == 'error') {
            echo "<p>Hubo un error en la operación.";
            if (isset($_GET['message'])) {
                echo " Detalle del error: " . htmlspecialchars($_GET['message']);
            }
            echo "</p>";
        } elseif ($status == 'invalid') {
            echo "<p>Datos inválidos recibidos.</p>";
        }
    }
    ?>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Tipo</th>
                <th>Teléfono</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($negocio = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><?php echo htmlspecialchars($negocio['Nombre_N']); ?></td>
                <td><?php echo htmlspecialchars($negocio['Direccion_N']); ?></td>
                <td><?php echo htmlspecialchars($negocio['Tipo_N']); ?></td>
                <td><?php echo htmlspecialchars($negocio['Telefono_N']); ?></td>
                
                <td>
                    <?php if (!empty($negocio['imagen_N'])): ?>
                        <img src="<?php echo htmlspecialchars($negocio['imagen_N']); ?>" alt="Imagen del negocio">
                    <?php else: ?>
                        No hay imagen disponible
                    <?php endif; ?>
                </td>
                <td>
                <form method="POST" action="/snacks/controller/aprobarNeg.php">
                        <input type="hidden" name="idNegocio_N" value="<?php echo $negocio['IdNegocio_N']; ?>">
                        <button type="submit" name="accion" value="aprobar">Aprobar</button>
                        <button type="submit" name="accion" value="rechazar">Rechazar</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
