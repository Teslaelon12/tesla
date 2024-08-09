<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['telefono'])) {
    header('Location: inicio_sesion.php');
    exit();
}

// Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "registro";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el número de teléfono del usuario actual
$telefono = $_SESSION['telefono'];

// Consultar recargas del usuario
$sql = "SELECT * FROM recargas WHERE telefono = '$telefono' ORDER BY fecha DESC";
$result = $conn->query($sql);

if (!$result) {
    die("Error al ejecutar la consulta: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Recargas</title>
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
            margin: 0 auto;
            padding: 20px;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 8px;
            margin-top: 20px;
        }
        .header, .footer {
            text-align: center;
            margin-bottom: 20px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .table th {
            background-color: #4CAF50;
            color: white;
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
        <h1>Historial de Recargas</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cantidad</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['cantidad_recarga']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['fecha']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['estado']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No hay recargas para mostrar.</td></tr>";
                }
                ?>
            </tbody>
        </table>
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
