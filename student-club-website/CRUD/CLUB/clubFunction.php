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

function addClub($clubInput){

    global $conn;

    $name = mysqli_real_escape_string($conn, $clubInput["Club_name"]);
    $desc = mysqli_real_escape_string($conn, $clubInput["Club_description"]);
    $logo = mysqli_real_escape_string($conn, $clubInput["Club_logo"]);

    if(empty(trim($name))){

        return error422("Enter The Club Name: ");
    }elseif(empty(trim($desc))){

        return error422("Enter The Club Description: ");
    }elseif(empty(trim($logo))){

        return error422("Enter The Club Logo: ");
    }else{
        $query = "INSERT INTO club (Club_name,Club_description,Club_logo) VALUES ('$name','$desc','$logo')";
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

function updateClub($clubInput, $clubParams){

    global $conn;

    if(!isset($clubParams['Club_ID'])){

        return error422("Club ID Not Found:");
    }elseif($clubParams['Club_ID'] == null){

        return error422("Enter The Club ID:");
    }

    $clubID = mysqli_real_escape_string($conn, $clubParams["Club_ID"]);

    $name = mysqli_real_escape_string($conn, $clubInput["Club_name"]);
    $desc = mysqli_real_escape_string($conn, $clubInput["Club_description"]);
    $logo = mysqli_real_escape_string($conn, $clubInput["Club_logo"]);

    if(empty(trim($name))){

        return error422("Enter The Club Name: ");
    }elseif(empty(trim($desc))){

        return error422("Enter The Club Description: ");
    }elseif(empty(trim($logo))){

        return error422("Enter The Club Logo: ");
    }else{
        $query = "UPDATE club SET Club_name='$name',Club_description='$desc',Club_logo='$logo' WHERE Club_ID='$clubID' LIMIT 1";
        $result = mysqli_query($conn, $query);
        
        if($result){

            $data = [
                "status" => 200,
                "message" => "Club Updated Successfully",
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

function getClub($clubParams){

    global $conn;

    if($clubParams['Club_ID'] == null){

        return error422("Enter The CLub ID: ");
    }
    $clubID = mysqli_real_escape_string($conn, $clubParams['Club_ID']);
    $query = "SELECT * FROM club WHERE Club_ID='$clubID' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if($result){

        if(mysqli_num_rows($result) == 1){

            $res = mysqli_fetch_assoc($result);

            $data = [
                "status" => 200,
                "message" => " Club Fetched Successfully",
                "data" => $res
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);

        }else{

        $data = [
            "status" => 404,
            "message" => " No Club Found",
        ];
        header("HTTP/1.0 404 No Club Found");
        return json_encode($data);

        }
    }else{
        $data = [
            "status" => 500,
            "message" => " Internal Server Error",
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}

function getClubList(){

    global $conn;

    $query = "SELECT * FROM club";
    $query_run = mysqli_query($conn, $query);

    if($query_run){

        if(mysqli_num_rows($query_run) > 0){

            $res= mysqli_fetch_all($query_run, MYSQLI_ASSOC);
        
            $data = [
                "status" => 200,
                "message" => "Club List Fetched Successfully",
                "data" => $res
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);

        }else{
            $data = [
                "status" => 404,
                "message" => "No Club Found",
            ];
            header("HTTP/1.0 404 No Club Found");
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

function deleteClub($clubParams){

    global $conn;

    if(!isset($clubParams['Club_ID'])){

        return error422("Club ID Not Found:");
    }elseif($clubParams['Club_ID'] == null){

        return error422("Enter The Club ID:");
    }

    $clubID = mysqli_real_escape_string($conn, $clubParams["Club_ID"]);

    $query = "DELETE FROM club WHERE Club_ID='$clubID' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if($result){

        $data = [
            "status" => 200,
            "message" => "Club Deleted Successfully",
        ];
        header("HTTP/1.0 200 Deleted");
        return json_encode($data);

    }else{

        $data = [
            "status" => 404,
            "message" => "Club Not Found",
        ];
        header("HTTP/1.0 404 Not Found");
        return json_encode($data);
    }
}

?>