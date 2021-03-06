<?php
    session_start();
    $nomeEmpresa = "Bolsas em Couro";
    $descricaoPagina = "DESCRIÇÃO MODELO ATUALIZAR...";
    $tituloPagina = "MUDAR TITULO - $nomeEmpresa";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
        <meta name="HandheldFriendly" content="true">
        <meta name="description" content="<?php echo $descricaoPagina;?>">
        <meta name="author" content="Efectus Web">
        <title><?php echo $tituloPagina;?></title>
        <!--DEFAULT LINKS-->
        <?php
            require_once "@link-standard-styles.php";
            require_once "@link-standard-scripts.php";
            require_once "@link-important-functions.php";
        ?>
        <!--END DEFAULT LINKS-->
        <!--PAGE CSS-->
        <style>
            .main-content{
                width: 80%;
                margin: 40px auto;
                min-height: 300px;
            }
            .main-content .navigation-tree{
                width: 100%;
                margin-bottom: 20px;
            }
            .section-produto{
                width: 100%;
                display: flex;
                flex-flow: row wrap;
                margin: 0px 0px 20px 0px;
            }
            .section-produto .display-miniaturas{
                width: 20%;
            }
            .section-produto .display-miniaturas .box-miniaturas{
                width: 50%;
                margin: 0px 0px 10px 0px;
            }
            .section-produto .display-miniaturas .box-miniaturas .miniatura{
                width: 100%;
                cursor: pointer;
            }
            .section-produto .display-miniaturas .box-miniaturas .miniatura:hover{
                opacity: .8;
            }
            .section-produto .display-miniaturas .box-play{
                width: 100px;
                height: 60px;
                display: flex;
                justify-content: center;
                align-items: center;
                font-size: 12px;
                flex-direction: column;
                text-align: center;
                margin: 10px 0px 10px 0px;
                cursor: pointer;
                color: #999;
            }
            .section-produto .display-miniaturas .box-play:hover{
                color: #333;   
            }
            .section-produto .display-miniaturas .box-play .icon-play{
                font-size: 52px;
                width: 100%;
                color: #ccc;
                cursor: pointer;
            }
            .section-produto .display-miniaturas .box-play:hover .icon-play{
                color: #333;
            }
            .section-produto .display-miniaturas .display-video{
                position: fixed;
                top: 130px;
                width: 100%;
                height: 100%;
                top: 0px;
                left: 0px;
                margin: 0 auto;
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 200;
                background-color: rgba(0, 0, 0, .5);
                visibility: hidden;
                opacity: 0;
                transition: .3s;
            }
            .section-produto .display-miniaturas .display-video iframe{
                width: 800px;
                height: 500px;
            }
            .section-produto .display-miniaturas .display-video .botao-voltar{
                position: absolute;
                bottom: 40px;
                margin: 0 auto;
                left: 0;
                right: 0;
                width: 100px;
                text-align: center;
                font-size: 16px;
                color: #fff;
                background-color: transparent;
                border: none;
                cursor: pointer;
                border-bottom: 2px solid transparent;
                padding: 5px 0px 5px 0px;
            }
            .section-produto .display-miniaturas .display-video .botao-voltar:hover{
                border-color: #fff;   
            }
            .section-produto .display-imagem-principal{
                width: 50%;
                text-align: center;
            }
            .section-produto .display-imagem-principal .imagem-principal{
                width: 90%;
            }
            .section-produto .display-info-produto{
                width: 30%;
                text-align: right;
            }
            .section-produto .display-info-produto .titulo-produto{
                font-size: 28px;
                margin: 10px 0px 10px 0px;
            }
            .section-produto .display-info-produto .preco-produto{
                font-size: 18px;
                color: #666;
                font-weight: normal;
            }
            .section-produto .display-info-produto .preco-produto .promo-price{
                text-decoration: line-through;
            }
            .section-produto .display-info-produto .preco-produto .final-price{
                font-size: 28px;
                white-space: nowrap;
                color: #6abd45;
            }
            .section-produto .display-info-produto .price-info{
                font-weight: normal;
                color: #666;
            }
            .section-produto .display-info-produto .view-disponibilidade{
                font-size: 16px;
            }
            .section-produto .display-info-produto .icone-disponibilidade{
                font-size: 18px;
            }
            .section-produto .display-info-produto .disponivel{
                color: #6abd45;
            }
            .section-produto .display-info-produto .indisponivel{
                color: #d11a1a;
            }
            .section-produto .display-info-produto .botao-comprar{
                border: none;
                color: #fff;
                background-color: #408122;
                font-size: 24px;
                width: 170px;
                height: 40px;
                transition: .2s;
                cursor: pointer;
                outline: none;
            }
            .section-produto .display-info-produto .botao-comprar:hover{
                background-color: #2f6117;
            }
            .section-produto .display-info-produto .botao-comprar:active{
                background-color: #333;
            }
            .section-produto .display-info-produto .calculo-frete{
                width: 100%;
                margin: 40px 20px 0px auto;
                color: #888;
            }
            .section-produto .display-info-produto .calculo-frete .titulo-frete{
                width: 225px;
                font-size: 14px;
                font-weight: normal;
                margin: 0px 0px 5px auto;
                text-align: left;
            }
            .section-produto .display-info-produto .calculo-frete .input-frete{
                width: 160px;
                height: 30px;
                padding: 0px 10px 0px 10px;
                margin: 0px;
                outline: none;
                color: #666;
                font-size: 16px;
                border: 1px solid #999;
            }
            .section-produto .display-info-produto .calculo-frete .botao-calculo-frete{
                width: 40px;
                height: 33px;
                margin: 0px;
                background-color: #eee;
                color: #333;
                border: 1px solid #999;
                position: relative;
                font-size: 16px;
                line-height: 30px;
                cursor: pointer;
                outline: none;
            }
            .section-produto .display-info-produto .calculo-frete .botao-calculo-frete:hover{
                color: #111;
                background-color: #dedede;
            }
            .section-produto .display-info-produto .sem-estoque{
                pointer-events: none;
                background-color: #ccc;
            }
			.display-desc{
				width: 100%;
				display: flex;
				justify-content: center;
				background-color: #ccc;
				margin-bottom: 100px;
			}
			.display-desc .box-desc{
				width: 50%;
			}
            @media screen and (max-width: 860px){
                .main-content{
                    width: 95%;
                }
                .section-produto .display-miniaturas{
                    width: 10%;
                }
                .section-produto .display-miniaturas .box-miniaturas{
                    width: 100%;
                }
                .section-produto .display-info-produto{
                    width: 40%;
                }
                @media screen and (max-width: 720px){
                    .section-produto{
                        margin-bottom: 60px;
                    }
                    .section-produto .display-miniaturas{
                        width: 20%;
                    }
                    .section-produto .display-miniaturas .box-miniaturas{
                        width: 80%;
                    }
                    .section-produto .display-imagem-principal{
                        width: 80%;
                    }
                    .section-produto .display-info-produto{
                        width: 100%;
                        text-align: left;
                    }
                    .section-produto .display-info-produto .display-cores{
                        justify-content: flex-start;
                    }
                    .section-produto .display-info-produto .display-comprar{
                        width: 50%;
                        float: left;
                    }
                    .section-produto .display-info-produto .calculo-frete{
                        position: relative;
                        width: 50%;
                        margin: 0px;
                        margin-left: auto;
                        top: -10px;
                    }
                    .section-produto .display-info-produto .calculo-frete .input-frete{
                        width: 100px;   
                    }
                    .section-produto .display-info-produto .calculo-frete .titulo-frete{
                        margin: 0px;
                    }
                }
            }
        </style>
        <!--END PAGE CSS-->
        <!--PAGE JS-->
        <script>
            $(document).ready(function(){
                console.log("Página carregada");

                var divImagemPrincipal = $(".display-imagem-principal");
                var imagemPrincipal = divImagemPrincipal.children(".imagem-principal");
                var displayMiniaturas = $(".display-miniaturas");
                var boxMiniaturas = displayMiniaturas.children(".box-miniaturas");
                function changeImagem(src){
                    imagemPrincipal.prop("src", src);
                }
                /*TRIGGERS CHANGE IMAGE*/
                boxMiniaturas.each(function(){
                    var imgMiniatura = $(this).children(".miniatura");
                    var srcMiniatura = imgMiniatura.prop("src");
                    imgMiniatura.off().on("click", function(){
                        changeImagem(srcMiniatura);
                    });
                });
                /*END TRIGGERS CHANGE IMAGE*/
                
                var displayVideo = $(".display-video");
                var botaoVoltar = displayVideo.children(".botao-voltar");
                $(".box-play").off().on("click", function(){
                    displayVideo.css({
                        visibility: "visible",
                        opacity: "1"
                    });
                })
                botaoVoltar.off().on("click", function(){
                    displayVideo.css({
                        visibility: "hidden",
                        opacity: "0"
                    });
                });
            });
        </script>
        <!--END PAGE JS-->
    </head>
    <body>
        <!--REQUIRES PADRAO-->
        <?php
            require_once "@link-body-scripts.php";
            require_once "@classe-system-functions.php";
            require_once "@classe-produtos.php";
            require_once "@classe-vitrine-produtos.php";
            require_once "@include-header-principal.php";
            require_once "@include-interatividade.php";
        ?>
        <!--THIS PAGE CONTENT-->
        <div class="main-content">
            <?php
            /*SET TABLES*/
            $tabela_produtos = $pew_custom_db->tabela_produtos;
            $tabela_produtos_relacionados = $pew_custom_db->tabela_produtos_relacionados;
            /*END SET TABLES*/

            /*DEFAULT VARS*/
            $dirImagensProduto = "imagens/produtos";
            /*END DEFAULT VARS*/

            $idProduto = isset($_GET["id_produto"]) ? (int)$_GET["id_produto"] : 0;
            $totalProduto = $pew_functions->contar_resultados($tabela_produtos, "id = '$idProduto'");

            if($totalProduto > 0){

            $produto = new Produtos();
            $produto->montar_produto($idProduto);
            $infoProduto = $produto->montar_array();

            /*INFO PRODUTO*/
            $nomeProduto = $infoProduto["nome"];
            $descricaoLongaProduto = $infoProduto["descricao_longa"];
            $precoProduto = $infoProduto["preco"];
            $precoPromocaoProduto = $infoProduto["preco_promocao"];
            $promocaoAtiva = $infoProduto["promocao_ativa"] == true && $precoPromocaoProduto > 0 && $precoPromocaoProduto < $precoProduto;
            $precoFinal = $promocaoAtiva == true ? $precoPromocaoProduto : $precoProduto;
            $precoBoleto = $precoFinal - ($precoFinal * 0.05);
            $qtdParcelas = 6;
            $precoParcelas = $precoFinal / $qtdParcelas;
            $estoqueProduto = $infoProduto["estoque"];
            $imagensProduto = $infoProduto["imagens"];
            $urlVideo = $infoProduto["url_video"];
            /*INFO PRODUTO*/

            /*HTML VIEW*/
            $viewPriceField = null;
            if($promocaoAtiva){
                $viewPriceField = "<h3 class='preco-produto'>De <span class='promo-price'>R$".number_format($precoProduto, 2, ",", ".")."</span> por <span class='final-price'>R$".number_format($precoPromocaoProduto, 2, ",", ".")."</span></h3>";
            }else{
                $viewPriceField = "<h3 class='preco-produto'><span class='final-price'>R$".number_format($precoPromocaoProduto, 2, ",", ".")."</span></h3>";
            }

            $viewParcelasField = null;
            if($qtdParcelas > 0){
                $viewParcelasField = "<h4 class='price-info'>".$qtdParcelas."x de R$".number_format($precoParcelas, 2, ',', '.')." ou a vista R$".number_format($precoBoleto, 2, ",", ".")."<br> (5% de desconto no boleto)</h4>";
            }else{
                $viewParcelasField = "<h4 class='price-info'>ou à vista R$".number_format($precoBoleto, 2, ",", ".")."<br> (5% de desconto no boleto)</h4>";
            }

            $viewDisponibilidadadeField = $estoqueProduto == 0 ? "<div class='view-disponibilidade indisponivel'><span class='icone-disponibilidade'><i class='fas fa-times'></i></span> SEM ESTOQUE</div>" : "<div class='view-disponibilidade disponivel'><span class='icone-disponibilidade'><i class='fas fa-check'></i></span> EM ESTOQUE</div>";

            $viewBotaoComprar = $estoqueProduto == 0 ? "<button class='botao-comprar sem-estoque'>COMPRAR</button>" : "<button  class='botao-comprar' id='addProdutoCarrinho'>COMPRAR</button>";
            /*END HTML VIEW*/
                
            $iconArrow = "<i class='fas fa-angle-right icon'></i>";
            $navigationTree = "<div class='navigation-tree'><a href='index.php'>Página inicial</a> $iconArrow <a href='#'>Departamento</a> $iconArrow <a href='#'>$nomeProduto</a></a></div>";
            echo $navigationTree;
                
            ?>
            <section class="section-produto">
                <div class="display-miniaturas">
                    <?php
                        $ctrlImagens = 0;
                        $imagemPrincipal = null;
                        foreach($imagensProduto as $infoImagem){
                            $srcImagem = $infoImagem["src"];
                            $ctrlImagens++;
                            $imagemPrincipal = $ctrlImagens == 1 ? $srcImagem : $imagemPrincipal;
                            echo "<div class='box-miniaturas'><img src='$dirImagensProduto/$srcImagem' alt='$nomeEmpresa - $nomeProduto - Imagem $ctrlImagens' class='miniatura'></div>";
                        }
                
                        if($urlVideo != null){
                            echo "<div class='box-play'><i class='fas fa-play-circle icon-play'></i>Veja o vídeo</div>";
                            echo "<div class='display-video'>$urlVideo <button class='botao-voltar'><i class='fas fa-times'></i> VOLTAR</button></div>";
                        }
                    ?>
                </div>
                <div class="display-imagem-principal">
                    <?php
                        echo "<img src='$dirImagensProduto/$imagemPrincipal' alt='$nomeEmpresa - $nomeProduto - Imagem principal' class='imagem-principal'>";
                    ?>
                </div>
                
                <div class="display-info-produto">
                    <h1 class="titulo-produto"><?php echo $nomeProduto; ?></h1>
                    <?php
                        echo $viewPriceField;
                        echo $viewParcelasField;
                        echo $viewDisponibilidadadeField;
                    ?>
                    <div class="display-comprar">
                        <?php echo $viewBotaoComprar; ?>
                    </div>
                    <div class="calculo-frete">
                        <h5 class="titulo-frete">CALCULAR FRETE</h5>
                        <input type="text" class="input-frete">
                        <button class="botao-calculo-frete"><i class="fas fa-truck"></i></button>
                    </div>
                </div>
            </section>
        </div>
        <div class="display-desc">
        	<div class="box-desc">
        		<h3>DESCRIÇÃO E DETALHES</h3>
        		<?php
					echo "<p>".$descricaoLongaProduto."</p>";
				?>
        	</div>
        </div>
        <section class="produtos-relacionados">
            <?php
                $vitrineProdutos[0] = new VitrineProdutos("carrossel", 15, "COMPRE JUNTO COM DESCONTO");
                $vitrineProdutos[0]->montar_vitrine();
            ?>
        </section>
        <?php
        }else{
            echo "<h3 class='mensagem-no-result'><i class='fas fa-search'></i> Nenhum produto foi encontrado</h3>";
            echo "<br><center><a href='index.php' class='link-padrao' align=center>Voltar a página inicial</a></center>";
            echo "</div>";
        }
        ?>
        <!--END THIS PAGE CONTENT-->
        <?php
            require_once "@include-footer-principal.php";
        ?>
        <!--END REQUIRES PADRAO-->
    </body>
</html>
