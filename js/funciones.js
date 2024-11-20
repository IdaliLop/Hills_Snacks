//FUNCION PARA VER LA PANTALLA SEGUN LA OPCIÓN
function showContent(sectionId) {
  // Ocultar todas las secciones
  const sections = document.querySelectorAll('.content_section');
  sections.forEach(section => {
    section.style.display = 'none';
  });

  // Mostrar la sección seleccionada
  const sectionToShow = document.getElementById(sectionId);
  if (sectionToShow) {
    sectionToShow.style.display = 'block';
  } else {
    console.error(`No se encontró la sección con id: ${sectionId}`);
  }
}

//FUNCION PARA MOSTRAR LAS PREGUNTAS
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
    } else if (section === 'cuentas') {
        content = `
             <div class="faq-item">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <h2>¿Cómo puedo dar de alta a un empleado?</h2>
                    <i class='bx bx-plus-circle'></i>
                </div>

                <div class="faq-answer">
                    <p>Para que puedas dar de alta a un empleado y pueda utilizar nuestra plataforma hemos diseñado una opción
                    llamada "Añadir empleado", la encontraras en tu menu de opciones.</p><br>
                    <p>Dentro de este apartado podras crear el perfil del empleado para que tenga acceso a realizar ciertas acciones 
                    para el necio.</p><br>
                </div>

                <div class="faq-question" onclick="toggleFAQ(this)">
                    <h2>¿Que puede hacer el empleado que registre?</h2>
                    <i class='bx bx-plus-circle'></i>
                </div>

                <div class="faq-answer">
                <p>El empleado que sea dado de alta en la plataforma podrá darle seguimiento a los pedidos que tenga el negocio.</p>
                <p>El empleado puede ver el estado de las solicitud de ordenes que tenga el negocio, y completar las solicitudes.</p>
                <p>El empleado puede vizualizar el catálogo de productos en donde solo para ver la descripcion de los mismo.</p><br>
                <p>Puede visualizar los combos, así como la descripción del combo.</p><br>
                </div>

                <div class="faq-question" onclick="toggleFAQ(this)">
                    <h2>¿Cómo gestiono las cuentas que registro?</h2>
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
}


//FUNCIONES OPCION ESTADO DE SOLICITUDES
//dunción para editar la fecha pendiente
document.querySelector('.icono-edit').addEventListener('click', function() {
    alert('Función para editar la fecha pendiente.');
  });
  //función para buscar
  document.querySelector('.icono-buscar').addEventListener('click', function() {
    const searchValue = document.querySelector('.input-texto').value;
    alert('Buscando: ' + searchValue);
  });
  
//FUNCION PARA MENSAJE DE ERROR LOGIN
    function handleSubmit(event) {
        event.preventDefault(); // Evitar que el formulario se envíe de forma tradicional

        const form = document.getElementById('loginForm');
        const formData = new FormData(form);

        fetch('../controller/LoginController.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json()) // Convertir la respuesta a JSON
        .then(data => {
            if (data.success) {
                window.location.href = data.redirectUrl; // Redirigir al URL proporcionado en la respuesta
            } else {
                alert(data.message); // Mostrar el mensaje de error si no fue exitoso
            }
        })
        .catch(error => {
            console.error('Error en la solicitud:', error);
            alert('Hubo un error al procesar el login.');
        });
    }


// FUNCION PARA MOSTRAR FORMULARIO DE AGREGAR EMPLEADO
function mostrarFormularioEmpleado() {
    const modal = document.getElementById("formulario-empleado-modal");
    modal.style.display = "flex"; // Mostramos el modal centrado
  }
  
  function ocultarFormularioEmpleado() {
    const modal = document.getElementById("formulario-empleado-modal");
    modal.style.display = "none"; // Ocultamos el modal
  }
  
  

//MODAL PARA VER LA INFORMACION DEL PRODUCTO
document.addEventListener('DOMContentLoaded', function () {
    const modalContainer = document.getElementById('modal-container');
    const closeModal = document.getElementById('close-modal');
    const lupaButtons = document.querySelectorAll('.bx-search-alt-2');
  
    // Agregar un evento de clic a cada botón de lupa
    lupaButtons.forEach(button => {
      button.addEventListener('click', function (event) {
        event.preventDefault();
        showProductModal();
      });
    });
  
    // Función para mostrar el modal
    function showProductModal() {
      modalContainer.style.display = 'block';
    }
  
    // Evento para cerrar el modal cuando se hace clic en la "X"
    closeModal.addEventListener('click', function() {
      modalContainer.style.display = 'none';
    });
  
    // Cerrar el modal si el usuario hace clic fuera del contenido del modal
    window.addEventListener('click', function (event) {
      if (event.target === modalContainer) {
        modalContainer.style.display = 'none';
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
  









