<?php
    session_start();
    $nomeEmpresa = "Bolsas em Couro";
    $descricaoPagina = "DESCRIÇÃO MODELO ATUALIZAR...";
    $tituloPagina = "Quem somos - $nomeEmpresa";
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
                width: 100%;
                margin: 0 auto;
                min-height: 300px;
            }
			.banner-quem-somos{
				width: 100%;
				height: 500px;
				margin-bottom: 100px;
				background-color: #666;
			}
			.text-espec{
				width: 80%;
				margin: 0 auto;
				margin-bottom: 30px;
			}
			.text-espec h1{
				margin: 0;
				text-align: center;
			}
			.text-espec p{
				text-align: justify;
			}
			.inf{
				display: flex;
				align-items: flex-start;
				flex-direction: column;
				width: 80%;
				margin: auto;
				margin-bottom: 100px;
			}
        </style>
        <!--END PAGE CSS-->
        <!--PAGE JS-->
        <script>
            $(document).ready(function(){
                console.log("Página carregada");
            });
        </script>
        <!--END PAGE JS-->
    </head>
    <body>
        <!--REQUIRES PADRAO-->
        <?php
            require_once "@link-body-scripts.php";
            require_once "@classe-system-functions.php";
            require_once "@include-header-principal.php";
            require_once "@include-interatividade.php";
        ?>
        <!--THIS PAGE CONTENT-->
        <div class="main-content">
            <div class="banner-quem-somos"></div>
            <div class="text-espec">
            	<h1>ACRISIGNS</h1>
            	<p>Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos. Lorem Ipsum sobreviveu não só a cinco séculos, como também ao salto para a editoração eletrônica,</p>
            </div>
            <div class="inf">
				<a href="garantia-de-qualidade.php" class="link-padrao">Garantia de qualidade</a>
				<a href="frete-gratis.php" class="link-padrao">Frete Grátis</a>
       		</div>
        </div>
        <!--END THIS PAGE CONTENT-->
        <?php
            require_once "@include-footer-principal.php";
        ?>
        <!--END REQUIRES PADRAO-->
    </body>
</html>