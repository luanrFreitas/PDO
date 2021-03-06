<!DOCTYPE HTML>

<?php
include "config.php";
include "navbar.php";
?>

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



        <?php
        # INSERT
        if(isset($_POST['novo'])){
            ?>
        <form method="post" action="">
            <div class="input-prepend">
                <label for="login">Ramal:</label>
                <span class="add-on"><i class="icon-ok"></i></span>
                <input type="text" name="name" placeholder="Ramal:" />
            </div>
            <div class="input-prepend">
                <label for="login">Contexto:</label>
                <span class="add-on"><i class="icon-ok"></i></span>
                <input type="text" name="context" placeholder="Contexto:" />
            </div>
            <div class="input-prepend">
                <label for="login">Senha:</label>
                <span class="add-on"><i class="icon-ok"></i></span>
                <input type="text" name="secret" placeholder="Senha:" />
            </div>
            <div class="input-prepend">
                <label for="login">Host:</label>
                <span class="add-on"><i class="icon-ok"></i></span>
                <input type="text" name="host" placeholder="Host:" />
            </div>
            <div class="input-prepend">
                <label for="login">Tipo:</label>
                <span class="add-on"><i class="icon-ok"></i></span>
                <input type="text" name="type" placeholder="Tipo:" />
            </div>
            <div class="input-prepend">
                <label for="login">Ligações Simultâneas:</label>
                <span class="add-on"><i class="icon-ok"></i></span>
                <input type="text" name="call" placeholder="Ligações Simultâneas:" />
            </div>
            <br />
            <input type="submit" name="enviar" class="btn btn-primary" value="Salvar">
        </form>

            <?php } ?>
        
            <?php
            if (isset($_POST['enviar'])) {
                $name = $_POST['name'];
                $context = $_POST['context'];
                $secret = $_POST['secret'];
                $host = $_POST['host'];
                $type = $_POST['type'];
                $call = $_POST['call'];
                if (empty($name) || empty($context) || empty($secret) || empty($host) || empty($type) || empty($call)){
                    echo "<div class='alert alert-error'>
						<button type='button' class='close' data-dismiss='alert'>&times;</button>
						<strong>Todos os campos devem ser preenchidos!</strong>
						</div>";
                }else {
                    $sql = "INSERT INTO pbxip_ramais (name,context,secret,host,type,`call-limit`) ";
                    $sql .= 'VALUES (:name,:context,:secret,:host,:type,:call)';
                    try {
                        $create = $db->prepare($sql);
                        $create->bindValue(':name', $name, PDO::PARAM_STR);
                        $create->bindValue(':context', $context, PDO::PARAM_STR);
                        $create->bindValue(':secret', $secret, PDO::PARAM_STR);
                        $create->bindValue(':host', $host, PDO::PARAM_STR);
                        $create->bindValue(':type', $type, PDO::PARAM_STR);
                        $create->bindValue(':call', $call, PDO::PARAM_STR);
                        if ($create->execute()) {
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
            }

        # UPDATE
        if(isset($_POST['atualizar'])){
            $id  = $_POST['id'];
            $name  = $_POST['name'];
            $context = $_POST['context'];
            $secret = $_POST['secret'];
            $host = $_POST['host'];
            $type = $_POST['type'];
            $call = $_POST['call'];
            $sqlUpdate = "UPDATE pbxip_ramais SET `name`=?,context=?,secret=?,host=?,type=?,`call-limit`=? WHERE id = ?";
            $dados = array($name, $context,$secret,$host,$type,$call,$id);
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
        if(isset($_POST['action']) && $_POST['action'] == 'delete'){
            $id = (int)$_POST['id'];
            $sqlDelete = 'DELETE FROM pbxip_ramais WHERE id = :id';
            try {
                $delete = $db->prepare($sqlDelete);
                $delete->bindValue(':id', $id, PDO::PARAM_INT);
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
            if(isset($_POST['action']) && $_POST['action'] == 'update'){
                $id = (int)$_POST['id'];
                $sqlSelect = 'SELECT id,`name`,`context`,`secret`,`host`,`type`,`call-limit` as calllimit FROM pbxip_ramais WHERE id = :id';
                try {
                    $select = $db->prepare($sqlSelect);
                    $select->bindValue(':id', $id, PDO::PARAM_INT);
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
                        <input type="text" name="name" value="<?php echo $result->name; ?>" placeholder="nome:" />
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
                        <input type="text" name="call" value="<?php echo $result->calllimit; ?>" placeholder="call-limit:" />
                    </div>
                    <input type="hidden" name="id" value="<?php echo $result->id; ?>"/>
                    <br />
                    <input type="submit" name="atualizar" class="btn btn-primary" value="Atualizar dados">
                </form>

            <?php }else{
            if(!isset($_POST['novo'])){
                ?>

                <form method="post" action="">
                    <br />
                    <input type="submit" name="novo" class="btn btn-primary" value="Novo ramal">
                </form>

            <?php } }?>

            <table class="table table-hover">

                <thead>
                <tr>

                    <th>Nome:</th>
                    <th>Contexto:</th>
                    <th>Senha:</th>
                    <th>Host:</th>
                    <th>Tipo:</th>
                    <th>Ligaçoes Simultâneas:</th>
                    <th>Ações</th>
                </tr>
                </thead>

                <tbody>

                 <?php
                 #SELECT
                $sqlRead = "SELECT id,`name`,`context`,`secret`,`host`,`type`,`call-limit` as calllimit FROM pbxip_ramais";
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
                            <form class="luan_form" action="ramais.php" method="post">
                                <input type="hidden" name="action" value="update"/>
                                <input type="hidden" name="id" value=<?php echo $rs->id; ?> />
                                <button class="btn"><i class="icon-pencil"></i></button>
                            </form>
                            <form class="luan_form" action="ramais.php" method="post">
                                <input type="hidden" name="action" value="delete"/>
                                <input type="hidden" name="id" value=<?php echo $rs->id; ?> />
                                <button class="btn" onclick="return confirm('Deseja deletar?');"><i class="icon-remove"></i></button>
                            </form>
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
