<?php
include('config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['isbn'])) {
    $isbn = $_GET['isbn'];

    $sql = "SELECT * FROM libros WHERE isbn = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('s', $isbn);

    if ($stmt->execute()) {
        $resultado = $stmt->get_result();
        $libro = $resultado->fetch_assoc();
        $stmt->close();

?>
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="style.css">
            <title>Editar Libro</title>
        </head>

        <body>
            <h2>Editar Libro</h2>
            <form action="actualizar.php" method="post">
                <input type="hidden" name="isbn" value="<?php echo htmlspecialchars($libro['isbn'])?>">
                <input type="text" name="titulo" value="<?php echo htmlspecialchars($libro['titulo'])?>">
                <input type="text" name="genero" value="<?php echo htmlspecialchars($libro['genero'])?>">
                <input type="submit" value="Guardar Cambios">

            </form>
        </body>

        </html>
<?php
    } else {
        die("Error al obtener detalles del libro: " . $conexion->error);
    }
} else {
    // Manejar el caso en el que no se proporciona el ISBN
    echo "ISBN no proporcionado.";
}
?>