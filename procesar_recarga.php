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

// Obtener los datos del formulario
$nombre_destinatario = $_POST['nombre_destinatario'];
$cantidad_recarga = str_replace('.', '', $_POST['cantidad_recarga']); // Quitar el formato de número
$numero_m = $_POST['numero_m']; // Obtener el número M desde el formulario
$codigo_orden = uniqid('ORD-', true); // Generar un código de orden único

// Obtener el número de teléfono de la sesión
$telefono = isset($_SESSION['telefono']) ? $_SESSION['telefono'] : '';

if ($telefono == '') {
    die("Número de teléfono no disponible en la sesión.");
}

// Insertar los datos en la base de datos
$sql = "INSERT INTO recargas (nombre_destinatario, cantidad_recarga, telefono, codigo_orden, numero_m) 
        VALUES ('$nombre_destinatario', '$cantidad_recarga', '$telefono', '$codigo_orden', '$numero_m')";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Su recarga está siendo procesada. Por favor tenga paciencia. Código de orden: $codigo_orden'); window.location.href='exito.php';</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
