//-----------------------------------FUNCION PARA CAMBIAR DINAMICAMENTE LA SECCION SELECCIONADA-------------------------
verificar_sesion();
document.addEventListener('DOMContentLoaded', () => {
  
  // Seleccionar todos los items de la barra lateral
  const sidebarItems = document.querySelectorAll('.sidebar_item');

  // Seleccionar el contenedor donde se cargará el contenido
  const contentPlaceholder = document.getElementById('content-placeholder');

  // Asignar evento de clic a cada elemento del menú
  sidebarItems.forEach(item => {
    item.addEventListener('click', (e) => {
      // Verificar si el clic es en el logo (y evitar la carga de contenido)
      const isLogoClick = item.querySelector('.logo');
      if (isLogoClick) {
        e.preventDefault(); // Evitar la acción predeterminada del enlace
        return; // Detener la propagación del evento y no hacer nada
      }

      // Si no es un clic en el logo, continuar con la carga de la sección
      e.preventDefault(); // Prevenir el comportamiento por defecto del enlace

      // Obtener el archivo PHP a cargar desde el atributo data-section
      const section = item.getAttribute('data-section');

      // Realizar la solicitud AJAX
      fetch(`../../Views/admin/${section}`)
        .then(response => {
          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
          }
          return response.text();
        })
        .then(html => {
          // Insertar el contenido cargado en el placeholder
          contentPlaceholder.innerHTML = html;
        })
        .catch(error => {
          console.error('Error cargando la sección:', error);
          contentPlaceholder.innerHTML = `<p>Error al cargar la sección. Intenta nuevamente.</p>`;
        });
    });
  });
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
            <div class="faq-item"><br>
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
            <div class="faq-item"><br>
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
             <div class="faq-item"><br>
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
function handleSubmit(event) {
  event.preventDefault(); // Evitar envío tradicional del formulario

  const form = document.getElementById('loginForm');
  const formData = new FormData(form);

  // Añadir el parámetro 'funcion' para indicar que es un login
  formData.append('funcion', 'login');

  // Enviar los datos al UsuarioClienteController.php
  fetch('../Controllers/UsuarioClienteController.php', {
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
  
 //--------------------------------------FUNCION PARA MODAL VER PRODUCTO ------------------------------------------------
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


//---------------------------------------FUNCIÓN PARA AGREGAR PRODUCTO------------------------------------------------------
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

function verificar_sesion(){
  fetch('../Controllers/UsuarioClienteController.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: 'funcion=verificar_sesion'
})
.then(response => {
    console.log('Response:', response);  // Imprime la respuesta completa
    return response.json();  // Luego convierte la respuesta a JSON
})
.then(data => {
    console.log('Data:', data);  // Imprime los datos obtenidos después de la conversión
    if (data.id) {
        // Si hay sesión activa, ocultamos el enlace de "INICIAR SESIÓN"
        document.getElementById('login-link').style.display = 'none';
        console.log("Hay una sesion activa");
    }
    else{
        console.log("No hay una sesion activa");
    }
})
.catch(error => console.log('Error:', error));
}

  //FIN DE ESTA FUNCIÓN
