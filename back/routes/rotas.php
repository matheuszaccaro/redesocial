<?php

require_once __DIR__ . "/../controllers/ClienteController.php";

$rota = $_GET["rota"] ?? "";
$metodo = $_SERVER["REQUEST_METHOD"];

if ($rota === "usuario"){
    switch($metodo){
        case "POST":
            createUsuario($con);
            break;
        case "GET":
            readUsuario($con);
            break;
        case "PUT":
            updateUsuario($con);
            break;
        case "DELETE":
            deleteUsuario($con);
            break;
        default:
            teste();
    }
}elseif ($rota === "publicacao"){
    switch($metodo){
        case "POST":
            createPublicacao($con);
            break;
        case "GET":
            readPublicacao($con);
            break;
        case "PUT":
            updatePublicacao($con);
            break;
        case "DELETE":
            deletePublicacao($con);
            break;
        default:
            teste();
    }
}elseif ($rota === "curtida"){
    switch($metodo){
        case "POST":
            createCurtida($con);
            break;
        case "GET":
            readCurtida($con);
            break;
        case "PUT":
            updateCurtida($con);
            break;
        case "DELETE":
            deleteCurtida($con);
            break;
        default:
            teste();
    }
}
?>