<?php
require_once "bdConfig.php";

// Conexión sa la base de datos
function conectBd()
{
    try {
        // Cadena de conexíon
        $GLOBALS['pdo'] = new PDO("mysql:host=".$GLOBALS['host'].";dbname=".$GLOBALS['bd']."", $GLOBALS['user'], $GLOBALS['password']);
        $GLOBALS['pdo']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        print "Error!: No se puede conectar a la base de datos".$bd."<br/>";
        print "\nError!: ".$e."<br/>";
        die();
    }
}

// Desconexión de la base de datos
function disconectBd()
{
    $GLOBALS['pdo']=null;
}

// función que retorna los datos solicitados
function methodGet($query)
{
    try {
        conectBd();
        $statement = $GLOBALS['pdo']->prepare($query);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute();
        disconectBd();
        return $statement;
    } catch (Exception $e) {
        die("Error: ".$e);
    }
}

// función que envía los datos enviados desde formularios
function methodPost($query, $idAutoincrement)
{
    try {
        conectBd();
        $statement = $GLOBALS['pdo']->prepare($query);
        $statement->execute();
        $idIncrementable = methodGet($idAutoincrement)->fetch(PDO::FETCH_ASSOC);
        $respuesta = array_merge($idIncrementable, $_POST);
        $statement->closeCursor();
        disconectBd();
        return $respuesta;
    } catch (Exception $e) {
        die("Error: ".$e);
    }
}

// función que registra los datos enviados
function methodPut($query)
{
    try {
        conectBd();
        $statement = $GLOBALS['pdo']->prepare($query);
        $statement->execute();
        $respuesta = array_merge($_GET, $_POST);
        $statement->closeCursor();
        disconectBd();
        return $respuesta;
    } catch (Exception $e) {
        die("Error: ".$e);
    }
}

// función que elimina los datos solicitados
function methodDelete($query)
{
    try {
        conectBd();
        $statement = $GLOBALS['pdo']->prepare($query);
        $statement->execute();
        $statement->closeCursor();
        disconectBd();
        return $_GET['id'];
    } catch (Exception $e) {
        die("Error: ".$e);
    }
}
