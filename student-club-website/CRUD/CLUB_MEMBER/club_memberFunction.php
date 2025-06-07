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

function addClubMember($clubmemberInput){

    global $conn;

    $clubID = mysqli_real_escape_string($conn, $clubmemberInput["Club_ID"]);
    $studentID = mysqli_real_escape_string($conn, $clubmemberInput["Student_ID"]);
    $role = mysqli_real_escape_string($conn, $clubmemberInput["Member_role"]);

    if(empty(trim($clubID))){

        return error422("Enter The Club ID: ");
    }elseif(empty(trim($studentID))){

        return error422("Enter The Student ID: ");
    }elseif(empty(trim($role))){

        return error422("Enter The Member Role: ");
    }else{
        $query = "INSERT INTO club_member (Club_ID,Student_ID,Member_role) VALUES ('$clubID','$studentID','$role')";
        $result = mysqli_query($conn, $query);
        
        if($result){

            $data = [
                "status" => 201,
                "message" => "Club Member Added Successfully",
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

function updateClubMember($clubmemberInput, $clubmemberParams){

    global $conn;

    if(!isset($clubmemberParams['Membership_ID'])){
       
        return error422("Membership ID Not Found:");
    }elseif($clubmemberParams['Membership_ID'] == null){

        return error422("Enter The Membership ID:");
    }

    $membershipID = mysqli_real_escape_string($conn, $clubmemberParams["Membership_ID"]);

    $clubID = mysqli_real_escape_string($conn, $clubmemberInput["Club_ID"]);
    $studentID = mysqli_real_escape_string($conn, $clubmemberInput["Student_ID"]);
    $role = mysqli_real_escape_string($conn, $clubmemberInput["Member_role"]);

    if(empty(trim($clubID))){

        return error422("Enter The Club ID: ");
    }elseif(empty(trim($studentID))){

        return error422("Enter The Student ID: ");
    }elseif(empty(trim($role))){

        return error422("Enter The Student Role: ");
    }else{
        $query = "UPDATE club_member SET Club_ID='$clubID',Student_ID='$studentID',Member_role='$role' WHERE Membership_ID='$membershipID' LIMIT 1";
        $result = mysqli_query($conn, $query);
        
        if($result){

            $data = [
                "status" => 200,
                "message" => "Club Member Updated Successfully",
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

function getClubMember($clubmemberParams) {
   
    global $conn;

    if (empty($clubmemberParams['Club_ID']) && empty($clubmemberParams['Membership_ID'])) {
        return error422("Enter either Club ID or Membership ID.");
    }

    if (!empty($clubmemberParams['Club_ID'])) {
        $clubID = mysqli_real_escape_string($conn, $clubmemberParams['Club_ID']);
        $query = "SELECT * FROM club_member WHERE Club_ID='$clubID'";
    }
    elseif (!empty($clubmemberParams['Membership_ID'])) {
        $membershipID = mysqli_real_escape_string($conn, $clubmemberParams['Membership_ID']);
        $query = "SELECT * FROM club_member WHERE Membership_ID='$membershipID'";
    }

    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $members = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $members[] = $row;
            }

            $data = [
                "status" => 200,
                "message" => "Club Member(s) Fetched Successfully",
                "data" => $members
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);
        } else {
            $data = [
                "status" => 404,
                "message" => "No Club Member(s) Found",
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

function getClubMemberList(){

    global $conn;

    $query = "SELECT * FROM club_member";
    $query_run = mysqli_query($conn, $query);

    if($query_run){

        if(mysqli_num_rows($query_run) > 0){

            $res= mysqli_fetch_all($query_run, MYSQLI_ASSOC);
        
            $data = [
                "status" => 200,
                "message" => "Club Member List Fetched Successfully",
                "data" => $res
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);

        }else{
            $data = [
                "status" => 404,
                "message" => "No Club member Found",
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

function deleteClubMember($clubmemberParams){

    global $conn;

    if(!isset($clubmemberParams['Membership_ID'])){

        return error422("Membership ID Not Found:");
    }elseif($clubmemberParams['Membership_ID'] == null){

        return error422("Enter The Membership ID:");
    }

    $membershipID = mysqli_real_escape_string($conn, $clubmemberParams["Membership_ID"]);

    $query = "DELETE FROM club_member WHERE Membership_ID='$membershipID' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if($result){

        $data = [
            "status" => 200,
            "message" => "Club Member Deleted Successfully",
        ];
        header("HTTP/1.0 200 Deleted");
        return json_encode($data);

    }else{

        $data = [
            "status" => 404,
            "message" => "Club Member Not Found",
        ];
        header("HTTP/1.0 404 Not Found");
        return json_encode($data);
    }
}

?>