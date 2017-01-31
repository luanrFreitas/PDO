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
    <meta name="author" content="Andrew Esteves"/>
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" />
    <!--[if lt IE 9]>
    <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>

<div class="container">

    <header class="masthead">
        <h1 class="muted">PDO na Prática</h1>
        <nav class="navbar">
            <div class="navbar-inner">
                <div class="container">
                    <ul class="nav">
                        <li class="active"><a href="index.php">Página inicial</a></li>
                        <li><a href="inserir.php">Inserir</a></li>
                        <li><a href="">Ler</a></li>
                        <li><a href="">Atualizar</a></li>
                        <li><a href="">Excluir</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <?php
        # CREATE
        if(isset($_POST['enviar'])){
            $nome  = $_POST['nome'];
            $login = $_POST['login'];
            $senha = $_POST['senha'];
            $ativo = $_POST['ativo'];
            $email = $_POST['email'];
            $sql  = 'INSERT INTO webpbxip_usuario (nome,login,senha,ativo,email) ';
            $sql .= 'VALUES (:nome,:login,:senha,:ativo,:email)';
            try {
                $create = $db->prepare($sql);
                $create->bindValue(':nome', $nome, PDO::PARAM_STR);
                $create->bindValue(':login', $login, PDO::PARAM_STR);
                $create->bindValue(':senha', $senha, PDO::PARAM_STR);
                $create->bindValue(':ativo', $ativo, PDO::PARAM_STR);
                $create->bindValue(':email', $email, PDO::PARAM_STR);
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
            $id = (int)$_GET['id'];
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $sqlUpdate = 'UPDATE webpbxip_usuario SET nome = ?, email = ? WHERE id = ?';
            $dados = array($nome, $email, $id);
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
            $id = (int)$_GET['id'];
            $sqlDelete = 'DELETE FROM webpbxip_usuario WHERE id = :id';
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
            if(isset($_GET['action']) && $_GET['action'] == 'update'){
                $id = (int)$_GET['id'];
                $sqlSelect = 'SELECT * FROM webpbxip_usuario WHERE id = :id';
                try {
                    $select = $db->prepare($sqlSelect);
                    $select->bindValue(':id', $id, PDO::PARAM_INT);
                    $select->execute();
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
                $result = $select->fetch(PDO::FETCH_OBJ);
                ?>

                <ul class="breadcrumb">
                    <li><a href="index.php">Página inicial <span class="divider"> /</span> </a></li>
                    <li class="active">Atualizar</li>
                </ul>

                <form method="post" action="">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-user"></i></span>
                        <input type="text" name="nome" value="<?php echo $result->nome; ?>" placeholder="Nome:" />
                    </div>
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-envelope"></i></span>
                        <input type="text" name="email" value="<?php echo $result->email; ?>" placeholder="E-mail:" />
                    </div>
                    <br />
                    <input type="submit" name="atualizar" class="btn btn-primary" value="Atualizar dados">
                </form>

            <?php }else{ ?>

                <form method="post" action="">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-user"></i></span>
                        <input type="text" name="nome" placeholder="Nome:" />
                    </div>
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-tags"></i></span>
                        <input type="text" name="login" placeholder="Login:" />
                    </div>
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-asterisk"></i></span>
                        <input type="text" name="senha" placeholder="Senha:" />
                    </div>
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-ok"></i></span>
                        <input type="text" name="ativo" placeholder="Ativo:" />
                    </div>
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-envelope"></i></span>
                        <input type="text" name="email" placeholder="E-mail:" />
                    </div>
                    <br />
                    <input type="submit" name="enviar" class="btn btn-primary" value="Cadastrar dados">
                </form>

            <?php } ?>

            <table class="table table-hover">

                <thead>
                <tr>
                    <th>#</th>
                    <th>Nome:</th>
                    <th>Login:</th>
                    <th>Senha:</th>
                    <th>Ativo:</th>
                    <th>E-mail:</th>
                    <th>Ações:</th>
                </tr>
                </thead>

                <tbody>
                <?php
                $sqlRead = 'SELECT * FROM webpbxip_usuario';
                try {
                    $read = $db->prepare($sqlRead);
                    $read->execute();
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
                while( $rs = $read->fetch(PDO::FETCH_OBJ) ){
                    ?>
                    <tr>
                        <td><?php echo $rs->id; ?></td>
                        <td><?php echo $rs->nome; ?></td>
                        <td><?php echo $rs->login; ?></td>
                        <td><?php echo $rs->senha; ?></td>
                        <td><?php echo $rs->ativo; ?></td>
                        <td><?php echo $rs->email; ?></td>

                        <td>
                            <a href="index.php?action=update&id=<?php echo $rs->id; ?>" class="btn"><i class="icon-pencil"></i></a>
                            <a href="index.php?action=delete&id=<?php echo $rs->id; ?>" class="btn" onclick="return confirm('Deseja deletar?');"><i class="icon-remove"></i></a>
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