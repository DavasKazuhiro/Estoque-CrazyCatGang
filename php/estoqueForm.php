<?php
    include "conexao.php";

    $nome = $_POST["nome"];
    $descricao = $_POST["descricao"];
    $quantidade = $_POST["quantidade"];
    $tipo = $_POST["tipo"];
    $resposta["mensagem"] = "Item adicionado com sucesso";

    if($nome == "" || $descricao == "" || $quantidade == ""){
        $resposta["mensagem"] = "Preencha todos os campos";
    }   
    else{
        $quantidade = (int) $quantidade;
        mysqli_query($con, "INSERT INTO estoque (nome, descricao, quantidade_estoque, tipo) VALUES ('$nome', '$descricao', $quantidade, '$tipo');");
    }

    echo json_encode($resposta);
?>