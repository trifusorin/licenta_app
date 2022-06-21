<?php
require __DIR__ . "/inc/bootstrap.php"; // https://code.tutsplus.com/tutorials/how-to-build-a-simple-rest-api-in-php--cms-37000
 
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );
 
 
require PROJECT_ROOT_PATH . "/Controllers/UserController.php";
require PROJECT_ROOT_PATH . "/Controllers/ProductController.php";
require PROJECT_ROOT_PATH . "/Controllers/OrderController.php";
require PROJECT_ROOT_PATH . "/Controllers/TableController.php";

cors();

 
$strMethodName = $uri[3] . 'Action';
$strController = $uri[2];


switch ($strController) {
    case "users":
        $objFeedController = new UserController();
        $objFeedController->{$strMethodName}();
        break;
    case "products":
        $objFeedController = new ProductController();
        if(isset($uri[4])){
            $objFeedController->{$strMethodName}($uri[4]);
        }else{
            $objFeedController->{$strMethodName}();
        }
        break;
    case "orders":
        $objFeedController = new OrderController();
        if(isset($uri[4])){
            $objFeedController->{$strMethodName}($uri[4]);
        }else{
            $objFeedController->{$strMethodName}();
        }
        break;
    case "tables":
        $objFeedController = new TableController();
        if(isset($uri[4])){
            $objFeedController->{$strMethodName}($uri[4]);
        }else{
            $objFeedController->{$strMethodName}();
        }
        break;
    default:
        header("HTTP/1.1 404 Not Found");
        exit();
        break;
}




function cors() {

    // Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
        // you want to allow, and if so:
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            // may also be using PUT, PATCH, HEAD etc
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }

   // echo array_values($_SERVER['HTTP_ORIGIN']);
    //echo "You have CORS!";
}

?>