//------------------------------------------FUNCION PARA CAMBIAR DINAMICAMENTE LA SECCION--------------------------------------------

// Seleccionar todos los elementos del menú con data-section
function setupSidebarNavigation(sidebarSelector, contentPlaceholderId, basePath, callback) {
  const sidebarItems = document.querySelectorAll(sidebarSelector);
  const contentPlaceholder = document.getElementById(contentPlaceholderId);

  if (!sidebarItems || !contentPlaceholder) {
    console.error('Elementos de navegación o contenedor no encontrados.');
    return;
  }

  // Asignar eventos a los elementos de la barra lateral
  sidebarItems.forEach(item => {
    item.addEventListener('click', (e) => {
      // Obtener el archivo PHP a cargar desde el atributo data-section
      const section = item.getAttribute('data-section');
      if (!section) {
        // Elementos sin sección (como "Salir") siguen su enlace normal
        return;
      }

      e.preventDefault(); // Prevenir el comportamiento por defecto del enlace solo si se carga una sección

      // Realizar la solicitud AJAX
      fetch(`${basePath}/${section}`)
        .then(response => {
          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
          }
          return response.text();
        })
        .then(html => {
          // Insertar el contenido cargado en el placeholder
          contentPlaceholder.innerHTML = html;

          // Ejecutar el callback si se proporciona
          if (typeof callback === 'function') {
            callback();
          }
        })
        .catch(error => {
          console.error('Error cargando la sección:', error);
          contentPlaceholder.innerHTML = `<p>Error al cargar la sección. Intenta nuevamente.</p>`;
        });
    });
  });
}

// Uso de la función
setupSidebarNavigation(
  '.sidebar_item', // Selector de elementos del menú
  'content-placeholder', // ID del contenedor para el contenido dinámico
  '../../Views/admin', // Ruta base para los archivos PHP
  attachAddProductFunctionality // Callback para enlazar eventos dinámicos
);


//--------------------------FUNCION PARA MANEJAR AGREGAR PRODUCTO Y CAMBIO ENTRE FORMULARIO, CONTROLES Y TABLA---------------------------------------
function attachAddProductFunctionality() {
  const openFormBtn = document.getElementById('openFormBtn');
  const productForm = document.getElementById('productForm');
  const inventoryTable = document.querySelector('.inventory-table');
  const controls = document.querySelector('.controls');
  const cancelFormBtn = document.getElementById('cancelFormBtn');

  if (openFormBtn && productForm && inventoryTable && controls) {
    // Mostrar formulario y ocultar tabla y controles
    openFormBtn.addEventListener('click', () => {
      prepararFormularioProducto(null);  // modo "agregar"
      productForm.classList.remove('hidden');
      controls.classList.add('hidden');
      inventoryTable.style.display = 'none';
    });

    // Ocultar formulario y volver a mostrar tabla y controles
    if (cancelFormBtn) {
      cancelFormBtn.addEventListener('click', () => {
        productForm.classList.add('hidden');
        controls.classList.remove('hidden');
        inventoryTable.style.display = 'table';
      });
    }
  }

  // Manejar el envío del formulario
  const addProductForm = document.getElementById('addProductForm');
  if (addProductForm) {
    addProductForm.addEventListener('submit', function (event) {
      event.preventDefault();  // Prevenir el comportamiento por defecto del formulario
  
      const formData = new FormData(this);  // Crear un FormData con los datos del formulario
      const editando = document.getElementById('productId').value !== '';
      formData.append('funcion', editando ? 'editar' : 'crear');
  
      // Enviar los datos al backend usando fetch con método POST
      fetch('../../Controllers/ProductoAdminController.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())  // Respuesta en formato JSON
      .then(data => {
        console.log('Respuesta del servidor:', data);  // Verifica qué datos se reciben
        if (data.success) {
          alert(editando ? "Producto actualizado correctamente." : "Producto agregado correctamente.");
          recargarSeccion('inventario.php');  // vuelve a cargar la tabla para que aparezca el producto nuevo
        } else {
          alert(data.error || "Hubo un error al agregar el producto. Intenta nuevamente.");
        }
      })
      .catch(error => {
        console.error("Error enviando el formulario:", error);
        alert("Error al agregar el producto. Intenta nuevamente.");
      });
      
    });
  }
  
}

// Prepara el formulario del inventario: sin fila = agregar producto nuevo; con fila = editar ese producto
function prepararFormularioProducto(fila) {
  const formulario = document.getElementById('addProductForm');
  if (!formulario) return;
  formulario.reset();
  const imagen = document.getElementById('productImage');
  document.getElementById('productId').value = fila ? fila.dataset.id : '';
  document.getElementById('tituloFormProducto').textContent = fila ? 'Editar Producto' : 'Agregar Producto';
  document.getElementById('etiquetaImagen').textContent = fila ? 'Cambiar imagen (opcional):' : 'Subir Imagen:';
  imagen.required = !fila;
  if (fila) {
    document.getElementById('negocio').value = fila.dataset.negocio;
    document.getElementById('productName').value = fila.dataset.nombre;
    document.getElementById('productPrice').value = fila.dataset.precio;
    document.getElementById('productDis').value = fila.dataset.disp;
  }
}

// Botón del lápiz en el inventario: abre el formulario con los datos del producto
function editarProducto(fila) {
  prepararFormularioProducto(fila);
  document.getElementById('productForm').classList.remove('hidden');
  document.querySelector('.controls').classList.add('hidden');
  document.querySelector('.inventory-table').style.display = 'none';
}

// Adjuntar la funcionalidad inicial para agregar producto
attachAddProductFunctionality();

//------------------------------------ FUNCION MODAL CATALOGO DE PRODUCTO ---------------------------------------------------
// Función para mostrar el modal con los detalles del producto
function showModal(productName, productId, productPrecio, productDisponibilidad, productImagen) {
  // Llenar los campos del modal con los datos del producto
  document.getElementById('product-name').textContent = productName;
  document.getElementById('product-id').textContent = productId;
  document.getElementById('product-precio').textContent = productPrecio;
  document.getElementById('product-availability').textContent = productDisponibilidad;
  document.getElementById('product-image').src = productImagen;

  // Mostrar el modal
  document.getElementById('modal-container').style.display = 'flex'; // Cambiar a 'flex' para centrarlo
}

// Función para cerrar el modal
document.querySelectorAll('.close-btn').forEach(button => {
  button.addEventListener('click', function() {
    document.getElementById('modal-container').style.display = 'none';
  });
});

// También cerramos el modal cuando se haga clic fuera del contenido del modal
window.addEventListener('click', function(event) {
  if (event.target === document.getElementById('modal-container')) {
    document.getElementById('modal-container').style.display = 'none';
  }
});









  /* FUNCION PARA BOTONES DE BUSCAR Y DESCARGAS
  document.querySelector('.btn-primary').addEventListener('click', () => {
    const id = document.querySelector('input[placeholder="ID de la orden"]').value;
    if (id) {
        window.location.href = `descargar_historial.php?id=${id}`;
    } else {
        alert('Por favor ingresa un ID válido.');
    }
});*/
//FIN DE ESTA FUNCIÓN


//------------------------------------------- FUNCIONES DEL PANEL: INVENTARIO, PEDIDOS E HISTORIAL -------------------------------
// Vuelve a cargar una sección del panel (por ejemplo después de guardar un producto)
function recargarSeccion(seccion) {
  fetch('../../Views/admin/' + seccion)
    .then(response => response.text())
    .then(html => {
      document.getElementById('content-placeholder').innerHTML = html;
      attachAddProductFunctionality();
    });
}

// Inventario: guarda en la BD el cambio Activo / Inactivo de un producto
function cambiarDisponibilidad(idProducto, select) {
  const datos = new FormData();
  datos.append('funcion', 'disponibilidad');
  datos.append('id', idProducto);
  datos.append('disponibilidad', select.value);

  fetch('../../Controllers/ProductoAdminController.php', { method: 'POST', body: datos })
    .then(response => response.json())
    .then(data => {
      if (!data.success) {
        alert(data.error || 'No se pudo cambiar la disponibilidad.');
        recargarSeccion('inventario.php');
        return;
      }
      select.closest('tr').dataset.estado = select.value;
      filtrarInventario();
    })
    .catch(() => alert('No se pudo conectar con el servidor.'));
}

// Inventario: filtra por estado y por texto de búsqueda
function filtrarInventario() {
  const estado = document.getElementById('statusDropdown').value;
  const texto = document.getElementById('searchBox').value.trim().toLowerCase();
  document.querySelectorAll('.fila-producto').forEach(fila => {
    const coincideEstado = !estado || fila.dataset.estado === estado;
    const coincideTexto = !texto || fila.dataset.texto.includes(texto);
    fila.style.display = (coincideEstado && coincideTexto) ? '' : 'none';
  });
}

// Pedidos: filtra la lista por estado
function filtrarPedidos(estado) {
  document.querySelectorAll('.fila-pedido').forEach(fila => {
    fila.style.display = (!estado || fila.dataset.estado === estado) ? '' : 'none';
  });
}

// Pedidos: marca un pedido como Completado o Cancelado y recarga la lista
function cambiarEstadoPedido(idPedido, estado) {
  const accion = estado === 'Completado' ? 'marcar como entregado' : 'cancelar';
  if (!confirm('¿Seguro que quieres ' + accion + ' el pedido #' + idPedido + '?')) return;

  const datos = new FormData();
  datos.append('funcion', 'estado');
  datos.append('id', idPedido);
  datos.append('estado', estado);

  fetch('../../Controllers/PedidoController.php', { method: 'POST', body: datos })
    .then(response => response.json())
    .then(data => {
      if (data.ok) {
        recargarSeccion('pedidos.php');
      } else {
        alert(data.error || 'No se pudo actualizar el pedido.');
      }
    })
    .catch(() => alert('No se pudo conectar con el servidor.'));
}

// Historial: filtra por ID de orden y por periodo
function filtrarHistorial() {
  const id = document.getElementById('buscar-orden').value.trim();
  const dias = parseInt(document.getElementById('period').value, 10);
  const limite = dias > 0 ? (Date.now() / 1000) - dias * 86400 : 0;
  document.querySelectorAll('.fila-historial').forEach(fila => {
    const coincideId = !id || fila.dataset.id.includes(id);
    const coincidePeriodo = !limite || parseInt(fila.dataset.ts, 10) >= limite;
    fila.style.display = (coincideId && coincidePeriodo) ? '' : 'none';
  });
}

// Historial: descarga en CSV las filas que se están viendo
function descargarHistorial() {
  const lineas = [['ID', 'Negocio', 'Fecha de creacion', 'Fecha de entrega', 'Total', 'Estado']];
  document.querySelectorAll('.fila-historial').forEach(fila => {
    if (fila.style.display === 'none') return;
    lineas.push(Array.from(fila.cells).map(celda => celda.innerText.trim()));
  });
  const csv = lineas.map(l => l.map(v => '"' + v.replace(/"/g, '""') + '"').join(',')).join('\r\n');
  const enlace = document.createElement('a');
  enlace.href = URL.createObjectURL(new Blob(['\ufeff' + csv], { type: 'text/csv;charset=utf-8;' }));
  enlace.download = 'historial_ordenes.csv';
  enlace.click();
  URL.revokeObjectURL(enlace.href);
}

//-------------------------------------------FUNCION PARA MOSTRAR LAS PREGUNTAS---------------------------------------------
function showFAQ(section) {
    const faqContent = document.getElementById('faqContent'); //bsca el id de la pregunta
    faqContent.innerHTML = ''; // Limpiar el contenido anterior

    // Generar contenido dinámico para cada sección
    let content = '';

    if (section === 'pago') {
        content = `
            <div class="faq-item"><br>
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <h2>¿Qué Métodos de pago tienen disponibles?</h2>
                    <i class='bx bx-plus-circle'></i>
                </div>
                <div class="faq-answer">
                    <p>Disponemos de pagos en línea y en efectivo.</p><br>
                    <p>Los pagos en línea se hacen por medio de la plataforma de PayPal.</p><br>
                    <p>Los pagos en efectivo se realizan al momento de recibir tu pedido.</p><br>
                </div>


        `;
    } else if (section === 'orden') {
        content = `
            <div class="faq-item"><br>
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <h2>¿Cómo funciona los Pedidos?</h2>
                    <i class='bx bx-plus-circle'></i>
                </div>

                <div class="faq-answer">
                <p>Los pedidos que tienes por entregar puedes visualizarlas en la opcion de pedidos </p><br>
                <p>En la opción de pedidos podras visualizar las entregas que tienes pendientes</p><br>
                </div>

            </div>
        `;
    } else if (section === 'producto') {
        content = `
            <div class="faq-item"><br>
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <h2>¿Cómo funcionan mis productos?</h2>
                    <i class='bx bx-plus-circle'></i>
                </div>

                <div class="faq-answer">
                    <p>En la opción de cátalogo de productos podras visualizar cuales son los productos que tienes agregados en nuestra aplicación,
                    asi como los detalles del producto.</p><br>

                    <p>En el inventario de productos podras visualizar tambien de manera rápida una tabla con todos los productos de tu negocio</p><br>

                    <p>En el apartdado de "Inventario de productos" es en donde podras dar de alta tus productos en nuestra aplicación, asi mismo darás 
                    las descripciones del producto, el precio, podrás editar el producto si ya está creado y habilitar o deshabilitar el producto en la plataforma.</p><br>
                
                </div>

            </div>

        `;
    } else if (section === 'seguridad') {
        content = `
             <div class="faq-item"><br>
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <h2>¿Cómo protegen mis datos?</h2>
                    <i class='bx bx-plus-circle'></i>
                </div>

                <div class="faq-answer">
                <p>Tus datos estan protegidos en nuestra plataforma, ya que contamos con las medidas de seguridad necesarias
                ante ataques maliciosos.</p><br>
                <p></p><br>
                </div>
            </div>

        `;
    }

    // Insertar el contenido en faqContent
    faqContent.innerHTML = content;
}
//FIN DE ESTA FUNCIÓN

//--------------------------------------------- Función para mostrar/ocultar preguntas-------------------------------------
function toggleFAQ(element) {
    const answer = element.nextElementSibling;
    const icon = element.querySelector('i');

    if (answer.style.display === "none") {
        answer.style.display = "block";
        icon.classList.remove('bx-plus-circle');
        icon.classList.add('bx-minus-circle');
    } else {
        answer.style.display = "none";
        icon.classList.remove('bx-minus-circle');
        icon.classList.add('bx-plus-circle');
    }
}//FIN DE ESTA FUNCIÓN


  
//---------------------------------- FUNCION PARA MENSAJE DE ERROR LOGIN-------------------------------------------------

 
//--------------------------------------------FUNCIÓN PARA OCULAR EL NAV DE ADMIN--------------------------------------------
// Selección de elementos necesarios
const menuToggle = document.querySelector('.menu-toggle'); // Ícono del menú
const sidebarNav = document.querySelector('.sidebar_nav'); // Sidebar

// Evento para alternar el menú en móviles
menuToggle.addEventListener('click', () => {
    sidebarNav.classList.toggle('active'); // Activa/desactiva la clase 'active'
});

// Evento para cerrar el sidebar si se hace clic fuera de él
document.addEventListener('click', (e) => {
    if (!sidebarNav.contains(e.target) && !menuToggle.contains(e.target)) {
        sidebarNav.classList.remove('active'); // Oculta el sidebar
    }
});



  
//-----------------------------FUNCION PARA CAMBIAR DATOS---------------------------------------------------------
function habilitarEdicion() {
    const inputs = document.querySelectorAll("#info-form input");
    inputs.forEach(input => {
      input.readOnly = false;
      input.style.backgroundColor = "#fff";
    });
  
    document.querySelector(".btn-cambio").style.display = "none";
    document.querySelector(".btn-guardar").style.display = "block";
  }
  
  // El formulario de "Mi cuenta" se carga después con fetch, por eso se escucha el evento en todo el documento
  document.addEventListener("submit", function (e) {
    if (e.target.id !== "info-form") return;
    e.preventDefault();
    const formulario = e.target;
    const mensaje = document.querySelector("#mensaje");
    const error = document.querySelector("#mensaje-error");
    mensaje.style.display = "none";
    error.style.display = "none";

    fetch('../../Controllers/CuentaController.php', { method: 'POST', body: new FormData(formulario) })
      .then(response => response.json())
      .then(data => {
        if (!data.ok) {
          error.textContent = data.error || "No se pudieron guardar los cambios.";
          error.style.display = "block";
          return;
        }
        formulario.querySelectorAll("input").forEach(input => {
          input.readOnly = true;
          input.style.backgroundColor = "#e9ecef";
        });
        document.querySelector("#contrasena").value = "";
        document.querySelector(".btn-cambio").style.display = "block";
        document.querySelector(".btn-guardar").style.display = "none";
        mensaje.style.display = "block";
        setTimeout(() => { mensaje.style.display = "none"; }, 3000);
      })
      .catch(() => {
        error.textContent = "No se pudo conectar con el servidor.";
        error.style.display = "block";
      });
  });
//FIN DE ESTA FUNCIÓN



//--------------------------------------- FUNCION PARA SESIONES-------------------------------------------------------------


  //FIN DE ESTA FUNCIÓN
//------------------------------------------------FUNCIÓN PARA CERRAR SESIÓN------------------------------------------------------

