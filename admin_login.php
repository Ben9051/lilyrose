<?php
session_start();
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Fetch admin details from users table where role = admin
    $query = $conn->prepare("SELECT id, name, password FROM users WHERE email = ? AND role = 'admin'");
    $query->bind_param("s", $email);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows == 1) {
        $admin = $result->fetch_assoc();
        
        // Compare directly since passwords are not hashed
        if ($password === $admin["password"]) {  
            $_SESSION["admin_id"] = $admin["id"];
            $_SESSION["admin_name"] = $admin["name"];
            $_SESSION["role"] = "admin"; // Set admin role session

            echo json_encode(["status" => "success", "redirect" => "admin_dashboard.php"]);
            exit();
        }
    }
    
    echo json_encode(["status" => "error", "message" => "Invalid credentials"]);
}
?>
