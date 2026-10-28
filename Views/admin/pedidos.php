<?php
require_once __DIR__ . '/../../config/helpers.php';
exigirAdminParcial();
require_once __DIR__ . '/../../config/database.php';

$db = (new Database())->getConnection();

// Pedidos más recientes primero, con el nombre del negocio
$pedidos = [];
$consulta = "SELECT p.IdPedido, p.Nombre_Cliente, p.Telefono_Cliente, p.Direccion_Entrega, p.Total,
                    p.Metodo_Pago, p.Estado, p.Fecha_Creacion, n.Nombre_N
             FROM pedido p
             JOIN negocio n ON n.IdNegocio_N = p.IdNegocio_N
             ORDER BY p.Fecha_Creacion DESC, p.IdPedido DESC
             LIMIT 100";
if ($resultado = $db->query($consulta)) {
    $pedidos = $resultado->fetchAll(PDO::FETCH_ASSOC);
}

// Productos de cada pedido (una sola consulta y se agrupan aquí)
$detalles = [];
if (!empty($pedidos)) {
    $ids = array_map('intval', array_column($pedidos, 'IdPedido'));
    $consulta = "SELECT IdPedido, Nombre_P, Cantidad FROM pedido_detalle WHERE IdPedido IN (" . implode(',', $ids) . ") ORDER BY IdDetalle";
    foreach ($db->query($consulta)->fetchAll(PDO::FETCH_ASSOC) as $fila) {
        $detalles[$fila['IdPedido']][] = $fila;
    }
}

$clasesEstado = ['Pendiente' => 'bg-yellow-200', 'Completado' => 'bg-green-200', 'Cancelado' => 'bg-red-200'];
?>
<!-- OPCIÓN PARA VER LOS PEDIDOS -->
<div class="pedidos-header">
    <h1 class="pedidos-title" style="color: #154360; font-size: 35px">Pedidos Recientes</h1>
    <div class="pedidos-filtros">
        <div class="filtros-opciones">
            <select class="select-filtro" onchange="filtrarPedidos(this.value)">
                <option value="">Todos los estados</option>
                <option value="Pendiente">Pendiente</option>
                <option value="Completado">Completado</option>
                <option value="Cancelado">Cancelado</option>
            </select>
        </div>
    </div>
</div>
<h2 class="pedidos-subtitulo">Lista de Pedidos</h2>

<?php if (empty($pedidos)): ?>
<div class="pedidos-contenido">
    <img src="../../Util/img/reloj.png" class="pedidos-imagen" alt="Reloj de espera" />
    <h3 class="pedidos-aviso">No tienes pedidos recientes</h3>
    <p class="pedidos-mensaje">Cuando hagan un pedido, aquí podrás darle seguimiento.</p>
</div>
<?php else: ?>
<div class="overflow-x-auto">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Fecha</th>
                <th>Negocio</th>
                <th>Cliente</th>
                <th>Entrega</th>
                <th>Productos</th>
                <th>Total</th>
                <th>Pago</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pedidos as $pedido): ?>
            <tr class="fila-pedido" data-estado="<?= e($pedido['Estado']) ?>">
                <td><?= (int) $pedido['IdPedido'] ?></td>
                <td><?= e(fechaLegible($pedido['Fecha_Creacion'])) ?></td>
                <td><?= e($pedido['Nombre_N']) ?></td>
                <td><?= e($pedido['Nombre_Cliente']) ?><br><small><?= e($pedido['Telefono_Cliente']) ?></small></td>
                <td><?= e($pedido['Direccion_Entrega']) ?></td>
                <td>
                    <ul class="pedido-productos">
                        <?php foreach ($detalles[$pedido['IdPedido']] ?? [] as $linea): ?>
                            <li><?= (int) $linea['Cantidad'] ?> × <?= e($linea['Nombre_P']) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </td>
                <td>$<?= e(number_format((float) $pedido['Total'], 2)) ?></td>
                <td><?= e($pedido['Metodo_Pago']) ?></td>
                <td><span class="<?= e($clasesEstado[$pedido['Estado']] ?? 'bg-yellow-200') ?>"><?= e($pedido['Estado']) ?></span></td>
                <td class="pedido-acciones">
                    <?php if ($pedido['Estado'] === 'Pendiente'): ?>
                        <button class="btn-entregado" onclick="cambiarEstadoPedido(<?= (int) $pedido['IdPedido'] ?>, 'Completado')">Entregado</button>
                        <button class="btn-cancelar" onclick="cambiarEstadoPedido(<?= (int) $pedido['IdPedido'] ?>, 'Cancelado')">Cancelar</button>
                    <?php else: ?>
                        —
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
