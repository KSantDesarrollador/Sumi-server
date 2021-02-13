<?php
require "../root/master.php";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: x-API-KEY, Origin, Authorization,X-Request-With, Content-Type, Accept, Access-Control-Request-Method');


// Consulta a la base de datos para traer los datos
if ($_SERVER['REQUEST_METHOD']=='GET') {
    if (isset($_GET['id'])) {
        $query = "SELECT * FROM sumi_vistaproductos WHERE MdcId=".$_GET['id'];
        $res = methodGet($query);
        echo json_encode($res->fetch(PDO::FETCH_ASSOC));
    } elseif (isset($_GET['cat'])) {
        $query = "SELECT CtgId, CtgNomCat, CtgColorCat FROM sumi_categoria06";
        $res = methodGet($query);
        echo json_encode($res->fetchAll());
    } else {
        $query = "SELECT * FROM sumi_vistaproductos";
        $res = methodGet($query);
        echo json_encode($res->fetchAll());
    }
    header("HTTP/1.1 200 ok");
    exit();
}


// Inserta registros a la base de datos
if ($_POST['METHOD']=='POST') {
    unset($_POST['METHOD']);
    $CtgId = __ChainFilter($_POST['CtgId']);
    $MdcCodMed = __ChainFilter($_POST['MdcCodMed']);
    $MdcDescMed = __ChainFilter($_POST['MdcDescMed']);
    $MdcPresenMed = __ChainFilter($_POST['MdcPresenMed']);
    $MdcConcenMed = __ChainFilter($_POST['MdcConcenMed']);
    $MdcNivPrescMed = __ChainFilter($_POST['MdcNivPrescMed']);
    $MdcNivAtencMed = __ChainFilter($_POST['MdcNivAtencMed']);
    $MdcViaAdmMed = __ChainFilter($_POST['MdcViaAdmMed']);
    $MdcFotoMed = __ChainFilter($_POST['MdcFotoMed']);

    $query = "INSERT INTO sumi_productos15(CtgId, MdcCodMed, MdcDescMed, MdcPresenMed, MdcConcenMed, MdcNivPrescMed,
        MdcNivAtencMed, MdcViaAdmMed, MdcFotoMed) 
        VALUES('$CtgId', '$MdcCodMed', '$MdcDescMed', '$MdcPresenMed', '$MdcConcenMed', '$MdcNivPrescMed', '$MdcNivAtencMed',
        '$MdcViaAdmMed' , '$MdcFotoMed')";
    $idAutoincrement = "SELECT *, MAX(MdcId) AS MdcId FROM sumi_productos15";
    $res = methodPost($query, $idAutoincrement);

    echo json_encode($res);
    header("HTTP/1.1 200 ok");
    exit();
}

// Actualiza la información de un registro mediante el id
if ($_POST['METHOD']=='PUT') {
    unset($_POST['METHOD']);
    $id = $_GET['id'];
    $CtgId = __ChainFilter($_POST['CtgId']);
    $MdcCodMed = __ChainFilter($_POST['MdcCodMed']);
    $MdcDescMed = __ChainFilter($_POST['MdcDescMed']);
    $MdcPresenMed = __ChainFilter($_POST['MdcPresenMed']);
    $MdcConcenMed = __ChainFilter($_POST['MdcConcenMed']);
    $MdcNivPrescMed = __ChainFilter($_POST['MdcNivPrescMed']);
    $MdcNivAtencMed = __ChainFilter($_POST['MdcNivAtencMed']);
    $MdcViaAdmMed = __ChainFilter($_POST['MdcViaAdmMed']);
    $MdcEstMed = __ChainFilter($_POST['MdcEstMed']);
    $MdcFotoMed = __ChainFilter($_POST['MdcFotoMed']);

    $query = "UPDATE sumi_productos15 SET CtgId = '$CtgId', MdcCodMed = '$MdcCodMed',
        MdcDescMed = '$MdcDescMed', MdcPresenMed = '$MdcPresenMed', MdcConcenMed = '$MdcConcenMed',
        MdcNivPrescMed = '$MdcNivPrescMed', MdcNivAtencMed = '$MdcNivAtencMed', MdcViaAdmMed = '$MdcViaAdmMed',
        MdcFotoMed = '$MdcFotoMed', MdcEstMed = '$MdcEstMed' WHERE MdcId = '$id'";
    $res = methodPut($query);
    
    echo json_encode($res);
    header("HTTP/1.1 200 ok");
    exit();
}

// Elimina el registro solicitado mediante su id
if ($_POST['METHOD']=='DELETE') {
    unset($_POST['METHOD']);
    $id = $_GET['id'];
    $query = "DELETE FROM sumi_productos15 WHERE MdcId = '$id'";
    $res = methodDelete($query);
    echo json_encode($res);
    header("HTTP/1.1 200 ok");
    exit();
}

header("HTTP/1.1 400 Bad Request");
