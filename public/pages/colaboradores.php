<?php
session_start();
require '../../vendor/autoload.php';
use app\functions\database\Connect;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/crudstyle.css">
    <title>Colaboradores - Amazônia Pneus</title>
    <style>
        /* Estilização da Seção Colaboradores */
        .colaboradores-section {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
            background: #ffffff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }

        .colaboradores-section h1 {
            font-size: 32px;
            color: #004d2c;
            text-align: center;
            margin-bottom: 20px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .colaboradores-section p {
            font-size: 18px;
            line-height: 1.6;
            text-align: justify;
            margin-bottom: 20px;
        }

        .colaboradores-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-around;
        }

        .colaborador-card {
            flex: 1 1 calc(30% - 20px);
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .colaborador-card img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .colaborador-card h3 {
            font-size: 20px;
            color: #004d2c;
            margin-bottom: 5px;
        }

        .colaborador-card p {
            font-size: 16px;
            color: #666;
            margin: 0;
        }
    </style>
</head>
<body>
<header>
    <!-- Cabeçalho e barra de navegação -->
    <header>
        <div class="menubar"></div>
        <img src="../assets/image/bandaglogo.png" alt="" class="circleyellow">
    </header>

    <label class="popup">
        <input type="checkbox">
        <div class="burger" tabindex="0">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <nav class="popup-window">
            <ul>
                <h3 class="nome-menu">Menu</h3>
                <article class="line-grey"></article>
                <li><button><span class="linkside">Colaboradores</span></button></li>
                <li><button><span class="linkside">Desenvolvimento</span></button></li>
                <li><button><span class="linkside">Onde Ficamos</span></button></li>
                <li><button><span class="linkside">Contato</span></button></li>
                <?php if (!empty($_SESSION) && $_SESSION['tipo'] == 'A'): ?>
                    <h3 class="nome-menu">Gerenciar Dados</h3>
                    <article class="line-grey"></article>
                    <li><button onclick="window.location.href='../consulta-med.php'"><span class="linkside">Medidas</span></button></li>
                    <li><button onclick="window.location.href='../consulta-user.php'"><span class="linkside">Cliente</span></button></li>
                    <li><button onclick="window.location.href='../consulta-pneu.php'"><span class="linkside">Pneus</span></button></li>
                    <li><button onclick="window.location.href='../consulta-img.php'"><span class="linkside">Imagens</span></button></li>
                    <li><button onclick="window.location.href='../consulta-compra.php'"><span class="linkside">Compras</span></button></li>
                    <li><button onclick="window.location.href='../consulta-city.php'"><span class="linkside">Cidades</span></button></li>
                <?php endif; ?>
                <img src="../assets/image/logoamazonia.png" class="img-menu-lado">
            </ul>
        </nav>
    </label>

    <nav class="navbar">
        <ul class="nav-links1">
            <li><a href="inicio.php" class="menu-letters">Início</a></li>
            <li><a href="about.php" class="menu-letters">Sobre</a></li>
            <li><a href="prod-pneus.php" class="menu-letters">Pneus</a></li>
            <li><a href="contato.php" class="menu-letters">Contato</a></li>
        </ul>
    </nav>

    <a href="carrinho.php"><img src="../assets/icon/cart.png" alt="" class="icon-cart"></a>
    <img src="../assets/icon/icon.png" alt="" class="icon-profile">
</header>

<main>
    <section class="colaboradores-section">
        <h1>Colaboradores</h1>
        <p>
            A Amazônia Pneus conta com uma equipe dedicada e altamente qualificada para oferecer os melhores serviços e produtos. Conheça alguns de nossos colaboradores:
        </p>

        <div class="colaboradores-list">
            <div class="colaborador-card">
                <img src="../assets/image/colaborador1.jpg" alt="Colaborador 1">
                <h3>João Silva</h3>
                <p>Gerente de Operações</p>
            </div>

            <div class="colaborador-card">
                <img src="../assets/image/colaborador2.jpg" alt="Colaborador 2">
                <h3>Maria Oliveira</h3>
                <p>Especialista em Vendas</p>
            </div>

            <div class="colaborador-card">
                <img src="../assets/image/colaborador3.jpg" alt="Colaborador 3">
                <h3>Carlos Santos</h3>
                <p>Técnico de Manutenção</p>
            </div>

            <div class="colaborador-card">
                <img src="../assets/image/colaborador4.jpg" alt="Colaborador 4">
                <h3>Ana Costa</h3>
                <p>Coordenadora de Marketing</p>
            </div>

            <div class="colaborador-card">
                <img src="../assets/image/colaborador5.jpg" alt="Colaborador 5">
                <h3>Pedro Souza</h3>
                <p>Analista Financeiro</p>
            </div>
        </div>
    </section>
</main>

<footer class="rodape">
    <div class="footer-verde">
        <!-- Conteúdo do rodapé -->
    </div>
    <div class="footer-bottom">
        <p>&copy; 2024 Amazônia Pneus. Todos os direitos reservados.</p>
    </div>
</footer>
</body>
</html>
