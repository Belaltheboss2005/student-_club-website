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

function addEvent($eventInput){

    global $conn;

    $clubID = mysqli_real_escape_string($conn, $eventInput["Club_ID"]);
    $name = mysqli_real_escape_string($conn, $eventInput["Event_name"]);
    $desc = mysqli_real_escape_string($conn, $eventInput["Event_description"]);
    $logo = mysqli_real_escape_string($conn, $eventInput["Event_logo"]);
    $eventdata = mysqli_real_escape_string($conn, $eventInput["Event_date"]);
 
    if(empty(trim($name))){

        return error422("Enter The Event Name: ");
    }elseif(empty(trim($desc))){

        return error422("Enter The Event Description: ");
    }elseif(empty(trim($clubID))){

        return error422("Enter The Club ID: ");
    }elseif(empty(trim($logo))){

        return error422("Enter The Event Logo: ");
    }elseif(empty(trim($eventdata))){

        return error422("Enter The Event Date: ");
    }else{
        $query = "INSERT INTO event (Club_ID,Event_name,Event_description,Event_logo,Event_date) VALUES ('$clubID','$name','$desc','$logo','$eventdata')";
        $result = mysqli_query($conn, $query);
        
        if($result){

            $data = [
                "status" => 201,
                "message" => "Club Added Successfully",
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

function updateEvent($eventInput, $eventParams){

    global $conn;

    if(!isset($eventParams['Event_ID'])){

        return error422("Event ID Not Found:");
    }elseif($eventParams['Event_ID'] == null){

        return error422("Enter The Event ID:");
    }

    $eventID = mysqli_real_escape_string($conn, $eventParams["Event_ID"]);

    $name = mysqli_real_escape_string($conn, $eventInput["Event_name"]);
    $desc = mysqli_real_escape_string($conn, $eventInput["Event_description"]);
    $logo = mysqli_real_escape_string($conn, $eventInput["Event_logo"]);
    $eventdata = mysqli_real_escape_string($conn, $eventInput["Event_date"]);

    if(empty(trim($name))){

        return error422("Enter The Event name: ");
    }elseif(empty(trim($desc))){

        return error422("Enter The Event Description: ");
    }elseif(empty(trim($logo))){

        return error422("Enter The Event Logo: ");
    }elseif(empty(trim($eventdata))){

        return error422("Enter The Event Date: ");
    }else{
        $query = "UPDATE event SET Event_name='$name',Event_description='$desc',Event_logo='$logo',Event_date='$eventdata' WHERE Event_ID='$eventID' LIMIT 1";
        $result = mysqli_query($conn, $query);
        
        if($result){

            $data = [
                "status" => 200,
                "message" => "Event Updated Successfully",
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

//replace 

function getEvent($eventParams){

    global $conn;

    if(empty($eventParams['Event_ID']) && empty($eventParams['Club_ID'])){

        return error422("Enter Either Event ID Or Club ID: ");
    }
    if (!empty($eventParams['Club_ID'])) {
        $clubID = mysqli_real_escape_string($conn, $eventParams['Club_ID']);
        $query = "SELECT * FROM event WHERE Club_ID='$clubID'";
    } elseif (!empty($eventParams['Event_ID'])) {
        $eventID = mysqli_real_escape_string($conn, $eventParams['Event_ID']);
        $query = "SELECT * FROM event WHERE Event_ID='$eventID'";
    } else {

        return error422("Invalid input. Unable to process request.");
    }

    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $event = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $event[] = $row;
            }

            $data = [
                "status" => 200,
                "message" => "Events Fetched Successfully",
                "data" => $event
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);
        } else {
            $data = [
                "status" => 404,
                "message" => "No Events Found",
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

function getEventList(){

    global $conn;

    $query = "SELECT * FROM event";
    $query_run = mysqli_query($conn, $query);

    if($query_run){

        if(mysqli_num_rows($query_run) > 0){

            $res= mysqli_fetch_all($query_run, MYSQLI_ASSOC);
        
            $data = [
                "status" => 200,
                "message" => "Event List Fetched Successfully",
                "data" => $res
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);

        }else{
            $data = [
                "status" => 404,
                "message" => "No Event Found",
            ];
            header("HTTP/1.0 404 No Event Found");
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

function deleteEvent($eventParams){

    global $conn;

    if(!isset($eventParams['Event_ID'])){

        return error422("Event ID Not Found:");

    }elseif($eventParams['Event_ID'] == null){

        return error422("Enter The Event ID:");
    }

    $eventID = mysqli_real_escape_string($conn, $eventParams["Event_ID"]);

    $query = "DELETE FROM event WHERE Event_ID='$eventID' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if($result){

        $data = [
            "status" => 200,
            "message" => "Event Deleted Successfully",
        ];
        header("HTTP/1.0 200 Deleted");
        return json_encode($data);

    }else{

        $data = [
            "status" => 404,
            "message" => "Event Not Found",
        ];
        header("HTTP/1.0 404 Not Found");
        return json_encode($data);
    }
}

?>