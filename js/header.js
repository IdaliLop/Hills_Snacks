const hamburger = document.querySelector(".hamburger");
const navMenu = document.querySelector(".nav-menu");

// Seleccionar el body
const body = document.body;

hamburger.addEventListener("click", () => {
    hamburger.classList.toggle("active");
    navMenu.classList.toggle("active");

    // Agregar o quitar la clase que bloquea el scroll
    if (hamburger.classList.contains("active")) {
        body.classList.add("no-scroll"); // Agrega la clase 'no-scroll' para desactivar el scroll
    } else {
        body.classList.remove("no-scroll"); // Elimina la clase 'no-scroll' para reactivar el scroll
    }
});

document.querySelectorAll(".nav-link").forEach(n => n.addEventListener("click", () => {
    hamburger.classList.remove("active");
    navMenu.classList.remove("active");

    // Eliminar la clase 'no-scroll' al hacer clic en un enlace
    body.classList.remove("no-scroll");
}));
