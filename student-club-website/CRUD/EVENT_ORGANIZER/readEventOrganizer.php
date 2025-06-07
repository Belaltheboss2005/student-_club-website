<?php

// error_reporting(0);

header("Access-Control-Allow-Origin:*");
header("Content-Type: application/json");
header("Access-Control-Allow-Method: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With");

include("event_organizerFunction.php");

$requestMethod =$_SERVER["REQUEST_METHOD"];

if($requestMethod == "GET"){
    
    if(isset($_GET['Event_ID']) || isset($_GET['Organizer_ID'])) {

        $getEventOrganizer = getEventOrganizer($_GET);
        echo $getEventOrganizer;

    }else{
        $eventOrganizerList= getEventOrganizerList();
        echo $eventOrganizerList;
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