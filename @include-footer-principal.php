<style>
    .footer-principal{
        width: 100%;
        display: flex;
        justify-content: center;
        align-content: center;
        background-color: #000;
        font-size: 16px;
        flex-flow: row wrap;
        overflow: hidden;
    }
    .footer-principal .newsletter{
		position: relative;
        width: 100%;
        display: block;
        padding: 50px 0px 50px 0px;
    }
    .footer-principal .newsletter .titulo{
        margin: 0px 0px 5px 0px;
        font-size: 16px;
        text-align: center;
		color: #FFF;
    }
	.footer-principal .newsletter .logo-footer{
		position: absolute;
		left: 250px;
		top: 70px;
	}
    .footer-principal .newsletter .subtitulo{
        margin: 0px 0px 10px 0px;
        font-size: 14px;
        text-align: center;
		color: #ccc;
    }
    .footer-principal .newsletter .form-newsletter{
        width: 330px;
        margin: 0 auto;
        text-align: center;
    }
    .footer-principal .newsletter .form-newsletter input{
        width: 100%;
        margin-bottom: 10px;
        height: 20px;
        border: none;
        border-bottom: 1px solid #333;
        font-size: 14px;
        background-color: transparent;
        outline: none;
        color: #ccc;
		transition: .1s;
    }
	.footer-principal .newsletter .form-newsletter input:focus{
		color: #66CD00;
		transform: scale(1.05);
		font-weight: bolder;
	}
    .footer-principal .newsletter .form-newsletter .btn-submit{
        width: 80px;
        height: 25px;
        background-color: #FFF;
        border: none;
        color: #333;
    }
    .footer-principal .newsletter .form-newsletter .btn-submit:hover{
        background-color: #66CD00;
		color: #fff;
        cursor: pointer;
		transform: scale(1.05);
    }
    .footer-principal .display-links{
        width: 80%;
    }
    .footer-principal .display-links .footer-links{
        width: 100%;
        display: flex;
        justify-content: center;
        margin: 10px 0px 10px 0px;
        padding: 0px;
    }
    .footer-principal .display-links .footer-links .first-li{
        display: flex;
        justify-content: space-between;
        flex: 1 1 auto;
        margin: 0px;
    }
    .footer-principal .display-links .footer-links .first-li span{
        position: relative;
        height: auto;
    }
    .footer-principal .display-links .footer-links .first-li .link-principal{
        display: block;
        font-size: 16px;
        text-decoration: none;
        color: #fff;
        padding: 2px 0px 2px 0px;
        margin-bottom: 10px;
        border-bottom: 1px solid transparent;
        transition: .3s;
    }
    .footer-principal .display-links .footer-links .first-li .link-principal:hover{
        border-color: #66CD00;
    }
    .footer-principal .display-links .footer-links .first-li .sub-menu{
        margin: 0px;
        padding: 0px;
    }
    .footer-principal .display-links .footer-links .first-li .sub-menu li{
        font-size: 12px;
        display: block;
    }
    .footer-principal .display-links .footer-links .first-li .sub-menu li .sub-link{
        display: block;
        text-decoration: none;
        color: #ccc;
        padding: 2.5px;
        margin: 0px 0px 5px 0px;
    }
    .footer-principal .display-links .footer-links .first-li .sub-menu li .sub-link:hover{
        border-color: #333;
        text-decoration: underline;
    }
    .footer-principal .display-links .footer-links .first-li .sub-menu .social-media a{
        display: inline-block;
        width: 25px;
        height: 25px;
        text-align: center;
        line-height: 26px;
        font-size: 16px;
        margin: 0px 10px 0px 0px;
        color: #333;
        border-radius: 50%;
        transition: .2s;
        border: 1px solid #333;
    }
    .footer-principal .display-links .footer-links .first-li .sub-menu .social-media .facebook{
        border: 1px solid #4267b2;
        color: #4267b2;
    }
    .footer-principal .display-links .footer-links .first-li .sub-menu .social-media .facebook:hover{
        background-color: #4267b2;
        color: #fff;
    }
    .footer-principal .display-links .footer-links .first-li .sub-menu .social-media .instagram{
        border: 1px solid #cd486b;
        color: #cd486b;
    }
    .footer-principal .display-links .footer-links .first-li .sub-menu .social-media .instagram:hover{
        background-color: #cd486b;
        color: #fff;
    }
    @media screen and (max-width: 1100px){
        .footer-principal .display-links .footer-links{
            width: 100%;
            flex-wrap: wrap;
        }
        .footer-principal .display-links .footer-links .first-li{
            display: inline-block;
            width: 33%;
            margin: 10px 0px 10px 0px;
        }
        @media screen and (max-width: 720px){
            .footer-principal .newsletter .titulo{
                font-size: 14px;
            }
            .footer-principal .newsletter .subtitulo{
                font-size: 12px;
            }
            .footer-principal .newsletter .form-newsletter{
                width: 290px;
            }
            .footer-principal .display-links{
                width: 95%;
            }
            .footer-principal .display-links .footer-links{
                justify-content: flex-start;
            }
            .footer-principal .display-links .footer-links .first-li{
                width: 50%;
                max-width: 50%;
                text-align: center;
            }
        }
    }
</style>
<script>
    $(document).ready(function(){
        var formNewsletter = $(".form-newsletter");
        var inputNome = formNewsletter.children(".input-nome");
        var inputEmail = formNewsletter.children(".input-email");
        var cadastrando = false;
        var gravaNewsletterUrl = "@grava-newsletter.php";
        formNewsletter.off().on("submit", function(){
            event.preventDefault();
            if(!cadastrando){
                cadastrando = true;
                var nome = inputNome.val();
                var email = inputEmail.val();

                function validarCampos(){
                    if(nome.length < 3){
                        mensagemAlerta("O campo nome deve conter no mínimo 3 caracteres", inputNome);
                        return false;
                    }
                    if(!validarEmail(email)){
                        mensagemAlerta("O campo email deve ser preenchido corretamente", inputEmail);
                        return false;
                    }
                    return true;
                }

                if(validarCampos() == true){
                    $.ajax({
                        type: "POST",
                        url: gravaNewsletterUrl,
                        data: {nome: nome, email: email},
                        error: function(){
                            mensagemAlerta("Ocorreu um erro ao enviar os dados. Recarregue a página e tente novamente.");
                        },
                        success: function(resposta){
                            if(resposta == "true"){
                                mensagemAlerta("Seu email foi cadastrado com sucesso! Logo lhe enviaremos novidades.", false, "limegreen");
                            }else if(resposta == "already"){
                                mensagemAlerta("Seu email já está cadastrado! Logo lhe enviaremos novidades.", false, "limegreen");
                            }else{
                                console.log(resposta);
                                mensagemAlerta("Ocorreu um erro ao enviar os dados. Recarregue a página e tente novamente.");
                            }
                            cadastrando = false;
                        }
                    });
                }else{
                    cadastrando = false;
                }
            }
        });
    });
</script>
<footer class="footer-principal">
    <div class="newsletter">
       	<img class="logo-footer" src="imagens/identidadeVisual/logo-acrisigns.png">
        <h3 class="titulo">Newsletter</h3>
        <h4 class="subtitulo">Assine nosso informativo e receba as ofertas</h4>
        <form class="form-newsletter">
            <input type="text" placeholder="Digite seu nome" name="nome" class="input-nome">
            <input type="text" placeholder="Digite seu email" name="email" class="input-email">
            <input type="submit" value="ENVIAR" class="btn-submit">
        </form>
    </div>
    <div class="display-links">
        <?php
        class FooterLinks{
            private $titulo_link;
            private $url_link;
            private $qtd_sublinks;
            private $sublinks;
            private $qtd_sub_sublinks;
            private $sub_sublinks;

            function __construct($tituloLink, $urlLink){
                $this->titulo_link = $tituloLink;
                $this->url_link = $urlLink;
                $this->qtd_sublinks = 0;
                $this->sublinks = array();
                $this->qtd_sub_sublinks = 0;
                $this->sub_sublinks = array();
            }

            public function add_sublink($id, $titulo, $url){
                $this->sublinks[$this->qtd_sublinks] = array();
                $this->sublinks[$this->qtd_sublinks]["id"] = $id;
                $this->sublinks[$this->qtd_sublinks]["titulo"] = $titulo;
                $this->sublinks[$this->qtd_sublinks]["url"] = $url;
                $this->sublinks[$this->qtd_sublinks]["qtd_sub_sublinks"] = 0;
                $this->qtd_sublinks++;
            }

            public function add_sub_sublink($idSublink, $titulo, $url){
                $this->sub_sublinks[$this->qtd_sub_sublinks] = array();
                $this->sub_sublinks[$this->qtd_sub_sublinks]["id_sublink"] = $idSublink;
                $this->sub_sublinks[$this->qtd_sub_sublinks]["titulo"] = $titulo;
                $this->sub_sublinks[$this->qtd_sub_sublinks]["url"] = $url;
                foreach($this->sublinks as $indice => $sublink){
                    $id = $sublink["id"];
                    if($idSublink == $id){
                        $this->sublinks[$indice]["qtd_sub_sublinks"]++;
                    }
                }
                $this->qtd_sub_sublinks++;
            }

            public function get_qtd_sublinks(){
                return $this->qtd_sublinks;
            }

            public function listar_link(){
                $tituloPrincipal = $this->titulo_link;
                $urlPrincipal = $this->url_link;
                $subLinks = $this->sublinks;
                echo "<li class='first-li'>";
                echo "<span>";
                    echo "<a href='$urlPrincipal' class='link-principal'>$tituloPrincipal</a>";
                    if($this->qtd_sublinks > 0){
                        echo "<ul class='sub-menu'>";
                        foreach($subLinks as $subLink){
                            $idSubLink = $subLink["id"];
                            $tituloSubLink = $subLink["titulo"];
                            $urlSubLink = $subLink["url"];
                            $qtd_sub_subLinks = $subLink["qtd_sub_sublinks"];
                            $sub_subLinks = $this->sub_sublinks;
                            echo "<li><a href='$urlSubLink' class='sub-link'>$tituloSubLink</a></li>";
                        }
                        echo "</ul>";
                    }
                echo "</span>";
                echo "</li>";
            }
        }

        $link_footer = null;
        $link_footer[0] = new FooterLinks("PÁGINA INICIAL", "index.php");
        $link_footer[1] = new FooterLinks("FESTA", "loja.php?departamento=feminino");
        $link_footer[1]->add_sub_sublink(1, "SUBCATEGORIA 1", "loja.php?departamento=feminino&categoria=categoria_1&subcategoria=subcategoria_1");
        $link_footer[1]->add_sub_sublink(1, "SUBCATEGORIA 2", "loja.php?departamento=feminino&categoria=categoria_1&subcategoria=subcategoria_2");
        $link_footer[2] = new FooterLinks("CASA", "loja.php?departamento=masculino");
        $link_footer[3] = new FooterLinks("BRINQUEDOS", "loja.php?departamento=mochilas");
        $link_footer[4] = new FooterLinks("BRINDES E DISPLAYS", "loja.php?departamento=acessorios");

        $quantidadeLinks = count($link_footer);
        if($quantidadeLinks > 0){
            echo "<ul class='footer-links'>";
                foreach($link_footer as $link){
                    $link->listar_link();
                }
            echo "</ul>";
        }
        ?>
        <br style="clear: both;">
        <ul class="footer-links links-estaticos">
            <li class='first-li'>
                <span>
                    <a href="institucional.php" class="link-principal">INSTITUCIONAL</a>
                    <ul class="sub-menu">
                        <li><a href='quem-somos.php' class='sub-link'>Quem Somos</a></li>
                        <li><a href='garantia-de-qualidade.php' class='sub-link'>Garantia de qualidade</a></li>
                        <li><a href='frete-gratis.php' class='sub-link'>Frete Grátis</a></li>
                    </ul>
                </span>
            </li>
            <li class='first-li'>
                <span>
                    <a class="link-principal">POLÍTICAS</a>
                    <ul class="sub-menu">
                        <li><a href='entrega-e-devolucao.php' class='sub-link'>Entrega e devolução</a></li>
                    </ul>
                </span>
            </li>
            <li class='first-li'><span><a href="#" class="link-principal">CONTATO</a></span></li>
            <li class='first-li'>
                <span>
                    <a class="link-principal">REDES SOCIAIS</a>
                    <ul class="sub-menu">
                        <li class="social-media">
                            <a href="#" class="facebook"><i class="fab fa-facebook-f"></i></a>
                        </li>
                    </ul>
                </span>
            </li>
            <li class='first-li'><span><a href="formas-de-pagamento.php" class="link-principal">FORMAS DE PAGAMENTO</a></span></li>
            <li class='first-li'><span><a href="seguranca.php" class="link-principal">SEGURANÇA</a></span></li>
        </ul>
    </div>
</footer>
