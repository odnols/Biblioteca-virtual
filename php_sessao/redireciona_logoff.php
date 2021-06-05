<?php require_once "conexao_obsoleta.php";
session_start();
	
$iduser = $_SESSION["id_usuario"];

// Conferindo o status do usuário e diminuindo a quantidade de sessões
$busca = "SELECT status_user from usuarios where userid = $iduser";
$executa_busca = $conexao->query($busca);

$dados = $executa_busca->fetch_assoc();
$status_user = $dados["status_user"] - 1;

// Atualizando o status no banco de dados
$atualizar = "UPDATE usuarios set status_user = $status_user where userid = '$iduser'";
$conexao->query($atualizar);

// Deletando a sessão
session_unset($_SESSION);
session_destroy();
header("Location: ../index.php");