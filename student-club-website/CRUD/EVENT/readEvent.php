<?php

// error_reporting(0);

header("Access-Control-Allow-Origin:*");
header("Content-Type: application/json");
header("Access-Control-Allow-Method: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With");

include("eventFunction.php");

$requestMethod =$_SERVER["REQUEST_METHOD"];

if($requestMethod == "GET"){
    
    if(isset($_GET['Event_ID']) || isset($_GET['Club_ID'])){
        $getEvent = getEvent($_GET);
        echo $getEvent;

    }else{
        $getEventList= getEventList();
        echo $getEventList;
    }
    
}else{
    $data = [
        "status" => 405,
        "message" => $requestMethod. " Method Not Allowed",
    ];
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($data);
}
?>