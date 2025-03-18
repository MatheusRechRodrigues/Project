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
    $entregue = $_POST['entregue'];
    $entrega = $_POST['entrega'];
    $codentrega = $_POST['codentrega'];
    $valorentrega = $_POST['valorentrega'];
    $formapagamento = $_POST['formapagamento'];
    $dtcompra = $_POST['dtcompra'];
    $codcliente = $_POST['codcliente'];
    $token = $_POST['token'];

    if (!empty($entregue) && !empty($entrega) && !empty($codentrega) && !empty($valorentrega) && !empty($formapagamento) && !empty($dtcompra) && !empty($codcliente) && !empty($token)) {
        try {
            // Preparar e executar o comando de inserção
            $stmt = $pdo->prepare("INSERT INTO tb_compras (entregue, entrega, codentrega, valorentrega, formapagamento, dtcompra, codcliente, token) VALUES (:entregue, :entrega, :codentrega, :valorentrega, :formapagamento, :dtcompra, :codcliente, :token)");
            $stmt->bindParam(':entregue', $entregue, PDO::PARAM_INT);
            $stmt->bindParam(':entrega', $entrega, PDO::PARAM_STR);
            $stmt->bindParam(':codentrega', $codentrega, PDO::PARAM_INT);
            $stmt->bindParam(':valorentrega', $valorentrega, PDO::PARAM_STR);
            $stmt->bindParam(':formapagamento', $formapagamento, PDO::PARAM_INT);
            $stmt->bindParam(':dtcompra', $dtcompra, PDO::PARAM_STR);
            $stmt->bindParam(':codcliente', $codcliente, PDO::PARAM_INT);
            $stmt->bindParam(':token', $token, PDO::PARAM_STR);

            $stmt->execute();
            $message = "Compra adicionada com sucesso!";
            $messageType = "success";
            // Redireciona após 2 segundos
            header("refresh:2;url=consulta-compra.php");
        } catch (PDOException $e) {
            $message = "Erro ao adicionar compra: " . $e->getMessage();
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
    <title>Cadastrar Compra</title>
    <link rel="stylesheet" href="./assets/css/cadastrostyle.css">
</head>

<body>

    <!-- Formulário de cadastro de compra -->
    <div class="login-card-med">
        <div class="card-header">
            <h1>Cadastro de Compra</h1>
        </div>
        <div class="card-body">
            <form method="post">
                <div class="form-group">
                    <label for="entregue">Entregue (0 para Não, 1 para Sim)</label>
                    <input type="number" id="entregue" name="entregue" required>
                </div>

                <div class="form-group">
                    <label for="entrega">Endereço de Entrega</label>
                    <input type="text" id="entrega" name="entrega" required>
                </div>

                <div class="form-group">
                    <label for="codentrega">Código de Entrega</label>
                    <input type="number" id="codentrega" name="codentrega" required>
                </div>

                <div class="form-group">
                    <label for="valorentrega">Valor da Entrega (R$)</label>
                    <input type="text" id="valorentrega" name="valorentrega" required>
                </div>

                <div class="form-group">
                    <label for="formapagamento">Forma de Pagamento (ID)</label>
                    <input type="number" id="formapagamento" name="formapagamento" required>
                </div>

                <div class="form-group">
                    <label for="dtcompra">Data da Compra</label>
                    <input type="date" id="dtcompra" name="dtcompra" required>
                </div>

                <div class="form-group">
                    <label for="codcliente">Código do Cliente</label>
                    <input type="number" id="codcliente" name="codcliente" required>
                </div>

                <div class="form-group">
                    <label for="token">Token</label>
                    <input type="text" id="token" name="token" required>
                </div>

                <div class="form-group">
                    <button type="submit" class="login-button" name="btnAdd">Cadastrar Compra</button>
                </div>

                <div class="cadastrolinkdiv">
                    <a href="consulta-compra.php" class="linkcadastrolog">VOLTAR</a>
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
                    <a href="consulta-compra.php" class="btn btn-secondary mt-2">Voltar</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

</body>

</html>
