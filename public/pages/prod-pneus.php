<?php


require '../../vendor/autoload.php';
use app\functions\database\Connect;


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/crudstyle.css">
    <title>Document</title>
</head>
<body>
<header>
    <!-- parte do menu, colocar em todos -->

    <header>
        <div class="menubar">



        </div>

        <img src="../assets/image/bandaglogo.png" alt="" class="circleyellow">
    </header>

<!-- tres riscosdo menu side-bar -->
    <label class="popup">
  <input type="checkbox">
  <div class="burger" tabindex="0">
    <span></span>
    <span></span>
    <span></span>
  </div>
  <nav class="popup-window">   
    <ul>
      
    <h3 class="nome-menu"> Menu</h3>
    <article class="line-grey"></article>
    <li>
        <button>       
          <span class="linkside">Colaboradores</span>
        </button>
      </li>
      <li>
        <button>  
          <span class="linkside">Desenvolvimento</span>
        </button>
      </li>
      <li>
        
        <button>  
          <span class="linkside">Onde Ficamos</span>
        </button>
      </li> 
      <li>
        <button>  
          <span class="linkside">Contato</span>
        </button>
      </li>
      <?php

if (!empty($_SESSION) && $_SESSION['tipo'] == 'A' && empty($_SESSION['tipo'] == '')) //tela pro adm, somente o adm vai ter acesso a links aq
{ ?>
    <!-- tudo do html pro adm -->

<h3 class="nome-menu">Gerenciar Dados </h3>
<article class="line-grey"></article>

      <li>
    <button onclick="window.location.href='../consulta-med.php'">
        <span class="linkside">Medidas</span>
    </button>
</li>

<li>
    <button onclick="window.location.href='../consulta-user.php'">
        <span class="linkside">Cliente</span>
    </button>
</li>

<li>
    <button onclick="window.location.href='../consulta-pneu.php'">
        <span class="linkside">Pneus</span>
    </button>
</li>

<li>
    <button onclick="window.location.href='../consulta-img.php'">
        <span class="linkside">Imagens</span>
    </button>
</li>

<li>
    <button onclick="window.location.href='../consulta-compra.php'">
        <span class="linkside">Compras</span>
    </button>
</li>

<li>
    <button onclick="window.location.href='../consulta-city.php'">
        <span class="linkside">Cidades</span>
    </button>
</li>

    
<?php


} else { //tela pro user, coisas que o usuario vai ter
    ?>
<?php
}
?>

<img src="../assets/image/logoamazonia.png" class="img-menu-lado">
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



<article class="divisor-pneu">
    <h1 class="txt-pneu-prod"> CONFIRA NOSSOS PNEUS RECAPADOS</h1> 
</article>




<div class="produtos-div">

<?php
$pdo = Connect::conect();
$sql = "
   SELECT p.codpneu, p.nomepneu, p.descricao, p.preco, i.url 
   FROM tb_pneus p
   INNER JOIN tb_imagens i ON p.codpneu = i.codpneu
   
";

// Prepara e executa a consulta
$stmt = $pdo->prepare($sql);
$stmt->execute();

// Busca todos os resultados em forma de array associativo
$pneus = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="produtos_container">
   <?php foreach ($pneus as $pneu) { ?>
       <div class="produto_card">
           <!-- Exibe a imagem do pneu -->
           <img class="produto_imagem" src="<?php echo htmlspecialchars($pneu['url']); ?>" alt="Imagem do <?php echo htmlspecialchars($pneu['nomepneu']); ?>">

           <!-- Exibe nome, descrição e preço do pneu -->
           <h3 class="produto_nome"><?php echo htmlspecialchars($pneu['nomepneu']); ?></h3>
           <p class="produto_descricao"><?php echo htmlspecialchars($pneu['descricao']); ?></p>
           <span class="produto_valor">R$ <?php echo number_format($pneu['preco'], 2, ',', '.'); ?></span>

           <!-- Botão 'Saiba Mais' com o codpneu na URL -->
           <form action="iten-card.php" method="get">
               <input type="hidden" name="id_pneu" value="<?php echo htmlspecialchars($pneu['codpneu']); ?>">
               <article class="line-card-division"></article>
               
           <button class="btn-card">    <a href="iten-card.php?codpneu=<?php echo htmlspecialchars($pneu['codpneu']); ?>" style="text-decoration: none; color: inherit;">
                   Saiba Mais
               </a></button>
           </form>
       </div>
   <?php } ?>
</div>


</div>

   
</div>

<script>
 var addZoom = targetClass => {
   // Seleciona todas as imagens com a classe targetClass
   let images = document.querySelectorAll(`.${targetClass}`);

   images.forEach(image => {
     // Cria um novo objeto de imagem para determinar o tamanho
     let img = new Image();
     img.src = image.src;

     img.onload = () => {
       let ratio = img.naturalHeight / img.naturalWidth;

       // Configura eventos de zoom ao passar o mouse
       image.onmousemove = e => {
         let rect = image.getBoundingClientRect(),
             xPos = e.clientX - rect.left,
             yPos = e.clientY - rect.top,
             xPercent = xPos / (image.clientWidth / 100) + "%",
             yPercent = yPos / ((image.clientWidth * ratio) / 100) + "%";

         Object.assign(image.style, {
           transformOrigin: `${xPercent} ${yPercent}`,
           transform: "scale(1.2)",
           transition: "transform 0.1s ease" // Animação rápida para resposta
         });
       };

       // Reset ao sair do elemento
       image.onmouseleave = () => {
         Object.assign(image.style, {
           transform: "scale(1)"
         });
       };
     };
   });
 };

 window.onload = () => addZoom("produto_imagem");
</script>







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