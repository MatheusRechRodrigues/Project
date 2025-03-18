<?php
session_start();
require '../vendor/autoload.php'; // Carregar o autoload para incluir a classe Connect
use app\functions\database\Connect;

$pdo = Connect::conect(); // Usando a classe Connect para criar a conexão PDO
$message = '';
$messageType = '';

if (isset($_GET['codmedida'])) {
    $codmedida = $_GET['codmedida'];  // Corrigido para $codmedida

    if (isset($_POST['confirm'])) {
        try {
            $sql = "DELETE FROM tb_medidas WHERE codmedida = :codmedida";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':codmedida', $codmedida, PDO::PARAM_INT);
            $stmt->execute();
            $message = "Registro excluído com sucesso!";
            $messageType = "success";
            header("refresh:2;url=consulta-med.php");
            exit;
        } catch (PDOException $e) {
            $message = "Erro ao excluir o registro: " . $e->getMessage();
            $messageType = "danger";
        }
    } else {
        try {
            $sql = "SELECT * FROM tb_medidas WHERE codmedida = :codmedida";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':codmedida', $codmedida, PDO::PARAM_INT);
            $stmt->execute();
            $tb_medidas = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$tb_medidas) {
                $message = "Registro não encontrado.";
                $messageType = "danger";
            }
        } catch (PDOException $e) {
            $message = "Erro ao buscar registro: " . $e->getMessage();
            $messageType = "danger";
        }
    }
} else {
    header('Location: consulta-med.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Excluir Grupo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="shortcut icon" href="./assets/icon/logoamazonia.ico" type="image/x-icon">
    <link rel="stylesheet" href="./assets/css/crudstyle.css" >
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
                <span class="title"><?php echo ($messageType == 'success') ? 'Medida Excluída' : 'Erro na Exclusão'; ?></span>
                <p class="message"><?php echo $message; ?></p>
                <?php if ($messageType == 'success'): ?>
                    <p class="message">Você será redirecionado em 2 segundos...</p>
                <?php else: ?>
                    <a href="consulta-med.php" class="cancel">Voltar</a>
                <?php endif; ?>
            <?php elseif (isset($tb_medidas)): ?>
                <span class="title">Excluir Medida</span>
                <p class="message">Tem certeza que deseja excluir a medida <strong><?php echo htmlspecialchars($tb_medidas['codmedida']); ?></strong>? Esta ação não poderá ser desfeita.</p>
            </div>
            <div class="actions">
                <form method="post" action="">
                    <button type="submit" name="confirm" class="desactivate">Confirmar Exclusão</button>
                    <a href="consulta-med.php" class="cancel">Cancelar</a>
                </form>
            <?php else: ?>
                <span class="title">Erro</span>
                <p class="message">Registro não encontrado.</p>
                <a href="consulta-med.php" class="cancel">Voltar</a>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>
