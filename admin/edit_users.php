<?php session_start();
$seguranca = isset($_SESSION['ativa']) ? TRUE : header("location: login.php");
require_once "functions.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel admin - usuarios</title>
</head>

<body>

    <?php if ($seguranca) { ?>
        <h1>Painel do administrador</h1>
        <h3>Bem vindo: <?php echo $_SESSION['nome']; ?></h3>
        <h2>Gerenciador de usuarios</h2>

        <nav>
            <div>
                <a href="index.php">Painel</a>
                <a href="users.php">Gerenciar Usuarios</a>
                <a href="logout.php">Sair</a>
            </div>
        </nav>

        <?php
        $tabela = "usuarios";
        $order = "id";
        $usuarios = buscar($connect, $tabela, 1, $order);
        ?>

        <?php if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $usuario = buscaUnica($connect, "usuarios", $id);
            updateUser($connect);

        ?>
            <h2>Editando usuario <?php echo $_GET['nome']; ?></h2>
        <?php } ?>

        <form action="" method="post">
            <fieldset>
                <legend>Editar usuario</legend>
                <input value="<?php echo $usuario['id']; ?>" type="hidden" name="id" required>
                <input value="<?php echo $usuario['nome']; ?>" type="text" name="nome" placeholder="Nome" required>
                <input value="<?php echo $usuario['email']; ?>" type="email" name="email" placeholder="Email" required>
                <input type="password" name="senha" placeholder="Senha">
                <input type="password" name="repeteSenha" placeholder="Confirme a senha">
                <input value="<?php echo $usuario['data_cadastro']; ?>" type="date" name="data_cadastro">

                <input type="submit" name="atualizar" value="Editar">
            </fieldset>
        </form>

    <?php } ?>

</body>

</html>