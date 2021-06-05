<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">  
    <title>Conquistas</title>
    <link rel="shortcut icon" href="img/Icones/Xbox_Logo.png">

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/conquistas.css">
    <link rel="stylesheet" type="text/css" href="css/animacoes.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css">

    <!-- Slick -->
    <link rel="stylesheet" type="text/css" href="slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>

    <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="slick/slick.min.js"></script>
    <script type="text/javascript" src="JS/tooltip.js"></script>
    <script type="text/javascript" src="JS/funcoes.js"></script>
</head>
<?php session_start();;

    $iduser = $_SESSION["id_usuario"];
    $conta_conquistas = 0;
    $total_conquistas_alc = 0;
    $total_pontuacao_alc = 0;

    $pontuacao_total = 0;
    $soma_pontuacao = 0;
    $plat_cont = 0;
    $primeira_conquista = 0;

    if(isset($_SESSION["logado"])){ include_once "php_funcoes/dados_carregar.php"; } 
    if(isset($_SESSION["logado"])) { $gamerscore = $_SESSION["gamerscore"]; }?>

<body onload="atualiza_gamerscore(<?php if(isset($_SESSION['logado'])){ echo $gamerscore; }?>)">

    <audio id="audio"></audio>
    <?php
    $id_game = $_SESSION["ultimoGame"];
    $plataforma_esc = $_SESSION["plataforma"];

    // Salvando o id do último game acessado
    $_SESSION["ultimoGame"] = $id_game;

    $pegardados = "SELECT * from game where id_game = $id_game";
    $executa_busca = $conexao->query($pegardados);

    if($executa_busca->num_rows > 0){
        while ($dados = $executa_busca->fetch_assoc()){
            $nome_game = $dados["nome_game"];
            $img_capa = $dados["img_game"];
        }
    }else{
        Header("Location: php_funcoes/game_carrega.php?id=55");
    }

    echo "<style>
        #fundo3{
            background-image: url('img/Capas/Capas_Grandes/$img_capa');
        }
        </style>"; ?>
    
    <div id="barra_topo">
        <!-- Barra de Porcentagem do Game -->
        <div id="status_bar"></div>
        
        <h2 id="titulo"><?php echo "$nome_game"; ?></h2>
        
        <center><i class="fab fa-xbox fa-3x" id="xbox_sm" onclick="JumpIn('itens_barra')"></i></center>
        
        <h1 id="historico_sm"><i class="fas fa-calendar-alt" onclick="AbreHistorico('index','carrosel_fundo')" onMouseOver="toolTip('Histórico')" onMouseOut="toolTip()""></i></h1>
        
        <h1><i id="conquista_sm" class="fas fa-trophy" onclick="AbreBiblio('conquista','fundo2', 'fundo3', 'conquistas_grid')" onMouseOver="toolTip('Biblioteca')" onMouseOut="toolTip()"></i></h1>
        
        <img id="perfil_sm" src="<?php echo $_SESSION['foto_perfil']; ?>" onclick="Perfil('conquistas_grid')">
        
        <div id="itens_barra">
            <h3 id="gamerscore"></h3>
        </div>
    </div>
    
    <?php
        $plataformas = "SELECT plataforma from game where id_game = '$id_game'";
        $verifica_plataformas = $conexao->query($plataformas);

        $dados1 = $verifica_plataformas->fetch_assoc();
        $plataformas = $dados1["plataforma"];
    ?>
    <!-- Formulário para adicionar um jogo -->
    <form id="form_impt_conq" action="php_funcoes/conquistas_importar.php" method="POST" enctype="multipart/form-data">
    <center>
        
        <input name="id_game" value="<?php echo $id_game ?>" style="display:none">
        <h4 style="color: yellow">Atenção: As Conquistas importadas por aqui não se referem as conquistas Obtidas</h4>
        
        <h1 id="h2_text">Plataforma
        <select name="plataforma" style="color: black;">
        <?php if(strpos($plataformas, "Xbox One") !== false){
                echo "<option value='Xbox One'>Xbox One</option>";
            }
            if(strpos($plataformas, "Xbox 360") !== false){
                echo "<option value='Xbox 360'>Xbox 360</option>";
            }
            if(strpos($plataformas, "PC") !== false){
                echo "<option value='PC'>Steam</option>";
            }
            if(strpos($plataformas, "Android") !== false){
                echo "<option value='Android'>Androd</option>";
            } ?>
        </select></h1>
        
        <hr style="width: 500px;">
        <?php if(strpos($plataformas, "PC") !== false){
                echo "<h2 style='color: yellow'>Vinculado ao Xbox: <input type='checkbox' name='excessao' id='checkbox_historico'></h2>";
            } ?>

        <h1 id="h2_text">Arquivo de Importação</h1>
        <input type="file" name="arquivo" style="color: white" required><br>

        <input class="button_confirma" type="submit" value="Importar">
    </center>
    </form>
    
    <form id="form_add_conq" action="php_funcoes/conquistas_adicionar.php" method="POST">
        
        <div id="add_conq_org">

        <h1 id="h2_text">Plataforma
            <select name="plataforma" style="color: black;">
            <?php if(strpos($plataformas, "Xbox One") !== false){
                    echo "<option value='Xbox One'>Xbox One</option>";
                }
                if(strpos($plataformas, "Xbox 360") !== false){
                    echo "<option value='Xbox 360'>Xbox 360</option>";
                }
                if(strpos($plataformas, "PC") !== false){
                    echo "<option value='PC'>Steam</option>";
                }
                if(strpos($plataformas, "Android") !== false){
                    echo "<option value='Android'>Androd</option>";
                } ?>
            </select>
        </h1>

            <h2><hr style="width: 500px;">
            <input class="input_conq" name="nome" placeholder="Nome" required maxlength="255"></h2>

            <h2 id="h2_text">
            <textarea class="input_conq" name="descricao" placeholder="Descrição" maxlength="500" style="height: 100px; width: 375px"></textarea></h2>

            <h2 id="h2_text">
            <input class="input_conq" name="pontuacao" placeholder="Pontuação" required></h2>

            <h2 id="h2_text">Secreta:
            <input type="checkbox" name="secreta" id="checkbox_historico">
            <input class="button_confirma" type="submit" value="Adicionar"></h2>
            
        </div>
    </form>
    
    <div id="opcoes_add">
        <?php if(isset($_SESSION["develop"])) { ?>
        <input class="butao_add" type="button" value="Adicionar Conquista" onclick="adicionar_Conquistas()">

        <input class="butao_add" type="button" value="Importar Conquistas" onclick="importar_Conquistas()">
        <?php } ?>
        
        <?php if($_SESSION["moderacao"] == 1){ ?>
        <input class="butao_add" type="button" value="Modo Desenvolvedor" onclick="Desenvolvedor('Conquistas')">
        <?php } ?>

        <?php if($_SESSION["total_games"] > 1){ ?>
        <input class="butao_add" type="button" value="Jogo Aleatório" onclick="aleatorizador(<?php echo $_SESSION['total_games']; ?>, 'conquista')">
        <?php } ?>
    </div>
    
    <div id="conquistas_grid">
        
        <div class="grid-item-capa">
            <?php echo "<img id='capa_jogo' src='img/Capas/$img_capa'>";

            echo "<i class='fas fa-award fa-4x' id='icone_completo'></i>";

            echo "<div id='icones'><h2 id='icones_plats'>";

            // Verificando as plataformas que o jogo está disponível
            if(strpos($plataformas, "Xbox One") !== false){
                echo " <i class='fab fa-xbox' title='Jogado no Xbox One'></i> ";
                $plat_cont++;
            }
            if(strpos($plataformas, "Xbox 360") !== false){
                if($plat_cont == 0)
                    echo "<i class='fab fa-xbox' title='Jogado no Xbox 360'></i> ";
                $plat_cont++;
            }
            if(strpos($plataformas, "PC") !== false){
                echo "<i class='fab fa-steam' title='Jogado no PC'></i> ";
                $plat_cont++;
            }
            if(strpos($plataformas, "Android") !== false){
                echo "<i class='fab fa-android' title='Jogado no Android'></i> ";
                $plat_cont++;
            }

            echo "</h2></div>";
            ?>
        </div>
      <?php $lista_conquistas = "SELECT * from conquista where id_game = $id_game and plataforma = '$plataforma_esc'"; 
            $executa_busca = $conexao->query($lista_conquistas);

            if($executa_busca->num_rows > 0){
                while ($dados = $executa_busca->fetch_assoc()){

                    $id_conquista = $dados["id_conquista"];
                    $nome_conquista = $dados["nome_conquista"];
                    $pontuacao_conquista = $dados["pontuacao"];
                    $descricao = $dados["descricao"];
                    $secreta = $dados["tipo"];
                    $img_conquista = $dados["img_conquista"];
                    $plataforma = $dados["plataforma"];
                    
                    if($descricao == null)
                        $descricao = "Ainda não há uma descrição :(";

                    if($primeira_conquista == 0)
                        $primeira_conquista = $id_conquista;

                    if($plataforma == "Xbox One")
                        $plat_conq = 1;
                    else if($plataforma == "Xbox 360")
                        $plat_conq = 2;
                    else if($plataforma == "PC")
                        $plat_conq = 3;
                    else if($plataforma == "Android")
                        $plat_conq = 4;
                    else
                        $plat_conq = 5;

                    $imagem = "img/Conquistas/$id_conquista.jpg";
                    
                    $soma_pontuacao += $pontuacao_conquista;

                    // Verificando se o arquivo existe e se o campo img_conquista do banco de dados é nulo
                    if($dados["img_conquista"] == null && file_exists($imagem))
                        $img_conquista = "$id_conquista.jpg";
                    else
                        $img_conquista = "semimagem.jpg";
                    
                    if(mb_strpos($dados["img_conquista"], $id_conquista) !== true && $img_conquista != "$id_conquista.jpg" && $img_conquista != "semimagem.jpg")
                        $img_conquista = $dados["img_conquista"];
                    else if($dados["img_conquista"] != null && $img_conquista != "$id_conquista.jpg")
                        $img_conquista = $dados["img_conquista"];

                    if($plat_conq > 1 && file_exists($id_conquista - ($executa_busca->num_rows / 2))){

                        $img_conquista = $id_conquista - ($executa_busca->num_rows / 2)."jpg";
                    }

                    // Calcula o tamanho da imagem
                    $pesquisa_img = "Img/Conquistas/"."". $img_conquista;
                    list($largura_original, $altura_original) = getimagesize($pesquisa_img);

                    if($largura_original > 100)
                        $plat_conq = 1;
                    else
                        $plat_conq = 2;

                    // Buscando a data da Conquista 
                    $busca_data = "SELECT data_alcancada from alcancada where id_jogador = $iduser and id_conquista = $id_conquista";
                    $executa_busca2 = $conexao->query($busca_data);
                    
                    $dados = $executa_busca2->fetch_assoc();
                    $data_conquista = $dados["data_alcancada"];
                    
                    if($data_conquista == null)
                        if($plat_conq == 3 || $plat_conq == 2) // PC e Xbox 360
                                $status_conquista = "conq_bloqueada_espec";
                            else
                                $status_conquista = "conq_bloqueada";
                    else
                        $status_conquista = "conq_desblock";

                    if($executa_busca2 != null){
                        $conta_conquistas++;
                    }

                    echo "<div id='descricao'>";

                        echo "<div id='ajusta_icon_view' onclick='select()'><i id='icon_view_conq' class='fa fa-eye fa-3x' aria-hidden='true' onclick='abrirPrancheta($id_conquista)'></i></div>";

                        echo "<div id='infos-descri'>";

                        if(isset($_SESSION["develop"]))
                        echo "<div id='id_conq'>$id_conquista</div>";
                    
                    if($pontuacao_conquista > 0){
                        echo "$pontuacao_conquista G";
                    }else if($secreta == 1){
                        echo "???";
                    }else{
                        echo "<br>";
                    }
                        
                    if(strlen($data_conquista) > 0) {
                        $data_conquista = date('d-m-Y', strtotime($data_conquista));
                        echo "<h4 id='desbloq'>Desbloqueada em<br><strong>$data_conquista</strong></h4>";
                    }

                    echo "</div>

                    <div class='grid-item plat_$plat_conq' onclick='atualizarConquista($id_conquista, $executa_busca2->num_rows)'>";
                    
                    if($secreta == 1 || $nome_conquista == "Conquista secreta")
                        echo "<i class='fas fa-user-secret fa-5x' id='icon_secret_conq'></i>";
                        
                    if($plat_conq == 3 || $plat_conq == 2)
                        echo "<div class='fundo_desfocado $status_conquista' style='background-image: url(img/Conquistas/$img_conquista)'></div>";
                       
                    echo "<img src='img/Conquistas/$img_conquista' class='img_conq img_plat_$plat_conq preview_$status_conquista'>";
                    
                    if($data_conquista != null){?>
                        <div id="contorna_conq" onMouseOver="toolTip('<?php echo $descricao; ?>')" onMouseOut="toolTip()"></div>

                        <?php $total_conquistas_alc++;
                        $total_pontuacao_alc += $pontuacao_conquista;
                    }else{ ?>
                        <div id="contorna_conq_block" onMouseOver="toolTip(<?php echo $descricao; ?>)" onMouseOut="toolTip()"></div>
                    <?php } 

                    if($secreta != 1)
                        echo "<h3 class='nome_conq'>$nome_conquista</h3>";
                    else
                        echo "<h3 class='nome_conq'>Conquista secreta</h3>";

                echo "      </div>
                        </div>";
                }
            
            if($pontuacao_total > 0)
                $porcentagem = ($total_pontuacao_alc * 100) / $soma_pontuacao;
            else
                $porcentagem = ($total_conquistas_alc * 100) / $conta_conquistas;
            
            $porcentagem = round($porcentagem, 2);
            
            if($porcentagem == 100){
                echo "<style>
                    #icone_completo{
                        display: block;
                    }
                </style>";
            }

            echo "<style>
                #status_bar{
                    width: $porcentagem%;

                }
                @keyframes carrega_porcentagem{
                    from { width: 0px; opacity: 0; }
                    to { width: $porcentagem%; opacity: 1; }
                }
            </style>";
            } ?>
    </div>
    
    <!-- Botões para alterar a plataforma do game -->
    <?php if($plat_cont > 1) { ?>
        <div id="opcoes_add_plat"><?php 
            if(strpos($plataformas, "Xbox One") !== false){ ?>
                <input class="butao_add" id="button_filt_1" type="button" value="Xbox One" onclick="filtrar_conquista('Xbox One')">
           <?php }
            if(strpos($plataformas, "Xbox 360") !== false){ ?>
                <input class="butao_add" id="button_filt_2" type="button" value="Xbox 360" onclick="filtrar_conquista('Xbox 360')">
            <?php }
            if(strpos($plataformas, "PC") !== false){ ?>
                <input class="butao_add" id="button_filt_3" type="button" value="Steam" onclick="filtrar_conquista('PC')">
            <?php }
            if(strpos($plataformas, "Android") !== false){ ?>
                <input class="butao_add" id="button_filt_4" type="button" value="Android" onclick="filtrar_conquista('Android')">
            <?php } ?>
        </div>
    <?php } ?>
    
    <!-- Informações -->
    <div id="informacoes_jogo">   
    <?php if($conta_conquistas != 0){ ?>
        <h3 id="msg_conqui"> <?php echo "$total_conquistas_alc de $conta_conquistas conquistas"; ?></h3>    
    <?php }
    if($soma_pontuacao > 0 ){ ?>
        <h3 id="msg_conqui" style='color: yellow'> <?php echo "$soma_pontuacao G"; ?></h3> 
    <?php } ?>
    </div>
    
    <?php 
    if($plat_cont > 1){
        if($_SESSION["plataforma"] == "Xbox One")
            $botao_plataforma = "button_filt_1";
        else if($_SESSION["plataforma"] == "Xbox 360")
            $botao_plataforma = "button_filt_2";
        else if($_SESSION["plataforma"] == "PC")
            $botao_plataforma = "button_filt_3";
        else
            $botao_plataforma = "button_filt_4";

    echo "<style>
        #$botao_plataforma{
            background-color: midnightblue;
            color: white;
        }
        </style>"; 
    } ?>
    <!-- Atualização de Conquista -->
    <div id="input_conq"></div>
    
    <div id="opcoes_add_conq">
        <input class="butao_add" type="button" value="Retornar" onclick="retornar_conq()">
    </div>
    
    <!-- Div para transitar entre as páginas -->
    <div id="transitador"></div>
    <div id="fundo2"></div>
    <div id="fundo3"></div>
    <div id="fundo4"></div>

    <div id="rodape">
        <h3>Versão 1.0</h3>
    </div>
</body>
</html>