<?php session_start();
$seguranca = isset($_SESSION['ativa']) ? TRUE : header("location: login.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel admin</title>
</head>

<body>

    <?php if ($seguranca) { ?>

        <h1>Painel do administrador</h1>
        <h3>Bem vindo: <?php echo $_SESSION['nome']; ?></h3>

        <nav>
            <div>
                <a href="index.php">Painel</a>
                <a href="users.php"> Gerenciar Usuarios</a>
                <a href="logout.php">Sair</a>
            </div>
        </nav>

    <?php } ?>

</body>

</html>