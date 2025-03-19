<?php
session_start();
require_once "db.php";

// Ensure only logged-in admin can access this page
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.html");
    exit();
}

// Fetch total users, orders, services, and gallery items
$totalUsers = $conn->query("SELECT COUNT(*) FROM users")->fetch_row()[0];
$totalOrders = $conn->query("SELECT COUNT(*) FROM orders")->fetch_row()[0];
$totalServices = $conn->query("SELECT COUNT(*) FROM services")->fetch_row()[0];
$totalGallery = $conn->query("SELECT COUNT(*) FROM gallery")->fetch_row()[0];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Lilyrose Hotel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: url('uploads/WhatsApp%20Image%202025-03-13%20at%2014.54.02_e59446e7.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
        }
        .header, .footer {
            background: maroon;
            color: white;
            text-align: center;
            padding: 15px;
        }
        .dashboard-container {
            background: rgba(0, 0, 0, 0.8);
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }
        .card {
            background: rgba(255, 255, 255, 0.9);
            color: black;
        }
        .btn {
            margin: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Admin Dashboard - Lilyrose Hotel</h2>
    </div>

    <div class="container dashboard-container">
        <h3 class="text-center mb-4">Welcome, <?= $_SESSION['admin_name']; ?>!</h3>
        <div class="row text-center">
            <div class="col-md-3">
                <div class="card p-3">
                    <h5>Total Users</h5>
                    <p><?= $totalUsers; ?></p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3">
                    <h5>Total Orders</h5>
                    <p><?= $totalOrders; ?></p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3">
                    <h5>Total Services</h5>
                    <p><?= $totalServices; ?></p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3">
                    <h5>Total Gallery Items</h5>
                    <p><?= $totalGallery; ?></p>
                </div>
            </div>
        </div>

        <div class="mt-4 text-center">
            <a href="manage_users.php" class="btn btn-primary">Manage Users</a>
            <a href="manage_orders.php" class="btn btn-success">Manage Orders</a>
            <a href="manage_services.php" class="btn btn-warning">Manage Services</a>
            <a href="manage_gallery.php" class="btn btn-danger">Manage Gallery</a>
            <a href="admin_logout.php" class="btn btn-secondary">Logout</a>
        </div>
    </div>

    <div class="footer">
        <p>© <?= date("Y"); ?> Lilyrose Hotel. All rights reserved.</p>
    </div>
</body>
</html>
