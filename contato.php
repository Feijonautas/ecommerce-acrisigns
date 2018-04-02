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
                width: 50%;
                margin: 0 auto;
            }
			.box-form{
				display: flex;
				flex-direction: column;
				align-items: center;
				width: 100%;
				margin: 100px 0 100px 0;
			}
			.botao-continuar{
				margin-left: 350px;
				padding: 5px 10px 5px 10px;
				background-color: #66cd00;
				border: none;
			}
        </style>
        <!--END PAGE CSS-->
        <!--PAGE JS-->
        <script>
            $(document).ready(function(){
                console.log("Página carregada");
				phone_mask($("#contatoTelefone"));
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
			<div class="box-form">
				<h1>Contato</h1>
				<form method="post" action="@grava-contato.php">
					<div class="label-full">
                        <h4 class="input-title">Nome Completo</h4>
                        <input type="text" placeholder="Nome Completo" name="nome" id="contatoNome" class="input-standard">
                        <h6 class="msg-input"></h6>
                    </div>
                    <div class="label-half">
                        <h4 class="input-title">Telefone</h4>
                        <input type="text" placeholder="Telefone" name="telefone" id="contatoTelefone" class="input-standard">
                        <h6 class="msg-input"></h6>
                    </div>
                    <div class="label-half">
                        <h4 class="input-title">E-mail</h4>
                        <input type="text" placeholder="E-mail" name="nome" id="contatoEmail" class="input-standard">
                        <h6 class="msg-input"></h6>
                    </div>
             		<div class="label-half">
                        <h4 class="input-title">Assunto</h4>
                        <select class="input-standard">
                        	<option value="">- Selecione -</option>
                        	<option>Dúvida</option>
                        	<option>Sugestão</option>
                        	<option>Reclamação</option>
                        	<option>Outros</option>
                        </select>
                        <h6 class="msg-input"></h6>
                    </div>
                    <div class="label-half">
                        <h4 class="input-title">Envie sua mensagem</h4>
                        <input type="text" placeholder="Envie sua mensagem" name="nome" id="contatoEmail" class="input-standard">
                        <h6 class="msg-input"></h6>
					</div>
					<div class="label-xsmall">
                        <button class="botao-continuar" type="button">Enviar</button>
                    </div>
				</form>
			</div>
        </div>
        <!--END THIS PAGE CONTENT-->
        <?php
            require_once "@include-footer-principal.php";
        ?>
        <!--END REQUIRES PADRAO-->
    </body>
</html>
