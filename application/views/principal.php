<!DOCTYPE html>
<html lang="en">
    <head>
        <base href="<?php echo base_url(); ?>" />
        <meta charset="utf-8">
        <title>Sistema para Gestão de Alunos</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Le styles -->
        <link href="assets/css/bootstrap.css" rel="stylesheet">
        <link href="assets/css/jquery-ui.css" rel="stylesheet">
        <link href="assets/css/main.css" rel="stylesheet">
        <link href="assets/css/bootstrap-wysihtml5.css" rel="stylesheet">
        <style type="text/css">
            body {
                padding-top: 60px;
                padding-bottom: 40px;
            }
            .sidebar-nav {
                padding: 9px 0;
            }

            @media (max-width: 980px) {
                /* Enable use of floated navbar text */
                .navbar-text.pull-right {
                    float: none;
                    padding-left: 5px;
                    padding-right: 5px;
                }
            }

            .footer {
                background-color: #F5F5F5;
                border-top: 1px solid #E5E5E5;
                margin-top: 70px;
                padding: 30px 0;
                text-align: center;
            }

            .footer-links li {
                display: inline;
                padding: 0 2px;
            }
        </style>
        <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="assets/js/html5shiv.js"></script>
        <![endif]-->

        <!-- Fav and touch icons -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
        <link rel="shortcut icon" href="assets/ico/favicon.png">
    </head>

    <body onload="menu('<?php echo "index.php/" . uri_string() ?>')">

        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="brand" href="index.php/principal">C.O.D.E - Beta</a>
                    <div class="nav-collapse collapse">
                        <p class="navbar-text pull-right">
                            Seja bem vindo(a) <a href="index.php/perfil/atualizar" class="navbar-link"><?php echo $this->session->userdata('nome') ?>.</a>
                        </p>
                        <ul class="nav menu">
                            <li><a href="index.php/principal">Página Inicial</a></li>
                            <li><a href="index.php/sobre-o-sistema">Sobre o Sistema</a></li>
                            <li><a href="index.php/suporte">Suporte</a></li>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span3">
                    <div class="well sidebar-nav">
                        <ul class="nav nav-list menu">
                            <?php if ($this->session->userdata('nivel') == 1): ?>
                            <li class="nav-header">Usuários</li>
                            <li><a href="index.php/usuarios/cadastrar">Cadastrar</a></li>
                            <li><a href="index.php/usuarios/gerenciar/null">Gerenciar</a></li>
                            <?php endif; ?>
                            <li class="nav-header">Alunos</li>
                            <li><a href="index.php/alunos/cadastrar">Cadastrar</a></li>
                            <li><a href="index.php/alunos/gerenciar/null">Gerenciar</a></li>
                            <li class="nav-header">Ocorrências</li>
                            <li><a href="index.php/ocorrencias/cadastrar">Cadastrar</a></li>
                            <li><a href="index.php/ocorrencias/gerenciar/null">Gerenciar</a></li>
                            <li class="nav-header">Desempenho Escolar</li>
                            <li><a href="index.php/desempenho-escolar/cadastrar">Cadastrar</a></li>
                            <li><a href="index.php/desempenho-escolar/gerenciar/null">Gerenciar</a></li>
                            <?php if ($this->session->userdata('nivel') == 1): ?>
                            <li class="nav-header">Relatórios</li>
                            <li><a href="index.php/relatorio/gerarRelatorio">Gerar Relatório</a></li>
                            <?php endif; ?>
                            <li class="nav-header">Perfil</li>
                            <li><a href="index.php/perfil/atualizar">Editar</a></li>
                            <li class="nav-header">Deslogar</li>
                            <li><a href="index.php/deslogarController">Sair</a></li>
                        </ul>
                    </div><!--/.well -->
                </div><!--/span-->
                <div class="span9">
                    <?php echo $this->load->view($pagina) ?>
                </div><!--/span-->
            </div><!--/row-->
        </div><!--/.fluid-container-->

        <footer class="footer">
            <div class="container">
                <p>Projetado e construido utilizando o Twitter BootStrap <a href="http://twitter.github.com/bootstrap/index.html" target="_blank">Twitter BootStrap</a>.</p>
                <p>Código licenciado sob <a href="http://www.opensource.org/licenses/mit-license.php" target="_blank">The MIT License (MIT)</a>, Documentação sobre <a href="http://creativecommons.org/licenses/by/3.0/">CC BY 3.0</a>.</p>
                <ul class="footer-links">
                    <li><a href="#">Blog</a></li>
                    <li class="muted">&middot;</li>
                    <li><a href="#">Documentação</a></li>
                    <li class="muted">&middot;</li>
                    <li><a href="#">Mudanças</a></li>
                </ul>
            </div>
        </footer>

        <!-- Le javascript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="assets/js/jquery.js"></script>
        <script src="assets/js/jqform.js"></script>
        <script src="assets/js/jquery-ui.js"></script>
        <script src="assets/js/jquery.maskedinput.min.js"></script>
        <script src="assets/js/bootstrap-transition.js"></script>
        <script src="assets/js/bootstrap-alert.js"></script>
        <script src="assets/js/bootstrap-modal.js"></script>
        <script src="assets/js/bootstrap-dropdown.js"></script>
        <script src="assets/js/bootstrap-scrollspy.js"></script>
        <script src="assets/js/bootstrap-tab.js"></script>
        <script src="assets/js/bootstrap-tooltip.js"></script>
        <script src="assets/js/bootstrap-popover.js"></script>
        <script src="assets/js/bootstrap-button.js"></script>
        <script src="assets/js/bootstrap-collapse.js"></script>
        <script src="assets/js/bootstrap-carousel.js"></script>
        <script src="assets/js/bootstrap-typeahead.js"></script>
        <script src="assets/js/wysihtml5-0.3.0.js"></script> 
        <script src="assets/js/bootstrap-wysihtml5.js"></script>
        <script src="assets/js/main.js"></script>

    </body>
</html>
