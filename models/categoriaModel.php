<?php
require "../root/master.php";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: x-API-KEY, Origin, Authorization,X-Request-With, Content-Type, Accept, Access-Control-Request-Method');

// Consulta a la base de datos para traer los datos
if ($_SERVER['REQUEST_METHOD']=='GET') {
    if (isset($_GET['id'])) {
        $query = "SELECT * FROM sumi_categoria06 WHERE CtgId=".$_GET['id'];
        $res = methodGet($query);
        echo json_encode($res->fetch(PDO::FETCH_ASSOC));
    } else {
        $query = "SELECT * FROM sumi_categoria06";
        $res = methodGet($query);
        echo json_encode($res->fetchAll());
    }
    header("HTTP/1.1 200 ok");
    exit();
}

// Inserta registros a la base de datos
if ($_POST['METHOD']=='POST') {
    unset($_POST['METHOD']);
    $CtgNomCat = __ChainFilter($_POST['CtgNomCat']);
    $CtgColorCat = __ChainFilter($_POST['CtgColorCat']);
    $query = "INSERT INTO sumi_categoria06(CtgNomCat, CtgColorCat) VALUES('$CtgNomCat', '$CtgColorCat')";
    $idAutoincrement = "SELECT *, MAX(CtgId) AS CtgId FROM sumi_categoria06";
    $res = methodPost($query, $idAutoincrement);
    echo json_encode($res);
    header("HTTP/1.1 200 ok");
    exit();
}

// Actualiza la información de un registro mediante el id
if ($_POST['METHOD']=='PUT') {
    unset($_POST['METHOD']);
    $id = $_GET['id'];
    $CtgNomCat = __ChainFilter($_POST['CtgNomCat']);
    $CtgColorCat = __ChainFilter($_POST['CtgColorCat']);
    $CtgEstCat = __ChainFilter($_POST['CtgEstCat']);
    $query = "UPDATE sumi_categoria06 SET CtgNomCat = '$CtgNomCat', CtgColorCat ='$CtgColorCat', CtgEstCat = '$CtgEstCat' WHERE CtgId = '$id'";
    $res = methodPut($query);
    echo json_encode($res);
    header("HTTP/1.1 200 ok");
    exit();
}

// Elimina el registro solicitado mediante su id
if ($_POST['METHOD']=='DELETE') {
    unset($_POST['METHOD']);
    $id = $_GET['id'];
    $query = "DELETE FROM sumi_categoria06 WHERE CtgId = '$id'";
    $res = methodDelete($query);
    echo json_encode($res);
    header("HTTP/1.1 200 ok");
    exit();
}

header("HTTP/1.1 400 Bad Request");
