<?php include_once "../php_sessao/conexao_obsoleta.php"; 

session_start();

$nome = $_POST["nome"];
$plataforma = $_POST["plataforma"];
$descricao = $_POST["descricao"];
$pontuacao = $_POST["pontuacao"];
$idgame = $_SESSION["ultimoGame"];

if(isset($_POST["secreta"])){ $secreta = 1; }else{ $secreta = 0; }

if(strlen($descricao) > 0){
    $insere = "INSERT into conquista (id_conquista, id_game, nome_conquista, descricao, pontuacao, tipo, plataforma) values (null, $idgame, '$nome', '$descricao', $pontuacao, $secreta, '$plataforma');";
    $executa = $conexao->query($insere);

}else{
    $insere = "INSERT into conquista (id_conquista, id_game, nome_conquista, pontuacao, tipo, plataforma) values (null, $idgame, '$nome', $pontuacao, $secreta, '$plataforma');";
    $executa = $conexao->query($insere);
}

Header("Location: ../Conquistas.php");