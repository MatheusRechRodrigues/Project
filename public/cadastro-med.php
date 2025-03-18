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
    $largura = $_POST['largura'];
    $aro = $_POST['aro'];
    $medida = $_POST['medida'];
    $altura = $_POST['altura'];
    $indicecarga = $_POST['indicecarga'];
    $velocidade = $_POST['velocidade'];
    $construcao = $_POST['construcao'];
    $raio = $_POST['raio'];

    // Verificar se todos os campos estão preenchidos
    if (!empty($largura) && !empty($aro) && !empty($medida) && !empty($altura) && !empty($indicecarga) && !empty($velocidade) && !empty($construcao) && !empty($raio)) {
        try {
            // Preparar e executar o comando de inserção
            $stmt = $pdo->prepare("INSERT INTO tb_medidas (largura, aro, medida, altura, indicecarga, velocidade, construcao, raio) VALUES (:largura, :aro, :medida, :altura, :indicecarga, :velocidade, :construcao, :raio)");
            $stmt->bindParam(':largura', $largura, PDO::PARAM_STR);
            $stmt->bindParam(':aro', $aro, PDO::PARAM_INT);
            $stmt->bindParam(':medida', $medida, PDO::PARAM_INT);
            $stmt->bindParam(':altura', $altura, PDO::PARAM_STR);
            $stmt->bindParam(':indicecarga', $indicecarga, PDO::PARAM_STR);
            $stmt->bindParam(':velocidade', $velocidade, PDO::PARAM_STR);
            $stmt->bindParam(':construcao', $construcao, PDO::PARAM_STR);
            $stmt->bindParam(':raio', $raio, PDO::PARAM_STR);
            $stmt->execute();

            $message = "Medida adicionada com sucesso!";
            $messageType = "success";
            // Redireciona após 2 segundos
            header("refresh:2;url=consulta-med.php");
        } catch (PDOException $e) {
            $message = "Erro ao adicionar medida: " . $e->getMessage();
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
    <title>Cadastro de Medidas</title>
    <link rel="stylesheet" href="./assets/css/cadastrostyle.css">
</head>

<body>

    <!-- Formulário de Adição de Medidas -->
    <div class="login-card-med">
        <div class="card-header">
            <h1>MEDIDAS DO PNEU</h1>
        </div>
        <div class="card-body">
            <form method="post">

                <div class="form-group">
                    <label for="text">Largura</label>
                    <input type="text" id="largura" name="largura" required>
                </div>

                <div class="form-group">
                    <label for="text">Aro</label>
                    <input type="number" id="aro" name="aro" required>
                </div>

                <div class="form-group">
                    <label for="text">Medida</label>
                    <input type="number" id="medida" name="medida" required>
                </div>

                <div class="form-group">
                    <label for="text">Altura</label>
                    <input type="text" id="altura" name="altura" required>
                </div>

                <div class="form-group">
                    <label for="text">Índice de Carga</label>
                    <input type="text" id="indicecarga" name="indicecarga" required>
                </div>

                <div class="form-group">
                    <label for="text">Velocidade</label>
                    <input type="text" id="velocidade" name="velocidade" required>
                </div>

                <div class="form-group">
                    <label for="text">Construção (R - C)</label>
                    <input type="text" id="construcao" name="construcao" required>
                </div>

                <div class="form-group">
                    <label for="text">Raio</label>
                    <input type="text" id="raio" name="raio" required>
                </div>

                <!-- Botões -->
                <div class="form-group">
                    <button type="submit" class="login-button" name="btnAdd">Cadastrar</button>
                    <a href="consulta-user.php"></a>
                </div>

                <div class="cadastrolinkdiv">
                    <a href="consulta-med.php" class="linkcadastrolog">VOLTAR</a>
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
                    <a href="consulta-med.php" class="btn btn-secondary mt-2">Voltar</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

</body>

</html>
