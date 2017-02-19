<!DOCTYPE HTML>
<html land="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>PBXIP</title>
    <meta name="description" content="PBXIP" />
    <meta name="robots" content="index, follow" />
    <meta name="author" content="Luan Freitas"/>
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/luan.css" />
    <!--[if lt IE 9]>
    <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>

<div class="container">

    <header class="masthead">
        <h1 class="muted">PBX IP</h1>
        <nav class="navbar">
            <div class="navbar-inner">
                <div class="container">
                    <ul class="nav">
                        <?php switch ($_SERVER['REQUEST_URI']) {
                            case "/pbxip/index.php": ?>
                                <li class = "active"><a href = "index.php">Página inicial</a></li>
                                <li><a href = "ramais.php">Ramais</a></li>
                                <li><a href = "usuarios.php">Usuarios</a></li>
                                <li><a href = "contextos.php">Contextos</a></li>
                                <li><a href = "/astcdr">Relatórios</a></li>
                                <li><a href = "">Sair</a></li>
                                <?php break;
                            case "/pbxip/ramais.php": ?>
                                <li><a href = "index.php">Página inicial</a></li>
                                <li class = "active"><a href = "ramais.php">Ramais</a></li>
                                <li><a href = "usuarios.php">Usuarios</a></li>
                                <li><a href = "contextos.php">Contextos</a></li>
                                <li><a href = "/astcdr">Relatórios</a></li>
                                <li><a href = "">Sair</a></li>
                                <?php break;
                            case "/pbxip/usuarios.php": ?>
                                <li><a href = "index.php">Página inicial</a></li>
                                <li><a href = "ramais.php">Ramais</a></li>
                                <li class = "active"><a href = "usuarios.php">Usuarios</a></li>
                                <li><a href = "contextos.php">Contextos</a></li>
                                <li><a href = "/astcdr">Relatórios</a></li>
                                <li><a href = "">Sair</a></li>
                                <?php break;
                            case "/pbxip/contextos.php": ?>
                                <li><a href = "index.php">Página inicial</a></li>
                                <li><a href = "ramais.php">Ramais</a></li>
                                <li><a href = "usuarios.php">Usuarios</a></li>
                                <li class = "active"><a href = "contextos.php">Contextos</a></li>
                                <li><a href = "/astcdr">Relatórios</a></li>
                                <li><a href = "">Sair</a></li>
                                <?php break;
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
</div>

<script src="js/jQuery.js"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>

<?php


//echo $_SERVER['REQUEST_URI'];