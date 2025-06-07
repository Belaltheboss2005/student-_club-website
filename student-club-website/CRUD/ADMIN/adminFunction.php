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

function addAdmin($adminInput){

    global $conn;


    $name = mysqli_real_escape_string($conn, $adminInput["Admin_username"]);
    $pass = mysqli_real_escape_string($conn, $adminInput["Admin_pass"]);

    if(empty(trim($name))){

        return error422("Enter The Username: ");
    }elseif(empty(trim($pass))){

        return error422("Enter The Password: ");
    }else{
        $pass = password_hash($pass, PASSWORD_DEFAULT);
        $query = "INSERT INTO admin (Admin_username,Admin_pass) VALUES ('$name','$pass')";
        $result = mysqli_query($conn, $query);
        
        if($result){

            $data = [
                "status" => 201,
                "message" => "Admin Added Successfully",
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

function updateAdmin($adminInput, $adminParams){

    global $conn;

    if(!isset($adminParams['Admin_ID'])){

        return error422("Admin ID Not Found:");
    }elseif($adminParams['Admin_ID'] == null){

        return error422("Enter The Admin ID:");
    }

    $adminID = mysqli_real_escape_string($conn, $adminParams["Admin_ID"]);

    $username = mysqli_real_escape_string($conn, $adminInput["Admin_username"]);
    $pass = mysqli_real_escape_string($conn, $adminInput["Admin_pass"]);

    if(empty(trim($username))){

        return error422("Enter The Username: ");
    }elseif(empty(trim($pass))){

        return error422("Enter The Password: ");
    }else{
        $pass = password_hash($pass, PASSWORD_DEFAULT);
        $query = "UPDATE admin SET Admin_username='$username',Admin_pass='$pass' WHERE Admin_ID='$adminID' LIMIT 1";
        $result = mysqli_query($conn, $query);
        
        if($result){

            $data = [
                "status" => 200,
                "message" => "Admin Updated Succesfully",
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

function getAdmin($adminParams){

    global $conn;

    if($adminParams['Admin_username'] == null){

        return error422("Enter The Username: ");
    }
    $adminUsername = mysqli_real_escape_string($conn, $adminParams['Admin_username']);
    $query = "SELECT * FROM admin WHERE Admin_username='$adminUsername' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if($result){

        if(mysqli_num_rows($result) == 1){

            $res = mysqli_fetch_assoc($result);

            $data = [
                "status" => 200,
                "message" => " Admin Fetched Successfully",
                "data" => $res
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);

        }else{

        $data = [
            "status" => 404,
            "message" => " No Admin Found",
        ];
        header("HTTP/1.0 404 No Admin Found");
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

function getAdminList(){

    global $conn;

    $query = "SELECT * FROM admin";
    $query_run = mysqli_query($conn, $query);

    if($query_run){

        if(mysqli_num_rows($query_run) > 0){

            $res= mysqli_fetch_all($query_run, MYSQLI_ASSOC);
        
            $data = [
                "status" => 200,
                "message" => "Admin List Fetched Successfully",
                "data" => $res
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);

        }else{
            $data = [
                "status" => 404,
                "message" => "No Admin Found",
            ];
            header("HTTP/1.0 404 No Admin Found");
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

function deleteAdmin($adminParams){

    global $conn;

    if(!isset($adminParams['Admin_ID'])){

        return error422("Admin ID Not Found:");

    }elseif($adminParams['Admin_ID'] == null){

        return error422("Enter The Admin ID:");
    }

    $adminID = mysqli_real_escape_string($conn, $adminParams["Admin_ID"]);

    $query = "DELETE FROM admin WHERE Admin_ID='$adminID' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if($result){

        $data = [
            "status" => 200,
            "message" => "Admin Deleted Successfully",
        ];
        header("HTTP/1.0 200 Deleted");
        return json_encode($data);

    }else{

        $data = [
            "status" => 404,
            "message" => "Admin Not Found",
        ];
        header("HTTP/1.0 404 Not Found");
        return json_encode($data);
    }
}

?>