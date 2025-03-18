<?php
session_start();
require '../../vendor/autoload.php';

use app\functions\classes\CartProducts;
use app\functions\classes\Cart;

// Objeto concreto que implementa o cartInterface
$cartProducts = new CartProducts();
$products = $cartProducts->products(new Cart);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Cart</title>
</head>

<body>
    <h2>Cart | <a href="carrinho-pika.php">Home</a></h2>
    <hr>
    <div id="container">
        <?php if (count($products['products']) <= 0): ?>
            <h3>Nenhum produto dentro do carrinho de compras</h3>
        <?php else: ?>
            <ul>
                <?php foreach ($products['products'] as $product): ?>
                    <li class="cart-produtc">
                        <strong><?php echo $product['nomepneu']; ?></strong>
                        <form action="quantidade.php" method="get">
                            <input type="hidden" name="codpneu" value="<?php echo $product['codpneu']; ?>">
                            <input type="text" name="qty" value="<?php echo $product['qty']; ?>" id="cart-input-qty">
                        </form>
                        <?php echo $product['descricao']; ?> 
                        x R$ <?php echo number_format($product['preco'], 2, ',', '.'); ?> 
                        | Subtotal: R$ <?php echo number_format($product['subtotal'], 2, ',', '.'); ?>
                        <a href="remove.php?codpneu=<?php echo $product['codpneu']; ?>" id="cart-remove">Remove</a>
                    </li>
                <?php endforeach ?>
            </ul>
            <div id="cart-total-clear">
                <span id="cart-total">
                    Total: R$ <?php echo number_format($products['total'], 2, ',', '.'); ?>
                </span>
                <span id="cart-clear">
                    <a href="clear.php">Clear Cart</a>
                </span>
            </div>
        <?php endif ?>
    </div>
</body>
</html>
