<?php
require_once PROJECT_ROOT_PATH . "/Models/Database.php";
 
class ProductModel extends Database
{
    public function getProducts($limit)
    {
        return $this->select("SELECT * FROM Products ORDER BY id ASC LIMIT ?", ["i", $limit]);
    }

    public function getProductById($id)
    {
        $resp = $this->select("SELECT * FROM Products WHERE id = '$id'", []);
        
        if($resp != true){
            return $resp;
        }else{
            return $resp;
        }
    }

    public function insertProducts($data)
    {
        $dateNow = date('Y-m-d H:i:s');

        $resp = $this->insert("INSERT INTO Products (name, description, price, created) VALUES ('$data->name', '$data->description', '$data->price',  '$dateNow')", 'Products', []);
        if($resp != true){
            return $resp;
        }else{
            return $resp;
        }
    }

    
    public function deleteProducts($id)
    {
        $resp = $this->delete("DELETE FROM Products WHERE id = '$id'", 'Products', $id, []);
        if($resp != true){
            return $resp;
        }else{
            return $resp;
        }
    }
}