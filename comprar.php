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
$sql = "SELECT id, saldo FROM usuarios1 WHERE telefono = '$telefono'";
$result = $conn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
    $usuario_id = $row['id'];
    $saldo = $row['saldo'];
} else {
    echo "Usuario no encontrado.";
    exit();
}

// Obtener el ID de la máquina desde el formulario
$maquina_id = $_POST['maquina_id'] ?? 0; // Asegúrate de que $maquina_id tenga un valor válido

// Obtener la información de la máquina
$sql = "SELECT nombre, precio, ganancias_diarias FROM maquinas WHERE id = '$maquina_id'";
$result = $conn->query($sql);

if (!$result) {
    echo "Error en la consulta: " . $conn->error;
    exit();
}

if ($result->num_rows == 1) {
    $maquina = $result->fetch_assoc();
    $nombre = $maquina['nombre'];
    $precio = $maquina['precio'];
    $ganancias_diarias = $maquina['ganancias_diarias'];

    // Verificar si el usuario tiene suficiente saldo
    if ($saldo >= $precio) {
        // Comenzar una transacción
        $conn->begin_transaction();

        try {
            // Insertar la compra en la base de datos
            $sql = "INSERT INTO compras (usuario_id, maquina_id, precio, ganancias_diarias, fecha_compra) 
                    VALUES ('$usuario_id', '$maquina_id', '$precio', '$ganancias_diarias', NOW())";
            if ($conn->query($sql) === TRUE) {
                // Actualizar el saldo del usuario
                $nuevo_saldo = $saldo - $precio;
                $sql = "UPDATE usuarios1 SET saldo = '$nuevo_saldo' WHERE id = '$usuario_id'";
                if ($conn->query($sql) === TRUE) {
                    // Confirmar la transacción
                    $conn->commit();

                    // Redirigir a la página de éxito
                    header('Location: exito.php');
                    exit();
                } else {
                    throw new Exception("Error al actualizar el saldo: " . $conn->error);
                }
            } else {
                throw new Exception("Error al insertar la compra: " . $conn->error);
            }
        } catch (Exception $e) {
            // Revertir la transacción en caso de error
            $conn->rollback();
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Saldo insuficiente para realizar la compra.";
    }
} else {
    echo "Máquina no encontrada.";
}

$conn->close();
?>
