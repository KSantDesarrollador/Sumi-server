<?php
require "../root/master.php";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: x-API-KEY, Origin, Authorization,X-Request-With, Content-Type, Accept, Access-Control-Request-Method');

// Consulta a la base de datos para traer los datos
if ($_SERVER['REQUEST_METHOD']=='GET') {
    if (isset($_GET['id'])) {
        $query = "SELECT * FROM sumi_unidadmedica23 WHERE UmdId=".$_GET['id'];
        $res = methodGet($query);
        echo json_encode($res->fetch(PDO::FETCH_ASSOC));
    } else {
        $query = "SELECT * FROM sumi_unidadmedica23";
        $res = methodGet($query);
        echo json_encode($res->fetchAll());
    }
    header("HTTP/1.1 200 ok");
    exit();
}


// Inserta registros a la base de datos
if ($_POST['METHOD']=='POST') {
    unset($_POST['METHOD']);
    $UmdIdentUdm = __ChainFilter($_POST['UmdIdentUdm']);
    $UmdNomUdm = __ChainFilter($_POST['UmdNomUdm']);
    $UmdTelfUdm = __ChainFilter($_POST['UmdTelfUdm']);
    $UmdDirUdm = __ChainFilter($_POST['UmdDirUdm']);
    $UmdEmailUdm = __ChainFilter($_POST['UmdEmailUdm']);

    $query = "INSERT INTO sumi_unidadmedica23(UmdIdentUdm, UmdNomUdm, UmdTelfUdm, UmdDirUdm, UmdEmailUdm) 
        VALUES('$UmdIdentUdm', '$UmdNomUdm', '$UmdTelfUdm', '$UmdDirUdm', '$UmdEmailUdm')";
    $idAutoincrement = "SELECT *, MAX(UmdId) AS UmdId FROM sumi_unidadmedica23";
    $res = methodPost($query, $idAutoincrement);
    
    echo json_encode($res);
    header("HTTP/1.1 200 ok");
    exit();
}

// Actualiza la información de un registro mediante el id
if ($_POST['METHOD']=='PUT') {
    unset($_POST['METHOD']);
    $id = $_GET['id'];
    $UmdIdentUdm = __ChainFilter($_POST['UmdIdentUdm']);
    $UmdNomUdm = __ChainFilter($_POST['UmdNomUdm']);
    $UmdTelfUdm = __ChainFilter($_POST['UmdTelfUdm']);
    $UmdDirUdm = __ChainFilter($_POST['UmdDirUdm']);
    $UmdEmailUdm = __ChainFilter($_POST['UmdEmailUdm']);
    $UmdEstUdm = __ChainFilter($_POST['UmdEstUdm']);
    
    $query = "UPDATE sumi_unidadmedica23 SET UmdIdentUdm = '$UmdIdentUdm', UmdNomUdm = '$UmdNomUdm',
        UmdTelfUdm = '$UmdTelfUdm', UmdDirUdm = '$UmdDirUdm', UmdEmailUdm = '$UmdEmailUdm',
        UmdEstUdm = '$UmdEstUdm' WHERE UmdId = '$id'";
    $res = methodPut($query);
    
    echo json_encode($res);
    header("HTTP/1.1 200 ok");
    exit();
}

// Elimina el registro solicitado mediante su id
if ($_POST['METHOD']=='DELETE') {
    unset($_POST['METHOD']);
    $id = $_GET['id'];
    $query = "DELETE FROM sumi_unidadmedica23 WHERE UmdId = '$id'";
    $res = methodDelete($query);
    echo json_encode($res);
    header("HTTP/1.1 200 ok");
    exit();
}

header("HTTP/1.1 400 Bad Request");
