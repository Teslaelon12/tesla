<?php
// Conexión a la base de datos (ajusta los detalles de conexión según tu configuración)
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

// Obtener datos del formulario
$valor_recarga = isset($_POST['valor_recarga']) ? $_POST['valor_recarga'] : null;
$referencia = isset($_POST['referencia']) ? $_POST['referencia'] : null;

// Generar un número de orden único
$numero_orden = uniqid('ORD-', true);

// Validar que el monto sea al menos $25,000
if (!$valor_recarga || intval($valor_recarga) < 25000) {
    $error_message = 'El monto ingresado es inválido. Debe ser al menos $25,000.';
} else {
    $error_message = null;

    // Insertar en la base de datos
    $sql = "INSERT INTO recargas (numero_orden, valor_recarga, referencia) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $numero_orden, $valor_recarga, $referencia);

    if ($stmt->execute()) {
        $success_message = "Su depósito está siendo revisado. Por favor, tenga paciencia.";
    } else {
        $error_message = "Error al registrar la recarga: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Recarga</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            color: #333;
            text-align: center;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .alert, .success {
            font-size: 14px;
        }
        .success {
            color: green;
        }
        .button {
            display: inline-block;
            margin-top: 20px;
        }
        .button img {
            width: 150px; /* Ajusta el tamaño según sea necesario */
            height: auto;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($error_message): ?>
            <p class="alert"><?php echo htmlspecialchars($error_message); ?></p>
        <?php else: ?>
            <h1>Confirmación de Recarga</h1>
            <p class="success"><?php echo htmlspecialchars($success_message); ?></p>
            <p>Su número de orden es: <strong><?php echo htmlspecialchars($numero_orden); ?></strong></p>
            <p>Referencia: <strong><?php echo htmlspecialchars($referencia); ?></strong></p>
            <p>Su recarga por $<?php echo number_format($valor_recarga, 0, ',', '.'); ?> está siendo procesada.</p>
            
            <p>Serás redirigido a la página de inicio en 10 segundos...</p>

            <a href="index.html" class="button">
                <img src="inicio.png" alt="Inicio">
            </a>
        <?php endif; ?>
    </div>

    <!-- Redirigir después de 10 segundos -->
    <script>
        setTimeout(function() {
            window.location.href = 'index.html'; // Redirige a la página de inicio
        }, 10000); // 10000 milisegundos = 10 segundos
    </script>
</body>
</html>
