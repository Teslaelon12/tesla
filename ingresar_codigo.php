<?php
// Confirmacion Recarga PHP

// Obtener el valor de la recarga desde el formulario
$valor_recarga = isset($_POST['valor_recarga']) ? $_POST['valor_recarga'] : null;
$valor_personalizado = isset($_POST['valor_personalizado']) ? $_POST['valor_personalizado'] : null;

// Determinar el monto final a mostrar
$valor_mostrar = $valor_personalizado ? $valor_personalizado : $valor_recarga;

// Validar que se haya ingresado un monto válido
if (!$valor_mostrar || intval($valor_mostrar) < 25000) {
    // Mostrar un mensaje de error si el monto no es válido
    $error_message = 'El monto ingresado es inválido. Debe ser al menos $25,000.';
} else {
    $error_message = null;
}
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
        .button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-align: center;
            display: inline-block;
            font-size: 16px;
            margin-top: 20px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .alert {
            color: red;
            font-size: 14px;
        }
        .qr-code {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($error_message): ?>
            <p class="alert"><?php echo htmlspecialchars($error_message); ?></p>
            <a href="index.html" class="button">Regresar</a>
        <?php else: ?>
            <h1>Confirmación de Recarga</h1>
            <p>Has seleccionado recargar $<?php echo number_format($valor_mostrar, 0, ',', '.'); ?></p>

            <!-- Aquí debes generar el código QR -->
            <div class="qr-code">
                <!-- Asumiendo que usas una librería como PHP QR Code, reemplaza esta línea con el código para generar QR -->
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=recarga<?php echo $valor_mostrar; ?>" alt="Código QR">
            </div>

            <p>Por favor, escanea el código QR con la aplicación Nequi para completar tu recarga.</p>
            <p>Si tienes algún problema, por favor contáctanos.</p>

            <!-- Botón para confirmar -->
            <a href="confirmar.php" class="button">Confirmar</a>
        <?php endif; ?>
    </div>
</body>
</html>

