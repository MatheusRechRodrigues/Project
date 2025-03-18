<?php
namespace app\functions\classes;

// include '/database/conect.php';
// $pdo = conect();

use app\functions\interfaces\CartInterface;
use app\functions\database\models\Read;

class CartProducts {

    //função que implementa a variavel do cartInterface. Por conta disso, essa função da acesso a o products da página de produtos
    public function products(CartInterface $cartInterface)
    {
         $productsInCart = $cartInterface->cart();
        //  $productsInDatabase = require_once '../app/helpers/products.php';
         $productsInDatabase = (new Read)->all('tb_pneus');
         
         //Array vazio onde seram colocados todos os produtos, com nome, preço e etc.
         $products = [];
         $total = 0;

         foreach ($productsInCart as $productId => $quantity) {
            //esses tres pontinhos são usados para poder tornar o Array com itens dentro apenas com indice 0
            $product = [...array_filter($productsInDatabase, fn ($product) => (int)$product->codpneu === $productId)];

            // $product = $productsInDatabase[$productId];
            $products[] = [
                'codpneu' => $productId,
                'nomepneu' => $product[0]->nomepneu,
                'descricao' => $product[0]->descricao,
                'tipo' => $product[0]->tipo,
                'preco' => $product[0]->preco,
                'qty' => $quantity,
                'subtotal' => $quantity * $product[0]->preco
            ];
            $total += $quantity * $product[0]->preco;
         }
         return [
            'products' => $products,
            'total' => $total
         ];
    }
}
?>
