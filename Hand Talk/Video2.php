<?php
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'handtalk';

// Conectar ao banco de dados MySQL
$conectar = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Se a conexão não funcionar, exibir uma mensagem de erro
if (!$conectar) 
{
    echo 'Código de Erro: ' . mysqli_connect_errno() . '<br>';
    echo 'Mensagem de Erro: ' . mysqli_connect_error() . '<br>';
    exit;
}

?>
<!doctype html>
<html>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jogo de Perguntas e Respostas com Imagens</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <style>
        /* Estilos CSS para o corpo */
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            text-align: center;
        }

        /* Estilos CSS para o contêiner do jogo */
        .game-container{
            background-color: rgba(0, 0, 0, 0.9);
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            padding: 80px;
            border-radius: 15px;
            color: #fff;
        }
        .esco-but{
            background-color: dodgerblue;
            border: none;
            padding: 15px;
            width: 100%;
            border-radius: 10px;
            color: white;
            font-size: 15px;
            
        }
        .constquestions{
            background-color: deepskyblue;
            cursor: pointer;
        }

        /* Estilos CSS para a pergunta (imagem) */
        .question {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
        }

        /* Estilos CSS para as opções de resposta */
        .options {
            display: flex;
            flex-direction: column;
        }

        .option {
            font-size: 18px;
            padding: 10px;
            margin: 5px;
            border: 1px solid #ccc;
            cursor: pointer;
        }

        /* Estilos CSS para o botão "Próxima Pergunta" */
        #next-button {
            display: none;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 18px;
            background-color: #333;
            color: #fff;
            border: none;
            cursor: pointer;
        }
                /* Estilos CSS para a barra de navegação */
                body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #81d3ba;
            overflow: hidden;
        }
        .navbar a {
            float: left;
            font-size: 16px;
            color: #085a42;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        .navbar a:hover {
            background-color: #81d3ba;
            color: #085a42;
        }

        /* Estilos CSS para o formulário de contato */
        .container {
            padding: 20px;
        }
        form {
            max-width: 400px;
            margin: 0 auto;
        }
        label, input, textarea {
            display: block;
            margin-bottom: 10px;
        }

                /* Estilos para a janela flutuante */
        .div-php {
            background-color: #10392d;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            padding: 80px;
            border-radius: 15px;
            color: #fff;
        }
                
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg ">
  
        <div class="container-fluid">
          <a class="navbar-brand" href="#">Hand Talk</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0" class="nav nav-tabs">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="Inicio.html">Início</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="Historia.html">História</a>
              </li>
              </li>

            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="Login.php">Login</a>
              </li>
              </ul>
            
            
          </div>
        </div>
      </nav>

        <div class="div-php">
        <?php

        // Criar uma consulta
        $consulta = 'SELECT id, nome, youtubeid
            FROM videos
            ORDER BY nome';

        // Executar a consulta
        $resultado = mysqli_query($conectar, $consulta);

        // Se não houver resultado, exibir uma mensagem de erro
        if (!$resultado)
        {
            echo 'Mensagem de Erro: ' . mysqli_error($conectar) . '<br>';
            exit;
        }

        // Percorrer os registros encontrados
        while ($registro = mysqli_fetch_assoc($resultado))
        {

            // Exibir o registro usando instruções if e echo
            echo '<hr>';

            echo '<h2>'.$registro['nome'].'</h2>';

            echo '<br><br>';

            echo '<iframe width="560" height="315" src="https://www.youtube.com/embed/'.$registro['youtubeid'].'?modestbranding=1" 
                frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                allowfullscreen></iframe>';

        }

        ?>   
        </div>
    </div>



<footer style="background-color: #81d3ba; color: #085a42; text-align: center; padding: 10px; position: fixed; bottom: 0; width: 100%;">
    © 2023 Hand Talk
</footer>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">    
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous">   
</script>

    </body>
</html>
