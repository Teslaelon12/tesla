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

// Obtener el saldo del usuario
$telefono = $_SESSION['telefono'];
$sql = "SELECT saldo FROM usuarios1 WHERE telefono = '$telefono'";
$result = $conn->query($sql);
if ($result) {
    $row = $result->fetch_assoc();
    $saldo = $row['saldo'];
} else {
    $saldo = 0;
}

// Obtener las máquinas de inversión
$sql = "SELECT id, nombre, precio, ganancias_diarias FROM maquinas";
$maquinas = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inversiones</title>
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
            background-color: rgba(0, 0, 0, 0.8);
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
    <!-- Contenido opcional del encabezado -->
</div>
<div class="buttons">
    <a href="recarga.php">
        <img src="recarga.png" alt="">
        <p>Recarga</p>
    </a>
    <a href="retiro.php">
        <img src="retirar.png" alt="">
        <p>Retiro</p>
    </a>
    <a href="equipo.php">
        <img src="equipo.png" alt="">
        <p>Equipo</p>
    </a>
    <a href="">
        <img src="soporte.png" alt="">
        <p>Soporte</p>
    </a>
</div>
<div class="machine-list">
    <?php while ($maquina = $maquinas->fetch_assoc()) { ?>
        <div class="machine">
            <img src="mama.png" alt="Imagen de Máquina"> <!-- Imagen fija para todas las máquinas -->
            <div class="machine-details">
                <p><strong>Nombre:</strong> <?php echo $maquina['nombre']; ?></p>
                <p><strong>Precio:</strong> $<?php echo $maquina['precio']; ?></p>
                <p><strong>Ganancias Diarias:</strong> $<?php echo $maquina['ganancias_diarias']; ?></p>
                <p><strong>Duración:</strong> 60 días</p> <!-- Información agregada -->
            </div>
            <div class="machine-button">
                <form action="comprar.php" method="post">
                    <input type="hidden" name="maquina_id" value="<?php echo $maquina['id']; ?>">
                    <input type="submit" value="Comprar">
                </form>
            </div>
        </div>
    <?php } ?>
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


