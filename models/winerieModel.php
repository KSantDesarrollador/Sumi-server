<?php
require "../root/master.php";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: x-API-KEY, Origin, Authorization,X-Request-With, Content-Type, Accept, Access-Control-Request-Method');

// Consulta a la base de datos para traer los datos
if ($_SERVER['REQUEST_METHOD']=='GET') {
    if (isset($_GET['id'])) {
        $query = "SELECT * FROM sumi_vistabodega WHERE BdgId=".$_GET['id'];
        $res = methodGet($query);
        echo json_encode($res->fetch(PDO::FETCH_ASSOC));
    } else {
        $query = "SELECT * FROM sumi_vistabodega";
        $res = methodGet($query);
        echo json_encode($res->fetchAll());
    }
    header("HTTP/1.1 200 ok");
    exit();
}


// Inserta registros a la base de datos
if ($_POST['METHOD']=='POST') {
    unset($_POST['METHOD']);
    $UmdId = __ChainFilter($_POST['UmdId']);
    $BdgCodBod = __ChainFilter($_POST['BdgCodBod']);
    $BdgDescBod = __ChainFilter($_POST['BdgDescBod']);
    $BdgTelfBod = __ChainFilter($_POST['BdgTelfBod']);
    $BdgDirBod = __ChainFilter($_POST['BdgDirBod']);

    $query = "INSERT INTO sumi_bodega04(UmdId, BdgCodBod, BdgDescBod, BdgTelfBod, BdgDirBod) 
        VALUES('$UmdId', '$BdgCodBod', '$BdgDescBod', '$BdgTelfBod', '$BdgDirBod')";
    $idAutoincrement = "SELECT *, MAX(BdgId) AS BdgId FROM sumi_bodega04";
    $res = methodPost($query, $idAutoincrement);
    
    echo json_encode($res);
    header("HTTP/1.1 200 ok");
    exit();
}

// Actualiza la información de un registro mediante el id
if ($_POST['METHOD']=='PUT') {
    unset($_POST['METHOD']);
    $id = $_GET['id'];
    $UmdId = __ChainFilter($_POST['UmdId']);
    $BdgCodBod = __ChainFilter($_POST['BdgCodBod']);
    $BdgDescBod = __ChainFilter($_POST['BdgDescBod']);
    $BdgTelfBod = __ChainFilter($_POST['BdgTelfBod']);
    $BdgDirBod = __ChainFilter($_POST['BdgDirBod']);
    $BdgEstBod = __ChainFilter($_POST['BdgEstBod']);
    
    $query = "UPDATE sumi_bodega04 SET UmdId = '$UmdId', BdgCodBod = '$BdgCodBod',
        BdgDescBod = '$BdgDescBod', BdgTelfBod = '$BdgTelfBod', BdgDirBod = '$BdgDirBod',
        BdgEstBod = '$BdgEstBod' WHERE BdgId = '$id'";
    $res = methodPut($query);
    
    echo json_encode($res);
    header("HTTP/1.1 200 ok");
    exit();
}

// Elimina el registro solicitado mediante su id
if ($_POST['METHOD']=='DELETE') {
    unset($_POST['METHOD']);
    $id = $_GET['id'];
    $query = "DELETE FROM sumi_bodega04 WHERE BdgId = '$id'";
    $res = methodDelete($query);
    echo json_encode($res);
    header("HTTP/1.1 200 ok");
    exit();
}

header("HTTP/1.1 400 Bad Request");
