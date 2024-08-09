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
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <style>
        body {
            background-image: url('fondous.png');
            background-size: cover;
            color: white;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .phone-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background-color: rgba(0, 0, 0, 0.6);
            position: relative;
        }
        .phone-info .telefono {
            font-size: 18px;
            margin-left: 20px;
        }
        .phone-info .saldo {
            font-size: 16px;
            text-align: center;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }
        .buttons-container-top, .buttons-container-bottom {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin: 20px 0;
        }
        .button {
            background-color: transparent; /* Fondo transparente */
            border: none; /* Sin borde visible */
            color: white;
            text-align: center;
            margin: 10px;
            padding: 10px;
            flex-basis: 30%;
        }
        .button img {
            width: 50px;
            height: 50px;
        }
        .button a {
            text-decoration: none;
            color: white;
            display: block;
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
    <div class="phone-info">
        <p class="telefono">+57 <?php echo $telefono; ?></p>
        <p class="saldo">Saldo: $<?php echo number_format($saldo); ?></p>
    </div>

    <div class="buttons-container-top">
        <div class="button">
            <a href="recarga.php">
                <img src="recarga.png" alt="">
                <p>Recargar</p>
            </a>
        </div>
        <div class="button">
            <a href="retiro.php">
                <img src="retirar.png" ">
                <p>Retirar</p>
            </a>
        </div>
        <div class="button">
            <a href="pagina3.php">
                <img src="soporte.png" alt="">
                <p>Soporte</p>
            </a>
        </div>
    </div>

    <div class="buttons-container-bottom">
        <div class="button">
            <a href="equipo.php">
                <img src="equipo.png" alt="">
                <p>Equipo</p>
            </a>
        </div>
        <div class="button">
            <a href="invitacion.php">
                <img src="compartir.png" alt="">
                <p>Compartir</p>
            </a>
        </div>
        <div class="button">
            <a href="inicio_sesion.php">
                <img src="cierre.png" alt="">
                <p>Cerrar sesion</p>
            </a>
        </div>
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

