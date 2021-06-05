<?php include_once "../php_sessao/conexao_obsoleta.php";

session_start();

$id_conquista = $_GET["idconq"];

$apagador = "DELETE from conquista where id_conquista = $id_conquista";
$executor = $conexao->query($apagador);

Header("Location: ../Conquistas.php");