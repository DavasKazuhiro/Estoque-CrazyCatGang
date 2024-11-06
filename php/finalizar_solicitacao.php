<?php

    include "conexao.php";

    $id_solicitacao = $_POST["id_solicitacao"];

    $tabela = mysqli_query($con, "SELECT * FROM pedido AS p INNER JOIN  estoque AS e WHERE p.fk_id_solicitacao = $id_solicitacao AND p.fk_id_produto = e.id_produto;");

    $resposta["mensagem"] = "Solicitação concluída com sucesso!";
    $resposta["status"] = "s";
    $resposta["id"] = $id_solicitacao;

    while($registro = mysqli_fetch_assoc($tabela)){
        if($registro["quantidade_pedido"] > $registro["quantidade_estoque"]){
            $resposta["mensagem"] = "Quantidade em estoque insuficiente";
            $resposta["status"] = "n";
        }
    }


    $resultado = mysqli_query($con, "SELECT * FROM pedido AS p INNER JOIN  estoque AS e WHERE p.fk_id_solicitacao = $id_solicitacao AND p.fk_id_produto = e.id_produto;");
    if($resposta["status"] == "s"){
        while($registro = mysqli_fetch_assoc($resultado)){
            $id_solicitacao = $registro["fk_id_solicitacao"];
            $quantidade_pedido = $registro["quantidade_pedido"];
            $id_produto = $registro["id_produto"];
            mysqli_query($con, "UPDATE estoque SET quantidade_estoque = quantidade_estoque - $quantidade_pedido WHERE id_produto = $id_produto;");
        }
        mysqli_query($con, "UPDATE solicitacao SET status = 'concluido'  WHERE id_solicitacao = $id_solicitacao;");
    }

    echo json_encode($resposta);

?>