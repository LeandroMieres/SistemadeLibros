<?php
include('config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isbn = $_POST['isbn'];
    $titulo = $_POST['titulo'];
    $genero = $_POST['genero'];
    $autor = $_POST['autor'];

    $sql = "UPDATE libros SET titulo = ?, genero = ? WHERE isbn = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('sss', $titulo, $genero, $isbn);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        die("Error al actualizar el libro: " . $conexion->error);
    }
} else {
    // Manejar el caso en el que no se envían datos por POST
    echo "Acceso no autorizado.";
}
