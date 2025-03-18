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
    $nomeimg = $_POST['nomeimg'];
    $url = $_POST['url'];
    $codpneu = $_POST['codpneu'];

    if (!empty($nomeimg) && !empty($url) && !empty($codpneu)) {
        try {
            // Preparar e executar o comando de inserção
            $stmt = $pdo->prepare("INSERT INTO tb_imagens (nomeimg, url, codpneu) VALUES (:nomeimg, :url, :codpneu)");
            $stmt->bindParam(':nomeimg', $nomeimg, PDO::PARAM_STR);
            $stmt->bindParam(':url', $url, PDO::PARAM_STR);
            $stmt->bindParam(':codpneu', $codpneu, PDO::PARAM_INT);
            $stmt->execute();

            $message = "Imagem adicionada com sucesso!";
            $messageType = "success";
            // Redireciona após 2 segundos
            header("refresh:2;url=consulta-img.php");
        } catch (PDOException $e) {
            $message = "Erro ao adicionar imagem: " . $e->getMessage();
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
    <title>Adicionar Imagem</title>
    <link rel="stylesheet" href="./assets/css/cadastrostyle.css">
</head>

<body>

    <!-- Formulário de Adição de Imagem -->
    <div class="login-card-pneu">
        <div class="card-header">
            <h1>ADICIONAR IMAGEM</h1>
        </div>
        <div class="card-body">
            <form method="post" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="text">Nome da Imagem:</label>
                    <input type="text" id="nomeimg" name="nomeimg" required>
                </div>

                <div class="form-group">
                    <label for="text">URL da Imagem:</label>
                    <input type="url" id="url" name="url" required>
                </div>

                <div class="form-group">
                    <label for="text">Pneu Relacionado:</label>
                    <input type="text" id="codpneu" name="codpneu" required>
                </div>

                <!-- Acaba aqui os input, para baixo botões -->
                <div class="form-group">
                    <button type="submit" class="login-button" name="btnAdd">Cadastrar Imagem</button>
                    <a href="../pages/inicio.php"></a>
                </div>

                <div class="cadastrolinkdiv">
                    <a href="consulta-img.php" class="linkcadastrolog">VOLTAR</a>
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
                    <a href="consulta-img.php" class="btn btn-secondary mt-2">Voltar</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

</body>

</html>
