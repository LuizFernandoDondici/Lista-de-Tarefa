<?php

// Cria conexção com Banco de Dados.
$database = new PDO('sqlite:'. __DIR__ .'./database/lista-tarefas.sqlite');

// Cria tabela.
$database->exec(
    'CREATE TABLE IF NOT EXISTS lista(
        id INTEGER PRIMARY KEY,
        tarefa TEXT
    );'
);


// Cria tarefa.
if ($_SERVER['PATH_INFO'] == '/criar-tarefa'){

    if (empty($_POST['tarefa'])) {
        header('location: index.php');
        exit;
    }

    $stmt = $database->prepare('INSERT INTO lista (tarefa) VALUES (?);');
    $stmt->bindParam(1, $_POST['tarefa']);
    $stmt->execute();

    header('location: index.php'); 
}


// Deleta tarefa.
if ($_SERVER['PATH_INFO'] == '/deletar-tarefa') {

    if (empty($_GET['id'])) {
        header('location: index.php');
        exit;
    }

    $stmt = $database->prepare('DELETE FROM lista WHERE id = (?)');
    $stmt->bindParam(1, $_GET['id']);
    $stmt->execute();

    header('location: index.php');
}


// Busca todas as tarefas.
$stmt = $database->prepare('SELECT id, tarefa FROM lista');
$stmt->execute();
$tarefas = $stmt->fetchAll();


ob_clean();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./style/style.css">
    
    <title> Lista de Tarefas </title>

</head>
<body>  
    <main>
        <section>

            <h1 class="title"> Lista de Tarefas </h1>
            <form action="/criar-tarefa" method="POST" class="form">
                <input type="text" name="tarefa" placeholder="Digite sua tarefa aqui">
                <button type="submit"> Salvar </button>
            </form>

        </section>
        <section>

            <table class="table">
                <thead>
                    <tr>
                        <th id="th-id"> Id </th>
                        <th id="th-tarefas"> Tarefas </th>
                        <th id="th-deletar"> Deletar </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // Mostra todas as tarefas.
                        for ($i = 0; $i < count($tarefas); $i++):
                            $tarefa = $tarefas[$i];
                    ?> 
                    <tr>
                        <td id="td-id"> <?= $i+1 ?> </td>
                        <td id="td-tarefas"> <?= $tarefa['tarefa'] ?> </td>
                        <td id="td-deletar"><a href="deletar-tarefa?id=<?php echo $tarefa['id']?>"> X </a></td>
                    </tr>
                    <?php 
                        endfor; 
                    ?>
                </tbody>
            </table>

        </section>
    </main>
</body>
</html>
