<?php
session_start();
require '../vendor/autoload.php'; // Autoload para carregar a classe Connect
use app\functions\database\Connect;

$pdo = Connect::conect(); // Conexão via classe Connect
$message = '';
$messageType = '';

if (isset($_GET['codcidade'])) {
    $codcidade = $_GET['codcidade'];

    if (isset($_POST['confirm'])) {
        try {
            // Excluir compras_pneus associadas a compras dos clientes da cidade
            $sql = "DELETE FROM tb_compras_pneus WHERE codcompra IN (
                        SELECT codcompra FROM tb_compras WHERE codcliente IN (
                            SELECT codcliente FROM tb_clientes WHERE codcidade = :codcidade
                        )
                    )";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':codcidade', $codcidade, PDO::PARAM_INT);
            $stmt->execute();

            // Excluir compras associadas aos clientes da cidade
            $sql = "DELETE FROM tb_compras WHERE codcliente IN (
                        SELECT codcliente FROM tb_clientes WHERE codcidade = :codcidade
                    )";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':codcidade', $codcidade, PDO::PARAM_INT);
            $stmt->execute();

            // Excluir os clientes da cidade
            $sql = "DELETE FROM tb_clientes WHERE codcidade = :codcidade";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':codcidade', $codcidade, PDO::PARAM_INT);
            $stmt->execute();

            // Agora, excluir a cidade
            $sql = "DELETE FROM tb_cidades WHERE codcidade = :codcidade";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':codcidade', $codcidade, PDO::PARAM_INT);
            $stmt->execute();

            $message = "Registro excluído com sucesso!";
            $messageType = "success";
            header("refresh:2;url=consulta-city.php");
            exit;
        } catch (PDOException $e) {
            $message = "Erro ao excluir o registro: " . $e->getMessage();
            $messageType = "danger";
        }
    } else {
        try {
            // Buscar detalhes da cidade para confirmar exclusão
            $sql = "SELECT * FROM tb_cidades WHERE codcidade = :codcidade";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':codcidade', $codcidade, PDO::PARAM_INT);
            $stmt->execute();
            $tb_cidades = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$tb_cidades) {
                $message = "Registro não encontrado.";
                $messageType = "danger";
            }
        } catch (PDOException $e) {
            $message = "Erro ao buscar registro: " . $e->getMessage();
            $messageType = "danger";
        }
    }
} else {
    header('Location: consulta-city.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Excluir Cidade</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/crudstyle.css" >
    <link rel="shortcut icon" href="./assets/icon/logoamazonia.ico" type="image/x-icon">
</head>
<body>

<header>
    <div class="menubar"></div>
    <img src="./assets/image/bandaglogo.png" alt="" class="circleyellow">
</header>

<div class="card-exc">
    <div class="header">
        <div class="image">
            <svg aria-hidden="true" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" fill="none">
                <path d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" stroke-linejoin="round" stroke-linecap="round"></path>
            </svg>
        </div>
        <div class="content">
            <?php if ($message): ?>
                <span class="title"><?php echo ($messageType == 'success') ? 'Cidade Excluída' : 'Erro na Exclusão'; ?></span>
                <p class="message"><?php echo $message; ?></p>
                <?php if ($messageType == 'success'): ?>
                    <p class="message">Você será redirecionado em 2 segundos...</p>
                <?php else: ?>
                    <a href="consulta-city.php" class="cancel">Voltar</a>
                <?php endif; ?>
            <?php elseif (isset($tb_cidades)): ?>
                <span class="title">Excluir Cidade</span>
                <p class="message">Tem certeza que deseja excluir a cidade <strong><?php echo htmlspecialchars($tb_cidades['codcidade']); ?></strong>? Esta ação não poderá ser desfeita.</p>
            </div>
            <div class="actions">
                <form method="post" action="">
                    <button type="submit" name="confirm" class="desactivate">Confirmar Exclusão</button>
                    <a href="consulta-city.php" class="cancel">Cancelar</a>
                </form>
            <?php else: ?>
                <span class="title">Erro</span>
                <p class="message">Registro não encontrado.</p>
                <a href="consulta-city.php" class="cancel">Voltar</a>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>
