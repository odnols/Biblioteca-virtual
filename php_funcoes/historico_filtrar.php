<?php session_start();

if($_GET["idgame"]){
    $id_game = $_GET["idgame"];

    $_SESSION["filtrador_historico"] = $id_game;
}else{
    unset($_SESSION["filtrador_historico"]);
}

header("Location: ../historico.php");