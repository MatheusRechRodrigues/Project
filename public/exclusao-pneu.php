<?php
session_start();
require '../vendor/autoload.php'; // Carregar o autoload para incluir a classe Connect
use app\functions\database\Connect;

$pdo = Connect::conect(); // Conexão via classe Connect
$message = '';
$messageType = '';

if (isset($_GET['codpneu'])) {
    $codpneu = $_GET['codpneu'];

    if (isset($_POST['confirm'])) {
        try {
            // Alteração do campo 'ativo' para 'N' (inativo) ao invés de excluir o pneu
            $sql = "UPDATE tb_pneus SET ativo = 'N' WHERE codpneu = :codpneu";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':codpneu', $codpneu, PDO::PARAM_INT);
            $stmt->execute();
            $message = "Pneu marcado como inativo com sucesso!";
            $messageType = "success";
            header("refresh:2;url=consulta-pneu.php");
            exit;
        } catch (PDOException $e) {
            $message = "Erro ao alterar o campo ativo do pneu: " . $e->getMessage();
            $messageType = "danger";
        }
    } else {
        try {
            $sql = "SELECT * FROM tb_pneus WHERE codpneu = :codpneu";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':codpneu', $codpneu, PDO::PARAM_INT);
            $stmt->execute();
            $tb_pneus = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$tb_pneus) {
                $message = "Registro não encontrado.";
                $messageType = "danger";
            }
        } catch (PDOException $e) {
            $message = "Erro ao buscar registro: " . $e->getMessage();
            $messageType = "danger";
        }
    }
} else {
    header('Location: consulta-pneu.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Inativar Pneu</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="shortcut icon" href="./assets/icon/logoamazonia.ico" type="image/x-icon">
    <link rel="stylesheet" href="./assets/css/crudstyle.css">
</head>
<body>

<header>
    <div class="menubar">
        
    </div>
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
                <span class="title"><?php echo ($messageType == 'success') ? 'Pneu Inativado' : 'Erro ao Inativar'; ?></span>
                <p class="message"><?php echo $message; ?></p>
                <?php if ($messageType == 'success'): ?>
                    <p class="message">Você será redirecionado em 2 segundos...</p>
                <?php else: ?>
                    <a href="consulta-pneu.php" class="cancel">Voltar</a>
                <?php endif; ?>
            <?php elseif (isset($tb_pneus)): ?>
                <span class="title">Inativar Pneu</span>
                <p class="message">Tem certeza que deseja marcar o pneu <strong><?php echo htmlspecialchars($tb_pneus['codpneu']); ?></strong> como inativo? Esta ação não poderá ser desfeita.</p>
            </div>
            <div class="actions">
                <form method="post" action="">
                    <button type="submit" name="confirm" class="desactivate">Confirmar Inativação</button>
                    <a href="consulta-pneu.php" class="cancel">Cancelar</a>
                </form>
            <?php else: ?>
                <span class="title">Erro</span>
                <p class="message">Registro não encontrado.</p>
                <a href="consulta-pneu.php" class="cancel">Voltar</a>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>
