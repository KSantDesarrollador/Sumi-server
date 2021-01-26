<?php
require "../root/master.php";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: x-API-KEY, Origin, Authorization,X-Request-With, Content-Type, Accept, Access-Control-Request-Method');

// Consulta a la base de datos para traer los datos
if ($_SERVER['REQUEST_METHOD']=='GET') {
    if (isset($_GET['id'])) {
        $query = "SELECT * FROM sumi_proveedor19 WHERE PvdId=".$_GET['id'];
        $res = methodGet($query);
        echo json_encode($res->fetch(PDO::FETCH_ASSOC));
    } else {
        $query = "SELECT * FROM sumi_proveedor19";
        $res = methodGet($query);
        echo json_encode($res->fetchAll());
    }
    header("HTTP/1.1 200 ok");
    exit();
}


// Inserta registros a la base de datos
if ($_POST['METHOD']=='POST') {
    unset($_POST['METHOD']);
    $PvdTipProv = __ChainFilter($_POST['PvdTipProv']);
    $PvdIdentProv = __ChainFilter($_POST['PvdIdentProv']);
    $PvdRazSocProv = __ChainFilter($_POST['PvdRazSocProv']);
    $PvdTelfProv = __ChainFilter($_POST['PvdTelfProv']);
    $PvdDirProv = __ChainFilter($_POST['PvdDirProv']);
    $PvdEmailProv = __ChainFilter($_POST['PvdEmailProv']);
    $PvdPerContProv = __ChainFilter($_POST['PvdPerContProv']);
    $PvdCarContProv = __ChainFilter($_POST['PvdCarContProv']);

    $query = "INSERT INTO sumi_productos15(PvdTipProv, PvdIdentProv, PvdRazSocProv, PvdTelfProv, 
        PvdDirProv, PvdEmailProv, PvdPerContProv, PvdCarContProv) 
        VALUES('$PvdTipProv', '$PvdIdentProv', '$PvdRazSocProv', '$PvdTelfProv', '$PvdDirProv', 
        '$PvdEmailProv', '$PvdPerContProv', '$PvdCarContProv')";
    $idAutoincrement = "SELECT *, MAX(PvdId) AS PvdId FROM sumi_proveedor19";
    $res = methodPost($query, $idAutoincrement);
    

    echo json_encode($res);
    header("HTTP/1.1 200 ok");
    exit();
}

// Actualiza la información de un registro mediante el id
if ($_POST['METHOD']=='PUT') {
    unset($_POST['METHOD']);
    $id = $_GET['id'];
    $PvdTipProv = __ChainFilter($_POST['PvdTipProv']);
    $PvdIdentProv = __ChainFilter($_POST['PvdIdentProv']);
    $PvdRazSocProv = __ChainFilter($_POST['PvdRazSocProv']);
    $PvdTelfProv = __ChainFilter($_POST['PvdTelfProv']);
    $PvdDirProv = __ChainFilter($_POST['PvdDirProv']);
    $PvdEmailProv = __ChainFilter($_POST['PvdEmailProv']);
    $PvdPerContProv = __ChainFilter($_POST['PvdPerContProv']);
    $PvdCarContProv = __ChainFilter($_POST['PvdCarContProv']);
    $PvdEstProv = __ChainFilter($_POST['PvdEstProv']);
    
    $query = "UPDATE sumi_productos15 SET PvdTipProv = '$PvdTipProv', PvdIdentProv = '$PvdIdentProv',
        PvdRazSocProv = '$PvdRazSocProv', PvdTelfProv = '$PvdTelfProv', PvdDirProv = '$PvdDirProv',
        PvdEmailProv = '$PvdEmailProv', PvdPerContProv = '$PvdPerContProv', PvdCarContProv = '$PvdCarContProv',
        PvdEstProv = '$PvdEstProv' WHERE PvdId = '$id'";
    $res = methodPut($query);
    
    echo json_encode($res);
    header("HTTP/1.1 200 ok");
    exit();
}

// Elimina el registro solicitado mediante su id
if ($_POST['METHOD']=='DELETE') {
    unset($_POST['METHOD']);
    $id = $_GET['id'];
    $query = "DELETE FROM sumi_productos15 WHERE PvdId = '$id'";
    $res = methodDelete($query);
    echo json_encode($res);
    header("HTTP/1.1 200 ok");
    exit();
}

header("HTTP/1.1 400 Bad Request");
