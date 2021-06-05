<html>
    <link rel="stylesheet" type="text/css" href="../css/conquistas.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/animacoes.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css">

    <script type="text/javascript" src="../JS/funcoes.js"></script>
<body>
<?php
require_once "../php_sessao/conexao_obsoleta.php";
session_start();

$id_conquista = $_GET["idconq"];
$id_jogador = $_SESSION["id_usuario"];
$procura_game = 0;

$coletor = "SELECT * FROM conquista where id_conquista = $id_conquista";
$executa = $conexao->query($coletor);

$dados = $executa->fetch_assoc();

$nome = $dados["nome_conquista"];
$game = $dados["id_game"];
$pontuacao = $dados["pontuacao"];
$descricao = $dados["descricao"];
$secreta = $dados["tipo"];
$plataforma = $dados["plataforma"];

$img_conquista = $dados["img_conquista"];

if($secreta == 0 || $secreta == null)
    $checkbox = null;
else
    $checkbox = "checked";

if($plataforma == "Xbox One")
    $plat_conq = 1;
else if($plataforma == "Xbox 360")
    $plat_conq = 2;
else if($plataforma == "PC")
    $plat_conq = 3;

if(strlen($descricao) == 0 && isset($_SESSION["develop"]))
    $descricao = "Descrição";
else{
    echo "<style>
        #text_area{
            color: black;
        }
    </style>";
}

$imagem = "../img/Conquistas/$id_conquista.jpg";

# Verificando se a Imagem da Conquista Existe
if($dados["img_conquista"] == null && file_exists($imagem))
    $img_conquista = "$id_conquista.jpg";
else
    $img_conquista = "semimagem.jpg";

if(mb_strpos($dados["img_conquista"], $id_conquista) !== true && $img_conquista != "$id_conquista.jpg" && $img_conquista != "semimagem.jpg")
    $img_conquista = $dados["img_conquista"];
else if($dados["img_conquista"] != null && $img_conquista != "$id_conquista.jpg")
    $img_conquista = $dados["img_conquista"];

$game = "SELECT img_game from game where id_game = $game";
$executa = $conexao->query($game);

$dados = $executa->fetch_assoc();
$img_capa = $dados["img_game"];

# Verificar se o jogador pegou a conquista
$verificar = "SELECT * from alcancada where id_conquista = $id_conquista and id_jogador = $id_jogador";
$executa_busca2 = $conexao->query($verificar);

$dados = $executa_busca2->fetch_assoc();
$data_conquista = $dados["data_alcancada"];

echo "<style>
        #fundo3{
            background-image: url('../img/Capas/Capas_Grandes/$img_capa');
            animation: anima_fundo 50s infinite;
        }  
        </style>"

?>

<div id="fundo3"></div>
<div id="fundo4"></div>

<div id="att_conquista">
    <div id="dados_conq">
        
    <br><br>
        <form action="conquistas_atualizar.php" method="POST" enctype="multipart/form-data">
        <div id="texto_conq">
 
            <?php if(isset($_SESSION["develop"])){ ?>
                <input class="input_conq" name="modo" value="1" style="display: none;">

                <h2>
                <input class="input_conq" name="nome" placeholder="Nome" value="<?php echo $nome ?>" required maxlength="255" style="width: 380px"></h2>
                
                <h2>
                <textarea class="input_conq" id='text_area' name="descricao" placeholder="<?php echo $descricao; ?>" maxlength="500" rows="4" cols="24" style="color: black; resize: none;"></textarea></h2>

                <h2>Pontuação:
                <input class="input_conq" name="pontuacao" value="<?php echo $pontuacao ?>" style="width: 100px" required></h2>
 
                <h2>Secreta: <input type="checkbox" name="secreta" id="checkbox_historico" value="on" <?php echo $checkbox;?>></h2>

                <input class="input_conq" name="id_conq" value="<?php echo $id_conquista ?>" style="display: none" readonly>

            <?php }else{ ?>

            <h1><?php echo $nome ?></h1>
            <h2 id="pontuacao_conq"><?php if($plataforma != "PC")
            
            if($pontuacao > 0) echo "$pontuacao G"; else echo "???"; else echo "<i class='fab fa-steam' aria-hidden='true'></i>"; ?></h2>
            <div id="descricao_conquista">
                <hr id="conq_hr">
            
                <?php if($data_conquista){
                    $data_conquista = date('d-m-Y', strtotime($data_conquista));

                    echo "<h3>Alcançada em $data_conquista</h3><br>";
                } ?>

                <p id="descricao_conq"><?php if(strlen($descricao) > 0) echo $descricao; else if($nome != "Conquista secreta") echo "Não há uma descrição ainda."; else echo "Continue jogando para ter a chance de liberar essa conquista."; ?></p>
            </div>

            <?php } ?>
            <?php if(isset($_SESSION["develop"])){ ?>
            <input class="button_confirma" type="submit" value="Atualizar" style='color: black'>
            <?php } ?>
        </div>
        
        <?php 

            $pesquisa_img = "../Img/Conquistas/"."". $img_conquista;
            list($largura_original, $altura_original) = getimagesize($pesquisa_img);

            if($largura_original > 100)
                $plat_conq = 1;
            else
                $plat_conq = 2;
    ?>
        <div id="img_conq">
            <?php if($data_conquista == null)
                if($plat_conq == 3 || $plat_conq == 2) // PC e Xbox 360
                    $status_conquista = "conq_bloqueada_espec";
                else
                    $status_conquista = "conq_bloqueada";
            else
                $status_conquista = null;
            
            if($plat_conq == 3 || $plat_conq == 2)
                echo "<div class='fundo_desfocado prancheta_att_fundo $status_conquista' style='background-image: url(../img/Conquistas/$img_conquista)'></div>";

            echo "<img id='img_conquista' class='img_plat_$plat_conq preview_$status_conquista' src='../img/Conquistas/$img_conquista'>"; 
            
            ?>

            <div id="quadro_img"></div>
            
            <?php if($secreta == 1 || $nome == "Conquista secreta"){
                    echo "<i class='fas fa-user-secret fa-5x' id='icon_secret'></i>";
                } ?>
            
            <div id="icon_option">

                <?php if($executa_busca2->num_rows > 0){
                    echo "<i id='status_conq' class='fa fa-check-circle fa-3x' aria-hidden='true' title='Obtida'></i>";
                }else{
                    echo "<i id='status_conq' class='fa fa-times-circle fa-3x' aria-hidden='true' title='Não obtida'></i>";
                } ?>
            
            <?php if(isset($_SESSION["develop"])){ ?>
                <i class="fa fa-trash fa-3x" id="lixeira_conq" aria-hidden="true" onclick="apagar_conquista(<?php echo $id_conquista; ?>)"></i>
            </div>
            <?php } ?>
        </div>

        <?php if(isset($_SESSION["develop"])){ ?>
        <input id="input_add_imagem" type="file" name="arquivo" style="color: white" maxlength="50">
        <?php } ?>

        </form>
    </div>
</div>
</body>
</html>