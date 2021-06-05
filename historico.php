<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">  
    <title>Histórico</title>
    <link rel="shortcut icon" href="img/Icones/Xbox_Logo.png">

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/animacoes.css">
    <link rel="stylesheet" type="text/css" href="css/historico.css">
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

    include_once "php_funcoes/dados_carregar.php";
    $gamerscore = $_SESSION["gamerscore"];
    $id_jogador = $_SESSION["id_usuario"];
    $data_anterior = 0; $i = 0; $confirma = 0; ?>

<body onload="atualiza_gamerscore(<?php echo $gamerscore; ?>)">

    <audio id="audio"></audio>

    <!-- Barra Topo -->
    <div id="barra_topo">
        <h2 id="titulo">Seu Histórico</h2>

        <center><i class="fab fa-xbox fa-3x" id="xbox_sm" onclick="JumpIn('historic_grid_hs', 'historic_tt')"></i></center>

        <h1><i id="conquista_sm" class="fas fa-trophy" onclick="AbreBiblio('index','historic_grid_hs', 'historic_tt')" onMouseOver="toolTip('Biblioteca')" onMouseOut="toolTip()"></i></h1>

        <h3 id="gamerscore"><?php echo $_SESSION["gamerscore"]; echo " G"; ?></h3>

        <h1 id="ultimo_game_sm"><i class="fa fa-gamepad fa-" aria-hidden="true" onclick="carregaGame()" onMouseOver="toolTip('Último Game Aberto')" onMouseOut="toolTip()"></i></h1>

        <img id="perfil_sm" src="<?php echo $_SESSION["foto_perfil"]; ?>" onclick="Perfil()">
    </div>

    <?php if($_SESSION["total_games"] > 3){ ?>
        
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
                    
                    <div class="grid-item" onclick="filtrarHistorico(<?php echo $id_game ?>)" onmouseover="select()">
                        
                        <img src="Img/Capas/<?php echo $img_capa ?>" class="capa_game">   
                        <p id="nome_game_banner"><?php echo $nome_game; ?></p>  
                    </div>
                <?php }
            }?> 
            </div>
        </div>
    <?php } ?>
    
    <!-- Botões para Adicionar um Game ou Visualizar a Biblioteca Completa -->
    <div id="opcoes_add">
        <?php if(isset($_SESSION["filtrador_historico"])){ ?>
        <input class="butao_add" type="button" value="Limpar Filtro" onclick="limparFiltro()">
        <?php } ?>

        <?php if($_SESSION["total_games"] > 3){ ?>
        <input class="butao_add" type="button" value="Filtrar por Jogo" onclick="bibliocompleta()">
        <?php } ?>
    </div>

    <div id="historic_tt"> <?php

        $estat_ano = "SELECT count(id_conquista) as 'total', year(data_alcancada) as 'ano' from alcancada where id_jogador = $id_jogador group by year(data_alcancada)";
        $executor = $conexao->query($estat_ano);

        while($historic_conquistas = $executor->fetch_assoc()){
            echo "<h3><em>";
            echo $historic_conquistas["ano"];
            echo "</em> ";
            echo $historic_conquistas["total"];

            echo "</h3><br>";
        } ?>
    </div>

    <div id="historic_grid_hs"><?php 

    if(!isset($_SESSION["filtrador_historico"])){
        $coletor = "SELECT * from alcancada where id_jogador = $id_jogador group by data_alcancada desc limit 20";
        $executa = $conexao->query($coletor);

        // Calculando a Pontuação total Obtida nas datas
        $pont_tt = "SELECT sum(c.pontuacao) as 'pont', a.data_alcancada from 
        conquista c inner join alcancada a
        on a.id_conquista = c.id_conquista
        and a.id_jogador = $id_jogador 
        group by a.data_alcancada desc
        limit 20";
        $executor_pontua = $conexao->query($pont_tt);

        if($executa->num_rows > 0){
            while($dados = $executa->fetch_assoc()){
                
                $i = 0;
                $data = $dados["data_alcancada"];

                $dados_pontua = $executor_pontua->fetch_assoc();
                if($dados_pontua["pont"] > 0)
                    $pontuacao_total = $dados_pontua["pont"];
                else
                    $pontuacao_total = 0;

                $coletor3 = "SELECT * from alcancada where data_alcancada = '$data'";
                $executa3 = $conexao->query($coletor3);

                echo "<div id='data_conq'>";

                if($data != $data_anterior){
                    $data_formatada = date('d-m-Y', strtotime($data));
                    echo $data_formatada;
                }

                echo "</div>";

                echo "<div class='grid-conquistas-pp'>";

                while($i < 6){

                    $dados3 = $executa3->fetch_assoc();
                    $id_conquista = $dados3["id_conquista"];

                    $coletor2 = "SELECT * from conquista where id_conquista = $id_conquista";
                    $executa2 = $conexao->query($coletor2);

                    if($executa2){
                        $dados2 = $executa2->fetch_assoc();

                        $pontuacao = $dados2["pontuacao"];
                        $nome_conquista = $dados2["nome_conquista"];
                        $imagem = "img/Conquistas/$id_conquista.jpg";

                        if($dados2["img_conquista"] == null && file_exists($imagem))
                            $img_conquista = "$id_conquista.jpg";
                        else
                            $img_conquista = "semimagem.jpg";

                        if(mb_strpos($dados2["img_conquista"], $id_conquista) !== true && $img_conquista != "$id_conquista.jpg" && $img_conquista != "semimagem.jpg")
                            $img_conquista = $dados2["img_conquista"];
                        else if($dados2["img_conquista"] != null && $img_conquista != "$id_conquista.jpg")
                            $img_conquista = $dados2["img_conquista"];
 
                            ?>
                            
                            <div class="grid-conq-pp" onMouseOver="toolTip('<?php echo $nome_conquista ?>')" onMouseOut="toolTip()"><img src="img/conquistas/<?php echo $img_conquista; ?>" ></div>
                      <?php

                    }else{
                        echo "<div id='quadro'>
                            <div id='quadro_pequeno'></div>
                        </div>";
                    }

                    $data_anterior = $data;
                    $i++;
                }

                if($executa3->num_rows > 6){
                    $conquistas_remancescentes = $executa3->num_rows - 6;

                    echo "<div id='quadro_remanescente'><h3>";
                        echo " e+ $conquistas_remancescentes";
                    echo "</h3></div>";
                }else{
                    echo "<div id='quadro'>      
                            <div id='quadro_pequeno_plus'></div>
                        </div>";
                }
                
                echo "</div>";

                if($pontuacao_total > 0){
                    echo "<div id='pontuacao_soma_hs'>+$pontuacao_total G's</div>";
                }
                
                echo "<br>";
            }
        }
    }else{
        $id_game = $_SESSION["filtrador_historico"];

        $coletor = "SELECT * from conquista where id_game = $id_game";
        $executa = $conexao->query($coletor);

        if($executa->num_rows > 0){
            while($dados = $executa->fetch_assoc()){

                $i = 0;
                $pontuacao_total = 0;
                $id_conquista = $dados["id_conquista"];

                $verificador = "SELECT * from alcancada where id_conquista = $id_conquista";
                $executor = $conexao->query($verificador);
                
                if($executor->num_rows > 0){

                    $dados_conq = $executor->fetch_assoc();                
                    $data = $dados_conq["data_alcancada"];
                    $pontuacao = $dados["pontuacao"];

                    if($data != $data_anterior){
                        $data_formatada = date('d-m-Y', strtotime($data));
                        echo "<div id='data_conq'>$data_formatada</div>";
                    }

                    if($data != $data_anterior)
                        echo "<div class='grid-conquistas-pp'>";
                    
                        $imagem = "img/Conquistas/$id_conquista.jpg";

                        if($dados["img_conquista"] == null && file_exists($imagem))
                            $img_conquista = "$id_conquista.jpg";
                        else
                            $img_conquista = "semimagem.jpg";

                        if(mb_strpos($dados["img_conquista"], $id_conquista) !== true && $img_conquista != "$id_conquista.jpg" && $img_conquista != "semimagem.jpg")
                            $img_conquista = $dados["img_conquista"];
                        else if($dados["img_conquista"] != null && $img_conquista != "$id_conquista.jpg")
                            $img_conquista = $dados["img_conquista"];

                        echo "<div id='quadro'>";        
                            echo "<img class='grid-conq-pp' id='conquista_pp' src='img/conquistas/$img_conquista'>";
                        echo "</div>";

                        if($confirma = 1)
                            echo "</div><br>";

                    $i++;
                    $data_anterior = $data;
                    $pontuacao_total += $pontuacao;
                }
                if($pontuacao_total > 0){
                    echo "<div id='pontuacao_soma_hs'>+$pontuacao_total G's</div>";
                }
            }
        }
    } ?>
    </div><br><br><br><br>

    <!-- Div para transitar entre as páginas -->
    <div id="transitador"></div>
    <div id="fundo_historic"></div>

</body>
</html>