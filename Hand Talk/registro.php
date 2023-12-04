<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexão com o Banco de Dados
    
    $dbHost = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'handtalk';

    $conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

    // Verifica a Conexão
    if ($conexao->connect_error) {
        die("Erro de Conexão: " . $conexao->connect_error);
    }

    if (isset($_POST['login'])) {
        // Restante do código permanece inalterado
        // ...
    } elseif (isset($_POST['registro'])) {
        // Processar formulário de registro (registro.php)
        $nome = $conexao->real_escape_string($_POST['nome']);
        $username = $conexao->real_escape_string($_POST['username']);
        $email = $conexao->real_escape_string($_POST['email']);
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

        // Verifica se o usuário já existe
        $verificar_usuario = $conexao->query("SELECT * FROM `usuarios` WHERE `username`='$username'");
        if ($verificar_usuario->num_rows > 0) {
            echo "Usuário já existe. Escolha outro nome de usuário.";
        } else {
            // Insere o novo usuário
            $inserir_usuario = "INSERT INTO `usuarios` (`nome`, `username`, `email`, `senha_hash`) VALUES ('$nome', '$username', '$email', '$senha')";
            if ($conexao->query($inserir_usuario) === TRUE) {
                echo "Cadastro realizado com sucesso!";
                header("Location: Inicio.html"); // Redireciona para o Login2.html após o cadastro
                exit();
            } else {
                echo "Erro ao cadastrar: " . $conexao->error;
            }
        }
    }

    // Fecha a Conexão
    $conexao->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Login e Registro</title>
</head>
<body>
    <!-- ... (códigos de formulários permanecem inalterados) ... -->
</body>
</html>
