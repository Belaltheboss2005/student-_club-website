<?php

// error_reporting(0);

header("Access-Control-Allow-Origin:*");
header("Content-Type: application/json");
header("Access-Control-Allow-Method: DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With");

include("adminFunction.php");

$requestMethod =$_SERVER["REQUEST_METHOD"];

if($requestMethod == "DELETE"){
    
    $deleteAdmin= deleteAdmin($_GET);
    echo $deleteAdmin;
    
}else{
    $data = [
        "status" => 405,
        "message" => $requestMethod. " Methos Not Allowed",
    ];
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($data);
}
?>