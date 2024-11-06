<?php

    include "conexao.php";

    $nome = $_POST["nome"];
    $rua = $_POST["rua"];
    $numero = (int) $_POST["numero"];
    $bairro = $_POST["bairro"];
    $urgencia = (int) $_POST["urgencia"];
    $telefone = $_POST["telefone"];

    $resposta["status"] = "s";
    $resposta["mensagem"] = "Solicitação enviada com sucesso!";

    if($nome == "" || $rua == "" || $numero == "" || $bairro == "" || $urgencia == ""){
        $resposta["status"] = "n";
        $resposta["mensagem"] = "Preencha todos os campos!";
    }

    else{ 
        for($i = 0; $i < count($_POST["produto"]); $i++){
            if($_POST["produto"][$i] == "" || $_POST["qtd"][$i] == ""){
                $resposta["mensagem"] = "Preencha todos os campos";
                $resposta["status"] = "n";
                break;
            }
        }
    }

    if($resposta["status"] == "s"){
        mysqli_query($con, "INSERT INTO solicitacao (nome, endereco_rua, endereco_numero, endereco_bairro, urgencia, telefone) VALUES ('$nome', '$rua', $numero, '$bairro', '$urgencia', '$telefone');");
        
        $result = mysqli_query($con, "SELECT * FROM solicitacao ORDER BY id_solicitacao DESC LIMIT 1");
        $linha = mysqli_fetch_assoc($result);
        $id = $linha['id_solicitacao'];
        for($i = 0; $i < count($_POST["produto"]); $i++){
            $id_produto = $_POST["produto"][$i];
            $qtd = $_POST["qtd"][$i];
            mysqli_query($con, "INSERT INTO pedido (quantidade_pedido, fk_id_solicitacao, fk_id_produto) VALUES ('$qtd', '$id', $id_produto);");
        }
    }   
    
    
    echo json_encode($resposta);
?>