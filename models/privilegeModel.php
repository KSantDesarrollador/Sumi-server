<?php
require "../root/master.php";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: x-API-KEY, Origin, Authorization,X-Request-With, Content-Type, Accept, Access-Control-Request-Method');

// Consulta a la base de datos para traer los datos
if ($_SERVER['REQUEST_METHOD']=='GET') {
    if (isset($_GET['id'])) {
        $query = "SELECT * FROM sumi_vistaasignaprivilegios WHERE MxRId=".$_GET['id'];
        $res = methodGet($query);
        echo json_encode($res->fetch(PDO::FETCH_ASSOC));
    } elseif (isset($_GET['rol'])) {
        if ($_GET['rol']==0) {
            $query = "SELECT RrlId, RrlNomRol FROM sumi_rol21";
            $res = methodGet($query);
            echo json_encode($res->fetchAll());
        } else {
            $query = "SELECT RrlNomRol FROM sumi_rol21 WHERE RrlId=".$_GET['rol'];
            $res = methodGet($query);
            echo json_encode($res->fetch(PDO::FETCH_ASSOC));
        }
    } elseif (isset($_GET['menu'])) {
        if ($_GET['menu']==0) {
            $query = "SELECT MnuId, MnuNomMen FROM sumi_menu16 WHERE MnuNivelMen = 0";
            $res = methodGet($query);
            echo json_encode($res->fetchAll());
        } else {
            $query = "SELECT MnuNomMen FROM sumi_menu16 WHERE MnuId =".$_GET['menu'];
            $res = methodGet($query);
            echo json_encode($res->fetch(PDO::FETCH_ASSOC));
        }
    } else {
        $query = "SELECT * FROM sumi_vistaasignaprivilegios";
        $res = methodGet($query);
        echo json_encode($res->fetchAll());
    }
    header("HTTP/1.1 200 ok");
    exit();
}

// Inserta registros a la base de datos
if ($_POST['METHOD']=='POST') {
    unset($_POST['METHOD']);
    $RrlId = __ChainFilter($_POST['RrlId']);
    $MnuId = __ChainFilter($_POST['MnuId']);
    $query = "INSERT INTO sumi_menuxrol17(RrlId, MnuId) VALUES('$RrlId', '$MnuId')";
    $idAutoincrement = "SELECT *, MAX(MxRId) AS MxRId FROM sumi_menuxrol17";
    $res = methodPost($query, $idAutoincrement);
    echo json_encode($res);
    header("HTTP/1.1 200 ok");
    exit();
}

// Actualiza la información de un registro mediante el id
if ($_POST['METHOD']=='PUT') {
    unset($_POST['METHOD']);
    $id = $_GET['id'];
    $RrlId = __ChainFilter($_POST['RrlId']);
    $MnuId = __ChainFilter($_POST['MnuId']);
    $query = "UPDATE sumi_menuxrol17 SET RrlId = '$RrlId', MnuId ='$MnuId' WHERE MxRId = '$id'";
    $res = methodPut($query);
    echo json_encode($res);
    header("HTTP/1.1 200 ok");
    exit();
}

// Elimina el registro solicitado mediante su id
if ($_POST['METHOD']=='DELETE') {
    unset($_POST['METHOD']);
    $id = $_GET['id'];
    $query = "DELETE FROM sumi_menuxrol17 WHERE MxRId = '$id'";
    $res = methodDelete($query);
    echo json_encode($res);
    header("HTTP/1.1 200 ok");
    exit();
}

header("HTTP/1.1 400 Bad Request");
