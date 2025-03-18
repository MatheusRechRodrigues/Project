<?php 

session_start();

require '../../vendor/autoload.php';

use app\functions\classes\Cart;

$codpneu = filter_input(INPUT_GET,'codpneu',FILTER_SANITIZE_STRING);
$quantity = filter_input(INPUT_GET,'qty',FILTER_SANITIZE_STRING);


$cart = new Cart;
$cart->quantity($codpneu, $quantity);

header('Location:carrinho.php');
?>