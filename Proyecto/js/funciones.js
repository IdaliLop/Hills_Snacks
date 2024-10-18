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
  
//FUNCION PARA MENSAJE DE ERROR 
async function handleSubmit(event) {
    event.preventDefault(); // Evita el envío del formulario

    const form = document.getElementById('loginForm');
    const formData = new FormData(form);

    try {
        const response = await fetch(form.action, {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (result.success) {
            // Si el login es exitoso, redirigir a la página correspondiente
            window.location.href = result.redirectUrl;
        } else {
            alert(result.message); // Muestra el mensaje de error
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al intentar iniciar sesión. Por favor, inténtalo de nuevo.');
    }
}





