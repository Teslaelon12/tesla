<?php
session_start();
require_once 'conexion.php';

// Verifica si el usuario está logueado
if (!isset($_SESSION['telefono'])) {
    header('Location: inicio_sesion.php');
    exit();
}

$telefono = $_SESSION['telefono'];
$codigo_referencia = $_POST['codigo_referencia'];

// Verificar que el código de referencia no esté vacío
if (empty($codigo_referencia)) {
    header('Location: ingresar_referencia.php?error=El código de referencia es requerido');
    exit();
}

// Escapar los valores para evitar inyecciones SQL
$codigo_referencia = $conn->real_escape_string($codigo_referencia);

// Verificar el código de referencia en la base de datos
$sql = "SELECT * FROM referencias WHERE codigo = '$codigo_referencia' AND estado = 'pendiente'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    // Código de referencia encontrado y es válido
    $sql = "UPDATE referencias SET estado = 'verificado', telefono = '$telefono' WHERE codigo = '$codigo_referencia'";
    if ($conn->query($sql) === TRUE) {
        // Generar un número de orden único
        $numero_orden = uniqid('ORD_');
        
        // Insertar el número de orden en la base de datos
        $sql = "INSERT INTO ordenes (codigo_referencia, telefono, numero_orden, estado) VALUES ('$codigo_referencia', '$telefono', '$numero_orden', 'pendiente')";
        if ($conn->query($sql) === TRUE) {
            // Redirigir a una página de procesamiento con mensaje
            header('Location: procesamiento.php?numero_orden=' . $numero_orden);
            exit();
        } else {
            header('Location: ingresar_referencia.php?error=Error al crear la orden');
            exit();
        }
    } else {
        header('Location: ingresar_referencia.php?error=Error al actualizar el código de referencia');
        exit();
    }
} else {
    // Código de referencia no válido o ya usado
    header('Location: ingresar_referencia.php?error=Código de referencia inválido o ya utilizado');
    exit();
}

$conn->close();
?>
