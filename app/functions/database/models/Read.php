<?php 

namespace app\functions\database\models;

class Read extends Model 
{
    public function all($table, $fields = '*') 
    {
        try {
            $query = $this->pdo->query("select {$fields} from {$table}");
            $query->execute();

            return $query->fetchAll();
        } catch (\Throwable $th) {
            var_dump($th->getmessage());
        }
    }
}
?>