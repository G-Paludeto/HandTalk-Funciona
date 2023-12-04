<?php
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'handtalk';

// Conectar ao banco de dados MySQL
$conectar = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

$mensagem = ""; // Inicializa a mensagem vazia

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se a chave 'operacao' está definida no array $_POST
    if (isset($_POST['operacao']) && $_POST['operacao'] === 'cadastrar') {
        // Verifica se as chaves 'nome', 'email', 'senha', 'confirmar_senha' estão definidas no array $_POST
        $campos_obrigatorios = ['nome', 'email', 'senha', 'confirmar_senha'];
        $campos_preenchidos = array_intersect($campos_obrigatorios, array_keys($_POST));

        if (count($campos_preenchidos) === count($campos_obrigatorios)) {
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $senha = $_POST['senha'];
            $confirmar_senha = $_POST['confirmar_senha'];

            // Verifica se as senhas coincidem
            if ($senha !== $confirmar_senha) {
                $mensagem = "Erro: As senhas não coincidem.";
            } else {
                // Verifica se o e-mail já está cadastrado
                $verifica_email = "SELECT id FROM usuarios WHERE email = ?";
                $stmt_verifica = $conectar->prepare($verifica_email);

                if ($stmt_verifica) {
                    $stmt_verifica->bind_param("s", $email);
                    $stmt_verifica->execute();
                    $stmt_verifica->store_result();

                    if ($stmt_verifica->num_rows > 0) {
                        $mensagem = "Erro: Este e-mail já está cadastrado.";
                    } else {
                        // Usando instrução preparada para evitar injeção de SQL
                        $sql = "INSERT INTO usuarios (nome, email, senha_hash) VALUES (?, ?, ?)";
                        $stmt = $conectar->prepare($sql);

                        if ($stmt) {
                            // Hash da senha
                            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

                            // Vincula parâmetros da instrução preparada
                            $stmt->bind_param("sss", $nome, $email, $senha_hash);

                            // Executa a instrução preparada
                            if ($stmt->execute()) {
                                $mensagem = "Cadastro realizado com sucesso.";
                            } else {
                                $mensagem = "Erro: " . $stmt->error;
                            }

                            // Fecha a instrução preparada
                            $stmt->close();
                        } else {
                            $mensagem = "Erro na preparação da declaração: " . $conectar->error;
                        }
                    }

                    $stmt_verifica->close();
                }
            }
        } else {
            $mensagem = "Erro: Campos obrigatórios não foram preenchidos.";
        }
    } else {
        $mensagem = "Erro: Operação inválida.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Cadastro</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-image: linear-gradient(45deg, #81d3ba, #085a42);
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        form {
            background-color: #10392d;
            border-radius: 15px;
            padding: 40px;
            color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
        input {
            padding: 10px;
            margin: 10px 0;
            border: none;
            outline: none;
            font-size: 15px;
            width: 100%;
            box-sizing: border-box;
        }
        button {
            background-color: #085a42;
            border: none;
            padding: 15px;
            width: 100%;
            border-radius: 10px;
            color: white;
            font-size: 15px;
        }
        button:hover {
            background-color: #117d5d;
            cursor: pointer;
        }
        p {
            margin-top: 20px;
            text-align: center;
        }
        .mensagem {
            margin-top: 20px;
            text-align: center;
            color: #ff0000;
        }
    </style>
</head>
<body>
<form action="Cadastro.php" method="POST">
    <div>
        <h1>Cadastro</h1>
        <input type="hidden" name="operacao" value="cadastrar">
        <input type="text" name="nome" placeholder="Nome" required>
        <input type="email" name="email" placeholder="E-mail" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <input type="password" name="confirmar_senha" placeholder="Confirmar Senha" required>
        <button type="submit">Cadastrar</button>
        <p>Já tem uma conta? <a href="Login.php">Fazer Login</a></p>
    </div>
</form>
</body>
</html>

