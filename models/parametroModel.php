<?php
require "../root/master.php";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: x-API-KEY, Origin, Authorization,X-Request-With, Content-Type, Accept, Access-Control-Request-Method');

// Consulta a la base de datos para traer los datos
if ($_SERVER['REQUEST_METHOD']=='GET') {
    if (isset($_GET['id'])) {
        $query = "SELECT * FROM sumi_vistaparametros WHERE PmtId=".$_GET['id'];
        $res = methodGet($query);
        echo json_encode($res->fetch(PDO::FETCH_ASSOC));
    } elseif (isset($_GET['med'])) {
        $query = "SELECT MdcId, MdcDescMed FROM sumi_productos15";
        $res = methodGet($query);
        echo json_encode($res->fetchAll());
    } elseif (isset($_GET['alt'])) {
        $query = "SELECT AltId, AltNomAle FROM sumi_alerta01";
        $res = methodGet($query);
        echo json_encode($res->fetchAll());
    } else {
        $query = "SELECT * FROM sumi_vistaparametros";
        $res = methodGet($query);
        echo json_encode($res->fetchAll());
    }
    header("HTTP/1.1 200 ok");
    exit();
}

// Inserta registros a la base de datos
if ($_POST['METHOD']=='POST') {
    unset($_POST['METHOD']);
    $MdcId = __ChainFilter($_POST['MdcId']);
    $AltId = __ChainFilter($_POST['AltId']);
    $PmtMinPar = __ChainFilter($_POST['PmtMinPar']);
    $PmtMaxPar = __ChainFilter($_POST['PmtMaxPar']);
    $query = "INSERT INTO sumi_parametros18(MdcId, AltId, PmtMinPar, PmtMaxPar) VALUES('$MdcId', '$AltId', '$PmtMinPar', '$PmtMaxPar')";
    $idAutoincrement = "SELECT *, MAX(PmtId) AS PmtId FROM sumi_parametros18";
    $res = methodPost($query, $idAutoincrement);
    echo json_encode($res);
    header("HTTP/1.1 200 ok");
    exit();
}

// Actualiza la información de un registro mediante el id
if ($_POST['METHOD']=='PUT') {
    unset($_POST['METHOD']);
    $id = $_GET['id'];
    $MdcId = __ChainFilter($_POST['MdcId']);
    $AltId = __ChainFilter($_POST['AltId']);
    $PmtMinPar = __ChainFilter($_POST['PmtMinPar']);
    $PmtMaxPar = __ChainFilter($_POST['PmtMaxPar']);
    $query = "UPDATE sumi_parametros18 SET MdcId = '$MdcId', AltId ='$AltId', PmtMinPar = '$PmtMinPar', PmtMaxPar = '$PmtMaxPar' WHERE PmtId = '$id'";
    $res = methodPut($query);
    echo json_encode($res);
    header("HTTP/1.1 200 ok");
    exit();
}

// Elimina el registro solicitado mediante su id
if ($_POST['METHOD']=='DELETE') {
    unset($_POST['METHOD']);
    $id = $_GET['id'];
    $query = "DELETE FROM sumi_parametros18 WHERE PmtId = '$id'";
    $res = methodDelete($query);
    echo json_encode($res);
    header("HTTP/1.1 200 ok");
    exit();
}

header("HTTP/1.1 400 Bad Request");
