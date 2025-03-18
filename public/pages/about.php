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
    <title>Sobre Nós - Amazônia Pneus</title>
</head>
<body>
<header>
    <!-- parte do menu, colocar em todos -->
    <header>
        <div class="menubar"></div>
        <img src="../assets/image/bandaglogo.png" alt="" class="circleyellow">
    </header>

    <!-- tres riscos do menu side-bar -->
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
    <section class="sobre-nos">
        <h1>Sobre a Amazônia Pneus e Recapagem</h1>
        <p>
            Fundada em 1995, a Amazônia Pneus e Recapagem tem como missão oferecer produtos e serviços de alta qualidade para garantir a segurança e o desempenho de veículos em todo o Brasil. 
        </p>
        <p>
            Com uma equipe altamente capacitada e tecnologia de ponta, nossa empresa se especializa na venda de pneus, recapagem e manutenção, buscando sempre atender às necessidades de nossos clientes com excelência.
        </p>
        <h2>Nossos Valores</h2>
        <ul>
            <li><strong>Compromisso com a Qualidade:</strong> Produtos confiáveis e duráveis.</li>
            <li><strong>Atendimento ao Cliente:</strong> Prioridade no suporte e na satisfação.</li>
            <li><strong>Sustentabilidade:</strong> Contribuímos para um meio ambiente mais sustentável por meio da recapagem.</li>
        </ul>
        <h2>Por que nos escolher?</h2>
        <p>
            Com anos de experiência no mercado, oferecemos uma ampla gama de produtos e serviços que atendem desde pequenos veículos até grandes frotas. Nossa localização estratégica em Manaus, AM, facilita o atendimento de clientes em todo o Norte do Brasil.
        </p>
    </section>
</main>

<footer class="rodape">
    <div class="footer-verde">
        <div class="footer-section">
            <h4>Contato</h4>
            <p>Email: contato@amazoniapneus.com.br</p>
            <p>Telefone: (92) 3333-3333</p>
        </div>
        <div class="footer-section">
            <h4>Endereço</h4>
            <p>Avenida da Amazônia, 1234</p>
            <p>Manaus, AM</p>
        </div>
        <div class="footer-section">
            <h4>Redes Sociais</h4>
            <a href="#" class="footer-link">Facebook</a> | 
            <a href="#" class="footer-link">Instagram</a> | 
            <a href="#" class="footer-link">LinkedIn</a>
        </div>
        <div class="footer-section">
            <h4>Sobre Nós</h4>
            <p>A Amazônia Pneus é referência em pneus de alta qualidade, oferecendo serviços e produtos confiáveis para todos os nossos clientes.</p>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2024 Amazônia Pneus. Todos os direitos reservados.</p>
    </div>
</footer>

</body>
</html>
<style>/* Estilização da Seção Sobre Nós */
.sobre-nos {
    max-width: 900px;
    margin: 40px auto;
    padding: 20px;
    background: #ffffff;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
    border-radius: 10px;
}

.sobre-nos h1 {
    font-size: 32px;
    color: #004d2c;
    text-align: center;
    margin-bottom: 20px;
    font-weight: 700;
    text-transform: uppercase;
}

.sobre-nos p {
    font-size: 18px;
    line-height: 1.6;
    margin-bottom: 15px;
    text-align: justify;
}

.sobre-nos h2 {
    font-size: 26px;
    color: #004d2c;
    margin-top: 20px;
    text-align: left;
    border-bottom: 2px solid #f4e04d;
    display: inline-block;
    padding-bottom: 5px;
}

.sobre-nos ul {
    list-style-type: disc;
    margin: 10px 20px;
    padding: 0;
}

.sobre-nos ul li {
    margin: 5px 0;
    font-size: 18px;
    color: #555;
}

.sobre-nos ul li strong {
    color: #004d2c;
}
</style>