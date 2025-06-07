<?php

// error_reporting(0);

header("Access-Control-Allow-Origin:*");
header("Content-Type: application/json");
header("Access-Control-Allow-Method: PUT");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With");

include("adminFunction.php");

$requestMethod =$_SERVER["REQUEST_METHOD"];

if($requestMethod == "PUT"){

    $inputData = json_decode(file_get_contents("php://input"), true);
    if(empty($inputData)){
        
        $updateAdmin = updateAdmin($_POST, $_GET);
    }else{

        $updateAdmin = updateAdmin($inputData, $_GET);
    }

    echo $updateAdmin;

}else{
    $data = [
        "status" => 405,
        "message" => $requestMethod. " Methos Not Allowed",
    ];
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($data);
}
?>


