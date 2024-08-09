<?php
session_start();

// Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "registro";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['telefono'])) {
    header('Location: inicio_sesion.php'); // Redirigir a la página de inicio de sesión si no hay sesión activa
    exit();
}

// Obtener el saldo del usuario
$telefono = $_SESSION['telefono'];
$sql = "SELECT saldo FROM usuarios1 WHERE telefono = '$telefono'";
$result = $conn->query($sql);
if ($result) {
    $row = $result->fetch_assoc();
    $saldo = $row['saldo'];
} else {
    die("Error al obtener el saldo del usuario.");
}

// Procesar el formulario de retiro
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $numero_bancario = $_POST['numero_bancario'];
    $nombre_titular = $_POST['nombre_titular'];
    $cantidad = $_POST['cantidad'];
    
    // Validar que la cantidad a retirar sea válida
    if ($cantidad >= 15000 && $cantidad <= $saldo) {
        // Calcular la tarifa de retiro
        $tarifa = $cantidad * 0.10; // 10% de tarifa

        // Verificar si el teléfono existe en la tabla `usuarios1`
        $checkUsuario = "SELECT * FROM usuarios1 WHERE telefono = '$telefono'";
        $usuarioResult = $conn->query($checkUsuario);
        if ($usuarioResult->num_rows > 0) {
            // Actualizar el saldo del usuario
            $nuevo_saldo = $saldo - $cantidad;
            $updateSaldo = "UPDATE usuarios1 SET saldo = $nuevo_saldo WHERE telefono = '$telefono'";
            if ($conn->query($updateSaldo)) {
                // Registrar el retiro en la base de datos
                $insertRetiro = "INSERT INTO retiros (telefono, numero_bancario, nombre_titular, cantidad, tarifa) VALUES ('$telefono', '$numero_bancario', '$nombre_titular', $cantidad, $tarifa)";
                if ($conn->query($insertRetiro)) {
                    // Redirigir a la página de confirmación
                    header('Location: confirmacion_retiro.php');
                    exit();
                } else {
                    echo "<script>alert('Error al registrar el retiro: " . $conn->error . "'); window.location.href = 'retirar.php';</script>";
                }
            } else {
                echo "<script>alert('Error al actualizar el saldo: " . $conn->error . "'); window.location.href = 'retirar.php';</script>";
            }
        } else {
            echo "<script>alert('El número de teléfono no está registrado.'); window.location.href = 'retirar.php';</script>";
        }
    } else {
        echo "<script>alert('Cantidad mínima de retiro es $15,000 o saldo insuficiente.'); window.location.href = 'retirar.php';</script>";
    }
}

$conn->close();
?>
