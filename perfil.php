<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">  
    <title>Perfil</title>
    <link rel="shortcut icon" href="img/Icones/Xbox_Logo.png">

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/perfil.css">
    <link rel="stylesheet" type="text/css" href="css/animacoes.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css">
</link>

    <script type="text/javascript" src="JS/funcoes.js"></script>

    <?php
    include_once "php_sessao/verifica_sessao.php";
    include_once "php_funcoes/dados_carregar.php"; ?>

</head>
<body onload="atualiza_gamerscore(<?php echo $_SESSION['gamerscore']; ?>)">

    <audio id="audio"></audio>

    <!-- Barra Topo -->
    <div id="barra_topo">
        <h2 id="titulo">Seu Perfil</h2>

        <center><img id="xbox_sm" src="img/Icones/Xbox_Logo.png" onclick="JumpIn('itens_barra')"></center>

        <div id="itens_barra">
            <img id="conquista_sm" src="img/Icones/Conquista.png" onclick="AbreBiblio('perfil','cabecalho_perfil', 'opcoes_add')">
            <h3 id="gamerscore"></h3>
        </div>
    </div>

    <?php if($_SESSION["moderacao"] == 1){ ?>
    <div id="opcoes_add">
        <input class="butao_add" type="button" value="Modo Desenvolvedor" onclick="Desenvolvedor('Perfil')">
    </div>
    <?php } ?>

    <div id="cabecalho_perfil">
        <img id="img_perfil" src="<?php echo $_SESSION['foto_perfil']; ?>">

        <div id="texto_perfil">
            <h1 id="nome_jogador"><?php echo $_SESSION["gamertag"];   
            
            if(isset($_SESSION["develop"]))
                echo " <i class='fa fa-cogs' aria-hidden='true' style='color: yellow'></i>";
            ?></h1><hr><br><br>

            <h3>Plataformas  <i class='fab fa-windows'></i> <i class='fab fa-xbox'></i> <i class="fab fa-steam" aria-hidden="true"></i> <i class="fab fa-android" aria-hidden="true"></i></h3>
            <h3>Jogos Iniciados: <?php echo $_SESSION["total_games"]; ?></h3>
            <h3>Conquistas Coletadas: <?php echo $_SESSION["total_conquistas"]; ?></h3>
            <br>
            <h4><?php if(strlen($_SESSION["biografia"]) > 0){ echo "Bio: ", $_SESSION["biografia"], ""; } else {
                echo "Sem Biografia inserida."; }?></h4>
        
            <div id="mensagens">
            <?php if(isset($_SESSION["msg_sessao"])){
                echo $_SESSION["msg_sessao"];
                unset($_SESSION["msg_sessao"]);
                }
            ?>
            </div>

        </div>
    </div>

    <div id="fundo"></div>

    <!-- Div para transitar entre as páginas -->
    <div id="transitador"></div>

    <div id="rodape">
        <h3>Versão 1.0</h3>
    </div>
</body>
</html>