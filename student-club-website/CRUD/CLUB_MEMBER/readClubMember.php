<?php

// error_reporting(0);

header("Access-Control-Allow-Origin:*");
header("Content-Type: application/json");
header("Access-Control-Allow-Method: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With");

include("club_memberFunction.php");

$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod == "GET") {
    
    if (isset($_GET['Club_ID']) || isset($_GET['Membership_ID'])) {

        $getClubMember = getClubMember($_GET);
        echo $getClubMember;

    } else {
        $getClubMemberList = getClubMemberList();
        echo $getClubMemberList;
    }
    
} else {
    $data = [
        "status" => 405,
        "message" => $requestMethod . " Method Not Allowed",
    ];
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($data);
}

?>