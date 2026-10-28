<?php
require_once __DIR__ . '/../../config/helpers.php';
exigirAdminParcial();
require_once __DIR__ . '/../../config/database.php';

$db = (new Database())->getConnection();

// Historial: todas las órdenes, de la más reciente a la más antigua
$ordenes = [];
$consulta = "SELECT p.IdPedido, p.Total, p.Estado, p.Fecha_Creacion, p.Fecha_Entrega, p.Metodo_Pago, n.Nombre_N
             FROM pedido p
             JOIN negocio n ON n.IdNegocio_N = p.IdNegocio_N
             ORDER BY p.Fecha_Creacion DESC, p.IdPedido DESC
             LIMIT 500";
if ($resultado = $db->query($consulta)) {
    $ordenes = $resultado->fetchAll(PDO::FETCH_ASSOC);
}

$clasesEstado = ['Pendiente' => 'bg-yellow-200', 'Completado' => 'bg-green-200', 'Cancelado' => 'bg-red-200'];
$textoEstado = ['Pendiente' => 'Pendiente', 'Completado' => 'Entregado', 'Cancelado' => 'Cancelado'];
?>
<div class="histoty-container">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4" style="color: #154360; font-size: 35px">Historial de Órdenes</h1>
        <div class="flex justify-between items-center mb-4">
            <div class="flex items-center">
                <label for="period" class="mr-2">Periodo:</label>
                <select id="period" class="border rounded p-1" onchange="filtrarHistorial()">
                    <option value="0">Todo</option>
                    <option value="7">Últimos 7 días</option>
                    <option value="30">Últimos 30 días</option>
                </select>
                <input type="text" id="buscar-orden" placeholder="ID de la orden" class="border rounded p-1 ml-2" oninput="filtrarHistorial()" />
                <button class="btn-primary hover:bg-primary/80 ml-2" onclick="descargarHistorial()">Descargar historial<i class='bx bx-download'></i></button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table id="tabla-historial" class="min-w-full border-collapse border border-zinc-300">
                <thead>
                    <tr class="bg-zinc-100">
                        <th class="border border-zinc-300 p-2">ID</th>
                        <th class="border border-zinc-300 p-2">Negocio</th>
                        <th class="border border-zinc-300 p-2">Fecha de creación</th>
                        <th class="border border-zinc-300 p-2">Fecha de entrega</th>
                        <th class="border border-zinc-300 p-2">Total</th>
                        <th class="border border-zinc-300 p-2">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($ordenes)): ?>
                        <tr><td colspan="6" class="admin-vacio">Todavía no hay órdenes.</td></tr>
                    <?php endif; ?>
                    <?php foreach ($ordenes as $orden): ?>
                    <tr class="fila-historial"
                        data-id="<?= (int) $orden['IdPedido'] ?>"
                        data-ts="<?= (int) strtotime($orden['Fecha_Creacion']) ?>">
                        <td class="border border-zinc-300 p-2"><?= (int) $orden['IdPedido'] ?></td>
                        <td class="border border-zinc-300 p-2"><?= e($orden['Nombre_N']) ?></td>
                        <td class="border border-zinc-300 p-2"><?= e(fechaLegible($orden['Fecha_Creacion'])) ?></td>
                        <td class="border border-zinc-300 p-2"><?= e(fechaLegible($orden['Fecha_Entrega'])) ?></td>
                        <td class="border border-zinc-300 p-2">$<?= e(number_format((float) $orden['Total'], 2)) ?></td>
                        <td class="border border-zinc-300 p-2">
                            <span class="<?= e($clasesEstado[$orden['Estado']] ?? 'bg-yellow-200') ?>"><?= e($textoEstado[$orden['Estado']] ?? $orden['Estado']) ?></span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
