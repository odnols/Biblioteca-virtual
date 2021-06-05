<?php 

include_once "../php_sessao/conexao_obsoleta.php";
session_start();

$arquivo_tmp = $_FILES["arquivo"]["tmp_name"];
$nome_arquivo = $_POST["arquivo"];
$plataforma = $_POST["plataforma"];
$excessao = $_POST["excessao"];

$id_game = $_POST["id_game"]; 

// Lendo o arquivo para um array
$dados = file($arquivo_tmp);

// Criando posições numa linha comparando se existe no banco e inserindo ou atualizando
foreach ($dados as $linha) {

	$linha = trim($linha);
	$valor = explode(';/', $linha);

	$data = $valor[0];

	if($plataforma != "PC")
		$pontuacao = $valor[1];
	else
		if(isset($excessao))
			$pontuacao = $valor[1];
		else
			$pontuacao = 0;

	$nome_conq = $valor[2];

	if(isset($valor[3]) > 0)
		$descricao = $valor[3];
	else
		$descricao = null;

	if(strlen($descricao) > 1)
		$inserir = "INSERT into conquista (id_game, nome_conquista, pontuacao, descricao, plataforma) values ($id_game, '$nome_conq', $pontuacao, '$descricao', '$plataforma')";
	else
		$inserir = "INSERT into conquista (id_game, nome_conquista, pontuacao, plataforma) values ($id_game, '$nome_conq', $pontuacao, '$plataforma')";

    // Inserindo os valores no banco de dados
    $executa = $conexao->query($inserir);
}

// Verificando se foi realizado a importação da célula de dados
if(isset($executa))
	$_SESSION["msg_impt"] = "Arquivo importado com sucesso!";
else
    $_SESSION["msg_impt"] = "<h5 style='color: red'>Não foi possivel importar o arquivo, verifique ele e tente novamente</h5>";

header("Location: ../conquistas.php"); ?>