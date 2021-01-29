<?php
require "../root/master.php";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: x-API-KEY, Origin, Authorization,X-Request-With, Content-Type, Accept, Access-Control-Request-Method');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
header('Allow: GET, POST, OPTIONS, PUT, DELETE');

// Consulta a la base de datos para traer los datos
if ($_SERVER['REQUEST_METHOD']=='GET') {
    if (isset($_GET['id'])) {
        $query = "SELECT * FROM sumi_vistausuario WHERE UsrId=".$_GET['id'];
        $res = methodGet($query);
        echo json_encode($res->fetch(PDO::FETCH_ASSOC));
    } elseif (isset($_GET['rol'])) {
        $query = "SELECT RrlId, RrlNomRol FROM sumi_rol21";
        $res = methodGet($query);
        echo json_encode($res->fetchAll());
    } else {
        $query = "SELECT * FROM sumi_vistausuario";
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
    $UsrNomUsu = __ChainFilter($_POST['UsrNomUsu']);
    $UsrContraUsu = __Encripting($_POST['UsrContraUsu']);
    $UsrEmailUsu = __ChainFilter($_POST['UsrEmailUsu']);
    $UsrTelfUsu = __ChainFilter($_POST['UsrTelfUsu']);
    if (empty($_FILES['UsrImgUsu']['name'])) {
        $query = "INSERT INTO sumi_usuario24(RrlId, UsrNomUsu, UsrContraUsu, UsrEmailUsu, UsrTelfUsu) 
        VALUES('$RrlId', '$UsrNomUsu','$UsrContraUsu', '$UsrEmailUsu', '$UsrTelfUsu')";
        $idAutoincrement = "SELECT *, MAX(UsrId) AS UsrId FROM sumi_vistausuario";
        $res = methodPost($query, $idAutoincrement);
    } else {
        $UsrImgUsu = file_get_contents($_FILES['UsrImgUsu']['name']);
        $query = "INSERT INTO sumi_usuario24(RrlId, UsrNomUsu, UsrContraUsu, UsrEmailUsu, UsrTelfUsu, UsrImgUsu) 
        VALUES('$RrlId', '$UsrNomUsu','$UsrContraUsu', '$UsrEmailUsu', '$UsrTelfUsu', '$UsrImgUsu')";
        $idAutoincrement = "SELECT *, MAX(UsrId) AS UsrId FROM sumi_vistausuario";
        $res = methodPost($query, $idAutoincrement);
    }

    echo json_encode($res);
    header("HTTP/1.1 200 ok");
    exit();
}

// Actualiza la información de un registro mediante el id
if ($_POST['METHOD']=='PUT') {
    unset($_POST['METHOD']);
    $id = $_GET['id'];
    $RrlId = __ChainFilter($_POST['RrlId']);
    $UsrNomUsu = __ChainFilter($_POST['UsrNomUsu']);
    $UsrEmailUsu = __ChainFilter($_POST['UsrEmailUsu']);
    $UsrTelfUsu = __ChainFilter($_POST['UsrTelfUsu']);
    $UsrEstUsu = __ChainFilter($_POST['UsrEstUsu']);
    $UsrImgUsu = file_get_contents($_FILES['UsrImgUsu']['name']);
    if ($_POST['UsrContraUsu'] == 0) {
        $query = "UPDATE sumi_usuario24 SET RrlId = '$RrlId', UsrNomUsu = '$UsrNomUsu',
        UsrEmailUsu = '$UsrEmailUsu', UsrTelfUsu = '$UsrTelfUsu', UsrImgUsu = '$UsrImgUsu' WHERE UsrId = '$id'";
        $res = methodPut($query);
    } else {
        $UsrContraUsu = __Encripting($_POST['UsrContraUsu']);
        $query = "UPDATE sumi_usuario24 SET RrlId = '$RrlId', UsrNomUsu = '$UsrNomUsu', UsrContraUsu = '$UsrContraUsu',
        UsrEmailUsu = '$UsrEmailUsu', UsrTelfUsu = '$UsrTelfUsu', UsrImgUsu = '$UsrImgUsu' WHERE UsrId = '$id'";
        $res = methodPut($query);
    }
    echo json_encode($res);
    header("HTTP/1.1 200 ok");
    exit();
}

// Elimina el registro solicitado mediante su id
if ($_POST['METHOD']=='DELETE') {
    unset($_POST['METHOD']);
    $id = $_GET['id'];
    $query = "DELETE FROM sumi_usuario24 WHERE UsrId = '$id'";
    $res = methodDelete($query);
    echo json_encode($res);
    header("HTTP/1.1 200 ok");
    exit();
}

header("HTTP/1.1 400 Bad Request");
