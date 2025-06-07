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

function addEventAttendee($eventattendeeInput){

    global $conn;

    $eventID = mysqli_real_escape_string($conn, $eventattendeeInput["Event_ID"]);
    $studentID = mysqli_real_escape_string($conn, $eventattendeeInput["Student_ID"]);
    $eventeval = mysqli_real_escape_string($conn, $eventattendeeInput["Event_eval"]);
    $eventcomment = mysqli_real_escape_string($conn, $eventattendeeInput["Event_comment"]);

    if(empty(trim($eventID))){

        return error422("Enter The Event ID: ");
    }elseif(empty(trim($studentID))){

        return error422("Enter The Student ID: ");
    }elseif(empty(trim($eventeval))){

        return error422("Enter The Event Evaluation: ");
    }elseif(empty(trim($eventcomment))){

        return error422("Enter The Event Comment: ");
    }else{
        $query = "INSERT INTO event_attendee (Event_ID,Student_ID,Event_eval,Event_comment) VALUES ('$eventID','$studentID','$eventeval','$eventcomment')";
        $result = mysqli_query($conn, $query);
        
        if($result){

            $data = [
                "status" => 201,
                "message" => "Event Attendant Added Successfully",
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

function updateEventAttendee($eventattendeeInput, $eventattendeeParams){

    global $conn;

    if(!isset($eventattendeeParams['Attendant_ID'])){

        return error422("Attendant ID Not Found:");
    }elseif($eventattendeeParams['Attendant_ID'] == null){

        return error422("Enter The Attendant ID:");
    }

    $attendantID = mysqli_real_escape_string($conn, $eventattendeeParams["Attendant_ID"]);

    $studentID = mysqli_real_escape_string($conn, $eventattendeeInput["Student_ID "]);
    $eventId = mysqli_real_escape_string($conn, $eventattendeeInput["Event_ID "]);
    $eventeval = mysqli_real_escape_string($conn, $eventattendeeInput["Event_eval"]);
    $eventcomment = mysqli_real_escape_string($conn, $eventattendeeInput["Event_comment"]);

    if(empty(trim($studentID))){

        return error422("Enter The Student ID: ");
    }elseif(empty(trim($eventId))){

        return error422("Enter The Event ID: ");
    }elseif(empty(trim($eventeval))){

        return error422("Enter The Event Evaluation: ");
    }elseif(empty(trim($eventcomment))){

        return error422("Enter The Event Comment: ");
    }else{
        $query = "UPDATE event_attendee SET Student_ID='$studentID',Event_ID='$eventId',Event_eval='$eventeval',Event_comment='$eventcomment' WHERE Attendant_ID='$attendantID' LIMIT 1";
        $result = mysqli_query($conn, $query);
        
        if($result){

            $data = [
                "status" => 200,
                "message" => "Event Attendant Updated Successfully",
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

function updateEventAttendee2($eventattendeeInput, $eventattendeeParams){

    global $conn;

    if(!isset($eventattendeeParams['Attendant_ID'])){

        return error422("Attendant ID Not Found:");
    }elseif($eventattendeeParams['Attendant_ID'] == null){

        return error422("Enter The Attendant ID:");
    }

    $attendantID = mysqli_real_escape_string($conn, $eventattendeeParams["Attendant_ID"]);

    $eventeval = mysqli_real_escape_string($conn, $eventattendeeInput["Event_eval"]);
    $eventcomment = mysqli_real_escape_string($conn, $eventattendeeInput["Event_comment"]);

    if(empty(trim($eventeval))){

        return error422("Enter The Event Evaluation: ");
    }elseif(empty(trim($eventcomment))){

        return error422("Enter The Event Comment: ");
    }else{
        $query = "UPDATE event_attendee SET Event_eval='$eventeval',Event_comment='$eventcomment' WHERE Attendant_ID='$attendantID' LIMIT 1";
        $result = mysqli_query($conn, $query);
        
        if($result){

            $data = [
                "status" => 200,
                "message" => "Event Attendant Updated Successfully",
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

function getEventAttendee($eventattendeeParams) {
   
    global $conn;

    if (empty($eventattendeeParams['Event_ID']) && empty($eventattendeeParams['Attendant_ID'])) {
        return error422("Enter either Attendant ID or Event ID.");
    }

    if (!empty($eventattendeeParams['Attendant_ID'])) {
        $AttendantID = mysqli_real_escape_string($conn, $eventattendeeParams['Attendant_ID']);
        $query = "SELECT * FROM event_attendee WHERE Attendant_ID='$AttendantID'";
    } elseif (!empty($eventattendeeParams['Event_ID'])) {
        $eventID = mysqli_real_escape_string($conn, $eventattendeeParams['Event_ID']);
        $query = "SELECT * FROM event_attendee WHERE Event_ID='$eventID'";
    } else {

        return error422("Invalid input. Unable to process request.");
    }

    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $attendee = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $attendee[] = $row;
            }

            $data = [
                "status" => 200,
                "message" => "Event Attendee(s) Fetched Successfully",
                "data" => $attendee
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);
        } else {
            $data = [
                "status" => 404,
                "message" => "No Event Attendee(s) Found",
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

function getEventAttendeeList(){

    global $conn;

    $query = "SELECT * FROM event_attendee";
    $query_run = mysqli_query($conn, $query);

    if($query_run){

        if(mysqli_num_rows($query_run) > 0){

            $res= mysqli_fetch_all($query_run, MYSQLI_ASSOC);
        
            $data = [
                "status" => 200,
                "message" => "Event Attendant List Fetched Successfully",
                "data" => $res
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);

        }else{
            $data = [
                "status" => 404,
                "message" => "No Event Attendant Found",
            ];
            header("HTTP/1.0 404 No Event Attendant Found");
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

function deleteEventAttendee($eventattendeeParams){

    global $conn;

    if(!isset($eventattendeeParams['Attendant_ID'])){

        return error422("Attendant ID Not Found:");

    }elseif($eventattendeeParams['Attendant_ID'] == null){

        return error422("Enter The Attendant ID:");
    }

    $attendantID = mysqli_real_escape_string($conn, $eventattendeeParams["Attendant_ID"]);

    $query = "DELETE FROM event_attendee WHERE Attendant_ID='$attendantID' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if($result){

        $data = [
            "status" => 200,
            "message" => "Event Attendant Deleted Successfully",
        ];
        header("HTTP/1.0 200 Deleted");
        return json_encode($data);

    }else{

        $data = [
            "status" => 404,
            "message" => "Event Attendant Not Found",
        ];
        header("HTTP/1.0 404 Not Found");
        return json_encode($data);
    }
}

?>