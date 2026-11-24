<?php

require_once __DIR__ . "/../models/UsuarioModel.php";

function teste(){
    echo json_encode(["Mensagem" => "Back-end respondendo com sucesso!"]);
    exit;
}
//receber e validar os dados
function receberDadosUsuario(){
    $dados = json_decode(file_get_contents("php://input"), true);

    if(!is_array($dados)){ //detecta se não for um conjunto de dados, array = conjunto de dados
        http_response_code(400);
        echo json_encode(["erro" => "Envie um objeto JSON com os dados do usuário!"]);
        return null;
    }
    foreach(["nome","username","email","senha"] as $campo){
        if(!isset($dados[$campo]) || //detecta valores vazio
            !is_String($dados[$campo]) || //detecta valores que não são string(palavras ou frases)
            trim($dados[$campo]) === "") { //remove espaços(ex: "     ")
                http_response_code(400);
                echo json_encode(["erro" => "O campo $campo é obrigatório e deve ser um texto não vazio."]);
                return null;
            }
    }
    return $dados;
}
function receberIdUsuario(){
    $id = filter_var($_GET["id"] ?? null, FILTER_VALIDATE_INT, ["options" => ["min_range"=> 1]]);
    if($id === false){
        http_response_code(400);
        echo json_encode(["erro" => "Informa um id de usuário válido."]);
        return null;
    }
    return $id;
}
function createUsuario($con){
    $dados = receberDadosUsuario();
    if ($dados === null){
        return;
    }
    $id = inserirUsuario($con, $dados);
    http_response_code(201);
    echo json_encode(["mensagem" => "Usuário criado com sucesso!", "id" => $id]);
}
function readUsuario($con){
    echo json_encode(listarUsuario($con));
}
function updateUsuario($con){
    $id = receberIdUsuario();
    if ($id === null){
        return;
    }
    $dados = receberDadosUsuario();
    if ($dados === null){
        return;
    }
    atualizarUsuario($con, $id, $dados);
    echo json_encode(["mensagem" => "Senha alterada com sucesso!"]);
}
function deleteUsuario($con){
    $id = receberIdUsuario();
    if ($id === null){
        return;
    }
    removerUsuario($con, $id);
    echo json_encode(["mensagem" => "Usuário removido com sucesso!"]);
}
?>