<?php 

namespace app\functions\database\models;


use app\functions\database\Connect;

abstract class Model 
{
    protected $pdo;

    public function __construct()
    {
        $this->pdo = Connect::conect();
    }
}
?>