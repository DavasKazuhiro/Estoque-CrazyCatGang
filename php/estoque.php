<?php

    include "conexao.php";

    $conexao = mysqli_query($con, "SELECT * FROM estoque");

    $resposta["status"] = "s";
    $resposta["mensagem"] = "Tabela Preenchida";

    if(intval(mysqli_num_rows($conexao)) > 0){

        $resposta["status"] = "s";
        $resposta["mensagem"] = "Tabela Preenchida";
        $i = 0;

        while($registro = mysqli_fetch_assoc($conexao)){
            $resposta["item"][$i]["id_produto"] = $registro["id_ilha"];
            $resposta["item"][$i]["nome"] = $registro["nome"];
            $resposta["item"][$i]["descricao"] = $registro["descricao"];
            $resposta["item"][$i]["quantidade"] = $registro["quantidade"];
            $i++;
        }
    }
    else{
        $resposta["status"] = "n";
        $resposta["mensagem"] = "Não possui itens cadastradas";
    }

    echo json_encode($resposta);


?>