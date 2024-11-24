//-----------------------------------------FUNCION PARA CAMBIAR DINAMICAMENTE LA SECCION SELECCIONADA---------------------------------------
// Seleccionar todos los elementos del menú con data-section
const sidebarItems = document.querySelectorAll('.sidebar_item');

// Seleccionar el contenedor donde se cargará el contenido
const contentPlaceholder = document.getElementById('content-placeholder');

// Asignar evento de clic a cada elemento del menú
sidebarItems.forEach(item => {
  item.addEventListener('click', (e) => {
    e.preventDefault(); // Prevenir el comportamiento por defecto del enlace

    // Obtener el archivo PHP a cargar desde el atributo data-section
    const section = item.getAttribute('data-section');

    // Realizar la solicitud AJAX
    fetch(`../../views/admin/${section}`)
      .then(response => {
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.text();
      })
      .then(html => {
        // Insertar el contenido cargado en el placeholder
        contentPlaceholder.innerHTML = html;

        // Volver a enlazar eventos después de cargar contenido dinámico
        attachAddProductFunctionality();
      })
      .catch(error => {
        console.error('Error cargando la sección:', error);
        contentPlaceholder.innerHTML = `<p>Error al cargar la sección. Intenta nuevamente.</p>`;
      });
  });
});

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
  
      // Enviar los datos al backend usando fetch con método POST
      fetch('../../Controllers/addProduct.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())  // Respuesta en formato JSON
      .then(data => {
        console.log('Respuesta del servidor:', data);  // Verifica qué datos se reciben
        if (data.success) {
          alert("Producto agregado correctamente.");
          this.reset();  // Limpiar el formulario
          productForm.classList.add('hidden');
          controls.classList.remove('hidden');
          inventoryTable.style.display = 'table';
        } else {
          alert("Hubo un error al agregar el producto. Intenta nuevamente.");
        }
      })
      .catch(error => {
        console.error("Error enviando el formulario:", error);
        alert("Error al agregar el producto. Intenta nuevamente.");
      });
      
    });
  }
  
  

}

// Adjuntar la funcionalidad inicial para agregar producto
attachAddProductFunctionality();





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


//-------------------------------------------FUNCION PARA MOSTRAR LAS PREGUNTAS--------------------------------------------------------
function showFAQ(section) {
    const faqContent = document.getElementById('faqContent'); //bsca el id de la pregunta
    faqContent.innerHTML = ''; // Limpiar el contenido anterior

    // Generar contenido dinámico para cada sección
    let content = '';

    if (section === 'pago') {
        content = `
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <h2>¿Qué Métodos de pago tienen disponibles?</h2>
                    <i class='bx bx-plus-circle'></i>
                </div>
                <div class="faq-answer">
                    <p>Disponemos de pagos en línea y en efectivo.</p><br>
                    <p>Los pagos en línea se hacen por medio de la plataforma -------</p><br>
                </div>

                <div class="faq-question" onclick="toggleFAQ(this)">
                    <h2>¿Cómo gestiono los pagos en línea?</h2>
                    <i class='bx bx-plus-circle'></i>
                </div>
                <div class="faq-answer">
                    <p>Puedes gestionar los pagos desde el panel de administración.</p>
                </div>

                <div class="faq-question" onclick="toggleFAQ(this)">
                    <h2>¿Cómo recibo los pagos en línea y qué comisiones aplican?</h2>
                    <i class='bx bx-plus-circle'></i>
                </div>
                <div class="faq-answer">
                    <p>Los pagos se transfieren a tu cuenta bancaria y se aplican comisiones dependiendo la cantidad del pago.</p>
                </div>
            </div>

        `;
    } else if (section === 'orden') {
        content = `
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <h2>¿Cómo funciona las órdenes?</h2>
                    <i class='bx bx-plus-circle'></i>
                </div>

                <div class="faq-answer">
                <p>Las Ordenes que tienes por entregar puedes visualizarlas en la opcion de ordenes </p><br>
                <p></p><br>
                </div>

                <div class="faq-question" onclick="toggleFAQ(this)">
                    <h2>¿Cómo funciona las órdenes?</h2>
                    <i class='bx bx-plus-circle'></i>
                </div>

                <div class="faq-answer">
                <p>En la opción de ordenes se mostraran todas las ordenes que tienes en curso,
                tu podras modificar el proceso de la orden dependiendo como se esta realizando este </p><br>
                </div>

            </div>
        `;
    } else if (section === 'producto') {
        content = `
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <h2>¿Cómo funcionan mis productos?</h2>
                    <i class='bx bx-plus-circle'></i>
                </div>

                <div class="faq-answer">
                    <p>En la opción de cátalogo de productos podras visualizar cuales son los productos que tienes agregados en nuestra aplicación,
                    asi como los detalles del producto.</p><br>

                    <p>En el apartdado de "Inventario de productos" es en donde podras dar de alta tus productos en nuestra aplicación, asi mismo darás 
                    las descripciones del producto, el precio, podras editar el producto si ya está creado y habilitar o deshabilitar el producto en la plataforma.</p><br>
                
                </div>

            </div>

        `;
    } else if (section === 'seguridad') {
        content = `
             <div class="faq-item">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <h2>¿Cómo protegen mis datos?</h2>
                    <i class='bx bx-plus-circle'></i>
                </div>

                <div class="faq-answer">
                <p>Las Ordenes que tienes por entregar puedes visualizarlas en la opcion de ordenes </p><br>
                <p></p><br>
                </div>
            </div>

        `;
    }

    // Insertar el contenido en faqContent
    faqContent.innerHTML = content;
}
//FIN DE ESTA FUNCIÓN


// Función para mostrar/ocultar preguntas
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


//FUNCIONES OPCION ESTADO DE SOLICITUDES
document.querySelector('.icono-edit').addEventListener('click', function() {
    alert('Función para editar la fecha pendiente.');
  });
  //función para buscar
  document.querySelector('.icono-buscar').addEventListener('click', function() {
    const searchValue = document.querySelector('.input-texto').value;
    alert('Buscando: ' + searchValue);
  });
//FIN DE ESTA FUNCIÓN
  
// FUNCION PARA MENSAJE DE ERROR LOGIN
function handleSubmit(event) {
    event.preventDefault(); // Evitar envío tradicional del formulario

    const form = document.getElementById('loginForm');
    const formData = new FormData(form);

    fetch('../Controllers/LoginController.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            // Manejar errores HTTP
            throw new Error(`Error HTTP: ${response.status}`);
        }
        return response.json(); // Convertir la respuesta a JSON
    })
    .then(data => {
        console.log("Respuesta del servidor:", data); // Log de la respuesta
        if (data.success) {
            // Redirigir al URL proporcionado en la respuesta
            window.location.href = data.redirectUrl;
        } else {
            // Mostrar mensaje de error específico del servidor
            displayErrorMessage(data.message);
        }
    })
    .catch(error => {
        console.error('Error en la solicitud:', error);
        displayErrorMessage('Hubo un error inesperado al procesar el login. Inténtalo nuevamente.');
    });
}

// Mostrar mensajes de error en el DOM
function displayErrorMessage(message) {
    const errorContainer = document.getElementById('errorMessage');
    if (errorContainer) {
        errorContainer.textContent = message;
        errorContainer.style.display = 'block';
    } else {
        alert(message); // Como respaldo, usar un alert si no hay contenedor para errores
    }
}
//FIN DE ESTA FUNCIÓN
  
 //FUNCION PARA MODAL VER PRODUCTO 
// Espera a que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', function () {
  // Función para mostrar el modal con datos dinámicos
  function showModal(name, id, ean, sku, brand) {
    const modal = document.getElementById('modal-container');
    document.getElementById('product-name').textContent = name;
    document.getElementById('product-id').textContent = id;
    document.getElementById('product-ean').textContent = ean;
    document.getElementById('product-sku').textContent = sku;
    document.getElementById('product-brand').textContent = brand;
    modal.style.display = 'flex'; // Muestra el modal
  }

  // Cerrar modal al hacer clic en el ícono de la "X"
  const closeModalButton = document.getElementById('close-modal');
  closeModalButton.addEventListener('click', function (event) {
    console.log('Botón de cierre clickeado'); // Depuración
    event.stopPropagation(); // Evita que el clic se propague
    document.getElementById('modal-container').style.display = 'none'; // Cierra el modal
  });

  // Cerrar modal al hacer clic fuera del contenido
  const modalContainer = document.getElementById('modal-container');
  modalContainer.addEventListener('click', function (event) {
    if (event.target === modalContainer) {
      console.log('Clic fuera del modal'); // Depuración
      modalContainer.style.display = 'none';
    }
  });

  // Cerrar el modal con la tecla "Escape"
  document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') {
      console.log('Tecla Escape presionada'); // Depuración
      document.getElementById('modal-container').style.display = 'none';
    }
  });
});




  

//Obtener el ícono del menú y el sidebar y hacer mas chico
// Obtener el ícono de menú y el sidebar
const menuToggle = document.getElementById('menu-toggle');
const sidebar = document.getElementById('sidebar');

// Añadir el evento de clic al ícono
menuToggle.addEventListener('click', () => {
    // Alternar la clase 'active' en el sidebar
    sidebar.classList.toggle('active');
    
    // Alternar el estado del icono
    if (sidebar.classList.contains('active')) {
        // Cuando el sidebar está abierto, cambiar el ícono de hamburguesa
        menuToggle.innerHTML = '<i class="bx bx-menu"></i>'; // Ícono de 'X' para cerrar
    } else {
        // Cuando el sidebar está cerrado, mostrar el ícono de hamburguesa nuevamente
        menuToggle.innerHTML = '<i class="bx bx-menu"></i>'; // Ícono de hamburguesa
    }
});

  
//FUNCION PARA CAMBIAR DATOS
function habilitarEdicion() {
    const inputs = document.querySelectorAll("#info-form input");
    inputs.forEach(input => {
      input.readOnly = false;
      input.style.backgroundColor = "#fff";
    });
  
    document.querySelector(".btn-cambio").style.display = "none";
    document.querySelector(".btn-guardar").style.display = "block";
  }
  
  document.querySelector("#info-form").addEventListener("submit", function (e) {
    e.preventDefault();
    const inputs = document.querySelectorAll("#info-form input");
    inputs.forEach(input => {
      input.readOnly = true;
      input.style.backgroundColor = "#e9ecef";
    });
  
    document.querySelector(".btn-cambio").style.display = "block";
    document.querySelector(".btn-guardar").style.display = "none";
  
    document.querySelector("#mensaje").style.display = "block";
    setTimeout(() => {
      document.querySelector("#mensaje").style.display = "none";
    }, 3000);
  });
//FIN DE ESTA FUNCIÓN



document.addEventListener('DOMContentLoaded', () => {
  // Seleccionamos los elementos necesarios
  const openFormBtn = document.querySelector('#openFormBtn');
  const productModal = document.querySelector('#productModal');
  const closeModalBtn = document.querySelector('#closeModalBtn');

  // Validamos que los elementos existan
  if (openFormBtn && productModal && closeModalBtn) {
    // Abrir modal
    openFormBtn.addEventListener('click', () => {
      console.log('Abrir modal presionado');
      productModal.classList.remove('hidden');
    });

    // Cerrar modal al hacer clic en el botón de cerrar
    closeModalBtn.addEventListener('click', () => {
      console.log('Cerrar modal presionado');
      productModal.classList.add('hidden');
    });

    // Cerrar modal al hacer clic fuera del contenido
    window.addEventListener('click', (e) => {
      if (e.target === productModal) {
        console.log('Clic fuera del modal, cerrando');
        productModal.classList.add('hidden');
      }
    });
  } else {
    console.error('No se encontraron algunos elementos necesarios para el modal.');
  }
});

  //FIN DE ESTA FUNCIÓN
  

  








