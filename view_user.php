<?php
session_start();
require_once "db.php";

if ($_SESSION['role'] !== 'admin') {
    die("Unauthorized access");
}

if (!isset($_GET['id'])) {
    die("Invalid user ID");
}

$id = $_GET['id'];
$user = $conn->query("SELECT * FROM users WHERE id='$id'")->fetch_assoc();
$orders = $conn->query("SELECT * FROM orders WHERE user_id='$id'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>User Details</h2>
        <p><strong>Name:</strong> <?= $user['name']; ?></p>
        <p><strong>Email:</strong> <?= $user['email']; ?></p>
        <p><strong>Role:</strong> <?= ucfirst($user['role']); ?></p>
        <p><strong>Status:</strong> <?= ucfirst($user['status']); ?></p>

        <h3>Order History</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Service</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = $orders->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $order['id']; ?></td>
                        <td><?= $order['service']; ?></td>
                        <td><?= $order['quantity']; ?></td>
                        <td>Ksh <?= $order['total']; ?></td>
                        <td><?= ucfirst($order['status']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <a href="manage_users.php" class="btn btn-secondary">Back</a>
        <?php if ($user['status'] === 'active') { ?>
            <a href="manage_users.php?block=<?= $user['id']; ?>" class="btn btn-warning">Block</a>
        <?php } else { ?>
            <a href="manage_users.php?unblock=<?= $user['id']; ?>" class="btn btn-success">Unblock</a>
        <?php } ?>
        <a href="manage_users.php?delete=<?= $user['id']; ?>" class="btn btn-danger" onclick="return confirm('Delete this user?');">Delete</a>
    </div>
</body>
</html>
