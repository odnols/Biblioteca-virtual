<?php include_once "../php_sessao/conexao_obsoleta.php";
session_start();

$nome = $_POST["nome"];
$plataformas = $_POST["plataformas"];
$arq_name = $_FILES["arq"]["name"]; //O nome do ficheiro
$arq_size = $_FILES["arq"]["size"]; //O tamanho do ficheiro
$arq_tmp = $_FILES["arq"]["tmp_name"]; //O nome temporário do arquivo

$verificar = "SELECT nome_game from game where nome_game like '$nome'";
$executa = $conexao->query($verificar);

$registro = $executa->num_rows;

if($registro == 0){
    $insere = "INSERT into game (id_game, nome_game, img_game, plataforma) values (null, '$nome', '$arq_name', '$plataformas')";
    $executa_insercao = $conexao->query($insere);

    // Criando uma cópia da capa
    move_uploaded_file($arq_tmp, "C:\wamp64\www\Conquistas\Sistema\Img\Capas/". $arq_name);
    $_SESSION["msg_sessao"] = "<h3>Jogo Adicionado!</h3>";
}else
    $_SESSION["msg_sessao"] = "<h3 style='color: red'>Este Jogo já foi adicionado anteriormente, tente outro título.</h3>";

$_SESSION["addjogo"] = 1;

header("Location: ../biblioteca.php");