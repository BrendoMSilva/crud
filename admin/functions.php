<?php

$host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "teste_main_php";

//conexão do banco de dados
$connect = mysqli_connect($host, $db_user, $db_pass, $db_name);

function login($connect)
{
    if (isset($_POST['acessar']) and !empty($_POST['email']) and !empty($_POST['senha'])) {

        $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);

        $senha = sha1($_POST['senha']);

        $query = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha' ";
        $executar = mysqli_query($connect, $query);
        $return = mysqli_fetch_assoc($executar);

        if (!empty($return['email'])) {
            session_start();
            $_SESSION['nome'] = $return['nome'];
            $_SESSION['id'] = $return['id'];
            $_SESSION['ativa'] = TRUE;
            header("location: index.php");
        } else {
            echo "Usuário ou senha não encontrado";
        }
    }
}
function logout()
{
    session_start();
    session_unset();
    session_destroy();
    header("location: login.php");
}

//Seleciona no banco de dados apenas 1 resultado com base no ID
function buscaUnica($connect, $tabela, $id)
{
    $query = "SELECT * FROM $tabela WHERE id =" . (int) $id;
    $execute = mysqli_query($connect, $query);
    $result = mysqli_fetch_assoc($execute);
    return $result;
}

//Seleciona no banco de dadostodos os resultado com base no WHERE
function buscar($connect, $tabela, $where = 1, $order = "")
{
    if (!empty($order)) {
        $order = "ORDER BY $order";
    }
    $query = "SELECT * FROM $tabela WHERE $where $order";
    $execute = mysqli_query($connect, $query);
    $results = mysqli_fetch_all($execute, MYSQLI_ASSOC);
    return $results;
}

//Inserir novos usuarios
function inserirUsuarios($connect)
{
    if (isset($_POST['cadastrar']) and !empty($_POST['email']) and !empty($_POST['senha'])) {
        $erros = array();
        $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
        $nome = mysqli_real_escape_string($connect, $_POST['nome']);
        $senha = sha1($_POST['senha']);

        if ($_POST['senha'] != $_POST['repeteSenha']) {
            $erros[] = "Senha não são iguais";
        }

        $queryEmail = "SELECT email FROM usuarios WHERE email = '$email' ";
        $buscaEmail = mysqli_query($connect, $queryEmail);
        $verifica = mysqli_num_rows($buscaEmail);

        if (!empty($verifica)) {
            $erros[] = "Email já cadastrado";
        }
        if (empty($erros)) {

            //Inserir o usuario no banco de dados
            $query = "INSERT INTO usuarios (nome, email, senha, data_cadastro) VALUES ('$nome', '$email', '$senha', NOW()) ";
            $executar = mysqli_query($connect, $query);

            if ($executar) {
                echo "Usuario cadastrado com sucesso";
            } else {
                echo "Erro ao cadastrar usuario";
            }
        } else {
            foreach ($erros as $erro) {
                echo "<p>$erro</p>";
            }
        }
    }
}

//Deletar dados
function deletar($connect, $tabela, $id)
{
    if (!empty($id)) {
        $query = "DELETE FROM $tabela WHERE id = " . (int) $id;
        $execute = mysqli_query($connect, $query);

        if ($execute) {
            echo "Dado excluido com sucesso";
        } else {
            echo "Erro ao excluir dado";
        }
    }
}

function updateUser($connect)
{
    if (isset($_POST['atualizar']) and !empty($_POST['email'])) {
        $erros = array();
        $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
        $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
        $nome = mysqli_real_escape_string($connect, $_POST['nome']);
        $senha = "";
        $data = mysqli_real_escape_string($connect, $_POST['data_cadastro']);

        if (empty($data)) {
            $erros[] = "Preencha a data de cadastro";
        }

        if (empty($email)) {
            $erros[] = "Preencha o seu email corretamente ";
        }

        if (strLen($nome) < 3) {
            $erros[] = "Preencha o seu nome ";
        }

        if (empty($_POST['senha'])) {
            if ($_POST['senha'] == $_POST['repeteSenha']) {
                $senha = sha1($_POST['senha']);
            } else {
                $erros[] = "Senha não são iguais";
            }
        }

        $queryEmailAtual = "SELECT email FROM usuarios WHERE id = '$id' ";
        $buscaEmailAtual = mysqli_query($connect, $queryEmailAtual);
        $retornoEmail = mysqli_fetch_assoc($buscaEmailAtual);
        $retornoEmail['email'];

        $queryEmail = "SELECT email FROM usuarios WHERE email = '$email' AND email <> '" . $retornoEmail['email'] . "'";
        $buscaEmail = mysqli_query($connect, $queryEmail);
        $verifica = mysqli_num_rows($buscaEmail);

        if (!empty($verifica)) {
            $erros[] = "Email já cadastrado";
        }

        if (empty($erros)) {
            // UPDATE usuario
            if (!empty($senha)) {
                $query = "UPDATE usuarios SET nome = '$nome', email = '$email', senha = '$senha', data_cadastro = '$data' WHERE id = " . $id;
            }
            $query = "UPDATE usuarios SET nome = '$nome', email = '$email', data_cadastro = '$data' WHERE id = " . $id;

            $executar = mysqli_query($connect, $query);
            if ($executar) {
                echo "Usuario atualizado com sucesso";
            } else {
                echo "Erro ao atualizar usuario";
            }
        } else {
            foreach ($erros as $erro) {
                echo "<p>$erro</p>";
            }
        }
    }
}
