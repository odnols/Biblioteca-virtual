var gamerscore = 0;

$(document).ready(function(){

    $('#carrosel_fundo').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        speed: 2000,
        autoplaySpeed: 2000,
    });
});

function atualiza_gamerscore(pontuacao, funcao){

    if(funcao == 1)
        gamerscore += pontuacao;
    else{
        // Formata para o padrão brasileiro, separando milhares
        if(pontuacao != null)
            var formatado = pontuacao.toLocaleString('pt-BR');
        else
            formatado = 0;

        gamerscore = formatado;
        document.getElementById("gamerscore").innerHTML = gamerscore +" G";
    }
}

function select(){
    var audio = document.getElementById("audio");
    audio.src = "Sons/Select.mp3";
    audio.play();
}

function JumpIn(elemento){

    document.getElementById("xbox_sm").style.animation = "JumpIn 1s";
    document.getElementById("conquista_sm").style.display = "inline";
    document.getElementById("conquista_sm").style.animation = "mostra_bloco .5s";
    document.getElementById(elemento).style.animation = "volta_inicio .5s";
    document.getElementById(elemento).style.right = "10%";
    document.getElementById("titulo").style.animation = "esconde_bloco2 1s";

    var audio = document.getElementById("audio");
    audio.src = "Sons/JumpIn.mp3";
    audio.play();

    limpa_animacao = setTimeout(function(){
        document.location.href = "index.php";
        document.getElementById("titulo").style.display = "none";

        document.getElementById("xbox_sm").style.animation = "";
        clearTimeout(limpa_animacao);
    }, 1000);
}

function Perfil(elemento){

    document.getElementById("transitador").style.animation = "transita 1s";
    document.getElementById("perfil_sm").style.animation = "esconde_bloco 1s";
    document.getElementById(elemento).style.animation = "esconde_bloco2 1s";
    document.getElementById("titulo").style.animation = "esconde_bloco3 1s";

    select();

    limpa_transicao = setTimeout(function(){

        document.getElementById(elemento).style.opacity = 0;
        document.getElementById("perfil_sm").style.opacity = 0;
        document.getElementById("transitador").style.animation = "";
        document.getElementById("titulo").style.display = "none";
        
        document.location.href = "perfil.php";

        clearTimeout(limpa_transicao);
    }, 1000);
}

function login(){
    $("#formulario_login").fadeToggle();
}

function avisa_popup(caso){
    alert("Faça Login para ver "+ caso +"!");
}

function AbreBiblio(pagina, elemento, elemento2, elemento3){

    document.getElementById("conquista_sm").style.animation = "esconde_bloco2 1s";
    document.getElementById("transitador").style.opacity = 1;
    document.getElementById("transitador").style.borderRadius = "0px";
    document.getElementById("transitador").style.top = "0px";
    document.getElementById("transitador").style.right = "0px";
    document.getElementById("transitador").style.animation = "puxa_biblio .5s";
    document.getElementById("titulo").style.animation = "esconde_bloco2 .5s";

    select();
    
    if (pagina == 'index' || pagina == 'perfil')
        document.getElementById(elemento).style.animation = "esconde_bloco 1s";

    if (pagina == 'conquistas'){
        document.getElementById("opcoes_add").style.animation = "esconde_bloco 1s";
        document.getElementById("informacoes_jogo").style.animation = "esconde_bloco2 1s";
        document.getElementById("status_bar").style.animation = "esconde_bloco 1s";
    }

    if (elemento2 != null)
        document.getElementById(elemento2).style.animation = "esconde_bloco2 1s";
    if (elemento3 != null)
        document.getElementById(elemento3).style.animation = "esconde_bloco3 1s";

    limpa_transicao = setTimeout(function(){
        document.location.href = "biblioteca.php";
        document.getElementById("titulo").style.display = "none";

        if(pagina == 'conquista'){
            document.getElementById("opcoes_add").style.display = "none";
            document.getElementById(elemento).style.opacity = "1";
            document.getElementById(elemento).style.height = "100%";
            document.getElementById(elemento).style.background = "midnightblue";
            document.getElementById("informacoes_jogo").style.display = "none";
            document.getElementById("status_bar").style.display = "none";
        }else
            document.getElementById(elemento).style.display = "none";

        if (elemento2 != null)
            document.getElementById(elemento2).style.display = "none";

        if (elemento3 != null)
            document.getElementById(elemento3).style.display = "none";
        clearTimeout(limpa_transicao);
    }, 500);
}

function AbreHistorico(){
    select();

    limpa_transicao = setTimeout(function(){
        clearTimeout(limpa_transicao);
        document.location.href = "historico.php";
    }, 500);
}

function AbrirConquistas(id_game){

    document.getElementById("conquista_sm").style.animation = "esconde_bloco2 1s";
    document.getElementById("transitador").style.borderRadius = "0px";
    document.getElementById("transitador").style.top = "0px";
    document.getElementById("transitador").style.width = "100%";
    document.getElementById("transitador").style.animation = "puxa_conquista .5s";
    document.getElementById("corpo_pagina").style.animation = "esconde_bloco 1s";
    document.getElementById("titulo").style.animation = "esconde_bloco3 .5s";

    limpa_transicao = setTimeout(function(){
        document.location.href = "php_funcoes/game_carrega.php?id=" + id_game;

        document.getElementById("titulo").style.display = "none";
        document.getElementById("corpo_pagina").style.display = "none";

        if (elemento2 != null)
            document.getElementById(elemento2).style.opacity = 0;

        if (elemento3 != null)
            document.getElementById(elemento3).style.opacity = 0;
        clearTimeout(limpa_transicao);
    }, 500);
}

function carregaGame(){

    select();

    limpa_transicao = setTimeout(function(){
        clearTimeout(limpa_transicao);
        document.location.href = "conquistas.php";
    }, 500);
}

function puxa_import(estado){

    if(estado == 1){
        document.getElementById("gerencia_conq").style.animation = "mostra_bloco .5s";
        document.getElementById("gerencia_conq").style.opacity = 1;
        document.getElementById("gerencia_conq").style.height = "80%";
    }else{
        document.getElementById("gerencia_conq").style.animation = "esconde_bloco1 .5s";
        document.getElementById("gerencia_conq").style.opacity = 0;
        document.getElementById("gerencia_conq").style.height = "0px";
    }
}

function aleatorizador(total, pag){
    var id = Math.floor(Math.random() * total);

    if(pag == 'conquista'){
        document.getElementById("transitador").style.top = "0px";
        document.getElementById("transitador").style.width = "100%";
        document.getElementById("conquistas_grid").style.animation = "esconde_bloco2 .5s";
        document.getElementById("informacoes_jogo").style.animation = "esconde_bloco .5s";
        document.getElementById("transitador").style.animation = "transita_conquistas .5s";
        document.getElementById("fundo2").style.animation = "estica_bloco .5s";
        document.getElementById("fundo4").style.animation = "mostra_bloco .5s";
        document.getElementById("titulo").style.animation = "esconde_bloco3 .5s";

        limpa_transicao = setTimeout(function(){
            document.getElementById("opcoes_add").style.display = "none";
            document.getElementById("fundo4").style.opacity = 1;
            document.getElementById("fundo2").style.height = "100%";
            document.getElementById("fundo2").style.background = "midnightblue";
            document.getElementById("transitador").style.display = "block";
            document.getElementById("informacoes_jogo").style.display = "none";
            document.getElementById("conquistas_grid").style.display = "none";
            document.getElementById("titulo").style.display = "none";

            window.location.href = "php_funcoes/game_carrega.php?id=" + id;
            clearTimeout(limpa_transicao);
        }, 500);
    }else if(pag == 'biblioteca'){
        AbrirConquistas(id);
    }
}

function adicionar_jogo(){
    $("#form_add_jogo").fadeToggle();
    $("#biblioteca_completa").fadeOut();
}

function checaadd(valor){
    if(valor == 1)
        $("#form_impt_conq").fadeIn();
}

function bibliocompleta(){
    $("#biblioteca_completa").fadeToggle();
    $("#form_add_jogo").fadeOut();
}

function importar_Conquistas(){
    $("#form_impt_conq").fadeToggle();
    $("#form_add_conq").fadeOut();
}

function apagar_conquista(id_conquista){

    if(confirm("Deseja mesmo apagar esta conquista?")){
        document.location.href = "conquistas_apagar.php?idconq="+ id_conquista;
    }
}

function adicionar_Conquistas(){
    $("#form_add_conq").fadeToggle();
    $("#form_impt_conq").fadeOut();
}

function Desenvolvedor(pagina){
    window.location.href = "php_funcoes/modo_develop.php?pagina="+ pagina;
}

function atualizarConquista(conquista, estado){

    if(estado == 0){
        var data = prompt("Informe da data no padrão dd-mm-yyyy (deixe em branco para hoje): ")

        if(data != null){
            document.location.href = "php_funcoes/conquistas_atualizar.php?id_conq="+ conquista +"?"+ 0 +"?"+ data;
        }
    }else{
        // if(confirm("Deseja desmarcar essa conquista?"))
            document.location.href = "php_funcoes/conquistas_atualizar.php?id_conq="+ conquista +"?"+ 0;
    }
}

function abrirPrancheta(conquista){
            
    $("#input_conq").fadeIn();
    $("#opcoes_add_conq").fadeIn();

    document.getElementById("input_conq").innerHTML = "<iframe src='php_funcoes/conquistas_prancheta.php?idconq="+conquista+"' name='content' marginheight='0' scrolling='no' frameborder='0' hspace='0' vspace='0' allowtransparency='true' application='true' width='100%' height='100%'></iframe>";       

}

function retornar_conq(){

    document.getElementById("input_conq").style.display = "none";
    $("#opcoes_add_conq").fadeOut();
}

function opcoes(){
    window.location.href = "php_funcoes/opcoes.php";
}

function filtrar_conquista(plataforma){
    
    window.location.href = "php_funcoes/game_carrega.php?plat="+plataforma;
}

function filtrarHistorico(idgame){

    window.location.href = "php_funcoes/historico_filtrar.php?idgame="+idgame;
}

function limparFiltro(){
    window.location.href = "php_funcoes/historico_filtrar.php";
}