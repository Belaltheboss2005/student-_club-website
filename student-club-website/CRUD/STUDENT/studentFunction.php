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

function addStudent($studentInput){

    global $conn;


    $name = mysqli_real_escape_string($conn, $studentInput["Student_name"]);
    $username = mysqli_real_escape_string($conn, $studentInput["Student_username"]);
    $img = mysqli_real_escape_string($conn, $studentInput["Student_img"]);
    $phone = mysqli_real_escape_string($conn, $studentInput["Student_phone"]);
    $year = mysqli_real_escape_string($conn, $studentInput["Student_year"]);
    $pass = mysqli_real_escape_string($conn, $studentInput["Student_pass"]);

    if(empty(trim($name))){

        return error422("Enter The Name: ");
    }elseif(empty(trim($username))){

        return error422("Enter The Username: ");
    }elseif(empty(trim($img))){

        return error422("Enter The image: ");
    }elseif(empty(trim($pass))){

        return error422("Enter The Password: ");
    }elseif(empty(trim($phone))){

        return error422("Enter The Phone: ");
    }elseif(empty(trim($year))){

        return error422("Enter The Year: ");
    }else{
        $pass = password_hash($pass, PASSWORD_DEFAULT);
        $query = "INSERT INTO student (Student_name,Student_username,Student_img,Student_pass,Student_phone,Student_year) VALUES ('$name','$username','$img','$pass','$phone','$year')";
        $result = mysqli_query($conn, $query);
        
        if($result){

            $data = [
                "status" => 201,
                "message" => "Student Added Successfully",
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

function updateStudent($studentInput, $studentParams){

    global $conn;

    if(!isset($studentParams['Student_ID'])){

        return error422("Student ID Not Found:");
    }elseif($studentParams['Student_ID'] == null){

        return error422("Enter The Student ID:");
    }

    $studentID = mysqli_real_escape_string($conn, $studentParams["Student_ID"]);

    $name = mysqli_real_escape_string($conn, $studentInput["Student_name"]);
    $username = mysqli_real_escape_string($conn, $studentInput["Student_username"]);
    $img = mysqli_real_escape_string($conn, $studentInput["Student_img"]);
    $phone = mysqli_real_escape_string($conn, $studentInput["Student_phone"]);
    $year = mysqli_real_escape_string($conn, $studentInput["Student_year"]);
    $pass = mysqli_real_escape_string($conn, $studentInput["Student_pass"]);

    if(empty(trim($name))){

        return error422("Enter The Name: ");
    }elseif(empty(trim($username))){

        return error422("Enter The Username: ");
    }elseif(empty(trim($img))){

        return error422("Enter The image: ");
    }elseif(empty(trim($pass))){

        return error422("Enter The Password: ");
    }elseif(empty(trim($phone))){

        return error422("Enter The Phone Number: ");
    }elseif(empty(trim($year))){

        return error422("Enter The Year: ");
    }else{
        $pass = password_hash($pass, PASSWORD_DEFAULT);
        $query = "UPDATE student SET Student_name='$name',Student_username='$username',Student_img='$img',Student_phone='$phone',Student_year='$year',Student_pass='$pass' WHERE Student_ID='$studentID' LIMIT 1";
        $result = mysqli_query($conn, $query);
        
        if($result){

            $data = [
                "status" => 200,
                "message" => "Student Updated Successfully",
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

function getStudent($studentParams){

    global $conn;

    if($studentParams['Student_ID'] == null){

        return error422("Enter The ID: ");
    }
    $studentID = mysqli_real_escape_string($conn, $studentParams['Student_ID']);
    $query = "SELECT * FROM student WHERE Student_ID='$studentID' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if($result){

        if(mysqli_num_rows($result) == 1){

            $res = mysqli_fetch_assoc($result);

            $data = [
                "status" => 200,
                "message" => " Student Fetched Successfully",
                "data" => $res
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);

        }else{

        $data = [
            "status" => 404,
            "message" => " No Student Found",
        ];
        header("HTTP/1.0 404 No Student Found");
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

function getStudentList(){

    global $conn;

    $query = "SELECT * FROM student";
    $query_run = mysqli_query($conn, $query);

    if($query_run){

        if(mysqli_num_rows($query_run) > 0){

            $res= mysqli_fetch_all($query_run, MYSQLI_ASSOC);
        
            $data = [
                "status" => 200,
                "message" => "Student List Fetched Successfully",
                "data" => $res
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);

        }else{
            $data = [
                "status" => 404,
                "message" => "No Student Found",
            ];
            header("HTTP/1.0 404 No Student Found");
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

function deleteStudent($studentParams){

    global $conn;

    if(!isset($studentParams['Student_ID'])){

        return error422("Student ID Not Found:");
    }elseif($studentParams['Student_ID'] == null){

        return error422("Enter The Student ID:");
    }

    $studentID = mysqli_real_escape_string($conn, $studentParams["Student_ID"]);

    $query = "DELETE FROM student WHERE Student_ID='$studentID' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if($result){

        $data = [
            "status" => 200,
            "message" => "Student Deleted Successfully",
        ];
        header("HTTP/1.0 200 Deleted");
        return json_encode($data);

    }else{

        $data = [
            "status" => 404,
            "message" => "Student Not Found",
        ];
        header("HTTP/1.0 404 Not Found");
        return json_encode($data);
    }
}

?>