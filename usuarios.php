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
                        <li><a href="index.php">Página inicial</a></li>
                        <li><a href="ramais.php">Ramais</a></li>
                        <li class="active"><a href="usuarios.php">Usuarios</a></li>
                        <li><a href="/astcdr">Relatórios</a></li>
                        <li><a href="">Sair</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <?php
        # INSERT
        if(isset($_POST['novo'])){
            ?>
            <form method="post" action="">
                <div class="input-prepend">
                    <label for="nome">Nome:</label>
                    <span class="add-on"><i class="icon-user"></i></span>
                    <input type="text" name="nome" placeholder="Nome"/>
                </div>
                <div class="input-prepend">
                    <label for="login">Login:</label>
                    <span class="add-on"><i class="icon-tags"></i></span>
                    <input type="text" name="login" placeholder="Login" />
                </div>
                <div class="input-prepend">
                    <label for="senha">Senha:</label>
                    <span class="add-on"><i class="icon-asterisk"></i></span>
                    <input type="password" name="senha" placeholder="Senha" />
                </div>
<!--                <div class="input-prepend">-->
<!--                    <label for="ativo">Ativo:</label>-->
<!--                    <span class="add-on"><i class="icon-ok"></i></span>-->
<!--                    <input type="text" name="ativo" placeholder="Ativo" />-->
<!--                </div>-->
                <div class="input-prepend" >
                    <label for="email">E-mail:</label>
                    <span class="add-on"><i class="icon-envelope"></i></span>
                    <input type="text" name="email" placeholder="E-mail" />
                </div> </br>
                <br />
                <div class="form-group">
                    <label for="sel1">Ativo:</label>
                    <select class="form-control" id="sel1" name="ativo">
                        <option>Sim</option>
                        <option>Não</option>
                    </select>
                </div>
<!--                <div class="input-prepend">-->
<!--                    <label for="perfil">Perfil:</label>-->
<!--                    <span class="add-on"><i class="icon-tags"></i></span>-->
<!--                    <input type="text" name="perfil" placeholder="Perfil" />-->
<!--                </div>-->
                <div class="form-group" >
                    <label for="perfil">Perfil:</label>
                    <select class="form-control" id="perfil" name="perfil">
                        <option>Usuário</option>
                        <option>Administrador</option>
                    </select>
                </div>
                <br />
                <input type="submit" name="enviar" class="btn btn-primary" value="Salvar">
            </form>

        <?php } ?>

             <?php
        if(isset($_POST['enviar'])){
            $nome  = $_POST['nome'];
            $login = $_POST['login'];
            $senha = $_POST['senha'];
            $ativo = $_POST['ativo'];
            $email = $_POST['email'];
            $perfil = $_POST['perfil'];
            if(empty($nome) || empty($login) || empty($senha) || empty($ativo) || empty($email) || $perfil){
                echo "<div class='alert alert-error'>
						<button type='button' class='close' data-dismiss='alert'>&times;</button>
						<strong>Todos os campos devem ser preenchidos!</strong>
						</div>";
            }else {
            $sql  = 'INSERT INTO webpbxip_usuario (nome,login,senha,ativo,email,id_perfil) ';
            $sql .= 'VALUES (:nome,:login,:senha,:ativo,:email,:perfil)';
            try {
                $create = $db->prepare($sql);
                $create->bindValue(':nome', $nome, PDO::PARAM_STR);
                $create->bindValue(':login', $login, PDO::PARAM_STR);
                $create->bindValue(':senha', $senha, PDO::PARAM_STR);
                $create->bindValue(':ativo', $ativo, PDO::PARAM_STR);
                $create->bindValue(':email', $email, PDO::PARAM_STR);
                $create->bindValue(':perfil', $perfil, PDO::PARAM_STR);
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
        }
        # UPDATE
        if(isset($_POST['atualizar'])){
            $id_usuario = (int)$_GET['id_usuario'];
            $nome = $_POST['nome'];
            $login = $_POST['login'];
            $senha = $_POST['senha'];
            $ativo = $_POST['ativo'];
            $email = $_POST['email'];
            $id_perfil = $_POST['perfil'];
            $sqlUpdate = 'UPDATE webpbxip_usuario SET nome=?,login=?,senha=?,ativo=?,email=?,id_perfil=? WHERE id_usuario = ?';
            $dados = array($nome,$login,$senha,$ativo,$email,$id_perfil,$id_usuario);
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
            $id_usuario = (int)$_GET['id_usuario'];
            $sqlDelete = 'DELETE FROM webpbxip_usuario WHERE id_usuario = :id_usuario';
            try {
                $delete = $db->prepare($sqlDelete);
                $delete->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
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
                $id_usuario = (int)$_GET['id_usuario'];
                $sqlSelect = 'SELECT `id_usuario`, `nome`, `login`, `senha`, `ativo`, `email`, `id_perfil` FROM webpbxip_usuario WHERE id_usuario = :id_usuario';
                try {
                    $select = $db->prepare($sqlSelect);
                    $select->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
                    $select->execute();
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
                $result = $select->fetch(PDO::FETCH_OBJ);
                ?>


                <form method="post" action="">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-user"></i></span>
                        <input type="text" name="nome" value="<?php echo $result->nome; ?>" placeholder="Nome:" />
                    </div>
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-user"></i></span>
                        <input type="text" name="login" value="<?php echo $result->login; ?>" placeholder="Login:" />
                    </div>
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-user"></i></span>
                        <input type="text" name="senha" value="<?php echo $result->senha; ?>" placeholder="Senha:" />
                    </div>
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-user"></i></span>
                        <input type="text" name="ativo" value="<?php echo $result->ativo; ?>" placeholder="Ativo:" />
                    </div>
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-envelope"></i></span>
                        <input type="text" name="email" value="<?php echo $result->email; ?>" placeholder="E-mail:" />
                    </div>
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-envelope"></i></span>
                        <input type="text" name="perfil" value="<?php echo $result->id_perfil; ?>" placeholder="Perfil:" />
                    </div>
                    <input type="hidden" name="id_usuario" value="<?php echo $result->id_usuario; ?>"/>
                    <br />
                    <input type="submit" name="atualizar" class="btn btn-primary" value="Atualizar dados">
                </form>

            <?php }else{
                if(!isset($_POST['novo'])){
                    ?>

                <form method="post" action="">
                    <br />
                    <input type="submit" name="novo" class="btn btn-primary" value="Novo Usuário">
                </form>

            <?php } }?>

            <table class="table table-hover">

                <thead>
                <tr>
                    <th>Nome:</th>
                    <th>Login:</th>
                    <th>Ativo:</th>
                    <th>E-mail:</th>
                    <th>Perfil:</th>
                    <th>Ações:</th>
                </tr>
                </thead>

                <tbody>
                <?php
                #SELECT
                $sqlRead = 'SELECT id_usuario, `nome`, `login`, `senha`, `ativo`, `email`, `id_perfil` FROM `webpbxip_usuario';
                try {
                    $read = $db->prepare($sqlRead);
                    $read->execute();
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
                while( $rs = $read->fetch(PDO::FETCH_OBJ) ){
                    ?>
                    <tr>
                        <td><?php echo $rs->nome; ?></td>
                        <td><?php echo $rs->login; ?></td>
                        <td><?php echo $rs->ativo; ?></td>
                        <td><?php echo $rs->email; ?></td>
                        <td><?php echo $rs->id_perfil; ?></td>

                        <td>
                            <a href="usuarios.php?action=update&id_usuario=<?php echo $rs->id_usuario; ?>" class="btn"><i class="icon-pencil"></i></a>
                            <a href="usuarios.php?action=delete&id_usuario=<?php echo $rs->id_usuario; ?>" class="btn" onclick="return confirm('Deseja deletar?');"><i class="icon-remove"></i></a>
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