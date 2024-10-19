import "./bootstrap";

document.addEventListener("DOMContentLoaded", function() {
    const menuToggle = document.getElementById('menu-toggle');
    const dropdownMenu = document.getElementById('dropdown-menu');

    // Mostrar/ocultar el menú al hacer clic en el botón
    menuToggle.addEventListener('click', function(event) {
        dropdownMenu.classList.toggle('hidden');
        event.stopPropagation(); // Prevenir que el clic se propague al documento
    });

    // Cerrar el menú si se hace clic fuera de él
    document.addEventListener('click', function(event) {
        const isClickInsideMenu = dropdownMenu.contains(event.target) || menuToggle.contains(event
            .target);

        if (!isClickInsideMenu) {
            dropdownMenu.classList.add('hidden');
        }
    });

    document.getElementById('perfil-toggle').addEventListener('click', function() {
        const dropdownPerfil = document.getElementById('dropdown-perfil');
        dropdownPerfil.classList.toggle('hidden');
    });
});

document.addEventListener("DOMContentLoaded", function() {
    var swiper = new Swiper(".slide-content", {
        slidesPerView: 3,
        centeredSlides: true,
        spaceBetween: 25,
        centerSlide: "true",
        fade: "true",
        grabCursor: "true",
        pagination: {
            el: ".swiper-pagination",
            type: "fraction",
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
});

document.addEventListener("DOMContentLoaded", function () {
    // Seleccionar todas las imágenes con la clase `imagen-modal`
    const imagenes = document.querySelectorAll(".imagen-modal");
    const modal = document.getElementById("modal");
    const modalImage = document.getElementById("modalImage");

    // Añadir evento de click a cada imagen
    imagenes.forEach((imagen) => {
        imagen.addEventListener("click", function () {
            modal.classList.remove("hidden"); // Mostrar el modal
            modalImage.src = imagen.src; // Establecer la imagen en el modal
            modalImage.classList.add("imagenG"); // Añadir la clase de transición suave
            modalImage.style.transform = "scale(1)"; // Ampliar la imagen al tamaño original
        });
    });

    // Cerrar el modal al hacer clic en cualquier parte del mismo
    modal.addEventListener("click", function () {
        modal.classList.add("hidden"); // Ocultar el modal
        modalImage.style.transform = "scale(0.9)"; // Restablecer el tamaño
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const alerts = document.querySelectorAll(".alert-fixed");

    alerts.forEach((alert) => {
        const closeButton = alert.querySelector("[data-dismiss-target]");

        // Cerrar automáticamente después de 5 segundos
        setTimeout(() => {
            alert.style.opacity = "0";
            setTimeout(() => {
                alert.remove();
            }, 500);
        }, 5000);

        // Cerrar al hacer clic en el botón de cerrar
        closeButton.addEventListener("click", function () {
            const targetId = closeButton.getAttribute("data-dismiss-target");
            const target = document.querySelector(targetId);
            if (target) {
                target.style.opacity = "0";
                setTimeout(() => {
                    target.remove();
                }, 500);
            }
        });
    });
});

// Alerta para borrar comentario
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".btnEliminarComentario").forEach((element) => {
        element.addEventListener("submit", async function (event) {
            event.preventDefault();
            Swal.fire({
                title: "¿Estás seguro?",
                text: "¡No puedes revertir los cambios!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, borrarlo!",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });
});

// Alerta para borrar contenido
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("btnEliminarAlbum")
        .addEventListener("submit", async function (event) {
            event.preventDefault();
            Swal.fire({
                title: "¿Estás seguro?",
                text: "¡No puedes revertir los cambios!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, borrarlo!",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
});

// Alerta para borrar contenido
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".btnEliminarContenido").forEach((element) => {
        element.addEventListener("submit", async function (event) {
            event.preventDefault();
            Swal.fire({
                title: "¿Estás seguro?",
                text: "¡No puedes revertir los cambios!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, borrarlo!",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });
});

// Alerta para eliminar tu cuenta
document.addEventListener("DOMContentLoaded", () => {
    document
        .getElementById("btnEliminarCuenta")
        .addEventListener("submit", async function (event) {
            event.preventDefault();

            const { value: password } = await Swal.fire({
                title: "Ingrese su contraseña",
                input: "password",
                inputLabel: "Contraseña",
                inputPlaceholder: "Ingrese su contraseña",
                inputAttributes: {
                    maxlength: "10",
                    autocapitalize: "off",
                    autocorrect: "off",
                },
            });

            const passwordInput = document.createElement("input");
            passwordInput.type = "hidden";
            passwordInput.name = "password";
            passwordInput.value = password || "";
            this.appendChild(passwordInput);

            this.submit();
        });
});

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".btnEliminarUsuario").forEach((element) => {
        element.addEventListener("submit", async function (event) {
            event.preventDefault();
            Swal.fire({
                title: "¿Estás seguro?",
                text: "¡No puedes revertir los cambios!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, borrarlo!",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('[id^="menu-button-"]').forEach((button) => {
        button.addEventListener("click", function () {
            const menuId = this.getAttribute("id").replace(
                "menu-button-",
                "menu-"
            );
            const menu = document.getElementById(menuId);
            const isExpanded = this.getAttribute("aria-expanded") === "true";

            document
                .querySelectorAll('[id^="menu-"]')
                .forEach((m) => m.classList.add("hidden"));

            if (isExpanded) {
                this.setAttribute("aria-expanded", "false");
                menu.classList.add("hidden");
            } else {
                this.setAttribute("aria-expanded", "true");
                menu.classList.remove("hidden");
            }
        });
    });

    document.addEventListener("click", function (e) {
        if (!e.target.closest('[id^="menu-button-"]')) {
            document
                .querySelectorAll('[id^="menu-"]')
                .forEach((menu) => menu.classList.add("hidden"));
            document
                .querySelectorAll('[id^="menu-button-"]')
                .forEach((button) =>
                    button.setAttribute("aria-expanded", "false")
                );
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const rolSelect = document.getElementById("rol");
    const especialidadContainer = document.getElementById(
        "especialidad-container"
    );

    rolSelect.addEventListener("change", function () {
        if (rolSelect.value == 2) {
            // Asume que '2' es el id del rol Staff
            especialidadContainer.classList.remove("hidden");
        } else {
            especialidadContainer.classList.add("hidden");
        }
    });
});

// Inicializar el mapa solo una vez
let map = L.map("mapa").setView([40.712776, -74.005974], 16);

L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
    attribution:
        '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
}).addTo(map);

L.marker([40.712776, -74.005974])
    .addTo(map)
    .bindPopup("Ubicaciòn Del Evento")
    .openPopup();

// YOUTUBE PASA VIDEO
// let currentSlide = 0;

// function showSlide(index) {
//     const slides = document.querySelectorAll('.card');
//     if (index >= slides.length) currentSlide = 0;
//     else if (index < 0) currentSlide = slides.length - 1;
//     else currentSlide = index;

//     slides.forEach((slide, i) => {
//         slide.style.transform = `translateX(-${currentSlide * 100}%)`;
//     });
// }

// function nextSlide() {
//     showSlide(currentSlide + 1);
// }

// function prevSlide() {
//     showSlide(currentSlide - 1);
// }

// Mostrar el primer slide
// showSlide(currentSlide);
