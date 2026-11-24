<?php

require_once __DIR__ . "/../models/PublicacaoModel.php";

function testePublicacao(){
    echo json_encode(["Mensagem" => "Back-end respondendo com sucesso!"]);
    exit;
}
function receberDadosPublicacao(){
    $dados = json_decode(file_get_contents("php://input"), true);

    if(!is_array($dados)){
        http_response_code(400);
        echo json_encode(["erro" => "Envie um objeto JSON com os dados da publicação!"]);
        return null;
    }
    foreach(["id_usuario", "legenda", "imagem_url"] as $campo){
        if(!isset($dados[$campo]) || 
            !is_String($dados[$campo]) || 
            trim($dados[$campo]) === "") { 
                http_response_code(400);
                echo json_encode(["erro" => "O campo $campo é obrigatório e deve ser um texto não vazio."]);
                return null;
            }
    }
    return $dados;
}
function receberIdPublicacao(){
    $id = filter_var($_GET["id"] ?? null, FILTER_VALIDATE_INT, ["options" => ["min_range"=> 1]]);
    if($id === false){
        http_response_code(400);
        echo json_encode(["erro" => "Informa um id de publicação válido."]);
        return null;
    }
    return $id;
}
function createPublicacao($con){
    $dados = receberDadosPublicacao();
    if ($dados === null){
        return;
    }
    $id = inserirPublicacao($con, $dados);
    http_response_code(201);
    echo json_encode(["mensagem" => "Publicação criada com sucesso!", "id" => $id]);
}
function readPublicacao($con){
    echo json_encode(listarPublicacao($con));
}
function updatePublicacao($con){
    $id = receberIdPublicacao();
    if ($id === null){
        return;
    }
    $dados = receberDadosPublicacao();
    if ($dados === null){
        return;
    }
    atualizarPublicacao($con, $id, $dados);
    echo json_encode(["mensagem" => "Legenda alterada com sucesso!"]);
}
function deletePublicacao($con){
    $id = receberIdPublicacao();
    if ($id === null){
        return;
    }
    removerPublicacao($con, $id);
    echo json_encode(["mensagem" => "Publicação removida com sucesso!"]);
}
?>