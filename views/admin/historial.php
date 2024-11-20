<div class="histoty-container">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Historial de Órdenes</h1>
        <div class="flex justify-between items-center mb-4">
            <div class="flex items-center">
                <label for="period" class="mr-2">Periodo:</label>
                <select id="period" class="border rounded p-1">
                    <option>Últimos 7 días</option>
                </select>
                <input type="text" placeholder="ID de la orden" class="border rounded p-1 ml-2" />
                <button class="btn-primary hover:bg-primary/80 ml-2">Descargar historial<i class='bx bx-download'></i></button>
            </div>
            <button class="btn-primary hover:bg-primary/80 ml-2">Buscar</button>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full border-collapse border border-zinc-300">
                <thead>
                    <tr class="bg-zinc-100">
                        <th class="border border-zinc-300 p-2">ID</th>
                        <th class="border border-zinc-300 p-2">Ciudad</th>
                        <th class="border border-zinc-300 p-2">Tienda</th>
                        <th class="border border-zinc-300 p-2">Fecha de creación</th>
                        <th class="border border-zinc-300 p-2">Fecha de entrega</th>
                        <th class="border border-zinc-300 p-2">Total</th>
                        <th class="border border-zinc-300 p-2">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-zinc-300 p-2">2292458915</td>
                        <td class="border border-zinc-300 p-2">Guadalajara</td>
                        <td class="border border-zinc-300 p-2">Los Parrales, El Rosario</td>
                        <td class="border border-zinc-300 p-2">30/09/2024 10:06 pm</td>
                        <td class="border border-zinc-300 p-2">30/09/2024 10:58 pm</td>
                        <td class="border border-zinc-300 p-2">$578.08</td>
                        <td class="border border-zinc-300 p-2">
                            <span class="bg-green-200 text-green-800 rounded px-2">Entregado</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="border border-zinc-300 p-2">2292454216</td>
                        <td class="border border-zinc-300 p-2">Guadalajara</td>
                        <td class="border border-zinc-300 p-2">Los Parrales, El Rosario</td>
                        <td class="border border-zinc-300 p-2">30/09/2024 09:43 pm</td>
                        <td class="border border-zinc-300 p-2">30/09/2024 10:29 pm</td>
                        <td class="border border-zinc-300 p-2">$444.92</td>
                        <td class="border border-zinc-300 p-2">
                            <span class="bg-red-200 text-red-800 rounded px-2">Cancelado</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="flex justify-between items-center mt-4">
            <div>
                <label for="rows-per-page" class="mr-2">Filas Por Página:</label>
                <select id="rows-per-page" class="border rounded p-1">
                    <option>10</option>
                </select>
            </div>
        </div>
    </div>
</div>