<?php 

include_once "../php_sessao/conexao_obsoleta.php";
$i = 1;

while($i < 118){

    $insere = "INSERT into jogos_possuidos (id_game, id_user) values ($i, 1)";
    $confirma = $conexao->query($insere);

    $i++;
}

header("Location: ../biblioteca.php");