<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Medidor de pH - Inicio</title>
    <link rel="icon" type="image/png" href="favicon.png">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Firebase App (SDK principal) -->
    <script src="https://www.gstatic.com/firebasejs/9.15.0/firebase-app-compat.js"></script>
    <!-- Firebase Realtime Database SDK -->
    <script src="https://www.gstatic.com/firebasejs/9.15.0/firebase-database-compat.js"></script>
    <style>
        /* Fondo negro, texto blanco y fuente Arial */
        body {
            background-color: #000;
            color: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        /* Contenedor centrado vertical y horizontalmente */
        .container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        /* Banner superior para los logos */
        #banner {
            width: 100%;
            background-color: #1a1a1a;
            padding: 10px 0;
            /* Animación de entrada */
            animation: fadeInDown 1s ease-out;
        }

        #banner .logo {
            max-height: 60px;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Tarjeta con fondo oscuro y sombra sutil */
        .card {
            background-color: #1a1a1a;
            border: none;
            box-shadow: 0 0 15px rgb(255, 255, 255);
        }

        .card-body {
            padding: 2rem;
        }

        /* Estilo para el número de pH */
        h2 {
            font-size: 3rem;
            color: #fff;
            font-weight: bold;
        }

        /* Animación de carga personalizada (se usa dentro del modal de SweetAlert2) */
        .loader {
            border: 5px solid rgba(255, 255, 255, 0.2);
            border-left-color: #fff;
            border-radius: 50%;
            width: 80px;
            height: 80px;
            animation: spin 0.5s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Animación para actualización */
        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        .update-pulse {
            animation: pulse 0.5s ease-in-out;
        }

        /* Ocultar scrollbar */
        body::-webkit-scrollbar {
            width: 0;
            background: transparent;
        }

        body {
            scrollbar-width: none;
            /* Para Firefox */
        }
    </style>
</head>

<body>
    <!-- Contenedor principal -->
    <div id="mainContent" class="container" style="display: none;">
        <!-- Banner con logos -->
        <div id="banner" class="d-flex justify-content-around align-items-center mb-4">
            <img src="favicon.png" alt="Logo 1" class="logo img-fluid">
            <img src="logopanteras.png" alt="Logo 2" class="logo img-fluid">
        </div>
        <!-- Título y contenido principal -->
        <div>
            <h1 class="mb-4">Medidor de pH</h1>
            <div class="card">
                <div class="card-body">
                    <!-- Aquí se mostrará el valor de pH en tiempo real -->
                    <h2 id="phValue" class="display-4">Cargando...</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap Bundle con Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Al cargarse el contenido, muestra el modal de carga de SweetAlert2
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: 'Cargando datos...',
                html: '<div class="loader"></div>',
                allowOutsideClick: false,
                showConfirmButton: false,
                background: '#000',
                color: '#fff',
                timer: 2000,
                didClose: () => {
                    // Al cerrar la animación de carga se muestra el contenedor principal con el banner animado
                    document.getElementById("mainContent").style.display = "flex";
                }
            });

            // Animación de actualización cada 2 segundos para el valor de pH
            setInterval(() => {
                const phElement = document.getElementById("phValue");
                phElement.classList.add("update-pulse");
                setTimeout(() => {
                    phElement.classList.remove("update-pulse");
                }, 500);
            }, 2000);
        });

        // Configuración de Firebase: reemplaza estos valores con los de tu proyecto
        const firebaseConfig = {
            apiKey: "AIzaSyCjpDm2pVzcx6WEMOrNesbDe8VKlfeorMk",
            authDomain: "esp32-988f2.firebaseapp.com",
            databaseURL: "https://esp32-988f2-default-rtdb.firebaseio.com",
            projectId: "esp32-988f2",
            storageBucket: "esp32-988f2.firebasestorage.app",
            messagingSenderId: "1000534345519",
            appId: "1:1000534345519:web:f1d29865b7464b100f43da"
        };

        // Inicializa Firebase
        firebase.initializeApp(firebaseConfig);

        // Obtiene una referencia al servicio de Realtime Database
        const database = firebase.database();

        // Referencia a la ruta donde se almacena el pH (ajusta la ruta si es necesario)
        const phRef = database.ref('/Sensores/ph');

        // Escucha cambios en tiempo real y actualiza el contenido del elemento con id "phValue"
        phRef.on('value', (snapshot) => {
            const ph = snapshot.val();
            document.getElementById('phValue').innerText = (ph !== null) ? ph : "Sin datos";
        });
    </script>
</body>

</html>