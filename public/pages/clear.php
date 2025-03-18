<?php

session_start();

//Chamando o vendor do composer
require '../../vendor/autoload.php';

use app\functions\classes\Cart;

$codpneu = filter_input(INPUT_GET,'codpneu',FILTER_SANITIZE_STRING);

(new Cart)->clear();

header('Location: carrinho.php');