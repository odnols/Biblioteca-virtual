<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">  
    <title>Sua Biblioteca</title>
    <link rel="shortcut icon" href="Img/Icones/Xbox_Logo.png">

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/biblio.css">
    <link rel="stylesheet" type="text/css" href="css/animacoes.css">
    <link rel="stylesheet" type="text/css" href="css/responsividade.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- Slick -->
    <link rel="stylesheet" type="text/css" href="slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>

    <script src="https://kit.fontawesome.com/6c1b2d82eb.js" crossorigin="anonymous"></script>
    
    <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="slick/slick.min.js"></script>
    <script type="text/javascript" src="JS/tooltip.js"></script>
    <script type="text/javascript" src="JS/funcoes.js"></script>

</head>

<?php session_start();  

    require_once "php_sessao/verifica_sessao.php";
    
    $jogo = 1;
    $jogos = 0;
    $repeticao = 0;
    $lista_games = array();
    $lista_games2 = array();
    $id_conquistas = array();
    $needle_array = array();

    $id_jogador = $_SESSION["id_usuario"];

    if(isset($_SESSION["logado"])){ include_once "php_funcoes/dados_carregar.php"; } 
    if(isset($_SESSION["logado"])) { $gamerscore = $_SESSION["gamerscore"]; }
    if(isset($_SESSION["addjogo"])) { $addjogo = $_SESSION["addjogo"]; unset($_SESSION["addjogo"]); }else{ $addjogo = 0; }
    
    
    function count_repeat_values($needle, $haystack){
        $repeticoes = 0;

        $x = count($haystack);

        for($i = 0; $i < $x; $i++){
           
            if($haystack[$i] == $needle){
                $repeticoes += 1;
            }
        }
        
        // echo $repeticoes;
        return $repeticoes;
    } ?>

<body onload="atualiza_gamerscore(<?php if(isset($_SESSION['logado'])){ echo $gamerscore; }?>), checaadd(<?php echo $addjogo; ?>)">
    
    <audio id="audio"></audio>
    <!-- Menu Superior -->
    <div id="barra_topo">
        <h2 id="titulo">Seus Games</h2>

        <center><img id="xbox_sm" src="img/Icones/Xbox_Logo.png" onclick="JumpIn('itens_barra')"></center>
        <img id="conquista_sm" src="img/Icones/Conquista.png">

        <h1 id="historico_sm"><i class="fas fa-calendar-alt" onclick="AbreHistorico('index','carrosel_fundo')" onMouseOver="toolTip('Histórico')" onMouseOut="toolTip()"></i></h1>

        <img id="perfil_sm" src="img/Perfil/SlondoTk.png" onclick="Perfil('corpo_pagina')">
        
        <div id="itens_barra">
            <h3 id="gamerscore"></h3>
        </div>
    </div>

    <div id="corpo_pagina">
        <div id="estatisticas">
            Biblioteca: <?php echo $_SESSION["total_games"] ?><br><br>
            Jogos Concluídos:<br><br>
            Conquistas Coletadas: <?php echo $_SESSION["total_conquistas"] ?><br><br>
            Conquistas no Total: <?php echo $_SESSION["conquistas_globais"] ?>
        </div>

        <!-- Últimos Jogos Atualizados -->
        <div id="ultimos_atualizados">
            <?php // Buscando os últimos 5 games atualizados
 
                // Recolhendo e ordenando os games pela data da última conquista obtida
                $verifica_conquista = "SELECT * from alcancada where id_jogador = $id_jogador";
                $verifica1 = $conexao->query($verifica_conquista);

                if($verifica1->num_rows > 0){
                        
        echo "<h2>Últimos Jogos Atualizados</h2>";
            echo "<div class='grid-container'>";

                    $verifica_conquista = "SELECT * from alcancada where id_jogador = $id_jogador order by data_alcancada desc";
                    $verificador = $conexao->query($verifica_conquista);
                    
                    if($verificador->num_rows > 0){
                        while($dados = $verificador->fetch_assoc()){
                            array_push($id_conquistas, $dados["id_conquista"]);
                        }
                    }
                    
                    while($jogo < 7){
                        
                        while($jogos < 6){

                            $total_conquista_col = sizeof($id_conquistas);

                            for($i = 0; $i < $total_conquista_col; $i++){
                                if(isset($id_conquistas[$i])){
                                
                                    $idconquista = $id_conquistas[$i];

                                    $pegaconquista = "SELECT * from conquista where id_conquista = $idconquista";
                                    $executa = $conexao->query($pegaconquista);

                                    $dadosconq = $executa->fetch_assoc();

                                    $idgame = $dadosconq["id_game"];

                                    $recolhe_game = "SELECT * from game where id_game = $idgame";
                                    $busca_game = $conexao->query($recolhe_game);
                                }else{
                                    
                                    $seletor = "SELECT * from game order by rand()";
                                    $busca_game = $conexao->query($seletor);
                                }

                                $dados = $busca_game->fetch_assoc();

                                array_push($lista_games, $dados["id_game"]);

                                if(count_repeat_values($dados["id_game"], $lista_games) == 1){
                                    array_push($lista_games2, $dados["id_game"]);
                                    $jogos++;
                                }
                            }
                        }
                        
                        $id_game = $lista_games2[$jogo - 1];
                        $busca_jogo = "SELECT * from game where id_game = $id_game";
                        $executa_busca_jogo = $conexao->query($busca_jogo);
                        
                        $dados = $executa_busca_jogo->fetch_assoc();

                        $id_game = $dados["id_game"];
                        $nome_game = $dados["nome_game"];
                        $img_capa = $dados["img_game"];
                        
                        if($jogo == 1){
                            echo "<div class='grid-item1' onclick='AbrirConquistas($id_game)' onmouseover='select()'>
                                <img src='img/Capas/Capas_Grandes/$img_capa' class='capa_game_max'>";
                            echo "</div>";
                        }else{
                            echo "<div class='grid-item' onclick='AbrirConquistas($id_game)' onmouseover='select()'>
                                <img src='img/Capas/$img_capa' class='capa_game'>";
                            echo "</div>";
                        }
                        $jogo++;
                    }
                }else{
                        
        echo "<h2>Ainda não há jogos iniciados :(</h2>";
            echo "<div class='grid-container'>";

                        $seletor = "SELECT * from game order by rand() limit 5";
                        $executa = $conexao->query($seletor);
                        
                        while($dados = $executa->fetch_assoc()){

                            $id_game = $dados["id_game"];
                            $nome_game = $dados["nome_game"];
                            $img_capa = $dados["img_game"];

                            if($jogo == 1){
                                echo "<div class='grid-item1' onclick='AbrirConquistas($id_game)' onmouseover='select()'>
                                    <img src='img/Capas/Capas_Grandes/$img_capa' class='capa_game_max'>";
                                echo "</div>";
                            }else{
                                echo "<div class='grid-item' onclick='AbrirConquistas($id_game)' onmouseover='select()'>
                                    <img src='img/Capas/$img_capa' class='capa_game'>";
                                echo "</div>";
                            }
                            
                            $jogo++;
                        }
                    } ?>
                </div>
            </div>
        </div>
        
        <?php if($_SESSION["total_games"] > 5){ ?>
        
        <!-- Biblioteca Completa de jogos -->
        <div id="biblioteca_completa">
            <div class="grid-container"><?php

            $recolhe = "SELECT * from game order by nome_game";
            $executa_busca = $conexao->query($recolhe);

            if($executa_busca->num_rows > 0){
                while ($dados = $executa_busca->fetch_assoc()){
                    $id_game = $dados["id_game"];

                    $busca_conquista = "SELECT count(id_conquista) as 'total' from conquista where id_game = $id_game";
                    $executador_conquista = $conexao->query($busca_conquista);

                    $dado = $executador_conquista->fetch_assoc();
                    $tt_conquista = $dado["total"];

                    $nome_game = $dados["nome_game"];
                    $img_capa = $dados["img_game"]; ?>
                    
                    <div class="grid-item" onclick="AbrirConquistas(<?php echo $id_game ?>)" onmouseover="select()">
                        
                        <img src="Img/Capas/<?php echo $img_capa ?>" class="capa_game">   
                        <p id="nome_game_banner"><?php echo $nome_game; ?></p>  
                    </div>
                <?php }
            }?> 
            </div>
        </div>
        <?php } ?>
        
    <!-- Formulário para adicionar um jogo -->
    <form id="form_add_jogo" action="php_funcoes/jogos_adicionar.php" method="POST" enctype="multipart/form-data">

    <div id="mensagens">
        <?php if(isset($_SESSION["msg_sessao"])){
            echo $_SESSION["msg_sessao"];
            unset($_SESSION["msg_sessao"]);
        } ?>
    </div>

    <center>
        <h2 id="h2_text">Nome</h2>
        <input name="nome" type="text" required>
        
        <h2 id="h2_text">Plataforma</h2>
        <select name="plataformas">
            <option value="PC">Steam</option>
            <option value="Android">Android</option>
            <option value="Xbox 360">Xbox 360</option>
            <option value="Xbox One">Xbox One</option>
        </select>

        <h2 id="h2_text">Capa </h2>
        <input type="file" name="arq" style="color: white" required><br>

        <input type="submit" value="Inserir">
    </center>
    </form>
    
    <!-- Botões para Adicionar um Game ou Visualizar a Biblioteca Completa -->
    <div id="opcoes_add">
        
        <input class="butao_add" type="button" value="Opções" onclick="opcoes()">

        <?php if(isset($_SESSION["develop"])) { ?>
        <input class="butao_add" type="button" value="Adicionar Jogo" onclick="adicionar_jogo()">
        <?php }
        
        if($_SESSION["total_games"] > 5){ ?>
        <input class="butao_add" type="button" value="Biblioteca Completa" onclick="bibliocompleta()">
        <?php }

        if($_SESSION["total_games"] > 1){ ?>
        <input class="butao_add" type="button" value="Jogo Aleatório" onclick="aleatorizador(<?php echo $_SESSION['total_games']; ?>, 'biblioteca')">
        <?php } ?>
    </div>

    <!-- Transitador entre as páginas e animações -->
    <div id="transitador"></div>
    <div id="fundo2"></div>
    <div id="fundo3"></div>

    <div id="rodape">
        <h3>Versão 1.0</h3>
    </div>
</body>
</html>