<?php
require_once PROJECT_ROOT_PATH . "/Models/Database.php";
 
class TableModel extends Database
{
    public function getTables($limit)
    {
        return $this->select("SELECT * FROM Tables ORDER BY id ASC LIMIT ?", ["i", $limit]);
    }

    public function getTableById($id)
    {
        $resp = $this->select("SELECT * FROM Tables WHERE id = '$id'", [])[0];
        
        if($resp != true){
            return $resp;
        }else{
            return $resp;
        }
    }

    public function insertTables($data)
    {
        $dateNow = date('Y-m-d H:i:s');

        $randomTableCode = strval(rand(1000, 9999));
        $resp = $this->insert("INSERT INTO Tables (name, description, tableRandomCode, status, created) VALUES ('$data->name', '$data->description', '$randomTableCode', 'open',  '$dateNow')", "Tables", []);

        if($resp != true){
            return $resp;
        }else{
            return $resp;
        }
    }

    public function closeTables($id)
    {
        $resp = $this->update("UPDATE Tables SET status = 'closed' WHERE id = '$id'", "Tables", $id, []);
        
        if($resp != true){
            return $resp;
        }else{
            return $resp;
        }
    }

    public function getTableByCode($code)
    {
        $resp = $this->select("SELECT * FROM Tables WHERE tableRandomCode = '$code'", []);
        
        if($resp != true){
            return $resp;
        }else{
            return $resp;
        }
    }
}