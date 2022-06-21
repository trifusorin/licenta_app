<?php
define("PROJECT_ROOT_PATH", __DIR__ . "/../");
 
// include main configuration file
require_once PROJECT_ROOT_PATH . "/inc/config.php";
 
// include the base controller file
require_once PROJECT_ROOT_PATH . "/Controllers/BaseController.php";
 
// include the use model file
require_once PROJECT_ROOT_PATH . "/Models/UserModel.php";
require_once PROJECT_ROOT_PATH . "/Models/ProductModel.php";
require_once PROJECT_ROOT_PATH . "/Models/OrderModel.php";
require_once PROJECT_ROOT_PATH . "/Models/TableModel.php";


?>