<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$name = $_SESSION['name'];
$email = $_SESSION['email'];
$phone = $_SESSION['phone'];
$role = ucfirst($_SESSION['role']); // Capitalizes the first letter
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Lilyrose Hotel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: url('project images/admin_bg.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
        }
        .profile-container {
            max-width: 500px;
            margin: 100px auto;
            background: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 10px;
        }
        .header, .footer {
            background: maroon;
            padding: 10px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
        }
        .logout-btn {
            margin-top: 15px;
        }
    </style>
</head>
<body>

    <div class="header">Welcome, <?php echo $name; ?></div>

    <div class="container">
        <div class="profile-container">
            <h2 class="text-center">My Profile</h2>
            <p><strong>Name:</strong> <?php echo $name; ?></p>
            <p><strong>Email:</strong> <?php echo $email; ?></p>
            <p><strong>Phone:</strong> <?php echo $phone; ?></p>
            <p><strong>Role:</strong> <?php echo $role; ?></p>

            <a href="lily.php" class="btn btn-primary w-100">Go to Home</a>
            
            <form action="logout.php" method="POST">
                <button type="submit" class="btn btn-danger w-100 logout-btn">Logout</button>
            </form>
        </div>
    </div>

    <div class="footer">Lilyrose Hotel &copy; 2025</div>

</body>
</html>
