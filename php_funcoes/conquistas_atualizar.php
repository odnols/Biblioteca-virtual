<?php include_once "../php_sessao/conexao_obsoleta.php"; 

session_start();

date_default_timezone_set('America/Sao_Paulo');
$data = date('Y-m-d H:i');

$id_jogador = $_SESSION["id_usuario"];

if(isset($_GET["id_conq"])){ 
    
    $dado = $_GET["id_conq"];

    $convert = trim($dado);
	$dados = explode('?', $convert);

    $id_conquista = $dados[0];
    $modo = $dados[1];

    if(strlen($dados[2]) > 0){
        $data = $dados[2];

        $dataConvertida = date('Y-m-d', strtotime($data));
        $data = $dataConvertida;
    }

} else { $id_conquista = $_POST["id_conq"]; }

if(isset($_POST["modo"])) { $modo = $_POST["modo"]; }


# Determinando qual vai ser o modo de atualização, entre edição e atualização de status ( obtida ou nao )
if($modo == 1){

    $selecionar_conquista = "SELECT descricao from conquista where id_conquista = $id_conquista";
    $executor = $conexao->query($selecionar_conquista);

    $dado = $executor->fetch_assoc();
    $descricao_banco = $dado["descricao"];

    $nome = $_POST["nome"];
    $descricao = $_POST["descricao"];
    $pontuacao = $_POST["pontuacao"];
    $arq_name = $_FILES["img"]["name"];

    if(isset($_POST["secreta"])) $secreta = 1; else $secreta = 0;

    # Conferindo se o usuário possúi a conquista
    if(strlen($nome) > 0){
        $insere = "UPDATE conquista set nome_conquista = '$nome' where id_conquista = $id_conquista";
        $executa = $conexao->query($insere);
    }

    # Verifica se a nova descrição tem mais de 1 Caractere e se ela é diferente da Descrição do Banco
    if(strlen($descricao) > 0 && $descricao != $descricao_banco){
        $insere = "UPDATE conquista set descricao = '$descricao' where id_conquista = $id_conquista";
        $executa = $conexao->query($insere);
    }

    $insere = "UPDATE conquista set pontuacao = '$pontuacao' where id_conquista = $id_conquista";
    $executa = $conexao->query($insere);

    $insere = "UPDATE conquista set tipo = $secreta where id_conquista = $id_conquista";
    $executa = $conexao->query($insere);

    if(strlen($arq_name) > 0){
        // Criando uma cópia da imagem
        move_uploaded_file($arq_tmp, "C:\wamp64\www\Conquistas\Sistema\IMG/". $arq_name);
    }
}else{

    $confere = "SELECT * from alcancada where id_conquista = $id_conquista and id_jogador = $id_jogador";
    $executa_busca = $conexao->query($confere);

    // Buscando o valor da pontuação da conquista
    $pontua = "SELECT pontuacao from conquista where id_conquista = $id_conquista";
    $executa_pontua = $conexao->query($pontua);

    $dado = $executa_pontua->fetch_assoc();
    $pontuacao = $dado["pontuacao"];

    if($executa_busca->num_rows > 0){
        $dados = $executa_busca->fetch_assoc();

        $id_alcance = $dados["id_alcance"];

        $deleta = "DELETE from alcancada where id_alcance = $id_alcance";
        $executa = $conexao->query($deleta);

        // Atualizando o visor do Total de Conquistas Obtidas
        $_SESSION["total_conquistas"] -= 1;
        $_SESSION["gamerscore"] -= $pontuacao;
    }else{

        $atualiza = "INSERT INTO alcancada (id_conquista, id_jogador, data_alcancada) values ($id_conquista, $id_jogador, '$data')";
        $executa = $conexao->query($atualiza);

        // Atualizando o visor do Total de Conquistas Obtidas
        $_SESSION["total_conquistas"] += 1;
        $_SESSION["gamerscore"] += $pontuacao;
    }

}

Header("Location: ../conquistas.php");