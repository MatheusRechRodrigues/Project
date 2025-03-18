<?php

session_start();
require '../../vendor/autoload.php';
use app\functions\database\Connect;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../../src/Exception.php';
require '../../src/PHPMailer.php';
require '../../src/SMTP.php';

$pdo = conect();

// Função para enviar e-mail
function enviarEmail($email, $assunto, $mensagemHTML, $mensagemTexto) {
    $mail = new PHPMailer(true);
    try {
        // Configurações do servidor SMTP
        $mail->isSMTP();
        $mail->SMTPAuth = true; 
        $mail->Username = 'matheusrodrigues58277@gmail.com'; // Seu e-mail SMTP
        $mail->Password = 'vdgm vgjk dyyy nmio';             // Sua senha SMTP
        $mail->SMTPSecure = 'tls';             // Use 'tls' ou 'ssl' conforme seu provedor
        $mail->Host = 'smtp.gmail.com';        // Servidor SMTP
        $mail->Port = 587;                     // Porta TLS

        // Configurações do e-mail
        $mail->setFrom('matheusrodrigues58277@gmail.com', 'Matheus - AmazoniaPneus'); // Seu e-mail
        $mail->addAddress($email);  // Destinatário

        $mail->isHTML(true);    // Formato HTML
        $mail->Subject = $assunto;  // Assunto
        $mail->Body    = $mensagemHTML; // Corpo HTML
        $mail->AltBody = $mensagemTexto;  // Alternativa em texto

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Verifica se o e-mail existe no banco de dados
    $sql = "SELECT * FROM tb_clientes WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // Gera um token seguro
        $token = bin2hex(random_bytes(50));

        // Armazena o token e a validade no banco de dados
        $query = "UPDATE tb_clientes SET token = ?, token_expira = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email = ?";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(1, $token, PDO::PARAM_STR);
        $stmt->bindParam(2, $email, PDO::PARAM_STR);
        $stmt->execute();

        // Gera o link de redefinição de senha
        $link = "http://localhost/Amazonia-Pneus-TCC/public/pages/redefinir_senha.php?token=$token";
        $assunto = "Redefinir sua senha";
        $mensagemHTML = "Clique no link para redefinir sua senha: <a href='$link'>$link</a>";
        $mensagemTexto = "Clique no link para redefinir sua senha: $link";

        // Envia o e-mail usando PHPMailer
        if (enviarEmail($email, $assunto, $mensagemHTML, $mensagemTexto)) {
            echo "<script>alert ('Um link de redefinição de senha foi enviado para o seu e-mail.');</script>";
            header("Location: confirmacao.php"); 
        } else {
            echo "Erro ao enviar o e-mail. Tente novamente.";
        }
    } else {
        echo "E-mail não encontrado!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esqueci a Senha</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
            margin-left: 50%;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
            font-size: 1.8rem;
        }

        p {
            margin-bottom: 20px;
            color: #666;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input[type="email"] {
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        button {
            background-color: #007BFF;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        .alert {
            margin-top: 10px;
            color: red;
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Recuperar Senha</h1>
        <p>Digite seu e-mail cadastrado para receber o link de redefinição.</p>
        <form action="" method="POST">
            <input type="email" name="email" placeholder="Digite seu e-mail" required>
            <button type="submit">Recuperar Senha</button>
        </form>
        <div class="alert">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                echo isset($result) ? '' : "E-mail não encontrado!";
            }
            ?>
        </div>
    </div>
</body>
</html>
