<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recarga Nequi</title>
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
        .recarga-options {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-bottom: 50px; /* Espacio debajo de las opciones de recarga */
        }
        .recarga-option {
            width: calc(25% - 20px); /* Cuatro opciones por fila, con espacio entre ellas */
            margin: 10px;
            box-sizing: border-box;
            text-align: center;
        }
        .recarga-option input[type="radio"] {
            margin-right: 5px;
        }
        .input-recarga-container {
            margin-top: 50px; /* Ajusta este valor para mover el cuadro de ingreso manual más abajo */
            text-align: center;
        }
        .input-recarga {
            font-size: 18px;
            padding: 10px;
            width: 100%;
            max-width: 300px;
            margin: 0 auto; /* Centra el cuadro dentro del contenedor */
        }
        .button-recarga {
            background-color: #007bff;
            color: white;
            padding: 15px 20px;
            text-align: center;
            display: inline-block;
            font-size: 16px;
            margin: 10px 0;
            cursor: pointer;
            border: none;
            border-radius: 5px;
        }
        .button-recarga:hover {
            background-color: #0056b3;
        }
        .alert {
            color: red;
            font-size: 14px;
        }
        .historial-recargas {
            margin-top: 30px; /* Espacio antes del historial */
            padding: 20px;
            background-color: #f4f4f4;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: left;
            color: #333;
        }
        .historial-recargas a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }
        .historial-recargas a:hover {
            text-decoration: underline;
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
        <h1>Recarga Nequi</h1>
        <p>Seleccione o ingrese el valor de la recarga (mínimo $25,000):</p>
        <form action="codigoqr.php" method="post" onsubmit="return validarRecarga()">
            <div class="recarga-options">
                <!-- Opciones de recarga predefinidas -->
                <?php
                $opciones_recarga = [20000, 30000, 40000, 60000, 80000, 100000, 150000, 200000, 250000, 300000, 500000, 750000, 1000000];
                foreach ($opciones_recarga as $opcion) :
                ?>
                    <div class="recarga-option">
                        <input type="radio" id="opcion<?php echo $opcion; ?>" name="valor_recarga" value="<?php echo $opcion; ?>" onclick="actualizarManual(this.value)">
                        <label for="opcion<?php echo $opcion; ?>">$<?php echo number_format($opcion, 0, ',', '.'); ?></label>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="input-recarga-container">
                <input type="text" id="valor_personalizado" name="valor_personalizado" class="input-recarga" placeholder="Ingrese monto personalizado" pattern="\d+" title="Solo números son permitidos" oninput="actualizarSeleccionado()">
            </div>
            <button type="submit" class="button-recarga">Confirmar Recarga</button>
            <div id="mensaje-error" class="alert" style="display: none;"></div>
        </form>

        <!-- Sección de historia de recarga -->
        <div class="historial-recargas">
            <a href="historial.php">Ver historial completo</a>
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

    <script>
        function actualizarManual(valor) {
            document.getElementById('valor_personalizado').value = valor;
        }

        function actualizarSeleccionado() {
            let inputValor = document.getElementById('valor_personalizado').value;
            let radios = document.getElementsByName('valor_recarga');
            radios.forEach(radio => {
                if (radio.value === inputValor) {
                    radio.checked = true;
                }
            });
        }

        function validarRecarga() {
            let valorPersonalizado = document.getElementById('valor_personalizado').value;
            let radios = document.getElementsByName('valor_recarga');
            let valorSeleccionado = Array.from(radios).some(radio => radio.checked);
            if (!valorSeleccionado && (!valorPersonalizado || parseInt(valorPersonalizado) < 25000)) {
                document.getElementById('mensaje-error').textContent = 'Por favor, ingrese un monto válido de $25,000 o más.';
                document.getElementById('mensaje-error').style.display = 'block';
                return false;
            }
            document.getElementById('mensaje-error').style.display = 'none';
            return true;
        }
    </script>
</body>
</html>
