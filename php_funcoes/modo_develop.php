<?php

session_start();

$pagina = $_GET["pagina"];

if(isset($_SESSION["develop"])){
    unset($_SESSION["develop"]);
    $_SESSION["msg_sessao"] = "<h3>O Modo Develop está desativado.</h3>";
}else{
    $_SESSION["develop"] = 1;
    $_SESSION["msg_sessao"] = "<h3>O Modo Develop está ativo.</h3>";
}

header("Location: ../$pagina.php");