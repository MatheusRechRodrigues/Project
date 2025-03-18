<?php
// Iniciando a sessão
session_start();

// Incluindo o autoload do Composer e a classe de conexão com o banco de dados
require '../vendor/autoload.php';  
use app\functions\database\Connect; 

// Definindo as variáveis de mensagem
$message = '';
$messageType = '';

// Obter a conexão PDO usando a classe Connect
$pdo = Connect::conect();

// Verificar se o formulário de cadastro foi submetido
if (isset($_POST['btnAdd'])) {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $fone = $_POST['fone'];
    $email = $_POST['email'];
    $senha = md5($_POST['senha']); // Usando md5 para criptografar a senha
    $confirm_senha = md5($_POST['confirm_senha']); // Confirmando a senha
    $datanasc = $_POST['datanasc'];
    $rua = $_POST['rua'];
    $bairro = $_POST['bairro'];
    $ncasa = $_POST['ncasa'];
    $complemento = $_POST['complemento'];

    // Verificar se a senha e a confirmação são iguais antes de inserir no banco
    if ($senha === $confirm_senha) {
        try {
            // Preparar e executar o comando de inserção
            $stmt = $pdo->prepare("INSERT INTO tb_clientes (nome, cpf, fone, email, senha, datanasc, rua, bairro, ncasa, complemento) 
                                   VALUES (:nome, :cpf, :fone, :email, :senha, :datanasc, :rua, :bairro, :ncasa, :complemento)");
            $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindParam(':cpf', $cpf, PDO::PARAM_STR);
            $stmt->bindParam(':fone', $fone, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
            $stmt->bindParam(':datanasc', $datanasc, PDO::PARAM_STR);
            $stmt->bindParam(':rua', $rua, PDO::PARAM_STR);
            $stmt->bindParam(':bairro', $bairro, PDO::PARAM_STR);
            $stmt->bindParam(':ncasa', $ncasa, PDO::PARAM_INT);
            $stmt->bindParam(':complemento', $complemento, PDO::PARAM_STR);
            $stmt->execute();

            // Mensagem de sucesso
            $message = "Usuário cadastrado com sucesso!";
            $messageType = "success";
            // Redireciona após 2 segundos
            header("refresh:2;url=consulta-user.php");
        } catch (PDOException $e) {
            // Mensagem de erro
            $message = "Erro ao cadastrar usuário: " . $e->getMessage();
            $messageType = "danger";
        }
    } else {
        $message = "As senhas não coincidem!";
        $messageType = "danger";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" href="./assets/css/register.css">
    <link rel="shortcut icon" href="./assets/icon/logoamazonia.ico" type="image/x-icon">
    <script>
      // Função para validar se as senhas coincidem
      function validatePassword() {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
        if (password !== confirmPassword) {
          document.getElementById('passwordError').innerText = 'As senhas não coincidem!';
          return false;
        }
        document.getElementById('passwordError').innerText = '';
        return true;
      }
    </script>
</head>
<body>
<img src="../public/assets/image/logoamazonia.png" class="logoamazonia">

<div class="login-card-user">
  <div class="card-header">
    <h1>Cadastro</h1>
  </div>
  <div class="card-body">
    <form method="post" onsubmit="return validatePassword()">
      <div class="form-group-row">
        <div class="form-group">
          <label for="nome">Nome</label>
          <input type="text" id="nome" name="nome" required="true">
        </div>
        <div class="form-group">
          <label for="cpf">CPF</label>
          <input type="number" id="cpf" name="cpf" required="true">
        </div>
      </div>

      <div class="form-group-row">
        <div class="form-group">
          <label for="fone">Telefone</label>
          <input type="number" id="fone" name="fone" required="true">
        </div>
        <div class="form-group">
          <label for="email">E-mail</label>
          <input type="email" id="email" name="email" required="true">
        </div>
      </div>

      <div class="form-group-row">
        <div class="form-group">
          <label for="password">Senha</label>
          <input type="password" id="password" name="senha" required="true">
        </div>

        <div class="form-group">
          <label for="confirm_password">Repetir Senha</label>
          <input type="password" id="confirm_password" name="confirm_senha" required="true">
          <span id="passwordError" class="error-message"></span>
        </div>
      </div>

      <div class="form-group-row">
        <div class="form-group">
          <label for="datanasc">Data de Nascimento</label>
          <input type="date" id="datanasc" name="datanasc" required="true">
        </div>
        <div class="form-group">
          <label for="rua">Rua</label>
          <input type="text" id="rua" name="rua" required="true">
        </div>
      </div>

      <div class="form-group-row">
        <div class="form-group">
          <label for="bairro">Bairro</label>
          <input type="text" id="bairro" name="bairro" required="true">
        </div>
        <div class="form-group">
          <label for="ncasa">N° Casa</label>
          <input type="number" id="ncasa" name="ncasa" required="true">
        </div>
      </div>

      <div class="form-group">
        <label for="complemento">Complemento</label>
        <input type="text" id="complemento" name="complemento" required="true">
      </div>

      <div class="form-group">
        <button type="submit" class="login-button" name="btnAdd">Cadastrar</button>
      </div>

      <div class="cadastrolinkdiv">
        <a href="consulta-user.php" class="linkcadastrolog">VOLTAR</a>
      </div>
    </form>
  </div>
</div>

<div class="mensagem-banco">
    <?php if ($message) : ?>
        <div class="alert alert-<?php echo $messageType; ?>" role="alert">
            <?php echo $message; ?>
            <?php if ($messageType == 'success') : ?>
                <p>Você será redirecionado em 2 segundos...</p>
            <?php else : ?>
                <a href="consulta-user.php" class="btn btn-secondary mt-2">Voltar</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
