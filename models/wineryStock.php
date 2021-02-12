<?php
require "../root/master.php";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: x-API-KEY, Origin, Authorization,X-Request-With, Content-Type, Accept, Access-Control-Request-Method');

// Inserta registros a la base de datos
if ($_POST['METHOD']=='POST') {
    unset($_POST['METHOD']);
    $BdgId = __ChainFilter($_POST['BdgId']);
    $ExtId = __ChainFilter($_POST['ExtId']);
    $ExtStockEbo = __ChainFilter($_POST['ExtStockEbo']);
    $query = "INSERT INTO sumi_bodegaxusuario05(ExtId, BdgId, ExbStockEbo) VALUES('$ExtId', '$BdgId', '$ExbStockEbo')";
    $idAutoincrement = "SELECT *, MAX(BxUId) AS BxUId FROM sumi_bodegaxusuario05";
    $res = methodPost($query, $idAutoincrement);
    echo json_encode($res);
    header("HTTP/1.1 200 ok");
    exit();
}

// Actualiza la información de un registro mediante el id
if ($_POST['METHOD']=='PUT') {
    unset($_POST['METHOD']);
    $id = $_GET['id'];
    $BdgId = __ChainFilter($_POST['BdgId']);
    $ExtId = __ChainFilter($_POST['ExtId']);
    $ExtStockEbo = __ChainFilter($_POST['ExtStockEbo']);
    $query = "UPDATE sumi_bodegaxusuario05 SET ExtId = '$ExtId', BdgId ='$BdgId', ExbStockEbo = '$ExbStockEbo' WHERE BxUId = '$id'";
    $res = methodPut($query);
    echo json_encode($res);
    header("HTTP/1.1 200 ok");
    exit();
}

// Elimina el registro solicitado mediante su id
if ($_POST['METHOD']=='DELETE') {
    unset($_POST['METHOD']);
    $id = $_GET['id'];
    $query = "DELETE FROM sumi_bodegaxusuario05 WHERE BxUId = '$id'";
    $res = methodDelete($query);
    echo json_encode($res);
    header("HTTP/1.1 200 ok");
    exit();
}

header("HTTP/1.1 400 Bad Request");
