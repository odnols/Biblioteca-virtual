<?php

include_once "php_sessao/conexao_obsoleta.php";

if(!isset($_SESSION["gamerscore"]))
    $soma_gamerscore = 0;
else
    $soma_gamerscore = $_SESSION["gamerscore"];

$iduser = $_SESSION["id_usuario"];

// Conferindo o status do usuário e diminuindo a quantidade de sessões
$busca = "SELECT * from usuario where id_user = $iduser";
$executa_busca = $conexao->query($busca);

if($executa_busca->num_rows > 0){
    while ($dados = $executa_busca->fetch_assoc()){

        $_SESSION["gamertag"] = $dados["gamertag"];
        $_SESSION["gamerscore"] = $dados["pontuacao"];
        $_SESSION["biografia"] = $dados["biografia"];
        $_SESSION["moderacao"] = $dados["moderacao"];
        
        $nome_img = $dados["nome_img"];
        $_SESSION["foto_perfil"] = "img/Perfil/$nome_img";
    }
}


// Total de Games Iniciados
if(!isset($_SESSION["total_games"])){
    $games = "SELECT id_game from jogos_possuidos where id_user = $iduser";
    $executa_busca = $conexao->query($games);

    $_SESSION["total_games"] = $executa_busca->num_rows;
}

if(!isset($_SESSION["total_conquistas"])){
    // Total de Conquistas Coletadas
    $conquistas = "SELECT id_conquista from alcancada where id_jogador = $iduser";
    $executa_busca = $conexao->query($conquistas);

    $_SESSION["total_conquistas"] = $executa_busca->num_rows;

    // Contabilizando o gamerscore
    $gamerscore = "SELECT id_conquista, pontuacao from conquista";

    $busca1 = $conexao->query($gamerscore);

    // Laço das Pontuações
    if($busca1->num_rows > 0){
        while($dados1 = $busca1->fetch_assoc()){
            
            $id_conquista = $dados1["id_conquista"];

            $alcancadas = "SELECT id_conquista from alcancada where id_conquista = $id_conquista and id_jogador = $iduser";
            $busca2 = $conexao->query($alcancadas);

            // Laço das Conquistas Pegas
            if($busca2->num_rows > 0){
                $pontuacao = $dados1["pontuacao"];
                $soma_gamerscore += $pontuacao;
            }
        }
    }
}

// Salvando o gamerscore no banco
if($_SESSION["gamerscore"] != $soma_gamerscore and $executa_busca->num_rows > 0){

    $att_gamerscore = "UPDATE usuario set pontuacao = $soma_gamerscore where id_user = $iduser";
    $executa = $conexao->query($att_gamerscore);
}

// Contabilizando o total de conquistas registradas em todos os jogos iniciados
if($_SESSION["total_games"] > 0){
    $conquistas_globais = "SELECT id_conquista from conquista";
    $busca_conquistas = $conexao->query($conquistas_globais);

    if($busca_conquistas->num_rows > 0)
        $_SESSION["conquistas_globais"] = $busca_conquistas->num_rows;
    else
        $_SESSION["conquistas_globais"] = 0;
}else
    $_SESSION["conquistas_globais"] = 0;

$verificaArquivo = "SELECT * from game";
$executa = $conexao->query($verificaArquivo);

// Total de jogos inseridos na biblioteca
$_SESSION["total_games"] = $executa->num_rows;
$_SESSION["gamerscore"] = $soma_gamerscore;