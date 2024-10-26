# Proyecto "INNER": Desarrollo de Sitio Web para una Banda

### Autores

-   **Nicolás Aranda Santiago**
-   **Victoria Valentina Maidana Corti (VictoriaVMC)**

---

## Índice de Contenido

-   [Elección de Proyecto](#elección-de-proyecto)
-   [Estudio de Proyectos Similares](#estudio-de-proyectos-similares)
-   [Elección del Ciclo de Vida de Desarrollo](#elección-del-ciclo-de-vida-de-desarrollo)
-   [Elicitación de Requisitos](#elicitation-de-requisitos)
-   [Definición del Alcance del Proyecto](#definición-del-alcance-del-proyecto)
-   [Vista Previa](#vista-previa)
-   [Para Ejecutar](#para-poder-ejecutar)

---

## Elección de Proyecto

El proyecto **INNER** se centra en crear una plataforma digital avanzada para la banda musical “INNER”. Este sistema permite la Gestión de Contenidos y optimiza la presencia en línea de la banda, fomentando la interacción con sus seguidores y ofreciendo una experiencia personalizada.

Objetivos principales:

-   **Gestión de Contenidos**: Administración de noticias, eventos, y contenido multimedia.
-   **Foro Interactivo**: Espacio para que los fans discutan y compartan opiniones, con restricciones para usuarios sin suscripción.
-   **Sistema de Suscripción**: Acceso a contenido exclusivo mediante pagos únicos, integrados con plataformas de pago como Mercado Pago y/o Lemon.
-   **Integración de Redes Sociales**: Conexión con Spotify, Instagram y YouTube para facilitar la difusión de contenido.

Este proyecto busca mejorar la presencia digital de la banda, facilitando la gestión autónoma del contenido y potenciando la interacción con los seguidores.
Además, representa una excelente oportunidad para aplicar conocimientos avanzados en desarrollo web, asegurando una solución robusta y escalable que acompañe el crecimiento futuro de la banda.

## Estudio de Proyectos Similares

Se realizó una investigación exhaustiva de proyectos similares en la industria musical. Se analizaron las plataformas web de bandas como Metallica, Måneskin, Judas Priest, y The Cure, así como prácticas de diseño y funcionalidad observadas en sitios respaldados por Sony Music. Esta investigación permitió identificar características clave y buenas prácticas para la implementación de un gestor de contenido eficiente.

## Elección del Ciclo de Vida de Desarrollo

Para el desarrollo del sitio web, se seleccionó un ciclo de vida **Incremental** combinado con la metodología ágil **Extreme Programming (XP)**. Esta elección ofrece flexibilidad y permite una entrega continua y de alta calidad, asegurando que el producto final cumpla con las expectativas del cliente.

-   **Ciclo de Vida Incremental**: Descomposición del proyecto en incrementos, cada uno agregando funcionalidad al sistema de manera acumulativa. Esta estructura facilita la entrega temprana de valor al cliente y permite la iteración y mejora continua.
-   **Extreme Programming (XP)**: Metodología ágil enfocada en la colaboración constante con el cliente, la entrega rápida de funcionalidades, y el desarrollo basado en pruebas (TDD). El uso de XP asegura que cada incremento del ciclo de vida incremental sea desarrollado con alta calidad y adaptado a los cambios en los requisitos.

## Elicitación de Requisitos

La fase de elicitación de requisitos se realizó mediante lo solicitado por el docente. Las necesidades y expectativas, tanto funcionales como no funcionales:

-   **Requisitos Funcionales**:

    -   Gestión dinámica de contenidos (biografía, noticias, artistas, staffExtra).
    -   Integración de redes sociales.
    -   Gestión de eventos.
    -   Sistema de suscripción.
    -   Foro interactivo.
    -   Gestión de comentarios.
    -   Manejo de álbumes multimedia.
    -   Sistema de notificaciones.
    -   Acceso a contenido exclusivo mediante pagos.
    -   Restricción de interacciones para usuarios no suscriptores.

-   **Requisitos No Funcionales**: Se enfocan en la usabilidad, rendimiento, seguridad, escalabilidad, facilidad de mantenimiento, compatibilidad, y fiabilidad del sistema.

## Definición del Alcance del Proyecto

El alcance del proyecto abarca todos los componentes necesarios para desarrollar una gestión de contenido robusto y dinámico. Esto incluye:

1. **Diseño y Desarrollo**

    - **Gestión de Contenidos**: Creación y edición de publicaciones, manejo de álbumes y multimedia, calendario de eventos interactivo.
    - **Integración con Redes Sociales**: Widgets y enlaces para plataformas como Instagram y YouTube.
    - **Sistema de Notificaciones**: Opciones de recolección de correos electrónicos y envío de notificaciones.

2. **Diseño de la Interfaz de Usuario**

    - **Interfaz Intuitiva y Adaptativa**: Un diseño responsive que se adapta a todos los dispositivos.
    - **Gestión de Colores y Tipografía**: Identidad visual coherente.
    - **Iconografía y Imágenes**: Uso de imágenes e iconos relevantes.
    - **SELECCIONAR LAS MEJORES FOTOS PARA QUE PAREZCAN LINDOS Y TODO**

3. **Desarrollo del Backend**

    - **Optimización y Seguridad**: Eficiencia en el uso de recursos del servidor y medidas de seguridad avanzadas para proteger datos sensibles.

4. **Implementación de Suscripción**

    - **Sistema de Suscripción de Pago**: Acceso a contenido exclusivo mediante pago único, con gestión de visualización para usuarios no suscriptores.

5. **Foro Interactivo**
    - **Plataforma de Interacción**: Espacio para que los fans discutan y comenten sobre la banda y su música.

El proyecto está diseñado para ser escalable, seguro y fácil de mantener, permitiendo a la banda gestionar su presencia en línea de manera eficiente y ofrecer una experiencia enriquecida a sus seguidores.

## Vista Previa

[Insertar imágenes de la página principal]

## Para poder ejecutar

> **Nota:** No subimos el archivo `.env` ni la carpeta `storage`.

### Importante!

-   Asegúrate de tener instalados los siguientes paquetes:
    ````INSTALLAR DESDE SITIO WEB OFICIAL cacert.pem
    composer upgrade
    npm install vite
    npm run build
    npm run dev (EJECUTA)```
    ````

### En el php.init:

-   extension=curl
-   extension=pdo_mysql
-   extension=mysqli
-   extension=fileinfo
-   extension=zip
-   extension=openssl
-   curl.cainfo = "C:\ruta\hasta\cacert.pem"
-   extension=mbstring

### Libreria
- composer require maatwebsite/excel:^3.1.58
- composer require barryvdh/laravel-dompdf
- composer require "mercadopago/dx-php:3.0.0"