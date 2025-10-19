<?php
require_once 'php/funcionesBD.php';

//CREATE DATABASE and Table
if (isset($_POST['crear'])) {
    crearBDDyTabla($conn, $database);
}

// Search
$buscar = $_GET['buscar'] ?? "";
$resultado = leerComics($conn, $buscar);

// Insert
if (isset($_POST['insertar'])) {
    insertarComic($conn, $coleccion, $numero, $guionista, $dibujante, $fecha, $precio);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Comics</title>
</head>
<body>
    <form method="post">
        <h1>CRUD de Comics</h1>
        <button type="submit" name="crear" value="crear">Crear Base de Datos y Tabla</button>
    </form>
    <hr>
    <form method="get">
        <h2>Buscar</h2>
        <select name="buscarOpcion" for="option">
            <option value="coleccion" <?= ($_GET['buscarOpcion'] ?? '') === 'coleccion' ? 'selected' : '' ?> >Coleccion</option>
            <option value="guionista" <?= ($_GET['buscarOpcion'] ?? '') === 'guionista' ? 'selected' : '' ?>>Guionista</option>
            <option value="dibujante" <?= ($_GET['buscarOpcion'] ?? '') === 'dibujante' ? 'selected' : '' ?>>Dibujante</option>
        </select>
        <input type="text" name="buscar" placeholder="Buscar..." value="<?= htmlspecialchars($_GET['buscar'] ?? '') ?>">
        <button type="submit" name="filtrar">Filtrar</button>
    </form>

    <hr>
    <form action="/php/funcionesBD.php" method="get">
        <h2>Lisatado de Comics</h2>
        <table>
        <tr>
            <th>ID</th><th>Colección</th><th>Número</th><th>Guionista</th><th>Dibujante</th>
            <th>Fecha</th><th>Precio</th><th colspan="2">Acciones</th>
        </tr>
        
        <tr>
            <td><?= $fila['id'] ?></td>
            <td><?= htmlspecialchars($fila['coleccion']) ?></td>
            <td><?= $fila['numero'] ?></td>
            <td><?= htmlspecialchars($fila['guionista']) ?></td>
            <td><?= htmlspecialchars($fila['dibujante']) ?></td>
            <td><?= $fila['fecha_publicacion'] ?></td>
            <td><?= $fila['precio'] ?> €</td>
            <td><a href="editar.php?id=<?= $fila['id'] ?>">Editar</a></td>
            <td><a href="borrar.php?id=<?= $fila['id'] ?>" onclick="return confirm('¿Seguro que quieres borrar?')">Borrar</a></td>
        </tr>
         
        </table>
    </form>
    <hr>

    <form method="post">
        <h2>Insertar Nuevo Comic</h2>
        <label>Coleccion: </label><input type="text" name="coleccion"><br>
        <label>Numero: </label><input type="number" name="numero"><br>
        <label>Guionista:</label><input type="text" name="guionista"><br>
        <label>Dibujante:</label><input type="text" name="dibujante"><br>
        <label>Fecha: </label><input type="date" name="fecha"><br>
        <label>Precio: </label><input type="number" name="precio"><br>
        <button type="submit" name="insertar" value="Insertar">Insertar</button>
    </form>
</body>
</html>