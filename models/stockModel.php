<?php
require "../root/master.php";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: x-API-KEY, Origin, Authorization,X-Request-With, Content-Type, Accept, Access-Control-Request-Method');

// Consulta a la base de datos para traer los datos
if ($_SERVER['REQUEST_METHOD']=='GET') {
    if (isset($_GET['id'])) {
        $query = "SELECT * FROM sumi_vistaexistencia WHERE ExtId=".$_GET['id'];
        $res = methodGet($query);
        echo json_encode($res->fetch(PDO::FETCH_ASSOC));
    } else {
        $query = "SELECT * FROM sumi_vistaexistencia";
        $res = methodGet($query);
        echo json_encode($res->fetchAll());
    }
    header("HTTP/1.1 200 ok");
    exit();
}


// Inserta registros a la base de datos
if ($_POST['METHOD']=='POST') {
    unset($_POST['METHOD']);
    $DocId = __ChainFilter($_POST['DocId']);
    $ExtLoteEx = __ChainFilter($_POST['ExtLoteEx']);
    $ExtFchCadEx = __ChainFilter($_POST['ExtFchCadEx']);
    $ExtStockIniEx = __ChainFilter($_POST['ExtStockIniEx']);
    $ExtStockSegEx = __ChainFilter($_POST['ExtStockSegEx']);
    $ExtCodBarEx = __ChainFilter($_POST['ExtCodBarEx']);
    $ExtBinLocEx = __ChainFilter($_POST['ExtBinLocEx']);

    $query = "INSERT INTO sumi_existencias12(DocId, ExtLoteEx, ExtFchCadEx, ExtStockIniEx, 
        ExtStockSegEx, ExtCodBarEx, ExtBinLocEx,) 
        VALUES('$DocId', '$ExtLoteEx', '$ExtFchCadEx', '$ExtStockIniEx', '$ExtStockSegEx', 
        '$ExtCodBarEx', '$ExtBinLocEx')";
    $idAutoincrement = "SELECT *, MAX(ExtId) AS ExtId FROM sumi_existencias12";
    $res = methodPost($query, $idAutoincrement);
    

    echo json_encode($res);
    header("HTTP/1.1 200 ok");
    exit();
}

// Actualiza la información de un registro mediante el id
if ($_POST['METHOD']=='PUT') {
    unset($_POST['METHOD']);
    $id = $_GET['id'];
    $DocId = __ChainFilter($_POST['DocId']);
    $ExtLoteEx = __ChainFilter($_POST['ExtLoteEx']);
    $ExtFchCadEx = __ChainFilter($_POST['ExtFchCadEx']);
    $ExtStockIniEx = __ChainFilter($_POST['ExtStockIniEx']);
    $ExtStockSegEx = __ChainFilter($_POST['ExtStockSegEx']);
    $ExtCodBarEx = __ChainFilter($_POST['ExtCodBarEx']);
    $ExtBinLocEx = __ChainFilter($_POST['ExtBinLocEx']);
    $ExtEstEx = __ChainFilter($_POST['ExtEstEx']);
    
    $query = "UPDATE sumi_existencias12 SET DocId = '$DocId', ExtLoteEx = '$ExtLoteEx',
        ExtFchCadEx = '$ExtFchCadEx', ExtStockIniEx = '$ExtStockIniEx', ExtStockSegEx = '$ExtStockSegEx',
        ExtCodBarEx = '$ExtCodBarEx', ExtBinLocEx = '$ExtBinLocEx',
        ExtEstEx = '$ExtEstEx' WHERE ExtId = '$id'";
    $res = methodPut($query);
    
    echo json_encode($res);
    header("HTTP/1.1 200 ok");
    exit();
}

// Elimina el registro solicitado mediante su id
if ($_POST['METHOD']=='DELETE') {
    unset($_POST['METHOD']);
    $id = $_GET['id'];
    $query = "DELETE FROM sumi_existencias12 WHERE ExtId = '$id'";
    $res = methodDelete($query);
    echo json_encode($res);
    header("HTTP/1.1 200 ok");
    exit();
}

header("HTTP/1.1 400 Bad Request");
