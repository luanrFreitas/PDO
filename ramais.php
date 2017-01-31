<?php
include "config.php";
?>
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
    <link rel="stylesheet" />
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
                        <li class="active"><a href="index.php">Página inicial</a></li>
                        <li><a href="ramais.php">Ramais</a></li>
                        <li><a href="usuarios.php">Usuarios</a></li>
                        <li><a href="/astcdr">Relatórios</a></li>
                        <li><a href="">Sair</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <?php
        # INSERT
        if(isset($_POST['enviar'])){
            $name  = $_POST['name'];
            $context = $_POST['context'];
            $secret = $_POST['secret'];
            $host = $_POST['host'];
            $type = $_POST['type'];
            $call = $_POST['call'];
            $sql  = "INSERT INTO pbxip_ramais (name,context,secret,host,type,`call-limit`) ";
            $sql .= 'VALUES (:name,:context,:secret,:host,:type,:call)';
            try {
                $create = $db->prepare($sql);
                $create->bindValue(':name', $name, PDO::PARAM_STR);
                $create->bindValue(':context', $context, PDO::PARAM_STR);
                $create->bindValue(':secret', $secret, PDO::PARAM_STR);
                $create->bindValue(':host', $host, PDO::PARAM_STR);
                $create->bindValue(':type', $type, PDO::PARAM_STR);
                $create->bindValue(':call', $call, PDO::PARAM_STR);
                if($create->execute()){
                    echo "<div class='alert alert-success'>
						<button type='button' class='close' data-dismiss='alert'>&times;</button>
						<strong>Inserido com sucesso!</strong>
						</div>";
                }
            } catch (PDOException $e) {
                echo "<div class='alert alert-error'>
						<button type='button' class='close' data-dismiss='alert'>&times;</button>
						<strong>Erro ao inserir dados!</strong>" . $e->getMessage() . "
						</div>";
            }
        }
        # UPDATE
        if(isset($_POST['atualizar'])){
            $name  = $_POST['name'];
            $context = $_POST['context'];
            $secret = $_POST['secret'];
            $host = $_POST['host'];
            $type = $_POST['type'];
            $call = $_POST['call'];
            $sqlUpdate = "UPDATE pbxip_ramais SET name=?,context=?,secret=?,host=?,type=?,`call-limit`=? WHERE name = ?";
            $dados = array($name, $context,$secret,$host,$type,$call, $name);
            try {
                $update = $db->prepare($sqlUpdate);
                if($update->execute($dados)){
                    echo "<div class='alert alert-success'>
						<button type='button' class='close' data-dismiss='alert'>&times;</button>
						<strong>Atualizado com sucesso!</strong>
						</div>";
                }
            } catch (PDOException $e) {
                echo "<div class='alert alert-error'>
						<button type='button' class='close' data-dismiss='alert'>&times;</button>
						<strong>Erro ao atualizar dados!</strong>" . $e->getMessage() . "
						</div>";
            }
        }
        # DELETE
        if(isset($_GET['action']) && $_GET['action'] == 'delete'){
            $name = (int)$_GET['name'];
            $sqlDelete = 'DELETE FROM pbxip_ramais WHERE name = :name';
            try {
                $delete = $db->prepare($sqlDelete);
                $delete->bindValue(':name', $id, PDO::PARAM_STR);
                if($delete->execute()){
                    echo "<div class='alert alert-success'>
						<button type='button' class='close' data-dismiss='alert'>&times;</button>
						<strong>Deletado com sucesso!</strong>
						</div>";
                }
            } catch (PDOException $e) {
                echo "<div class='alert alert-error'>
						<button type='button' class='close' data-dismiss='alert'>&times;</button>
						<strong>Erro ao deletar dados!</strong>" . $e->getMessage() . "
						</div>";
            }
        }
        ?>
    </header>

    <article>

        <section class="jumbotron">
            <?php
            if(isset($_GET['action']) && $_GET['action'] == 'update'){
                $name = $_GET['name'];
                $sqlSelect = 'SELECT * FROM pbxip_ramais WHERE name = :name';
                try {
                    $select = $db->prepare($sqlSelect);
                    $select->bindValue(':name', $name, PDO::PARAM_STR);
                    $select->execute();
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
                $result = $select->fetch(PDO::FETCH_OBJ);
                ?>

<!--                <ul class="breadcrumb">-->
<!--                    <li><a href="index.php">Página inicial <span class="divider"> /</span> </a></li>-->
<!--                    <li class="active">Atualizar</li>-->
<!--                </ul>-->

                <form method="post" action="">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-ok"></i></span>
                        <input type="text" name="name" value="<?php echo $result->name; ?>" placeholder="name:" />
                    </div>
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-ok"></i></span>
                        <input type="text" name="context" value="<?php echo $result->context; ?>" placeholder="context:" />
                    </div>
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-ok"></i></span>
                        <input type="text" name="secret" value="<?php echo $result->secret; ?>" placeholder="secret:" />
                    </div>
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-ok"></i></span>
                        <input type="text" name="host" value="<?php echo $result->host; ?>" placeholder="host:" />
                    </div>
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-ok"></i></span>
                        <input type="text" name="type" value="<?php echo $result->type; ?>" placeholder="type:" />
                    </div>
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-ok"></i></span>
                        <input type="text" name="call" value="<?php echo $result->call; ?>" placeholder="call-limit:" />
                    </div>
                    <br />
                    <input type="submit" name="atualizar" class="btn btn-primary" value="Atualizar dados">
                </form>

            <?php }else{ ?>

                <form method="post" action="">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-ok"></i></span>
                        <input type="text" name="name" placeholder="name:" />
                    </div>
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-ok"></i></span>
                        <input type="text" name="context" placeholder="context:" />
                    </div>
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-ok"></i></span>
                        <input type="text" name="secret" placeholder="secret:" />
                    </div>
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-ok"></i></span>
                        <input type="text" name="host" placeholder="host:" />
                    </div>
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-ok"></i></span>
                        <input type="text" name="type" placeholder="type:" />
                    </div>
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-ok"></i></span>
                        <input type="text" name="call" placeholder="call-limit:" />
                    </div>
                    <br />
                    <input type="submit" name="enviar" class="btn btn-primary" value="Novo ramal">
                </form>

            <?php } ?>

            <table class="table table-hover">

                <thead>
                <tr>
                    <th>Nome:</th>
                    <th>Contexto:</th>
                    <th>Senha:</th>
                    <th>Host:</th>
                    <th>Tipo:</th>
                    <th>Ligaçoes Simultâneas:</th>
                </tr>
                </thead>

                <tbody>

                 <?php
                 #SELECT
                $sqlRead = "SELECT `name`,`context`,`secret`,`host`,`type`,`call-limit` as calllimit FROM pbxip_ramais";
                try {
                    $read = $db->prepare($sqlRead);
                    $read->execute();
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
                while( $rs = $read->fetch(PDO::FETCH_OBJ) ){
                    ?>
                    <tr>
                        <td><?php echo $rs->name; ?></td>
                        <td><?php echo $rs->context; ?></td>
                        <td><?php echo $rs->secret; ?></td>
                        <td><?php echo $rs->host; ?></td>
                        <td><?php echo $rs->type; ?></td>
                        <td><?php echo $rs->calllimit; ?></td>

                        <td>
                            <a href="ramais.php?action=update&name=<?php echo $rs->name; ?>" class="btn"><i class="icon-pencil"></i></a>
                            <a href="ramais.php?action=delete&name=<?php echo $rs->name; ?>" class="btn" onclick="return confirm('Deseja deletar?');"><i class="icon-remove"></i></a>
                        </td>
                    </tr>
                <?php }	?>
                </tbody>

            </table>

        </section>

    </article>

</div>

<script src="js/jQuery.js"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>