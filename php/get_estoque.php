<?php

    include "conexao.php";

    $resultado = mysqli_query($con, "SELECT * FROM estoque");

    if(intval(mysqli_num_rows($resultado)) > 0){

        $resposta["status"] = "s";
        $resposta["mensagem"] = "Lista Preenchida";
        $i = 0;

        while($registro = mysqli_fetch_assoc($resultado)){
            $resposta["produto"][$i]["id_produto"] = $registro["id_produto"];
            $resposta["produto"][$i]["nome"] = $registro["nome"];
            $resposta["produto"][$i]["descricao"] = $registro["descricao"];
            $resposta["produto"][$i]["descricao"] = $registro["descricao"];
            $resposta["produto"][$i]["qtd"] = $registro["quantidade_estoque"];
            $resposta["produto"][$i]["tipo"] = $registro["tipo"];

            $i++;
        }
    }
    else{
        $resposta["status"] = "n";
        $resposta["mensagem"] = "Não possui ilhas cadastradas";
    }

    echo json_encode($resposta);


?>