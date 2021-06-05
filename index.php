<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">  
    <title>Biblioteca Digital</title>
    <link rel="shortcut icon" href="img/Icones/Xbox_Logo.png">

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/animacoes.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- Slick -->
    <link rel="stylesheet" type="text/css" href="slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>

    <script src="https://kit.fontawesome.com/6c1b2d82eb.js" crossorigin="anonymous"></script>

    <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="slick/slick.min.js"></script>
    <script type="text/javascript" src="JS/funcoes.js"></script>
    <style>
        body{
            position: absolute;
            overflow-y: hidden;
            overflow-x: hidden;
        }
    </style>
</head>

<?php session_start();
    if(isset($_SESSION["logado"])){ include_once "php_funcoes/dados_carregar.php"; } 
    if(isset($_SESSION["logado"])) { $gamerscore = $_SESSION["gamerscore"]; }?>

<body onload="atualiza_gamerscore(<?php if(isset($_SESSION['logado'])){ echo $gamerscore; }?>)">
    
    <audio id="audio"></audio>
    <!-- Barra Topo -->
    <div id="barra_topo">
        <h2 id="titulo"><?php if(isset($_SESSION["gamertag"])){ echo $_SESSION["gamertag"]; }else{ echo "Faça Login"; } ?></h2>

        <center><img id="xbox_sm" src="img/Icones/Xbox_Logo.png"></center>

        <h1 id="historico_sm"><i class="fas fa-calendar-alt" onclick="<?php if(isset($_SESSION["id_usuario"])){ ?>AbreHistorico('index','carrosel_fundo')<?php }else{ ?>avisa_popup('o Histórico')<?php }?>"></i></h1>

        <h1><i id="conquista_sm" class="fas fa-trophy" onclick="<?php if(isset($_SESSION["id_usuario"])){ ?>AbreBiblio('index','carrosel_fundo')<?php }else{ ?>avisa_popup('as Conquistas')<?php }?>"></i></h1>

        <h3 id="gamerscore"><?php if(isset($_SESSION["logado"])) { echo $_SESSION["gamerscore"]; echo " G"; } ?></h3>

        <img id="perfil_sm" src="<?php if(isset($_SESSION["gamertag"])){ echo $_SESSION["foto_perfil"]; }else{ echo "img/Icones/avatar.png"; } ?>" onclick="<?php if(isset($_SESSION["id_usuario"])){ ?>Perfil('carrosel_fundo')<?php }else{ ?>login()<?php }?>">
        
    </div>
    
    <div id="formulario_login">
        <h1 style="color: white;">Quase lá...</h1><hr id="hr_login">
        
        <!-- Formulários de Login -->
        <div id="formularios_lg">
        <form name="loga" class="Logah" action="php_sessao/usuario_confirmar_login.php" method="post">
            <h2>
            <input type="text" name="gamertag" required="" placeholder="Gamertag" maxlength="100" value='1'><br><br>
        
            <input type="password" name="senha" required="" placeholder="Senha" maxlength="50" value='212212'><br><br>
            </h2>
            <button class="btn btn-custom btn-lg page-scroll configura_perfil">Entrar</button>
        </form>
        </div>

    </div>

    
    <!-- Slider Fundo -->
    <div id="carrosel_fundo">
        <div><img class="carrosel" src="img/Banners/Gta1.png"></div>
        <div><img class="carrosel" src="img/Banners/Forza3.png"></div>
        <div><img class="carrosel" src="img/Banners/Assassins1.png"></div>
        <div><img class="carrosel" src="img/Banners/Gta2.png"></div>
        <div><img class="carrosel" src="img/Banners/Forza2.png"></div>
        <div><img class="carrosel" src="img/Banners/Gta3.png"></div>
        <div><img class="carrosel" src="img/Banners/Gta4.jpg"></div>
        <div><img class="carrosel" src="img/Banners/Cities1.png"></div>
    </div>

    <!-- Div para transitar entre as páginas -->
    <div id="transitador"></div>
    <div id="fundo"></div>

    <div id="rodape">
        <h3>Versão 1.0</h3>
    </div>
</body>
</html>