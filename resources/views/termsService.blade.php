<x-AppLayout>

    <div class="bg-white text-black dark:bg-black dark:text-white">
        <div class="container mx-auto px-4 py-8">
            <p class="mb-4">
                Fecha: {{ now() }}
            </p>
            <div class='w-full flex'>
                <h1 class="text-3xl font-bold mb-4 text-orange-800">Términos y Condiciones de Uso</h1>
            </div>

            <br />
            <p class="mb-4 text-base">
                Al registrarte en la página de <strong>Inner</strong>, aceptas cumplir con los siguientes términos y
                condiciones:
            </p>

            <br />
            <div class='pb-5'>
                <h2 class='font-bold text-orange-700 dark:text-orange-300'>Aceptación de Normas</h2>
                <ul>
                    <li class='list-disc'>
                        <p class="text-base">
                            Al crear una cuenta, aceptas respetar las normas de conducta de la página y del foro.
                            Cualquier incumplimiento puede llevar a la suspensión o eliminación de tu cuenta.
                        </p>
                    </li>
                </ul>
            </div>

            <div class='pb-5'>
                <h2 class='font-bold text-orange-700 dark:text-orange-300'>Políticas de Privacidad</h2>
                <ul>
                    <li class='list-disc'>
                        <p class="text-base">
                            <strong>Datos Personales:</strong> La información que proporciones durante el registro
                            (como tu nombre, correo electrónico y cualquier otra información personal) será tratada de
                            manera confidencial. <br>
                            Nunca compartiremos ni venderemos tus datos a terceros sin tu consentimiento.
                        </p>
                    </li>
                </ul>
            </div>

            <div class='pb-5'>
                <h2 class='font-bold text-orange-700 dark:text-orange-300'>Condiciones de Uso</h2>
                <br />
                <ul>
                    <li class='list-disc'>
                        <p class="text-base">
                            <strong>Responsabilidad del Usuario:</strong> Al crear una cuenta, eres responsable de
                            mantener la seguridad de tu información de acceso
                            y del contenido que publiques. No permitas que otros usen tu cuenta. Ni reveles informacion
                            sensible.
                        </p>
                    </li>
                    <li class='list-disc'>
                        <p class="text-base">
                            <strong>Prohibiciones:</strong> Está prohibido el uso de lenguaje ofensivo, la publicación
                            de imágenes o contenido inapropiado, y la infracción de derechos de autor. Cualquier
                            comportamiento que viole las normas de respeto o privacidad será motivo de suspensión.
                        </p>
                    </li>
                    <li class='list-disc'>
                        <p class="text-base">
                            <strong>Derechos del Sitio:</strong> Nos reservamos el derecho de eliminar cualquier
                            contenido que infrinja estas condiciones y de tomar las medidas necesarias contra los
                            usuarios que no respeten las normas.
                        </p>
                    </li>
                </ul>
            </div>

            <div class='pb-5'>
                <h2 class='font-bold text-orange-700 dark:text-orange-300'>Acceso al Foro y Publicación de Imágenes</h2>
                <br />
                <ul>
                    <li class='list-disc'>
                        <p class="text-base">
                            Al publicar en el foro o subir imágenes, declaras que tienes los derechos sobre el contenido
                            o el permiso correspondiente para compartirlo. <br>
                            Cualquier imagen o mensaje que no cumpla con estas condiciones será eliminado.
                        </p>
                    </li>
                </ul>
            </div>

            <div class='pb-5'>
                <h2 class='font-bold text-orange-700 dark:text-orange-300'>Modificaciones de los Términos</h2>
                <br />
                <ul>
                    <li class='list-disc'>
                        <p class="text-base">
                            Nos reservamos el derecho de modificar estos términos en cualquier momento. Se te notificará
                            cualquier cambio importante, y el uso continuado del sitio implicará la aceptación de los
                            términos actualizados.
                        </p>
                    </li>
                </ul>
            </div>

        </div>
    </div>

</x-AppLayout>
