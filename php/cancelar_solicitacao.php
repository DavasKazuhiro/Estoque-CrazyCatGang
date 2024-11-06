<?php

    include "conexao.php";

    $id_solicitacao = $_POST["id_solicitacao"];

    mysqli_query($con, "UPDATE solicitacao SET status = 'cancelado'  WHERE id_solicitacao = $id_solicitacao;");

    $tabela = mysqli_query($con, "SELECT * FROM solicitacao WHERE id_solicitacao = $id_solicitacao;");

    $registro = mysqli_fetch_assoc($tabela);

    if($registro["status"] == "cancelado"){
        $resposta["mensagem"] = "Solicitação concluída com sucesso!";
        $resposta["status"] = "s";
    }

    else{
        $resposta["mensagem"] = "Erro";
        $resposta["status"] = "n";
    }
    

    echo json_encode($resposta);

?>
