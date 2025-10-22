<?php

require_once 'conexionBD.php';

function crearBDDyTabla($conn, $database){
    try{
        $conn->query("CREATE DATABASE IF NOT EXISTS $database");
        $conn->select_db($database);
        $conn->query("CREATE TABLE IF NOT EXISTS comic(
            id INT AUTO_INCREMENT PRIMARY KEY,
            coleccion VARCHAR(50),
            numero INT,
            guionista VARCHAR(50),
            dibujante VARCHAR(50),
            fecha_publi DATE,
            precio DECIMAL(5,2)         
        )");
        echo"<p>Base de datos y tabla creados correctamente.</p>";
    
    }catch(Exception $e){
        die("<p>Error de crear BDD o tabla ". $e->getMessage() . "</p>");
    }
}

function insertarComic($conn, $coleccion, $numero, $guionista, $dibujante, $fecha, $precio){
    $conn->select_db($database);
    $stmt = $conn->prepare("INSERT INTO comic (coleccion, numero, guionista, dibujante, fecha_publicacion, precio) VALUES (?, ?, ?, ?, ?, ?)");
    //sisssd: (string, int, string, string, string, double)
    $stmt->bind_param("sisssd", $coleccion, $numero, $guionista, $dibujante, $fecha, $precio);
    $stmt->execute();
}
// I have 3 option to search for a book by name of the coleccion, guionista or dibujante 
function leerComics($conn, $buscar = "", $buscarOpcion = "coleccion"){
    global $database;
    $conn->select_db($database);
    
    $options = ["coleccion", "guionista", "dibujante"];
    if(!in_array($buscarOpcion, $options)){
        $buscarOpcion = "coleccion"; // default option
    }

    $sql = "SELECT * FROM comic";
    if ($buscar !== "") {
        $sql .= " WHERE $buscarOpcion LIKE ?";
        $stmt = $conn->prepare($sql);
        $param = "%$buscar%";
        //searching with string so "s"
        $stmt->bind_param("s", $param);
        $stmt->execute();
        return $stmt->get_result();
    }
    //return $conn->query($sql);
}



function actualizarComic($conn, $id, $coleccion, $numero, $guionista, $dibujante, $fecha, $precio) {
    $stmt = $conn->prepare("UPDATE comic SET coleccion=?, numero=?, guionista=?, dibujante=?, fecha_publicacion=?, precio=? WHERE id=?");
    $stmt->bind_param("sisssdi", $coleccion, $numero, $guionista, $dibujante, $fecha, $precio, $id);
    $stmt->execute();
}

function borrarComic($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM comic WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

?>
