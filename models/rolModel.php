<?php
require "../root/master.php";

header('Access-Control-Allow-Origin: *');

// Consulta a la base de datos para traer los datos
if ($_SERVER['REQUEST_METHOD']=='GET') {
    if (isset($_GET['id'])) {
        $query = "SELECT * FROM ksvmrol02 WHERE RrlId=".$_GET['id'];
        $res = methodGet($query);
        echo json_encode($res->fetch(PDO::FETCH_ASSOC));
    } else {
        $query = "SELECT * FROM ksvmrol02";
        $res = methodGet($query);
        echo json_encode($res->fetchAll());
    }
    header("HTTP/1.1 200 ok");
    exit();
}

// Inserta registros a la base de datos
if ($_POST['METHOD']=='POST') {
    unset($_POST['METHOD']);
    $nomRol = $_POST['RrlNomRol'];
    $query = "INSERT INTO ksvmrol02(RrlNomRol) VALUES('$nomRol')";
    $idAutoincrement = "SELECT MAX(RrlId) AS RrlId, RrlNomRol, RrlEstRol FROM ksvmrol02";
    $res = methodPost($query, $idAutoincrement);
    echo json_encode($res);
    header("HTTP/1.1 200 ok");
    exit();
}

// Actualiza la información de un registro mediante el id
if ($_POST['METHOD']=='PUT') {
    unset($_POST['METHOD']);
    $id = $_GET['id'];
    $nomRol = $_POST['RrlNomRol'];
    $estRol = $_POST['RrlEstRol'];
    $query = "UPDATE ksvmrol02 SET RrlNomRol = '$nomRol', RrlEstRol = '$estRol' WHERE RrlId = '$id'";
    $res = methodPut($query);
    echo json_encode($res);
    header("HTTP/1.1 200 ok");
    exit();
}

// Elimina el registro solicitado mediante su id
if ($_POST['METHOD']=='DELETE') {
    unset($_POST['METHOD']);
    $id = $_GET['id'];
    $query = "DELETE FROM ksvmrol02 WHERE RrlId = '$id'";
    $res = methodDelete($query);
    echo json_encode($res);
    header("HTTP/1.1 200 ok");
    exit();
}

header("HTTP/1.1 400 Bad Request");
