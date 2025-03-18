<?php 

session_start();
require '../../vendor/autoload.php';


use app\functions\classes\Cart;

//Filtra as informações que são enviadas pela URL com o GET. Usa o filtro para que ID receba apenas o numero do produto
$codpneu = filter_input(INPUT_GET, 'codpneu', FILTER_SANITIZE_NUMBER_INT);

//cart agora recebe os valores da Classe Cart Interface
$cart = new Cart;
$cart->add($codpneu);

$cart->dump();

header('Location: carrinho-pika.php');

//Confere se realmente está passando produtos no carrinho