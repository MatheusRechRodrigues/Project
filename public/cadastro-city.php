<?php
session_start();
require '../vendor/autoload.php';  // Assumindo que você está usando o autoload do Composer
use app\functions\database\Connect; // Usando a classe de conexão com o banco de dados

// Definindo a variável de mensagem
$message = '';
$messageType = '';

// Obter a conexão PDO usando a classe Connect
$pdo = Connect::conect();

// Verificar se o formulário de cadastro foi submetido
if (isset($_POST['btnAdd'])) {
    $estado = $_POST['estado'];
    $nome = $_POST['nome'];

    if (!empty($estado) && !empty($nome)) {
        try {
            // Preparar e executar o comando de inserção
            $stmt = $pdo->prepare("INSERT INTO tb_cidades (estado, nome) VALUES (:estado, :nome)");
            $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
            $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);

            $stmt->execute();
            $message = "Cidade adicionada com sucesso!";
            $messageType = "success";
            // Redireciona após 2 segundos
            header("refresh:2;url=consulta-city.php");
        } catch (PDOException $e) {
            $message = "Erro ao adicionar cidade: " . $e->getMessage();
            $messageType = "danger";
        }
    } else {
        $message = "Todos os campos devem ser preenchidos!";
        $messageType = "danger";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./assets/icon/logoamazonia.ico" type="image/x-icon">
    <title>Cadastrar Cidades</title>
    <link rel="stylesheet" href="./assets/css/cadastrostyle.css">
</head>

<body>

    <!-- Formulário de cadastro de cidade -->
    <div class="login-card-city">
        <div class="card-header">
            <h1>Cadastrar Cidades</h1>
        </div>
        <div class="card-body">
            <form method="post">
                <div class="form-group">
                    <label for="estado">Estado:</label>
                    <select id="estado" name="estado" required>
                        <option value="">Selecione</option>
                        <option value="PR">PR</option>
                        <option value="SC">SC</option>
                        <option value="RS">RS</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="nome">Nome da Cidade:</label>
                    <input type="text" id="nome" name="nome" required>
                </div>

                <div class="form-group">
                    <button type="submit" class="login-button" name="btnAdd">Cadastrar</button>
                </div>

                <div class="cadastrolinkdiv">
                    <a href="consulta-city.php" class="linkcadastrolog">VOLTAR</a>
                </div>

            </form>
        </div>
    </div>

    <img src="../public/assets/image/logoamazonia.png" class="logoamazonia">

    <div class="mensagem-banco">
        <?php if ($message) : ?>
            <div class="alert alert-<?php echo $messageType; ?>" role="alert">
                <?php echo $message; ?>
                <?php if ($messageType == 'success') : ?>
                    <p>Você será redirecionado em 2 segundos...</p>
                <?php else : ?>
                    <a href="consulta-city.php" class="btn btn-secondary mt-2">Voltar</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

</body>

</html>
