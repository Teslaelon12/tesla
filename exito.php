<?php
session_start();

// Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "registro";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['telefono'])) {
    header('Location: inicio_sesion.php'); // Redirigir a la página de inicio de sesión si no hay sesión activa
    exit();
}

// Obtener el teléfono del usuario
$telefono = $_SESSION['telefono'];

// Obtener el ID del usuario basado en el teléfono
$sql = "SELECT id FROM usuarios1 WHERE telefono = '$telefono'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $usuario = $result->fetch_assoc();
    $usuario_id = $usuario['id'];

    // Obtener las máquinas compradas por el usuario
    $sql = "SELECT m.nombre, c.precio, c.ganancias_diarias, c.fecha_compra 
            FROM compras c
            JOIN maquinas m ON c.maquina_id = m.id
            WHERE c.usuario_id = '$usuario_id'";
    $compras = $conn->query($sql);
} else {
    echo "Usuario no encontrado.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Máquinas Compradas</title>
    <style>
        body {
            background: url('fondous.png') no-repeat center center fixed; /* Fondo de la página */
            background-size: cover; /* Asegura que la imagen cubra toda la pantalla */
            color: white;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .header {
            position: relative;
            width: 100%;
            height: 2.5cm; /* Altura fija de 2.5 centímetros */
            overflow: hidden;
        }
        .banner {
            display: none;
            width: 100%;
            height: 100%; /* Asegura que la imagen cubra toda la altura del contenedor */
            object-fit: cover; /* Mantiene la proporción de la imagen */
        }
        .active {
            display: block;
        }
        .buttons {
            display: flex;
            justify-content: space-around;
            margin: 20px 0;
        }
        .buttons a {
            text-align: center;
            color: white;
            text-decoration: none;
        }
        .machine {
            display: flex;
            align-items: center;
            border: 1px solid white;
            margin: 10px 0;
            padding: 10px;
            background: rgba(0, 0, 0, 0.5); /* Fondo ligeramente oscuro para las máquinas */
        }
        .machine img {
            width: 181px;
            height: auto;
            margin-right: 40px;
        }
        .machine-details {
            flex-grow: 1;
        }
        .machine-details p {
            margin: 11px 10px;
        }
        .machine-button input[type="submit"] {
            background-color: #4CAF50; /* Verde */
            border: none;
            color: white;
            padding: 15px 20px; /* Ajusta el tamaño del botón */
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 15px;
            margin: 4px 4px;
            cursor: pointer;
            border-radius: 7px;
            width: 110px; /* Ajusta el ancho del botón */
        }
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            display: flex;
            justify-content: space-around;
            background-color: rgba(0, 0, 0, 0.8); /* Ajusta el color de fondo para coincidir con el estilo general */
            padding: 10px 0;
        }
        .footer a {
            text-align: center;
            color: white;
            text-decoration: none;
            font-size: 12px;
        }
        .footer img {
            width: 30px;
            height: 30px;
        }
    </style>
</head>
<body>

<div class="header">
    <!-- Aquí puedes agregar contenido para el encabezado si es necesario -->
</div>

<div class="machine-list">
    <?php if ($compras->num_rows > 0): ?>
        <?php while ($compra = $compras->fetch_assoc()): ?>
            <div class="machine">
                <img src="mama.png" alt="Imagen de Máquina"> <!-- Imagen fija para todas las máquinas -->
                <div class="machine-details">
                    <p><strong>Nombre:</strong> <?php echo $compra['nombre']; ?></p>
                    <p><strong>Precio:</strong> $<?php echo $compra['precio']; ?></p>
                    <p><strong>Ganancias Diarias:</strong> $<?php echo $compra['ganancias_diarias']; ?></p>
                    <p><strong>Fecha de Compra:</strong> <?php echo $compra['fecha_compra']; ?></p>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No has comprado ninguna máquina.</p>
    <?php endif; ?>
</div>

<div class="footer">
    <a href="maquina.php">
        <img src="inicio.png" alt="">
        <p>Inicio</p>
    </a>
    <a href="exito.php">
        <img src="ganacia.png" alt="">
        <p>Ganancias</p>
    </a>
    <a href="invitacion.php">
        <img src="compartir.png" alt="">
        <p>Compartir</p>
    </a>
    <a href="usuario.php">
        <img src="mio.png" alt="">
        <p>Mio</p>
    </a>
</div>

</body>
</html>
<?php
$conn->close();
?>
