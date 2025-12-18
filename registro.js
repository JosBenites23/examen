document.addEventListener('DOMContentLoaded', async function () {
    const registrationForm = document.getElementById('registration-form');
    // URL del controlador de la API
    const apiUrl = 'backend/controler/peliculas.controller.php';

    if (registrationForm) {
        registrationForm.addEventListener('submit', async function (event) {
            event.preventDefault(); // Prevenir el envío por defecto del formulario

            // Recopilar datos del formulario
            const formData = new FormData(registrationForm);
            const peliculaData = {};
            for (let [key, value] of formData.entries()) {
                peliculaData[key] = value;
            }

            try {
                const response = await fetch(apiUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(peliculaData) // Convertir el objeto JS a JSON
                });

                const result = await response.json(); // Leer la respuesta JSON

                if (response.ok) { // Si el código de estado es 2xx
                    alert(result.message || 'pelicula registrada exitosamente.');
                    registrationForm.reset(); // Limpiar el formulario
                    // Redirigir a la página de login
                } else {
                    // Si el código de estado no es 2xx (ej: 400, 500)
                    alert(result.message || 'Error al registrar pelicula.');
                }
            } catch (error) {
                console.error('Error de red o del servidor:', error);
                alert('Ocurrió un error al intentar registrar el usuario.');
            }
        });
    }
});