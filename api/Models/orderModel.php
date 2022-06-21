<?php
require_once PROJECT_ROOT_PATH . "/Models/Database.php";
 
class OrderModel extends Database
{
    public function getOrders($limit)
    {
        $resp = $this->select("SELECT * FROM Orders ORDER BY id ASC LIMIT ?", ["i", $limit]);

        foreach ($resp as &$value) {

            $value['orderedProducts'] = $this->select("SELECT * FROM OrderedProducts WHERE orderId = '$value[id]'", []);

            if(count($value['orderedProducts']) > 0){
                foreach ($value['orderedProducts'] as &$value2) {
                    $value2['product'] = new stdClass();;

                    $product =  $this->select("SELECT * FROM Products WHERE id = '$value2[productId]'", [])[0];
                    $value2['product'] = $product;
                }
            }
        }

        return $resp;
    }

    public function getFilteredOrders($additionalFilter)
    {
        $resp = $this->select("SELECT * FROM Orders WHERE $additionalFilter ORDER BY id ASC ");

        foreach ($resp as &$value) {

            $value['orderedProducts'] = $this->select("SELECT * FROM OrderedProducts WHERE orderId = '$value[id]'", []);

            if(count($value['orderedProducts']) > 0){
                foreach ($value['orderedProducts'] as &$value2) {
                    $value2['product'] = new stdClass();;

                    $product =  $this->select("SELECT * FROM Products WHERE id = '$value2[productId]'", [])[0];
                    $value2['product'] = $product;
                }
            }
        }

        return $resp;
    }

    public function getOrderById($id)
    {
        $resp = $this->select("SELECT * FROM Orders WHERE id = '$id'", [])[0];

        $resp['orderedProducts'] = $this->select("SELECT * FROM OrderedProducts WHERE orderId = '$resp[id]'", []);

        foreach ($resp['orderedProducts'] as &$value) {
            $product =  $this->select("SELECT * FROM Products WHERE id = '$value[productId]'", [])[0];
            array_push($value['products'], $product);
        }

        if($resp != true){
            return $resp;
        }else{
            return $resp;
        }
    }

    public function insertOrder($data)
    {
        $dateNow = date('Y-m-d H:i:s');

        if(count($data->orderedProducts)){
            $resp = $this->insert("INSERT INTO Orders (title, description, tableId, status, price, created) VALUES ('$data->title','$data->description','$data->tableId','open', '$data->price', '$dateNow')",'Orders', []);
            $resp['orderedProducts'] = [];
            foreach ($data->orderedProducts as &$value) {
                $secondResp = $this->insert("INSERT INTO OrderedProducts (productId, orderId, created) VALUES ('$value->productId','$resp[id]',  '$dateNow')", 'OrderedProducts', []);
                array_push($resp['orderedProducts'], $secondResp);
            }

            if($resp != true){
                return $resp;
            }else{
                return $resp;
            }
        }
    }

    public function closeOrder($id)
    {
        $resp = $this->update("UPDATE Orders SET status = 'closed' WHERE id = '$id'", "Orders", $id, []);

        if($resp != true){
            return $resp;
        }else{
            return $resp;
        }
    }

}