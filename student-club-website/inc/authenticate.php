<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require "../inc/connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputData = json_decode(file_get_contents("php://input"), true); // Get JSON input

    if (isset($inputData['username']) && isset($inputData['password'])) {
        $username = mysqli_real_escape_string($conn, $inputData['username']);
        $password = mysqli_real_escape_string($conn, $inputData['password']);

        $adminQuery = "SELECT * FROM admin WHERE Admin_username = '$username'";
        $adminResult = mysqli_query($conn, $adminQuery);

        if ($adminResult && mysqli_num_rows($adminResult) === 1) {
            $admin = mysqli_fetch_assoc($adminResult);

            if (password_verify($password, $admin['Admin_pass'])) {
                echo json_encode([
                    "status" => 200,
                    "message" => "Login successful as Admin",
                    "role" => "admin",
                    "data" => [
                        "Admin_ID" => $admin['Admin_ID'],
                        "Admin_username" => $admin['Admin_username']
                    ]
                ]);
                exit();
            }
        }

        $studentQuery = "SELECT * FROM student WHERE Student_username = '$username'";
        $studentResult = mysqli_query($conn, $studentQuery);

        if ($studentResult && mysqli_num_rows($studentResult) === 1) {
            $student = mysqli_fetch_assoc($studentResult);

            if (password_verify($password, $student['Student_pass'])) {
                echo json_encode([
                    "status" => 200,
                    "message" => "Login successful as Student",
                    "role" => "student",
                    "data" => [
                        "Student_ID" => $student['Student_ID'],
                        "Student_name" => $student['Student_name'],
                        "Student_username" => $student['Student_username'],
                        "Student_phone" => $student['Student_phone'],
                        "Student_year" => $student['Student_year']
                    ]
                ]);
                exit();
            }
        }

        echo json_encode([
            "status" => 404,
            "message" => "User not registered or invalid credentials"
        ]);
    } else {
        echo json_encode([
            "status" => 422,
            "message" => "Username and password are required"
        ]);
    }
} else {
    echo json_encode([
        "status" => 405,
        "message" => "Method not allowed"
    ]);
}

exit();
?>
