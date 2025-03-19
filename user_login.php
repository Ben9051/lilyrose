<?php
session_start();
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    $query = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $query->bind_param("s", $email);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Direct password check (since no hashing)
        if ($password === $user["password"]) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["name"];
            $_SESSION["role"] = $user["role"]; // Store role in session

            // Redirect based on role
            if ($user["role"] === "admin") {
                echo json_encode(["status" => "success", "redirect" => "admin_dashboard.php"]);
            } elseif ($user["role"] === "cashier") {
                echo json_encode(["status" => "success", "redirect" => "cashier_dashboard.php"]);
            } else {
                echo json_encode(["status" => "success", "redirect" => "lily.php"]);
            }
            exit();
        }
    }

    echo json_encode(["status" => "error", "message" => "Invalid email or password"]);
    exit();
}
?>