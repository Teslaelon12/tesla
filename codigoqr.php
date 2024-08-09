<?php
session_start();

// Verificar si se envió el formulario y obtener el valor de recarga
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $valor_recarga = $_POST['valor_recarga'] ?? $_POST['valor_personalizado'];
    $_SESSION['valor_recarga'] = $valor_recarga;
} else {
    // Redirigir a la página de selección si no se ha enviado el formulario
    header('Location: recarga.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Pago</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('fondous.png') no-repeat center center fixed;
            background-size: cover;
            color: white;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        ol {
            padding-left: 20px;
        }
        .qr-code {
            text-align: center;
            margin: 20px 0;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: calc(100% - 50px);
            padding: 10px;
            border: none;
            border-radius: 4px;
        }
        .form-group button {
            width: 50px;
            padding: 10px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-group button:hover {
            background: #45a049;
        }
        .submit-btn {
            width: 100%;
            padding: 10px;
            background: #6200ea;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
            margin-top: 20px;
        }
        .submit-btn:hover {
            background: #3700b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Página de Pago</h1>
        <ol>
            <li>Captura de pantalla y copia el Código M después del pago exitoso</li>
            <li>Rellene el código M o cargue una captura de pantalla de pago</li>
            <li>Solo haciendo clic en el botón de abajo se considerará que el pedido está completo</li>
            <li>Si tiene otras preguntas, puede preguntar al personal.</li>
        </ol>
        <div class="qr-code">
            <img src="qr_code.png" alt="Código QR">
        </div>
        <form action="procesar_recarga.php" method="post">
            <div class="form-group">
                <label for="nombre_destinatario">Nombre del destinatario</label>
                <input type="text" id="nombre_destinatario" name="nombre_destinatario" value="BRAYAN BELTRAN" required>
            </div>
            <div class="form-group">
                <label for="cantidad_recarga">Cantidad de recarga</label>
                <input type="text" id="cantidad_recarga" name="cantidad_recarga" value="<?php echo number_format($_SESSION['valor_recarga'], 0, ',', '.'); ?>" readonly>
                <button type="button" onclick="copiarTexto('cantidad_recarga')">Copiar</button>
            </div>
            <div class="form-group">
                <label for="numero_m">Número M</label>
                <input type="text" id="numero_m" name="numero_m" placeholder="Exitoso después de rellenar su número M" required>
            </div>
            <button type="submit" class="submit-btn">He completado la recarga</button>
        </form>
    </div>
    <script>
        function copiarTexto(elementId) {
            var copyText = document.getElementById(elementId);
            copyText.select();
            copyText.setSelectionRange(0, 99999); /* For mobile devices */
            document.execCommand("copy");
            alert("Texto copiado: " + copyText.value);
        }
    </script>
</body>
</html>
