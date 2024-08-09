<?php
session_start();

// Verificar que se haya recibido un valor de recarga
if (isset($_POST['valor_recarga'])) {
    $valor_recarga = intval($_POST['valor_recarga']);
    $_SESSION['valor_recarga'] = $valor_recarga;
    header("Location: codigoqr.php");
    exit();
} else {
    // Redirigir a la página de recarga si no se ha recibido un valor
    header("Location: recarga.php");
    exit();
}
