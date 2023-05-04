<?php require_once "functions.php";

if (isset($_POST['acessar'])) {
    login($connect);
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de acesso</title>
</head>

<body>
    <form action="" method="post">
        <fieldset>
            <legend>Painel de login</legend>
            <input type="email" name="email" placeholder="Informe o seu email" required>

            <input type="password" name="senha" placeholder="Insira a sua senha" required>

            <input type="submit" name="acessar" value="Acessar">
        </fieldset>
    </form>
</body>

</html>