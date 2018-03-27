<?php
session_start();
require_once "pew-system-config.php";
$name_session_user = $pew_session->name_user;
$name_session_pass = $pew_session->name_pass;
$name_session_nivel = $pew_session->name_nivel;
$name_session_empresa = $pew_session->name_empresa;
if(isset($_SESSION[$name_session_user]) && isset($_SESSION[$name_session_pass]) && isset($_SESSION[$name_session_nivel]) && isset($_SESSION[$name_session_empresa])){
    $efectus_empresa_administrativo = $_SESSION[$name_session_empresa];
    $efectus_user_administrativo = $_SESSION[$name_session_user];
    $efectus_nivel_administrativo = $_SESSION[$name_session_nivel];
    $navigation_title = "Produtos - $efectus_empresa_administrativo";
    $page_title = "Cadastrar produto";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Acesso Restrito. Efectus Web.">
        <meta name="author" content="Efectus Web">
        <title><?php echo $navigation_title; ?></title>
        <!--LINKS e JS PADRAO-->
        <link type="image/png" rel="icon" href="imagens/sistema/identidadeVisual/icone-efectus-web.png">
        <link type="text/css" rel="stylesheet" href="css/estilo.css">
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/standard.js"></script>
        <script type="text/javascript" src="js/pew.js"></script>
        <!--FIM LINKS e JS PADRAO-->
        <!--THIS PAGE LINKS-->
        <script type="text/javascript" src="js/produtos.js"></script>
        <script type="text/javascript" src="custom-textarea/ckeditor.js"></script>
        <!--FIM THIS PAGE LINKS-->
        <script>
            $(document).ready(function(){
                CKEDITOR.replace("descricaoLonga");

                /*ESPECIFICACOES TECNICAS*/
                var botaoAdicionarEspecificacao = $(".btn-especificacoes");
                var selectEspecificacao = $("#selectEspecificacao");
                var displayEspecificacoes = $(".display-especificacoes");
                var objTextareaEspecificacao = $("#descricaoEspecificacao");

                function resetEspecificacao(){
                    objTextareaEspecificacao.val("");
                    selectEspecificacao.val("");
                }

                botaoAdicionarEspecificacao.off().on("click", function(){
                    var selectedEspecificacaoId = selectEspecificacao.val();
                    if(selectedEspecificacaoId != ""){
                        selectEspecificacao.children("option").each(function(){
                            var option = $(this);
                            var idEspecificacao = option.val();
                            var tituloEspecificacao = option.text();
                            if(idEspecificacao == selectedEspecificacaoId){
                                var descricaoEspecificacao = objTextareaEspecificacao.val();
                                var ctrlInputVal = idEspecificacao+"|-|"+descricaoEspecificacao;
                                if(descricaoEspecificacao.length > 0){
                                    var addedEspecificacao = "<label class='label-especificacao'><b>"+tituloEspecificacao+": </b> <input type='text' class='input-especificacao' value='"+descricaoEspecificacao+"'><input type='hidden' class='input-ctrl-especificacao' name='especicacao_produto[]' value='"+ctrlInputVal+"' pew-id-especificacao='"+idEspecificacao+"'> <a class='btn-excluir-especificacao' title='Excluir especificação'><i class='fa fa-times' aria-hidden='true'></i></a></label>";
                                    displayEspecificacoes.append(addedEspecificacao);
                                    notificacaoPadrao("Especificação adicionada", "success");
                                    resetEspecificacao();
                                }else{
                                    mensagemAlerta("O campo descrição deve ser preenchido", objTextareaEspecificacao);
                                }
                            }
                        });
                    }else{
                        mensagemAlerta("Selecione uma especificação", selectEspecificacao);
                    }
                });

                setInterval(function(){
                    displayEspecificacoes.children(".label-especificacao").each(function(){
                        var label = $(this);
                        var objInputView = label.children(".input-especificacao");
                        var objInputCtrl = label.children(".input-ctrl-especificacao");
                        var idEspec = objInputCtrl.attr("pew-id-especificacao");
                        var botaoExcluir = label.children(".btn-excluir-especificacao");
                        var ctrlInputVal = idEspec+"|-|"+objInputView.val();
                        objInputCtrl.val(ctrlInputVal);
                        botaoExcluir.off().on("click", function(){
                            function excluir(){
                                label.remove();
                            }
                            mensagemConfirma("Você tem certeza que deseja excluir esta especificação?", excluir);
                        });
                    });
                }, 200);
                /*END ESPECIFICACOES TECNICAS*/

                /*PRODUTOS RELACIONADOS*/
                var botaoProdutosRelacionados = $(".btn-produtos-relacionados");
                var displayRelacionados = $(".display-produtos-relacionados");
                var background = $(".background-interatividade");
                var botaoSalvarRelacionados = $(".btn-salvar-relacionados");
                var botaoCleanRelacionados = $(".limpar-todos-relacionados");
                var barraBusca = $(".busca-relacionados");
                var checkOnlyActives = $("#checkOnlyActives");
                var listaRelacionados = $(".lista-relacionados");
                var msgListaRelacionados = $(".lista-relacionados .lista-relacionados-msg");
                var buscandoProduto = false;
                var resetingBackground = false;
                var lastSearchString = null;

                /*!IMPORTANT FUNCTIONS*/
                function isJson(str){
                    try{
                        JSON.parse(str);
                    }catch(e){
                        return false;
                    }
                    return true;
                }
                function setMessageRelacionados(str){
                    listaRelacionados.css("padding", "30px 0px 10px 0px");
                    msgListaRelacionados.children("h4").text(str);
                    msgListaRelacionados.css({
                        height: "30px",
                        lineHeight: "30px",
                        visibility: "visible",
                        opacity: "1"
                    });
                }
                function resetMessageRelacionados(){
                    listaRelacionados.css("padding", "0px 0px 40px 0px");
                    msgListaRelacionados.children("h4").text("");
                    msgListaRelacionados.css({
                        height: "5px",
                        lineHeight: "5px",
                        visibility: "hidden",
                        opacity: "0"
                    });
                }
                function resetAllInputs(){
                    var onlyActives = checkOnlyActives.prop("checked");
                    var ctrlView = 0;
                    $(".label-relacionados").each(function(){
                        var label = $(this);
                        var input = label.children("input");
                        if(onlyActives && input.prop("checked") == true){
                            label.css("display", "inline-block").removeClass("last-search");
                            ctrlView++;
                        }else if(!onlyActives){
                            label.css("display", "inline-block").removeClass("last-search");
                            ctrlView++;
                        }
                    });
                    if(onlyActives){
                        setMessageRelacionados("Resultados encontrados: "+ctrlView);
                    }else{
                        resetMessageRelacionados();
                    }
                }
                function listLastSearch(){
                    var onlyActives = checkOnlyActives.prop("checked");
                    var ctrlQtd = 0;
                    $(".label-relacionados").each(function(){
                        var label = $(this);
                        var input = label.children("input");
                        if(onlyActives && label.hasClass("last-search") && input.prop("checked") == true){
                            label.css("display", "inline-block");
                            ctrlQtd++;
                        }else if(!onlyActives && label.hasClass("last-search")){
                            label.css("display", "inline-block");
                            ctrlQtd++;
                        }
                    });
                    if(ctrlQtd > 0){
                        setMessageRelacionados("Exibindo resultados mais aproximados:");
                    }else{
                        setMessageRelacionados("Nenhum resultado foi encontrado");
                        botaoCleanRelacionados.css("visibility", "hidden");
                    }
                }
                function contarProdutosSelecionados(){
                    var contagem = 0;
                    $(".label-relacionados").each(function(){
                        var label = $(this);
                        var input = label.children("input");
                        if(input.prop("checked") == true){
                            contagem++;
                        }
                    });
                    return contagem;
                }
                function clearRelacionados(){
                    $(".label-relacionados").each(function(){
                        var label = $(this);
                        var input = label.children("input");
                        if(label.css("display") != "none"){
                            input.prop("checked", false);
                        }
                    });
                }
                /*OPEN AND CLOSE*/
                function abrirRelacionados(){
                    background.css("display", "block");
                    displayRelacionados.css({
                        visibility: "visible",
                        opacity: "1"
                    });
                    /*SEARCH TRIGGRES*/
                    barraBusca.on("keyup", function(){
                        buscarProdutos();
                    });
                    barraBusca.on("search", function(){
                        buscarProdutos();
                    });
                    /*END SEARCH TRIGGRES*/
                    /*BOTAO SOMENTE SELECIONADOS*/
                    checkOnlyActives.off().on("change", function(){
                        var checked = $(this).prop("checked");
                        var buscaAtiva = barraBusca.val().length > 0 ? true : false;
                        if(checked && !buscaAtiva){
                            var ctrlQtd = 0;
                            $(".label-relacionados").each(function(){
                                var label = $(this);
                                var input = label.children("input");
                                var selecionado = input.prop("checked");
                                if(!selecionado){
                                    label.css("display", "none");
                                }else{
                                    ctrlQtd++;
                                }
                            });
                            botaoCleanRelacionados.css("visibility", "visible");
                            setMessageRelacionados("Resultados encontrados: "+ctrlQtd);
                        }else if(buscaAtiva){
                            lastSearchString = null;
                            buscarProdutos();
                            if(checked){
                                botaoCleanRelacionados.css("visibility", "visible");
                            }else{
                                botaoCleanRelacionados.css("visibility", "hidden");
                            }
                        }else{
                            /*LISTA TODOS OS PRODUTOS*/
                            resetAllInputs();
                            botaoCleanRelacionados.css("visibility", "hidden");
                        }
                    });
                    /*END BOTAO SOMENTE SELECIONADOS*/
                    /*LIMPAR RELACIONADOS*/
                    botaoCleanRelacionados.off().on("click", function(){
                        clearRelacionados();
                    });
                }
                function fecharRelacionados(){
                    displayRelacionados.css({
                        visibility: "hidden",
                        opacity: "0"
                    });
                    setTimeout(function(){
                        background.css("display", "none");
                    }, 200);
                    var totalSelecionados = contarProdutosSelecionados();
                    botaoProdutosRelacionados.text("Produtos Selecionados ("+totalSelecionados+")");
                }
                /*END OPEN AND CLOSE*/
                /*END !IMPORTANT FUNCTIONS*/

                /*MAIN SEARCH FUNCTION*/
                function buscarProdutos(){
                    buscandoProduto = true;
                    var busca = barraBusca.val();
                    var loadingBackground = $(".lista-relacionados .loading-background");
                    var urlBuscaProdutos = "pew-busca-produtos.php";
                    onlyActives = checkOnlyActives.prop("checked");

                    function resetBackgroundLoading(){
                        if(!resetingBackground){
                            setInterval(function(){
                                resetingBackground = true;
                                if(!buscandoProduto){
                                    loadingBackground.css({
                                        visibility: "hidden",
                                        opacity: "0"
                                    });
                                }
                            }, 500);
                        }
                    }
                    resetBackgroundLoading();
                    if(busca.length > 0 && lastSearchString != busca){
                        lastSearchString = busca;
                        $.ajax({
                            type: "POST",
                            url: urlBuscaProdutos,
                            data: {busca: busca},
                            error: function(){
                                loadingBackground.css({
                                    visibility: "hidden",
                                    opacity: "0"
                                });
                                notificacaoPadrao("Ocorreu um erro ao buscar o produto.");
                            },
                            success: function(resposta){
                                console.log(resposta);
                                setTimeout(function(){
                                    buscandoProduto = false;
                                }, 500);
                                var selectedProdutos = [];
                                var ctrlVQtdView = 0;
                                function listarOpcoes(){
                                    $(".label-relacionados").each(function(){
                                        var label = $(this);
                                        var input = label.children("input");
                                        var inputIdProduto = input.val();
                                        var inputChecked = input.prop("checked");
                                        var arraySearch = selectedProdutos.some(function(id){
                                            if(onlyActives){
                                                return id === inputIdProduto && inputChecked == true;
                                            }else{
                                                return id === inputIdProduto;
                                            }
                                        });
                                        if(arraySearch == false){
                                            if(onlyActives){
                                                label.css("display", "none");
                                            }else{
                                                label.css("display", "none").removeClass("last-search");
                                            }
                                        }else{
                                            ctrlVQtdView++;
                                            label.css("display", "inline-block").addClass("last-search");
                                        }
                                    });
                                    setMessageRelacionados("Resultados encontrados: "+ctrlVQtdView);
                                    if(ctrlVQtdView == 0){
                                        listLastSearch();
                                    }
                                }
                                if(resposta != "false" && isJson(resposta) == true){
                                    var jsonData = JSON.parse(resposta);
                                    var ctrlQtd = 0;
                                    jsonData.forEach(function(id_produto){
                                        selectedProdutos[ctrlQtd] = id_produto;
                                        ctrlQtd++;
                                    });
                                    listarOpcoes();
                                }else{
                                    if(onlyActives){
                                        listarOpcoes();
                                    }else{
                                        setMessageRelacionados("Exibindo resultados mais aproximados:");
                                        listLastSearch();
                                    }
                                }
                            },
                            beforeSend: function(){
                                loadingBackground.css({
                                    visibility: "visible",
                                    opacity: "1"
                                });
                            }
                        });
                    }else if(busca.length == 0){
                        resetAllInputs();
                    }
                }
                /*END MAIN SEARCH FUNCTION*/

                /*TRIGGERS*/
                botaoProdutosRelacionados.off().on("click", function(){
                    abrirRelacionados();
                });
                botaoSalvarRelacionados.off().on("click", function(){
                    fecharRelacionados();
                });
                background.off().on("click", function(){
                    fecharRelacionados();
                });
                /*END TRIGGERS*/

                /*END PRODUTOS RELACIONADOS*/
            });
        </script>
        <!--THIS PAGE CSS-->
        <style>
            .display-cores{
                width: 100%;
                height: 60px;
                padding-bottom: 10px;
                padding-top: 10px;
                text-align: center;
            }
            .display-cores .box-cor{
                width: 25px;
                height: 25px;
                background-color: #dedede;
                margin: 6px;
                display: inline-block;
                cursor: pointer;
                -webkit-box-shadow: 1px 1px 25px 1px rgba(0, 0, 0, 0.2);
                -moz-box-shadow: 1px 1px 25px 1px rgba(0, 0, 0, 0.2);
                box-shadow: 1px 1px 25px 1px rgba(0, 0, 0, 0.2);
            }
            .display-cores .box-cor:hover{
                border: 2px solid #111;
                border-radius: 5px;
                margin: 4px;
            }
            .display-cores .selected{
                border-radius: 50%;
                border: 2px solid #111;
                margin: 4px;
            }
            .display-cores .selected:hover{
                border-radius: 20px;
            }
            .file-field{
                height: 140px;
                line-height: 140px;
            }
            .file-field:hover{
                line-height: 140px;
            }
            /*ESPECIFICACAO TECNICA*/
            .btn-especificacoes{
                cursor: pointer;
                border: 1px solid #333;
                transition: .2s;
                white-space: nowrap;
                text-align: center;
                display: block;
                width: 100%;
            }
            .btn-especificacoes:hover{
                background-color: #fff;
            }
            .label-especificacao{
                display: block;
                margin: 10px 0px 10px 20px;
            }
            .label-especificacao input{
                height: 14px;
                padding: 5px;
                font-size: 16px;
                margin-left: 6px;
            }
            .label-especificacao .btn-excluir-especificacao{
                cursor: pointer;
            }
            /*END ESPECIFICACAO TECNICA*/
            /*PRODUTOS RELACIONADOS CSS*/
            .btn-produtos-relacionados{
                padding: 10px;
                cursor: pointer;
                border: 1px solid #999;
                transition: .2s;
                display: block;
                width: 240px;
                text-align: center;
                margin-top: 10px;
            }
            .btn-produtos-relacionados:hover{
                background-color: #fff;
            }
            .display-produtos-relacionados{
                position: fixed;
                width: 60%;
                height: 70vh;
                margin: 0 auto;
                top: 15vh;
                left: 0;
                right: 0;
                z-index: 200;
                visibility: hidden;
                opacity: 0;
                transition: .3s;
            }
            .display-produtos-relacionados .header-relacionados{
                position: relative;
                width: 100%;
                height: 10vh;
                background-color: #f78a14;
                color: #fff;
                border-radius: 6px 6px 0px 0px;
                text-align: center;
                line-height: 10vh;
                text-align: center;
                z-index: 50;
            }
            .display-produtos-relacionados .header-relacionados .title-relacionados{
                width: 26%;
                height: 10vh;
                margin: 0px;
                padding: 0px 2% 0px 2%;
                float: left;
            }
            .display-produtos-relacionados .header-relacionados .busca-relacionados{
                width: 38%;
                height: 5vh;
                font-size: 14px;
                margin: 2.5vh 1% 0px 1%;
                padding: 0px 1% 0px 1%;
                float: left;
                border: none;
            }
            .display-produtos-relacionados .header-relacionados label{
                width: 26%;
                height: 10vh;
                margin: 0px 2% 0px 0px;
                font-size: 12px;
                cursor: pointer;
            }
            .display-produtos-relacionados .header-relacionados label input{
                position: relative;
                vertical-align: middle;
                top: -1px;
                cursor: pointer;
            }
            .display-produtos-relacionados .bottom-relacionados{
                width: 100%;
                height: 10vh;
                background-color: #eee;
                line-height: 10vh;
                text-align: center;
                border-radius: 0px 0px 6px 6px;
                border-top: 2px solid #dedede;
            }
            .display-produtos-relacionados .bottom-relacionados .btn-salvar-relacionados{
                background-color: limegreen;
                color: #fff;
                padding: 10px 30px 10px 30px;
                cursor: pointer;
            }
            .display-produtos-relacionados .bottom-relacionados .btn-salvar-relacionados:hover{
                background-color: green;
            }
            .display-produtos-relacionados .lista-relacionados{
                position: relative;
                height: 50vh;
                overflow-x: auto;
                padding: 0px 0px 40px 0px;
                background-color: #eee;
                transition: .2s;
                clear: both;
                z-index: 40;
            }
            .display-produtos-relacionados .lista-relacionados .loading-background{
                position: fixed;
                width: 60%;
                height: 53vh;
                line-height: 53vh;
                margin: 0 auto;
                top: 30vh;
                left: 0;
                right: 0;
                background-color: rgba(255, 255, 255, .4);
                z-index: 50;
                visibility: hidden;
                transition: .3s;
                opacity: 0;
            }
            .display-produtos-relacionados .lista-relacionados .loading-background .loading-message{
                font-size: 18px;
                text-align: center;
                color: #f78a14;
                margin: 0px;
            }
            .display-produtos-relacionados .lista-relacionados .lista-relacionados-msg{
                position: fixed;
                width: 60%;
                height: 5px;
                line-height: 5px;
                margin: -30px 0px 0px 0px;
                visibility: hidden;
                opacity: 0;
                transition: .3s;
                background-color: #eee;
                border-bottom: 1px solid #dedede;
                z-index: 40;
            }
            .display-produtos-relacionados .lista-relacionados .lista-relacionados-msg h4{
                margin: 0px;
                padding: 0px 1% 5px 1%;
            }
            .display-produtos-relacionados .lista-relacionados .lista-relacionados-msg .limpar-todos-relacionados{
                position: absolute;
                height: 30px;
                top: 0px;
                right: 12.5%;
                width: 12%;
                font-size: 14px;
                white-space: nowrap;
                text-align: center;
                visibility: hidden;
            }
            .display-produtos-relacionados .lista-relacionados .label-relacionados{
                cursor: pointer;
                width: 98%;
                padding: 5px 1% 5px 1%;
                float: none;
                display: inline-block;
            }
            .display-produtos-relacionados .lista-relacionados .label-relacionados:hover{
                background-color: #fff;
            }
            /*END PRODUTOS RELACIONADOS CSS*/
        </style>
    </head>
    <body>
        <?php
            /*REQUIRE PADRAO*/
            require_once "header-efectus-web.php";
            require_once "pew-interatividade.php";
            /*FIM PADRAO*/
            require_once "pew-system-config.php";

            /*SET TABLES*/
            $tabela_categorias = $pew_db->tabela_categorias;
            $tabela_subcategorias = $pew_db->tabela_subcategorias;
            $tabela_departamentos = $pew_custom_db->tabela_departamentos;
            $tabela_produtos = $pew_custom_db->tabela_produtos;
            $tabela_marcas = $pew_custom_db->tabela_marcas;
            $tabela_especificacoes = $pew_custom_db->tabela_especificacoes;
            /*END SET TABLES*/
        ?>
        <h1 class="titulos"><?php echo $page_title; ?><a href="pew-produtos.php" class="btn-voltar"><i class="fa fa-arrow-left" aria-hidden="true"></i> Voltar</a></h1>
        <form name="busca_produto"><!--ESTA AQUI APENAS PARA NÃO BUGAR QUANDO DER ENTER NO INPUT BUSCA PRODUTO E TAMBÉM PARA FUNCIONAR O TRIGGER DA TECLA ENTER--></form>
        <section class="conteudo-painel">
            <form id="formCadastraProduto" action="pew-grava-produto.php" method="post" enctype="multipart/form-data">
                
                <!--LINHA 1-->
                <div class="label medium">
                    <h2 class='label-title'>Nome do Produto</h2>
                    <input type="text" name="nome" id="nome" placeholder="Produto" class="label-input">
                </div>
                <div class="label xsmall">
                    <h2 class='label-title'>Marca</h2>
                    <select name="marca" class="label-input">
                        <option value="">- Selecione -</option>
                        <?php
                            $contarMarcas = mysqli_query($conexao, "select count(id) as total from $tabela_marcas where status = 1");
                            $contagemMarcas = mysqli_fetch_array($contarMarcas);
                            $totalMarcas = $contagemMarcas["total"];
                            if($totalMarcas > 0){;
                                $queryMarcas = mysqli_query($conexao, "select * from $tabela_marcas where status = 1");
                                while($infoMarcas = mysqli_fetch_array($queryMarcas)){
                                    $nomeMarca = $infoMarcas["marca"];
                                    echo "<option value='$nomeMarca'>$nomeMarca</option>";
                                }
                            }
                        ?>
                    </select>
                    <?php
                    if($totalMarcas == 0){
                        echo "<h5 style='margin: 0px; margin-top: -6px;'>Nenhum marca cadastrada</h5>";
                    }
                    ?>
                </div>
                <div class="label xsmall">
                    <h2 class='label-title'>Estoque</h2>
                    <input type="number" step="any" name="estoque" id="estoque" class="label-input" value="1">
                </div>
                <div class="label xsmall">
                    <h2 class='label-title'>Estoque baixo</h2>
                    <input type="number" step="any" name="estoque_baixo" value="1" id="estoque_baixo" placeholder="Quantidade estoque baixo" class="label-input">
                </div>
                <div class="label xsmall">
                    <h2 class='label-title'>Fabricação (dias)</h2>
                    <input type="number" step="any" name="tempo_fabricacao" id="tempo_fabricacao" value="0" placeholder="Tempo em dias" class="label-input">
                </div>
                <!--END LINHA 1-->
                
                <!--LINHA 2-->
                <br class="clear">
                <div class="label half">
                    <h2 class='label-title'>Descrição Curta SEO Google<br>(Recomendado 156 caracteres)</h2>
                    <textarea placeholder="Descrição do produto" name="descricao_curta" maxlength="180" id="descricaoCurta" class="label-textarea" rows="3"></textarea>
                </div>
                <div class="label half">
                    <h2 class='label-title'>Descrição Longa</h2>
                    <textarea placeholder="Descrição do produto" name="descricao_longa" id="descricaoLonga" class="label-input" rows="5"></textarea>
                </div>
                <!--END LINHA 2-->
                <br class="clear">
                <br class="clear">
                <!--LINHA 3-->
                <div class="label xsmall">
                    <h2 class='label-title'>Status</h2>
                    <select name="status" class="label-input">
                        <option value="1">Ativo</option>
                        <option value="0">Inativo</option>
                    </select>
                </div>
                <div class="label xsmall">
                    <h2 class='label-title'>Preço</h2>
                    <input type="number" step="any" name="preco" id="preco" placeholder="Preço" class="label-input" style="margin-top: 10px;">
                </div>
                <div class="label xsmall">
                    <h2 class='label-title'>Preço promoção</h2>
                    <input type="number" step="any" name="preco_promocao" id="precoPromocao" placeholder="Preço promocao" class="label-input" style="margin-top: 10px;">
                </div>
                <div class="label xsmall">
                    <h2 class='label-title'>Promoção</h2>
                    <select name="promocao_ativa" class="label-input">
                        <option value="1">Ativa</option>
                        <option value="0" selected>Inativa</option>
                    </select>
                </div>
                <div class="label medium">
                    <h2 class='label-title'>SKU</h2>
                    <input type="text" name="sku" id="sku" placeholder="SKU" class="label-input">
                </div>
                <!--END LINHA 3-->
                <br class="clear">
                <br class="clear">
                <!--LINHA 4-->
                <div class="medium">
                    <div class="select-categorias">
                        <h3 class="titulo">Selecione os departamentos</h3>
                        <ul class="list-categorias">
                            <?php
                                $condicaoDepartamento = "true";
                                $totalDepartamentos = $pew_functions->contar_resultados($tabela_departamentos, $condicaoDepartamento);
                                if($totalDepartamentos > 0){
                                    $queryDepartamentos = mysqli_query($conexao, "select departamento, id from $tabela_departamentos where $condicaoDepartamento");
                                    while($departamentos = mysqli_fetch_array($queryDepartamentos)){
                                        $idDepartamento = $departamentos["id"];
                                        $departamento = $departamentos["departamento"];
                                        echo "<li class='box-categoria'><label><i class='fas fa-folder icone'></i>$departamento<input type='checkbox' value='$idDepartamento' class='check-categorias' name='departamentos[]'></label>";
                                        echo "</li>";
                                    }
                                }else{
                                    echo "<div class='full'>Nenhuma categoria foi cadastrada</div>";
                                }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="medium">
                    <div class="select-categorias">
                        <h3 class="titulo">Selecione as categorias e subcategorias</h3>
                        <ul class="list-categorias">
                            <?php
                                $condicaoCategorias = "status  = 1";
                                $totalCategorias = $pew_functions->contar_resultados($tabela_categorias, $condicaoCategorias);
                                if($totalCategorias > 0){
                                    $queryCategorias = mysqli_query($conexao, "select categoria, id from $tabela_categorias where $condicaoCategorias");
                                    while($categorias = mysqli_fetch_array($queryCategorias)){
                                        $idCategoria = $categorias["id"];
                                        $categoria = $categorias["categoria"];
                                        $condicaoSubcategorias = "status = 1 and id_categoria = '$idCategoria'";
                                        $totalSubcategorias = $pew_functions->contar_resultados($tabela_subcategorias, $condicaoSubcategorias);
                                        echo "<li class='box-categoria'><label><i class='fas fa-folder icone'></i>$categoria<input type='checkbox' value='$idCategoria' class='check-categorias' name='categorias[]'></label>";
                                        if($totalSubcategorias > 0){
                                            echo "<ul class='list-subcategorias'>";
                                            $querySubcategorias = mysqli_query($conexao, "select subcategoria, id from $tabela_subcategorias where $condicaoSubcategorias");
                                            while($subcategorias = mysqli_fetch_array($querySubcategorias)){
                                                $idSubcategoria = $subcategorias["id"];
                                                $subcategoria = $subcategorias["subcategoria"];
                                                echo "<li class='box-subcategoria'><label><i class='fas fa-folder icone'></i> $subcategoria<input type='checkbox' value='$subcategoria||$idSubcategoria' class='check-subcategorias' name='subcategorias[]'></label></li>";
                                            }
                                            echo "</ul>";
                                        }
                                        echo "</li>";
                                    }
                                }else{
                                    echo "<div class='full'>Nenhuma categoria foi cadastrada</div>";
                                }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="medium">
                    <h2 align=left style="margin: 0px;">Dimensões (Calculo frete)</h2>
                    <div class="label half">
                        <h2 class="label-title" title="Peso">Peso (kg)</h2>
                        <input type="number" step="any" name="peso" id="peso" placeholder="Ex: 0.500" class="label-input">
                    </div>
                    <div class="label half">
                        <h2 class="label-title" title="Comprimento">Comp. (cm)</h2>
                        <input type="number" step="any" name="comprimento" id="comprimento" placeholder="Ex: 20" class="label-input">
                    </div>
                    <div class="label half">
                        <h2 class="label-title" title="Largura">Largura (cm)</h2>
                        <input type="number" step="any" name="largura" id="largura" placeholder="Ex: 20" class="label-input">
                    </div>
                    <div class="label half">
                        <h2 class="label-title" title="Altura">Altura (cm)</h2>
                        <input type="number" step="any" name="altura" id="altura" placeholder="Ex: 20" class="label-input">
                    </div>
                </div>
                <!--END LINHA 4-->
                <br class="clear">
                <br class="clear">
                <br class="clear">
                <br class="clear">
                <!--LINHA 5-->
                <div class="half" align=right>
                    <h2 align=right>Especificações técnicas</h2>
                    <?php
                        $contarEspec = mysqli_query($conexao, "select count(id) as total from $tabela_especificacoes where status = 1");
                        $contagem = mysqli_fetch_assoc($contarEspec);
                        $totalEspec = $contagem["total"];
                        if($totalEspec > 0){
                            $queryEspecificacoes = mysqli_query($conexao, "select * from $tabela_especificacoes where status = 1 order by titulo asc");
                            echo "<div class='medium'>";
                            echo "<select id='selectEspecificacao' class='label-input'>";
                                echo "<option value=''>- Selecione -</option>";
                                while($infoEspecificacao = mysqli_fetch_array($queryEspecificacoes)){
                                    $tituloEspecificacao = $infoEspecificacao["titulo"];
                                    $idEspecificacao = $infoEspecificacao["id"];
                                    echo "<option value='$idEspecificacao'>$tituloEspecificacao</option>";
                                }
                            echo "</select>";
                            echo "</div>";
                            echo "<div class='medium'>";
                            echo "<input type='text' id='descricaoEspecificacao' class='label-input' placeholder='Descrição' form='addEspecificacao'>";
                            echo "</div>";
                            echo "<div class='medium'>";
                            echo "<a class='btn-especificacoes label-input'>Adicionar</a>";
                            echo "</div>";
                        }else{
                            echo "<h4>Nenhuma especificação foi cadastrada.</h4>";
                        }
                    ?>
                </div>
                <div class="label half" align=left>
                    <h2 class="label-title" align=left style="position: relative; top: 25px; margin-bottom: 25px;">Especificações adicionadas:</h2>
                    <div class="display-especificacoes"><!--ESPECIFICACOES ADICIONADAS--></div>
                </div>
                <!--END LINHA 5-->
                <br class="clear">
                <br class="clear">
                <br class="clear">
                <br class="clear">
                <!--LINHA 6-->
                <div class="label full clear">
                    <h2 class="label-title">Imagens do produto: (900px : 900px)</h2>
                    <div class="file-field label small" id="imagem1">
                        <div class="view"><i class="fa fa-plus" aria-hidden="true"></i></div>
                        <input type="file" name="imagem[]" id="imagemPrincipal" class="label-input" accept="image/*">
                        <div class="legenda">Selecione o arquivo</div>
                    </div>
                    <div class="file-field label small" id="imagem2">
                        <div class="view"><i class="fa fa-plus" aria-hidden="true"></i></div>
                        <input type="file" name="imagem[]" id="imagem2" class="label-input" accept="image/*">
                        <div class="legenda">Selecione o arquivo</div>
                    </div>
                    <div class="file-field label small" id="imagem3">
                        <div class="view"><i class="fa fa-plus" aria-hidden="true"></i></div>
                        <input type="file" name="imagem[]" id="imagem3" class="label-input" accept="image/*">
                        <div class="legenda">Selecione o arquivo</div>
                    </div>
                    <div class="file-field label small" id="imagem4">
                        <div class="view"><i class="fa fa-plus" aria-hidden="true"></i></div>
                        <input type="file" name="imagem[]" id="imagem4" class="label-input" accept="image/*">
                        <div class="legenda">Selecione o arquivo</div>
                    </div>
                </div>
                <!--END LINHA 6-->
                <br style="clear: both;">
                <br style="clear: both;">
                <br style="clear: both;">
                <br style="clear: both;">
                <!--LINHA 7-->
                <div class="label half" align="left">
                    <h3 class="label-title">Iframe Vídeo</h3>
                    <input type="text" class="label-input" name="url_video" placeholder="<iframe></iframe>">
                </div>
                <div class="half" align=left>
                    <!--PRODUTOS RELACIONADOS-->
                    <h3 class="label-title">Produtos Relacionados</h3>
                    <a class="btn-produtos-relacionados">Produtos Selecionados (0)</a>
                    <div class="display-produtos-relacionados">
                        <div class="header-relacionados">
                            <h3 class="title-relacionados">Produtos relacionados</h3>
                            <!--<h5 class="descricao-relacionados">Selecione os produtos relacionados</h5>-->
                            <input type="search" class="busca-relacionados" name="busca_relacionados" placeholder="Busque categoria, nome, marca, id, ou sku" form="busca_produto">
                            <label title="Listar somente os produtos que já foram selecionados"><input type="checkbox" id="checkOnlyActives"> Somente os selecionados</label>
                        </div>
                        <div class="lista-relacionados">
                            <div class="loading-background">
                                <h4 class="loading-message"><i class='fa fa-spinner fa-pulse fa-3x fa-fw'></i></h4>
                            </div>
                            <div class="lista-relacionados-msg"><h4>Exibindo todos os produtos:</h4><a class="link-padrao limpar-todos-relacionados" title="Limpar todos os produtos listados abaixo e que foram selecionados">Limpar todos</a></div>
                        <?php
                            $queryAllProdutos = mysqli_query($conexao, "select id, nome from $tabela_produtos where status = 1 order by nome asc");
                            while($infoRelacionados = mysqli_fetch_array($queryAllProdutos)){
                                $idProdutoRelacionado = $infoRelacionados["id"];
                                $nomeProdutoRelacionado = $infoRelacionados["nome"];
                                echo "<label class='label-relacionados'><input type='checkbox' name='produtos_relacionados[]' value='$idProdutoRelacionado'> $nomeProdutoRelacionado</label>";
                            }
                        ?>
                        </div>
                        <div class="bottom-relacionados">
                            <a class="btn-salvar-relacionados">Salvar</a>
                        </div>
                    </div>
                    <!--END PRODUTOS RELACIONADOS-->
                </div>
                <!--END LINHA 7-->
                <br class="clear">
                <br class="clear">
                <br class="clear">
                <br class="clear">
                <br class="clear">
                <div class="full clear">
                    <input type="submit" class="btn-submit" value="Cadastrar Produto">
                </div>
            </form>
        </section>
    </body>
</html>
<?php
}else{
    header("location: index.php?msg=Área Restrita. É necessário fazer login para continuar.");
}
?>