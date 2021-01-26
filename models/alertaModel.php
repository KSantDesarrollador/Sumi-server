<?php
require "../root/master.php";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: x-API-KEY, Origin, Authorization,X-Request-With, Content-Type, Accept, Access-Control-Request-Method');

// Consulta a la base de datos para traer los datos
if ($_SERVER['REQUEST_METHOD']=='GET') {
    if (isset($_GET['id'])) {
        $query = "SELECT * FROM sumi_alerta01 WHERE AltId=".$_GET['id'];
        $res = methodGet($query);
        echo json_encode($res->fetch(PDO::FETCH_ASSOC));
    } else {
        $query = "SELECT * FROM sumi_alerta01";
        $res = methodGet($query);
        echo json_encode($res->fetchAll());
    }
    header("HTTP/1.1 200 ok");
    exit();
}

// Inserta registros a la base de datos
if ($_POST['METHOD']=='POST') {
    unset($_POST['METHOD']);
    $AltNomAle = __ChainFilter($_POST['AltNomAle']);
    $AltColorAle = __ChainFilter($_POST['AltColorAle']);
    $AltDescAle = __ChainFilter($_POST['AltDescAle']);
    $query = "INSERT INTO sumi_alerta01(AltNomAle, AltColorAle, AltDescAle) VALUES('$AltNomAle', '$AltColorAle', '$AltDescAle')";
    $idAutoincrement = "SELECT *, MAX(AltId) AS AltId FROM sumi_alerta01";
    $res = methodPost($query, $idAutoincrement);
    echo json_encode($res);
    header("HTTP/1.1 200 ok");
    exit();
}

// Actualiza la información de un registro mediante el id
if ($_POST['METHOD']=='PUT') {
    unset($_POST['METHOD']);
    $id = $_GET['id'];
    $AltNomAle = __ChainFilter($_POST['AltNomAle']);
    $AltColorAle = __ChainFilter($_POST['AltColorAle']);
    $AltDescAle = __ChainFilter($_POST['AltDescAle']);
    $query = "UPDATE sumi_alerta01 SET AltNomAle = '$AltNomAle', AltColorAle ='$AltColorAle', AltDescAle = '$AltDescAle' WHERE AltId = '$id'";
    $res = methodPut($query);
    echo json_encode($res);
    header("HTTP/1.1 200 ok");
    exit();
}

// Elimina el registro solicitado mediante su id
if ($_POST['METHOD']=='DELETE') {
    unset($_POST['METHOD']);
    $id = $_GET['id'];
    $query = "DELETE FROM sumi_alerta01 WHERE AltId = '$id'";
    $res = methodDelete($query);
    echo json_encode($res);
    header("HTTP/1.1 200 ok");
    exit();
}

header("HTTP/1.1 400 Bad Request");
