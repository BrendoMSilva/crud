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
        inserirUsuarios($connect);

        if (isset($_GET['id'])) { ?>
            <h2>Tem certeza que deseja deletar o dado selecionado: <?php echo $_GET['nome']; ?></h2>
            <form action="" method="post">
                <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                <input type="submit" name="deletar" value="Deletar">
            </form>
        <?php } ?>

        <?php

        if (isset($_POST['deletar'])) {
            if ($_SESSION['id'] != $_POST['id']) {
                deletar($connect, "usuarios", $_POST['id']);
            } else {
                echo "Você não pode excluir o seu acesso de ADMINISTRADOR";
            }
        }
        ?>

        <form action="" method="post">
            <fieldset>
                <legend>Cadastrar novo usuario</legend>
                <input type="text" name="nome" placeholder="Nome">
                <input type="email" name="email" placeholder="Email">
                <input type="password" name="senha" placeholder="Senha">
                <input type="password" name="repeteSenha" placeholder="Confirme a senha">
                <input type="submit" name="cadastrar" value="Cadastrar">
            </fieldset>
        </form>

        <div class="container">
            <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Data de cadastro</th>
                        <th>Opções</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    foreach ($usuarios as $usuario) : ?>
                        <tr>
                            <td><?php echo $usuario['id']; ?></td>
                            <td><?php echo $usuario['nome']; ?></td>
                            <td><?php echo $usuario['email']; ?></td>
                            <td><?php echo $usuario['data_cadastro']; ?></td>

                            <td>
                                <a href="users.php?id=<?php echo $usuario['id']; ?>&nome=<?php echo $usuario['nome']; ?>">Excluir</a>
                                <a href="edit_users.php?id=<?php echo $usuario['id']; ?>&nome=<?php echo $usuario['nome']; ?>">Editar</a>
                            </td>
                        </tr>

                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>

    <?php } ?>

</body>

</html>