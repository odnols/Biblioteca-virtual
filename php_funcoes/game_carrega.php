<?php

include_once "../php_sessao/verifica_sessao.php";
include_once "../php_sessao/conexao_obsoleta.php";

if(!isset($_GET["plat"])){
    $id_game = $_GET["id"];

    // Apagando a plataforma da sessão
    if(isset($_SESSION["plataforma"])){
        unset($_SESSION["plataforma"]);
    }

    $plataforma = "SELECT plataforma from game where id_game = $id_game";
    $verificador = $conexao->query($plataforma);

    $dados = $verificador->fetch_assoc();
    $plataformas = $dados["plataforma"];

    if(strpos($plataformas, "Xbox One") !== false){
        $_SESSION["plataforma"] = "Xbox One";
    }
    if(strpos($plataformas, "Xbox 360") !== false){
        if(!isset($_SESSION["plataforma"]))
            $_SESSION["plataforma"] = "Xbox 360";
    }
    if(strpos($plataformas, "PC") !== false){
        if(!isset($_SESSION["plataforma"]))
            $_SESSION["plataforma"] = "PC";
    }
    if(strpos($plataformas, "Android") !== false){
        if(!isset($_SESSION["plataforma"]))
            $_SESSION["plataforma"] = "Android";
    }

    $_SESSION["ultimoGame"] = $id_game;
}else{
    $_SESSION["plataforma"] = $_GET["plat"];
}

Header("Location: ../conquistas.php");