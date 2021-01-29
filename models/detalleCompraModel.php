<?php
require "../root/master.php";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: x-API-KEY, Origin, Authorization,X-Request-With, Content-Type, Accept, Access-Control-Request-Method');

// Consulta a la base de datos para traer los datos
if ($_SERVER['REQUEST_METHOD']=='GET') {
    if (isset($_GET['id'])) {
        $query = "SELECT * FROM sumi_vistadetallecompra WHERE DocId=".$_GET['id'];
        $res = methodGet($query);
        echo json_encode($res->fetch(PDO::FETCH_ASSOC));
    } elseif (isset($_GET['med'])) {
        $query = "SELECT MdcId, MdcDescMed FROM sumi_productos15";
        $res = methodGet($query);
        echo json_encode($res->fetchAll());
    } else {
        $query = "SELECT * FROM sumi_vistadetallecompra";
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
    //  $CmpId = __ChainFilter($_POST['CmpId']);
    $DocCantOcp = __ChainFilter($_POST['DocCantOcp']);
    $DocValorUntOcp = __ChainFilter($_POST['DocValorUntOcp']);
    $DocValorTotOcp = ((float)$DocCantOcp * (float)$DocValorUntOcp);
    $DocObservOcp = __ChainFilter($_POST['DocObservOcp']);

    $query = "INSERT INTO sumi_detallecompras08(MdcId, DocCantOcp, DocValorUntOcp, 
        DocValorTotOcp, DocObservOcp) 
        VALUES('$MdcId', '$DocCantOcp', '$DocValorUntOcp', '$DocValorTotOcp', 
        '$DocObservOcp')";
    $idAutoincrement = "SELECT *, MAX(DocId) AS DocId FROM sumi_detallecompras08";
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
    $DocCantOcp = __ChainFilter($_POST['DocCantOcp']);
    $DocValorUntOcp = __ChainFilter($_POST['DocValorUntOcp']);
    $DocValorTotOcp = ((float)$DocCantOcp * (float)$DocValorUntOcp);
    $DocObservOcp = __ChainFilter($_POST['DocObservOcp']);
    $DocEstOcp = __ChainFilter($_POST['DocEstOcp']);
    
    $query = "UPDATE sumi_detallecompras08 SET MdcId = $MdcId, DocCantOcp = '$DocCantOcp', 
        DocValorUntOcp = '$DocValorUntOcp', DocValorTotOcp = '$DocValorTotOcp', DocObservOcp = '$DocObservOcp', 
        DocEstOcp = '$DocEstOcp' WHERE DocId = '$id'";
    $res = methodPut($query);
    
    echo json_encode($res);
    header("HTTP/1.1 200 ok");
    exit();
}

// Elimina el registro solicitado mediante su id
if ($_POST['METHOD']=='DELETE') {
    unset($_POST['METHOD']);
    $id = $_GET['id'];
    $query = "DELETE FROM sumi_detallecompras08 WHERE DocId = '$id'";
    $res = methodDelete($query);
    echo json_encode($res);
    header("HTTP/1.1 200 ok");
    exit();
}

header("HTTP/1.1 400 Bad Request");
