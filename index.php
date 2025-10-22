<?php
require_once 'php/funcionesBD.php';

//CREATE DATABASE and Table
if (isset($_POST['crear'])) {
    crearBDDyTabla($conn, $database);
    header('Location: index.php');
}

// Search


// Insert
if (isset($_POST['insertar'])) {
    $coleccion = $_POST['coleccion'];
    $numero = $_POST['numero'];
    $guionista = $_POST['guionista'];
    $dibujante = $_POST['dibujante'];
    $fecha = $_POST['fecha'];
    $precio = $_POST['precio'];
    insertarComic($conn, $coleccion, $numero, $guionista, $dibujante, $fecha, $precio);

    header('Location: index.php');
}
//Listar
$resultado = $conn->query("SELECT * FROM comic");

//Borrar
if (isset($_GET['borrar_id'])) {
    $id = $_GET['borrar_id'];
    borrarComic($conn, $id);
    header('Location: index.php');
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
            <option value="coleccion"  >Coleccion</option>
            <option value="guionista" >Guionista</option>
            <option value="dibujante" >Dibujante</option>
        </select>
        <input type="text" name="buscar" placeholder="Buscar..." >
        <button type="submit" name="filtrar">Filtrar</button>
    </form>

    <hr>
    <form action="" method="get">
        <h2>Lisatado de Comics</h2>
        <table border = "1">
        <tr>
            <th>ID</th>
            <th>Colección</th>
            <th>Número</th>
            <th>Guionista</th>
            <th>Dibujante</th>
            <th>Fecha</th>
            <th>Precio</th>
            <th colspan="2">Acciones</th>
        </tr>
            <?php 
                if($resultado->num_rows > 0){
                    while($comic = $resultado->fetch_assoc()){
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($comic['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($comic['coleccion']) . "</td>";
                        echo "<td>" . htmlspecialchars($comic['numero']) . "</td>";
                        echo "<td>" . htmlspecialchars($comic['guionista']) . "</td>";
                        echo "<td>" . htmlspecialchars($comic['dibujante']) . "</td>";
                        echo "<td>" . htmlspecialchars($comic['fecha_publi']) . "</td>";
                        echo "<td>" . htmlspecialchars($comic['precio']) . "</td>";
                        echo '<td><a href="">Editar</a></td>';
                        echo '<td><a href="index.php?borrar_id=' . $comic['id'] . '">Borrar</a></td>';
                        echo "</tr>";
                    }

                }else{
                    echo "<tr><td colspan='9'> No hay comics registrados </td></tr>";
                }
               
                     
            ?>
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
