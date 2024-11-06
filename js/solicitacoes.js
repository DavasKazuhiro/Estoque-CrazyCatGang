window.onload = async function () {
    
    var retorno = await fetch("../php/get_solicitacoes.php", {
        method: "GET"
    });

    var lista = await retorno.json();

    if(lista.status == "s"){
        for(var i = 0; i < lista.solicitacao.length; i++){
            var card = `
            <div class="solicitacao">
                <div class="titulo ${lista.solicitacao[i].urgencia}">
                    <div><h1>${lista.solicitacao[i].nome}</h1></div>
                    <div class="data"><h3>${lista.solicitacao[i].data.slice(0, 10)}</h3></div>
                </div>

                <div class="produtos" id="produtos${i}">
                    
                </div>

                <div class="infos">
                    <h4>${lista.solicitacao[i].rua}, ${lista.solicitacao[i].numero} - ${lista.solicitacao[i].bairro}</h4>
                    <h4>${lista.solicitacao[i].telefone}</h4>
                </div>

                <div class="btns">
                    <button type="button" onclick="cancelar_solicitacao(${lista.solicitacao[i].id_solicitacao})"><i class="fa-solid fa-xmark"></i></button>
                    <button type="button" onclick="finalizar_solicitacao(${lista.solicitacao[i].id_solicitacao})"><i class="fa-solid fa-check"></i></button>
                </div>
            </div>`;

            document.getElementById("solicitacoes").innerHTML += card;

            for(var j = 0; j < lista.solicitacao[i].pedido.length; j++){
                var produto = `
                    <div class="produto ${lista.solicitacao[i].pedido[j].status}" name="${lista.solicitacao[i].pedido[j].id_produto}">
                        <h4>${lista.solicitacao[i].pedido[j].nomeProduto}</h4>
                        <h4>${lista.solicitacao[i].pedido[j].qtd}</h4>
                    </div>`;
                document.getElementById(`produtos${i}`).innerHTML += produto;
            }
            
        }
    }
    
    else{
        alert(lista.mensagem);
    }
}

async function finalizar_solicitacao(id_solicitacao){
    form = new FormData();
    form.append("id_solicitacao", id_solicitacao);

    var req =  await fetch("../php/finalizar_solicitacao.php", {
        method: "POST",
        body: form
    });

    var resposta = await req.json();

    alert(resposta.mensagem);

    if(resposta.status == "s"){
        location.reload();
    }
}

async function cancelar_solicitacao(id_solicitacao){
    form = new FormData();
    form.append("id_solicitacao", id_solicitacao);

    var req =  await fetch("../php/cancelar_solicitacao.php", {
        method: "POST",
        body: form
    });

    var resposta = await req.json();

    alert(resposta.mensagem);

    if(resposta.status == "s"){
        location.reload();
    }
}