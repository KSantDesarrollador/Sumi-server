<?php
require "../root/master.php";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: x-API-KEY, Origin, Authorization,X-Request-With, Content-Type, Accept, Access-Control-Request-Method');

// Consulta a la base de datos para traer los datos
if ($_SERVER['REQUEST_METHOD']=='GET') {
    if (isset($_GET['id'])) {
        $query = "SELECT * FROM sumi_vistacompras WHERE CmpId=".$_GET['id'];
        $res = methodGet($query);
        echo json_encode($res->fetch(PDO::FETCH_ASSOC));
    } elseif (isset($_GET['prv'])) {
        $query = "SELECT PvdId, PvdRazSocProv FROM sumi_proveedor19";
        $res = methodGet($query);
        echo json_encode($res->fetchAll());
    } elseif (isset($_GET['udm'])) {
        $query = "SELECT UmdId, UmdNomUdm FROM sumi_unidadmedica23";
        $res = methodGet($query);
        echo json_encode($res->fetchAll());
    } else {
        $query = "SELECT * FROM sumi_vistacompras";
        $res = methodGet($query);
        echo json_encode($res->fetchAll());
    }
    header("HTTP/1.1 200 ok");
    exit();
}


// Inserta registros a la base de datos
if ($_POST['METHOD']=='POST') {
    unset($_POST['METHOD']);

    $idCompra = "SELECT CmpId FROM sumi_compras07";
    $res = methodGet($idCompra);
    $uniqueNum = $res->rowCount();

    $UmdId = __ChainFilter($_POST['UmdId']);
    $CmpNumOcp = __RandomCodeGenerate("0", 5, $uniqueNum);
    $PvdId = __ChainFilter($_POST['PvdId']);
    $CmpFchElabOcp = date("Y-m-d");
    $CmpNumFactOcp = "No registrado";
    $CmpPerElabOcp = __ChainFilter($_POST['CmpPerElabOcp']);
    $UsrId = __ChainFilter($_POST['UsrId']);

    $query = "INSERT INTO sumi_compras07(UmdId, CmpNumOcp, PvdId, CmpFchElabOcp, 
        CmpNumFactOcp, CmpPerElabOcp, UsrId) 
        VALUES('$UmdId', '$CmpNumOcp', '$PvdId', '$CmpFchElabOcp', '$CmpNumFactOcp', 
        '$CmpPerElabOcp', '$UsrId')";
    $idAutoincrement = "SELECT *, MAX(CmpId) AS CmpId FROM sumi_compras07";
    $res = methodPost($query, $idAutoincrement);
    

    echo json_encode($res);
    header("HTTP/1.1 200 ok");
    exit();
}

// Actualiza la información de un registro mediante el id
if ($_POST['METHOD']=='PUT') {
    unset($_POST['METHOD']);
    $id = $_GET['id'];
    $CmpFchRevOcp = date("Y-m-d");
    ;
    $CmpPerAprbOcp = __ChainFilter($_POST['CmpPerAprbOcp']);
    $UsrId = __ChainFilter($_POST['UsrId']);
    $CmpEstOcp = __ChainFilter($_POST['CmpEstOcp']);
    
    $query = "UPDATE sumi_compras07 SET CmpFchRevOcp = '$CmpFchRevOcp', CmpPerAprbOcp = '$CmpPerAprbOcp',
        UsrId = '$UsrId', CmpEstOcp = '$CmpEstOcp' WHERE CmpId = '$id'";
    $res = methodPut($query);
    
    echo json_encode($res);
    header("HTTP/1.1 200 ok");
    exit();
}

// Elimina el registro solicitado mediante su id
if ($_POST['METHOD']=='DELETE') {
    unset($_POST['METHOD']);
    $id = $_GET['id'];
    $query = "DELETE FROM sumi_compras07 WHERE CmpId = '$id'";
    $res = methodDelete($query);
    echo json_encode($res);
    header("HTTP/1.1 200 ok");
    exit();
}

header("HTTP/1.1 400 Bad Request");
