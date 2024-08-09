<?php
session_start();

if (!isset($_SESSION['telefono'])) {
    header('Location: inicio_sesion.php');
    exit();
}

$telefono = $_SESSION['telefono'];

$servername = "localhost";
$username = "root";
$password = "";
$database = "registro";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT codigo_referencia FROM usuarios1 WHERE telefono = '$telefono'";
$result = $conn->query($sql);

if ($result && $row = $result->fetch_assoc()) {
    $codigo_referencia = $row['codigo_referencia'];

    $sqlReferidos = "SELECT telefono, fecha_registro FROM usuarios1 WHERE invitador = '$codigo_referencia'";
    $resultReferidos = $conn->query($sqlReferidos);
} else {
    die("Error al obtener el código de referencia del usuario.");
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios Registrados con tu Código de Invitación</title>
    <style>
        body {
            background: url('fondous.png') no-repeat center center fixed;
            background-size: cover;
            color: white;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 8px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
        }
        th {
            background-color: #333;
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
    <div class="container">
        <h2>Usuarios Registrados con tu Código de Invitación</h2>
        <?php
        if (isset($resultReferidos) && $resultReferidos->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Teléfono</th><th>Fecha de Registro</th></tr>";
            while ($rowReferido = $resultReferidos->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($rowReferido['telefono']) . "</td>";
                echo "<td>" . htmlspecialchars($rowReferido['fecha_registro']) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No hay usuarios registrados con tu código de invitación.</p>";
        }
        ?>
    </div>
    <div class="footer">
        <a href="maquina.php">
            <img src="inicio.png" alt="Inicio">
            <p>Inicio</p>
        </a>
        <a href="exito.php">
            <img src="ganacia.png" alt="Ganancias">
            <p>Ganancias</p>
        </a>
        <a href="invitacion.php">
            <img src="compartir.png" alt="Compartir">
            <p>Compartir</p>
        </a>
        <a href="usuario.php">
            <img src="mio.png" alt="Mío">
            <p>Mío</p>
        </a>
    </div>
</body>
</html>



