<?php

require "../../inc/connection.php";

function error422($message){
    
    $data = [
        "status" => 422,
        "message" => $message,
    ];
    header("HTTP/1.0 422 Unprocessable Entity");
    echo json_encode($data);
    exit();
}

function addEventOrganizer($eventorganizerInput){

    global $conn;

    $eventID = mysqli_real_escape_string($conn, $eventorganizerInput["Event_ID"]);
    $membershipID = mysqli_real_escape_string($conn, $eventorganizerInput["Membership_ID"]);


    if(empty(trim($eventID))){

        return error422("Enter The Event ID: ");
    }elseif(empty(trim($membershipID))){

        return error422("Enter The Membership ID: ");
    }else{
        $query = "INSERT INTO event_organizer (Event_ID,Membership_ID) VALUES ('$eventID','$membershipID')";
        $result = mysqli_query($conn, $query);
        
        if($result){

            $data = [
                "status" => 201,
                "message" => "Event Organizer Added Successfully",
            ];
            header("HTTP/1.0 201 Created");
            return json_encode($data);

        }else{
            $data = [
                "status" => 500,
                "message" => "Internal Server Error",
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
}

function updateEventOrganizer($eventorganizerInput, $eventorganizerParams){

    global $conn;

    if(!isset($eventorganizerParams['Organizer_ID '])){

        return error422("Organizer ID Not Found:");
    }elseif($eventorganizerParams['Organizer_ID '] == null){

        return error422("Enter The Organizer ID:");
    }

    $organizerID = mysqli_real_escape_string($conn, $eventorganizerParams["Organizer_ID"]);

    $eventID = mysqli_real_escape_string($conn, $eventorganizerInput["Event_ID"]);
    $membershipID = mysqli_real_escape_string($conn, $eventorganizerInput["Membership_ID"]);

    if(empty(trim($eventID))){

        return error422("Enter The Event ID: ");
    }elseif(empty(trim($membershipID))){

        return error422("Enter The Membership ID: ");
    }else{
        $query = "UPDATE event_organizer SET Event_ID='$eventID',Membership_ID='$membershipID' WHERE Organizer_ID='$organizerID' LIMIT 1";
        $result = mysqli_query($conn, $query);
        
        if($result){

            $data = [
                "status" => 200,
                "message" => "Event Organizer Updated Successfully",
            ];
            header("HTTP/1.0 200 Updated");
            return json_encode($data);

        }else{
            $data = [
                "status" => 500,
                "message" => "Internal Server Error",
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
}

function getEventOrganizer($eventorganizerParams) {
    global $conn;

    if (empty($eventorganizerParams['Event_ID']) && empty($eventorganizerParams['Organizer_ID'])) {
        return error422("Enter either Event ID or Organizer ID.");
    }

    if (!empty($eventorganizerParams['Event_ID'])) {
        $eventID = mysqli_real_escape_string($conn, $eventorganizerParams['Event_ID']);
        $query = "SELECT * FROM event_organizer WHERE Event_ID='$eventID'";
    } elseif (!empty($eventorganizerParams['Organizer_ID'])) {
        $organizerID = mysqli_real_escape_string($conn, $eventorganizerParams['Organizer_ID']);
        $query = "SELECT * FROM event_organizer WHERE Organizer_ID='$organizerID' LIMIT 1";
    } else {

        return error422("Invalid input. Unable to process request.");
    }

    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $organizers = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $organizers[] = $row;
            }

            $data = [
                "status" => 200,
                "message" => "Event Organizer(s) Fetched Successfully",
                "data" => $organizers
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);
        } else {

            $data = [
                "status" => 404,
                "message" => "No Event Organizer(s) Found",
            ];
            header("HTTP/1.0 404 Not Found");
            return json_encode($data);
        }
    } else {

        $data = [
            "status" => 500,
            "message" => "Internal Server Error",
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}

function getEventOrganizerList(){

    global $conn;

    $query = "SELECT * FROM event_organizer";
    $query_run = mysqli_query($conn, $query);

    if($query_run){

        if(mysqli_num_rows($query_run) > 0){

            $res= mysqli_fetch_all($query_run, MYSQLI_ASSOC);
        
            $data = [
                "status" => 200,
                "message" => "Event Organizer List Fetched Successfully",
                "data" => $res
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);

        }else{
            $data = [
                "status" => 404,
                "message" => "No Event Organizer Found",
            ];
            header("HTTP/1.0 404 No Event Orgainzer Found");
            return json_encode($data);   
        }
    
    }else{
        $data = [
            "status" => 500,
            "message" => "Internal Server Error",
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    } 
}

function deleteEventOrganizer($eventorganizerParams){

    global $conn;

    if(!isset($eventorganizerParams['Organizer_ID'])){

        return error422("Event Organizer ID Not Found:");

    }elseif($eventorganizerParams['Organizer_ID'] == null){

        return error422("Enter The Event Organizer ID:");
    }

    $organizerID = mysqli_real_escape_string($conn, $eventorganizerParams["Organizer_ID"]);

    $query = "DELETE FROM event_organizer WHERE Organizer_ID='$organizerID' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if($result){

        $data = [
            "status" => 200,
            "message" => "Event Organizer Deleted Successfully",
        ];
        header("HTTP/1.0 200 Deleted");
        return json_encode($data);

    }else{

        $data = [
            "status" => 404,
            "message" => "Event Organizer Not Found",
        ];
        header("HTTP/1.0 404 Not Found");
        return json_encode($data);
    }
}

?>