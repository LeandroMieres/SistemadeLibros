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
    }

    ?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <title>Eliminar Libro</title>
    </head>

    <body>
        <div class="confirmation-box">
            <h2>Eliminar Libro</h2>
            <?php if (isset($libro)) { ?>
                <p>¿Estás seguro de que deseas eliminar el libro con ISBN: <strong><?= htmlspecialchars($libro['isbn']) ?></strong>?</p>
            <?php } ?>
            <form action="eliminar.php" method="post">
                <input type="hidden" name="isbn" value="<?= htmlspecialchars($isbn) ?>">
                <button type="submit" class="btn-confirm">Confirmar</button>
                <a href="index.php" class="btn-cancel">Cancelar</a>
            </form>
        </div>
    </body>

    </html>
    <?php
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['isbn'])) {
    $isbn = $_POST['isbn'];
    $sql = "DELETE FROM libros WHERE isbn = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('s', $isbn);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        die("Error al eliminar el libro: " . $conexion->error);
    }
} else {
    echo "ISBN no proporcionado.";
}
?>
