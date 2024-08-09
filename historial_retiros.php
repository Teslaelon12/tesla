<?php
session_start();

// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registro";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los datos de recargas
$sql = "SELECT codigo_orden, fecha, estado FROM recargas ORDER BY fecha DESC";
$result = $conn->query($sql);

if ($result === FALSE) {
    die("Error en la consulta: " . $conn->error);
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
            font-family: Arial, sans-serif;
            background-image: url('fondous.png'); /* Cambia el nombre de la imagen según sea necesario */
            background-size: cover;
            background-position: center;
            color: white;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        .container {
            max-width: 1380px;
            margin: 0 auto;
            padding: 60px;
            background-color: transparent; /* Fondo transparente para el contenedor */
            border-radius: 10px;
        }
        .historial-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: rgba(255, 255, 255, 0.2); /* Fondo semitransparente */
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .historial-table th, .historial-table td {
            padding: 12px;
            border: 1px solid #ddd;
        }
        .historial-table th {
            background-color: #007bff;
            color: white;
        }
        .historial-table tr:nth-child(even) {
            background-color: rgba(0, 0, 0, 0.2);
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
        <table class="historial-table">
            <thead>
                <tr>
                    <th>Número de Orden</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['codigo_orden']}</td>
                                <td>{$row['fecha']}</td>
                                <td>{$row['estado']}</td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No hay registros</td></tr>";
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
