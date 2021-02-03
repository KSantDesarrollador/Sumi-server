<?php
require "../root/master.php";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');

// verificando la existencia del usuario

if ($_SERVER['REQUEST_METHOD']=='POST') {
    $UsrEmailUsu = $_POST['UsrEmailUsu'];
    $UsrContraUsu = __Encripting($_POST['UsrContraUsu']);

    $query = "SELECT UsrId, RrlId, RrlNomRol, UsrNomUsu, UsrEmailUsu FROM sumi_vistausuario WHERE UsrEmailUsu = '$UsrEmailUsu' AND UsrContraUsu = '$UsrContraUsu'";
    $res = methodGet($query);
    echo json_encode($res->fetchAll());

    header("HTTP/1.1 200 ok");
    exit();
}
