<div class="ayuda-container">
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4" style="color: #154360; font-size: 35px">PREGUNTAS FRECUENTES</h1><br><br><br>
        <div class="flex flex-wrap justify-center gap-6 mb-6">
            <div class="text-center w-32 md:w-40" onclick="showFAQ('pago')">
                <img src="../../Util/img/pago.png" alt="Método de Pago" class="w-16 h-16 mx-auto" />
                <p>Pagos</p>
            </div><br><br>

            <div class="text-center w-32 md:w-40" onclick="showFAQ('orden')">
                <img src="../../Util/img/orden.png" alt="Órdenes" class="w-16 h-16 mx-auto" />
                <p>Órdenes</p>
            </div><br><br>

            <div class="text-center w-32 md:w-40" onclick="showFAQ('producto')">
                <img src="../../Util/img/producto.png" alt="Productos" class="w-16 h-16 mx-auto" />
                <p>Productos</p>
            </div><br><br>

            <div class="text-center w-32 md:w-40" onclick="showFAQ('seguridad')">
                <img src="../../Util/img/seguridad.png" alt="Seguridad" class="w-16 h-16 mx-auto" />
                <p>Seguridad</p>
            </div><br><br>

        </div>

        <!-- Contenedor donde se mostrarán las preguntas frecuentes -->
        <div id="faqContent" class="border border-zinc-300 rounded-lg p-4 mb-4">
            <!-- Aquí se mostrarán las preguntas dinámicamente -->
        </div>
    </div>
</div>

<!-- Funciones comunes -->
<script src="../../js/funciones.js"></script>
