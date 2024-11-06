<?php

    include "conexao.php";

    $resultado = mysqli_query($con, "SELECT * FROM solicitacao WHERE status = 'pendente';");

    if(intval(mysqli_num_rows($resultado)) > 0){

        $resposta["status"] = "s";
        $resposta["mensagem"] = "Lista Preenchida";
        $i = 0;

        while($registro = mysqli_fetch_assoc($resultado)){
            $resposta["solicitacao"][$i]["id_solicitacao"] = $registro["id_solicitacao"];
            $idSolicitacao = $registro["id_solicitacao"];
            $resposta["solicitacao"][$i]["nome"] = $registro["nome"];
            $resposta["solicitacao"][$i]["rua"] = $registro["endereco_rua"];
            $resposta["solicitacao"][$i]["numero"] = $registro["endereco_numero"];
            $resposta["solicitacao"][$i]["bairro"] = $registro["endereco_bairro"];
            $resposta["solicitacao"][$i]["urgencia"] = $registro["urgencia"];
            $resposta["solicitacao"][$i]["telefone"] = $registro["telefone"];
            $resposta["solicitacao"][$i]["data"] = $registro["data_hora"];

            $j = 0;
            $resultadoPedido = mysqli_query($con, "SELECT * FROM pedido AS p INNER JOIN estoque AS e ON p.fk_id_produto = e.id_produto WHERE fk_id_solicitacao = $idSolicitacao;");
            while($registroPedido = mysqli_fetch_assoc($resultadoPedido)){
                $resposta["solicitacao"][$i]["pedido"][$j]["qtd"] = $registroPedido["quantidade_pedido"];
                $resposta["solicitacao"][$i]["pedido"][$j]["nomeProduto"] = $registroPedido["nome"];
                $resposta["solicitacao"][$i]["pedido"][$j]["id_produto"] = $registroPedido["fk_id_produto"];
                if(intval($registroPedido["quantidade_pedido"]) > intval($registroPedido["quantidade_estoque"])){
                    $resposta["solicitacao"][$i]["pedido"][$j]["status"] = "insuficiente";
                }
                else{
                    $resposta["solicitacao"][$i]["pedido"][$j]["status"] = "suficiente";
                }
                $j++;
            }

            $i++;
        }
    }

    else{
        $resposta["status"] = "n";
        $resposta["mensagem"] = "Não possui pedidos cadastrados";
    }

    echo json_encode($resposta);

?>