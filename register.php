<?php
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);
    $role = 'user'; // Default role

    if (!empty($name) && !empty($email) && !empty($phone) && !empty($password)) {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo json_encode(["status" => "error", "message" => "Email already exists. Try logging in."]);
        } else {
            $stmt->close();

            // Insert new user (WITHOUT OTP)
            $stmt = $conn->prepare("INSERT INTO users (name, email, phone, password, role) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $name, $email, $phone, $password, $role);

            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "redirect" => "register.html"]); // Redirects to register.html
            } else {
                echo json_encode(["status" => "error", "message" => "Error signing up. Try again."]);
            }
        }
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "All fields are required."]);
    }
}
?>
