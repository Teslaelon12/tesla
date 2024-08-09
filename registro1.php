<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        h1 {
            margin-bottom: 20px;
            color: #333;
        }
        input[type="text"], input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            width: calc(100% - 20px);
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .link {
            display: block;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }
        .link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Registro</h1>
        <form action="registro.php" method="post">
            <input type="text" id="telefono" name="telefono" placeholder="Teléfono" required>
            <br>
            <input type="password" id="contraseña" name="contraseña" placeholder="Contraseña" required>
            <br>
            <input type="text" id="codigo_referido" name="codigo_referido" placeholder="Código de Referencia (Opcional)">
            <br>
            <button type="submit">Registrar</button>
            <a href="inicio_sesion.php" class="link">¿Ya tienes cuenta? Inicia sesión</a>
        </form>
    </div>
</body>
</html>
