async function adicionar_item(){
    var form = document.getElementById("form-novo-item");
    var dados = new FormData(form);

    var req = await fetch("../php/estoqueForm.php", {
        method: "POST",
        body: dados
    });

    var resposta = await req.json();
    alert(resposta.mensagem);
}

