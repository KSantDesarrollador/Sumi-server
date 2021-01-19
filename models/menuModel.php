<?php
require "../root/master.php";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: x-API-KEY, Origin, Authorization,X-Request-With, Content-Type, Accept, Access-Control-Request-Method');

// Consulta a la base de datos para traer los datos
if ($_SERVER['REQUEST_METHOD']=='GET') {
    if (isset($_GET['id'])) {
        $query = "SELECT * FROM sumi_vistamenu WHERE MnuId=".$_GET['id'];
        $res = methodGet($query);
        echo json_encode($res->fetch(PDO::FETCH_ASSOC));
    //  } elseif (condition) {
   //      # code...
    } else {
        $query = "SELECT * FROM sumi_vistamenu";
        $res = methodGet($query);
        echo json_encode($res->fetchAll());
    }
    header("HTTP/1.1 200 ok");
    exit();
}

// Inserta registros a la base de datos
if ($_POST['METHOD']=='POST') {
    unset($_POST['METHOD']);
    $MnuJerqMen = __ChainFilter($_POST['MnuJerqMen']);
    $MnuNomMen = __ChainFilter($_POST['MnuNomMen']);
    $MnuNivelMen = __ChainFilter($_POST['MnuNivelMen']);
    $MnuIconMen = __ChainFilter($_POST['MnuIconMen']);
    $MnuUrlMen = __ChainFilter($_POST['MnuUrlMen']);
    $MnuLeyendMen = __ChainFilter($_POST['MnuLeyendMen']);
    $query = "INSERT INTO sumi_menu16(MnuJerqMen, MnuNomMen, MnuNivelMen, MnuIconMen, MnuUrlMen, MnuLeyendMen) VALUES('$MnuJerqMen', '$MnuNomMen', '$MnuNivelMen', '$MnuIconMen', '$MnuUrlMen', '$MnuLeyendMen')";
    $idAutoincrement = "SELECT *, MAX(MnuId) AS MnuId FROM sumi_menu16";
    $res = methodPost($query, $idAutoincrement);
    echo json_encode($res);
    header("HTTP/1.1 200 ok");
    exit();
}

// Actualiza la información de un registro mediante el id
if ($_POST['METHOD']=='PUT') {
    unset($_POST['METHOD']);
    $id = $_GET['id'];
    $MnuJerqMen = __ChainFilter($_POST['MnuJerqMen']);
    $MnuNomMen = __ChainFilter($_POST['MnuNomMen']);
    $MnuNivelMen = __ChainFilter($_POST['MnuNivelMen']);
    $MnuIconMen = __ChainFilter($_POST['MnuIconMen']);
    $MnuUrlMen = __ChainFilter($_POST['MnuUrlMen']);
    $MnuLeyendMen = __ChainFilter($_POST['MnuLeyendMen']);
    $MnuEstMen = __ChainFilter($_POST['MnuEstMen']);
    $query = "UPDATE sumi_menu16 SET MnuJerqMen = '$MnuJerqMen', MnuNomMen = '$MnuNomMen', MnuNivelMen = '$MnuNivelMen', MnuIconMen = '$MnuIconMen', MnuUrlMen = '$MnuUrlMen', MnuLeyendMen = '$MnuLeyendMen', MnuEstMen = '$MnuEstMen' WHERE MnuId = '$id'";
    $res = methodPut($query);
    echo json_encode($res);
    header("HTTP/1.1 200 ok");
    exit();
}

// Elimina el registro solicitado mediante su id
if ($_POST['METHOD']=='DELETE') {
    unset($_POST['METHOD']);
    $id = $_GET['id'];
    $query = "DELETE FROM sumi_menu16 WHERE MnuId = '$id'";
    $res = methodDelete($query);
    echo json_encode($res);
    header("HTTP/1.1 200 ok");
    exit();
}

header("HTTP/1.1 400 Bad Request");
