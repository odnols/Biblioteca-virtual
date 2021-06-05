<?php require_once "conexao_obsoleta.php";

$email = $_POST["gamertag"];
$senha = $_POST["senha"];

$query = "SELECT id_user, gamertag, senha FROM usuario";

$resultado = $conexao->query($query);

if($resultado->num_rows > 0){
	while($linha = $resultado->fetch_assoc()){

		if(strlen($linha["id_user"]) > 0){ $usuario = $linha["id_user"]; } else { $usuario = $linha["gamertag"]; }
		$senha_real = $linha["senha"];
	
		//  Verifica se o email ou o id ou o telefone corresponte e se a senha está correta
		if($email == $usuario && $senha == $senha_real){

			$controle = 1;

			session_start();
			$_SESSION["id_usuario"] = $linha["id_user"];

			$_SESSION["logado"] = 1;
			header("Location: ../index.php");
		}else{ // Informações erradas
			header("Location: ../index.php?ERROR=001");
		}
	}
}else // Banco de Dados de usuários vazio
	header("Location: ../index.php?ERROR=004");