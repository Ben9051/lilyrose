<?php
include 'db.php';

$user_id = $_POST['user_id'];
$password = $_POST['password'];

// Get user password
$query = $conn->prepare("SELECT password FROM users WHERE id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['password'])) {
    $deleteQuery = $conn->prepare("DELETE FROM users WHERE id = ?");
    $deleteQuery->bind_param("i", $user_id);
    $deleteQuery->execute();
    echo "Account Deleted";
} else {
    echo "Wrong Password";
}
?>
