<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Retiro</title>
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
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 8px;
            margin-top: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group input[type="submit"] {
            background-color: #4CAF50; /* Verde */
            border: none;
            color: white;
            padding: 15px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 15px;
            cursor: pointer;
            border-radius: 5px;
        }
        .form-group button {
            background-color: #008CBA; /* Azul */
            border: none;
            color: white;
            padding: 15px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 15px;
            cursor: pointer;
            border-radius: 5px;
        }
        .info {
            margin-top: 20px;
        }
        .info p {
            margin: 0;
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
        <form action="retirar.php" method="post" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="nombre_titular">Nombre del Titular de la Cuenta:</label>
                <input type="text" id="nombre_titular" name="nombre_titular" required>
            </div>
            <div class="form-group">
                <label for="numero_bancario">Número Bancario:</label>
                <input type="text" id="numero_bancario" name="numero_bancario" required>
            </div>
            <div class="form-group">
                <label for="cantidad">Cantidad:</label>
                <input type="number" id="cantidad" name="cantidad" min="15000" required>
            </div>
            <div class="form-group">
                <label for="nequi">Nequi:</label>
                <input type="text" id="nequi" name="nequi" value="Nequi" readonly>
            </div>
            <div class="form-group">
                <input type="submit" value="Retirar">
            </div>
            <div class="form-group">
                <a href="historial_retiros.php">
                    <button type="button">Ver Historial de Retiro</button>
                </a>
            </div>
            <div class="info">
                <p><strong>Nota:</strong></p>
                <p>Mínimo de retiro: $15,000</p>
                <p>Tiempo de procesamiento: 2 a 24 horas</p>
                <p>Tarifas de retiro: 10%</p>
            </div>
        </form>
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

    <script>
        function validateForm() {
            var cantidad = document.getElementById("cantidad").value;
            if (cantidad < 15000) {
                alert("La cantidad mínima de retiro es $15,000.");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>





