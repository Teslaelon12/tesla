<?php
session_start();

// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "registro";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los datos del formulario
$telefono = $_POST['telefono'];
$contraseña = password_hash($_POST['contraseña'], PASSWORD_BCRYPT);
$codigo_referencia = uniqid();
$codigo_referido = $_POST['codigo_referido'];
$fecha_registro = date("Y-m-d H:i:s");

// Inicializar el saldo
$saldo_inicial = 7000.00;

// Verificar si se proporcionó un código de referencia válido
$invitador = null;
if (!empty($codigo_referido)) {
    $sql_referidor = "SELECT codigo_referencia FROM usuarios1 WHERE codigo_referencia = '$codigo_referido'";
    $result_referidor = $conn->query($sql_referidor);
    if ($result_referidor && $result_referidor->num_rows > 0) {
        $invitador = $codigo_referido;
    } else {
        echo "El código de referencia proporcionado no es válido.";
        exit;
    }
}

// Comenzar una transacción
$conn->begin_transaction();

try {
    // Preparar la consulta de inserción del usuario
    $sql = "INSERT INTO usuarios1 (telefono, saldo, codigo_referencia, contraseña, invitador, fecha_registro)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdssss", $telefono, $saldo_inicial, $codigo_referencia, $contraseña, $invitador, $fecha_registro);

    if ($stmt->execute()) {
        // Confirmar la transacción
        $conn->commit();

        // Redirigir al usuario a la página de éxito
        header("Location: inicio_sesion.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
        $conn->rollback();
    }

    $stmt->close();
} catch (Exception $e) {
    // Revertir la transacción en caso de error
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}

$conn->close();
?>

