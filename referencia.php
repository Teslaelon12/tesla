<?php
session_start();
if (!isset($_SESSION['telefono'])) {
    header('Location: inicio_sesion.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ingresar Referencia</title>
    <style>
        body {
            background-color: #f0f0f0; /* Fondo gris claro para contrastar con el formulario */
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Ocupa toda la altura de la ventana del navegador */
            margin: 0;
        }
        .container {
            background-color: #ffffff; /* Fondo blanco para el formulario */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Sombra sutil alrededor del formulario */
            max-width: 400px; /* Ancho máximo del formulario */
            width: 100%; /* Asegura que el formulario sea responsive */
        }
        h1 {
            margin-top: 0;
            font-size: 24px;
            text-align: center;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
        p.error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Ingresar Código de Referencia</h1>
        <?php
        if (isset($_GET['error'])) {
            $error_message = htmlspecialchars($_GET['error']); // Decodifica el mensaje de error
            echo '<p class="error">' . $error_message . '</p>';
        }
        ?>
        <form action="procesar_referencia.php" method="post">
            <label for="codigo_referencia">Código de Referencia:</label>
            <input type="text" id="codigo_referencia" name="codigo_referencia" required>
            <button type="submit">Enviar</button>
        </form>
    </div>
</body>
</html>
