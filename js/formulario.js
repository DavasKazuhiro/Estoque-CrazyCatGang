window.onload = async function () {
    var retorno = await fetch("../php/get_estoque.php", {
        method: "GET"
    });

    var lista = await retorno.json();

    if(lista.status == "s"){
        for(var i = 0; i < lista.produto.length; i++){
            var produto = `<option value="${lista.produto[i].id_produto}">${lista.produto[i].nome}</option>`;

            document.getElementById("produto").innerHTML += produto;
        }
    }
    
    else{
        alert(lista.mensagem);
    }
}

var id = 1;

async function add_select(){
    var select = `  
    <div class="pedido" id="pedido${id}">
        <select class="input item" id="produto${id}" name="produto[]">

        </select>
        <input type="number" placeholder="Quantidade" class="input qtd" name="qtd[]">
        <button class="mais" type="button" onclick="remove_select(${id})"><i class="fa-solid fa-minus"></i></button>
    </div>`;

    document.getElementById("pedidos").innerHTML += select;

    var retorno = await fetch("../php/get_estoque.php", {
        method: "GET"
    });

    var lista = await retorno.json();

    if(lista.status == "s"){
        for(var i = 0; i < lista.produto.length; i++){
            var produto = `<option value="${lista.produto[i].id_produto}">${lista.produto[i].nome}</option>`;

            document.getElementById(`produto${id}`).innerHTML += produto;
        }
        id++;
    }
    
    else{
        alert(lista.mensagem);
    }
}

async function remove_select(n){
    var container = document.getElementById("pedidos");
    var select = document.getElementById(`pedido${n}`);

    if (select) {
        container.removeChild(select);
        id--; // Decrementa o id após a remoção
    }
}


async function nova_solicitacao(){
    var form = document.getElementById("solicitacao");
    var dados = new FormData(form);

    var req = await fetch("../php/send_solicitacao.php", {
        method: "POST",
        body: dados
    });

    var resposta = await req.json();

    alert(resposta.mensagem)

    if(resposta.status == "s"){
        location.reload();
    }
}