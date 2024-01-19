<?php
include('config/conexion.php');

function obtenerLibros($conexion)
{
    $libros = array();

    $sql = "SELECT libros.isbn, libros.titulo, libros.genero, autores.autor
            FROM libros
            INNER JOIN autores ON libros.cod_autor = autores.cod_autor";

    $stmt = $conexion->prepare($sql);

    if ($stmt) {
        $stmt->execute();
        $resultado = $stmt->get_result();

        while ($fila = $resultado->fetch_assoc()) {
            $libros[] = $fila;
        }

        $stmt->close();
    } else {
        die("Error en la preparación de la consulta: " . $conexion->error);
    }

    return $libros;
}

$libros = obtenerLibros($conexion);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>CRUD libros</title>
</head>

<body>
    <table>
        <tr>
            <th>ISBN</th>
            <th>TITULO</th>
            <th>GENERO</th>
            <th>AUTOR</th>
            <th></th>
        </tr>
        <?php foreach ($libros as $libro) { ?>
            <tr>
                <td><?php echo htmlspecialchars($libro['isbn']) ?></td>
                <td><?php echo htmlspecialchars($libro['titulo']) ?></td>
                <td><?php echo htmlspecialchars($libro['genero']) ?></td>
                <td><?php echo htmlspecialchars($libro['autor']) ?></td>
                <td>
                    <a class="editar-btn" href="editar.php?isbn=<?php echo urlencode($libro['isbn']) ?>">Editar</a>
                    <a class="eliminar-btn" href="eliminar.php?isbn=<?php echo urlencode($libro['isbn']) ?>">Eliminar</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>