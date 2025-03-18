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
    $nomepneu = $_POST['nomepneu'];
    $descricao = $_POST['descricao'];
    $tipo = $_POST['tipo'];
    $preco = $_POST['preco'];

    // Verificar se todos os campos estão preenchidos
    if (!empty($nomepneu) && !empty($descricao) && !empty($tipo) && !empty($preco)) {
        try {
            // Preparar e executar o comando de inserção
            $stmt = $pdo->prepare("INSERT INTO tb_pneus (nomepneu, descricao, tipo, preco) VALUES (:nomepneu, :descricao, :tipo, :preco)");
            $stmt->bindParam(':nomepneu', $nomepneu, PDO::PARAM_STR);
            $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
            $stmt->bindParam(':tipo', $tipo, PDO::PARAM_STR);
            $stmt->bindParam(':preco', $preco, PDO::PARAM_INT);
            $stmt->execute();

            $message = "Pneu adicionado com sucesso!";
            $messageType = "success";
            // Redireciona após 2 segundos
            header("refresh:2;url=consulta-pneu.php");
        } catch (PDOException $e) {
            $message = "Erro ao adicionar pneu: " . $e->getMessage();
            $messageType = "danger";
        }
    } else {
        $message = "Todos os campos são obrigatórios!";
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
    <title>Cadastro de Pneus</title>
    <link rel="stylesheet" href="./assets/css/cadastrostyle.css">
</head>

<body>

    <!-- Formulário de Adição de Pneus -->
    <div class="login-card-pneu">
        <div class="card-header">
            <h1>ADICIONAR PNEUS</h1>
        </div>
        <div class="card-body">
            <form method="post">

                <div class="form-group">
                    <label for="text">Nome Pneu:</label>
                    <input type="text" id="nomepneu" name="nomepneu" required>
                </div>

                <div class="form-group">
                    <label for="text">Descrição:</label>
                    <input type="text" id="descricao" name="descricao" required>
                </div>

                <div class="form-group">
                    <label for="text">Tipo:</label>
                    <input type="text" id="tipo" name="tipo" required>
                </div>

                <div class="form-group">
                    <label for="text">Preço:</label>
                    <input type="number" id="preco" name="preco" required>
                </div>

                <!-- Botões -->
                <div class="form-group">
                    <button type="submit" class="login-button" name="btnAdd">Cadastrar Pneu</button>
                    <a href="../pages/inicio.php"></a>
                </div>

                <div class="cadastrolinkdiv">
                    <a href="consulta-pneu.php" class="linkcadastrolog">VOLTAR</a>
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
                    <a href="consulta-pneu.php" class="btn btn-secondary mt-2">Voltar</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

</body>

</html>
