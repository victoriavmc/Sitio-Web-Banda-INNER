import './bootstrap';

var swiper = new Swiper(".slide-content", {
    slidesPerView: 3,
    centeredSlides: true,
    spaceBetween: 25,
    centerSlide: 'true',
    fade: 'true',
    grabCursor: 'true',
    pagination: {
      el: ".swiper-pagination",
      type: "fraction",
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
});

let map = L.map("mapa").setView([-26.174986, -58.168595], 16);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    L.marker([-26.174986, -58.168595]).addTo(map)
        .bindPopup('Ubicaciòn Del Evento')
        .openPopup();

document.addEventListener('DOMContentLoaded', function () {
    const alerts = document.querySelectorAll('.alert-fixed');

    alerts.forEach(alert => {
        const closeButton = alert.querySelector('[data-dismiss-target]');

        // Cerrar automáticamente después de 5 segundos
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 500);
        }, 5000);

        // Cerrar al hacer clic en el botón de cerrar
        closeButton.addEventListener('click', function () {
            const targetId = closeButton.getAttribute('data-dismiss-target');
            const target = document.querySelector(targetId);
            if (target) {
                target.style.opacity = '0';
                setTimeout(() => {
                    target.remove();
                }, 500);
            }
        });
    });
});

document.getElementById('menu-toggle').addEventListener('click', function () {
    const dropdown = document.getElementById('dropdown-menu');
    dropdown.classList.toggle('hidden');
});

document.getElementById('perfil-toggle').addEventListener('click', function() {
    const dropdownPerfil = document.getElementById('dropdown-perfil');
    dropdownPerfil.classList.toggle('hidden');
});

// Alerta para eliminar tu cuenta
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('btnEliminarCuenta').addEventListener('submit', async function(event) {
        event.preventDefault();

        const { value: password } = await Swal.fire({
            title: "Ingrese su contraseña",
            input: "password",
            inputLabel: "Contraseña",
            inputPlaceholder: "Ingrese su contraseña",
            inputAttributes: {
                maxlength: "10",
                autocapitalize: "off",
                autocorrect: "off"
            }
        });

        const passwordInput = document.createElement('input');
        passwordInput.type = 'hidden';
        passwordInput.name = 'password';
        passwordInput.value = password || '';
        this.appendChild(passwordInput);

        this.submit();
    });
});

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.btnEliminarUsuario').forEach(element => {
        element.addEventListener('submit', async function(event) {
            event.preventDefault();
            Swal.fire({
                title: "¿Estás seguro?",
                text: "¡No puedes revertir los cambios!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, borrarlo!"
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[id^="menu-button-"]').forEach(button => {
        button.addEventListener('click', function () {
            const menuId = this.getAttribute('id').replace('menu-button-', 'menu-');
            const menu = document.getElementById(menuId);
            const isExpanded = this.getAttribute('aria-expanded') === 'true';

            document.querySelectorAll('[id^="menu-"]').forEach(m => m.classList.add('hidden'));

            if (isExpanded) {
                this.setAttribute('aria-expanded', 'false');
                menu.classList.add('hidden');
            } else {
                this.setAttribute('aria-expanded', 'true');
                menu.classList.remove('hidden');
            }
        });
    });

    document.addEventListener('click', function (e) {
        if (!e.target.closest('[id^="menu-button-"]')) {
            document.querySelectorAll('[id^="menu-"]').forEach(menu => menu.classList.add('hidden'));
            document.querySelectorAll('[id^="menu-button-"]').forEach(button => button.setAttribute('aria-expanded', 'false'));
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const rolSelect = document.getElementById('rol');
    const especialidadContainer = document.getElementById('especialidad-container');

    rolSelect.addEventListener('change', function() {
        if (rolSelect.value == 2) { // Asume que '2' es el id del rol Staff
            especialidadContainer.classList.remove('hidden');
        } else {
            especialidadContainer.classList.add('hidden');
        }
    });
});



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



