<?php
require_once PROJECT_ROOT_PATH . "/Models/Database.php";
 
class UserModel extends Database
{
    public function getUsers($limit)
    {
        return $this->select("SELECT * FROM Users ORDER BY id ASC LIMIT ?", ["i", $limit]);
    }

    public function insertUsers($data)
    {
        $dateNow = date('Y-m-d H:i:s');

        $resp = $this->insert("INSERT INTO Users (email, password, created) VALUES ('$data->email', '$data->password', 'Users',  '$dateNow')", []);
        if($resp != true){
            return $resp;
        }else{
            return $resp;
        }
    }
}