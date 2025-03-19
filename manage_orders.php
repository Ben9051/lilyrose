<?php
session_start();
require_once "db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit();
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
$query = "SELECT * FROM orders WHERE id LIKE '%$search%' OR user_email LIKE '%$search%'";
$result = $conn->query($query);

if (isset($_GET['update']) && isset($_GET['id'])) {
    $status = $_GET['update'];
    $id = $_GET['id'];
    $conn->query("UPDATE orders SET status='$status' WHERE id='$id'");
    header("Location: manage_orders.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Manage Orders</h2>
        <form class="mb-3">
            <input type="text" name="search" placeholder="Search Orders..." value="<?= htmlspecialchars($search); ?>">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User Email</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $order['id']; ?></td>
                        <td><?= $order['user_email']; ?></td>
                        <td><?= $order['total_amount']; ?></td>
                        <td><?= ucfirst($order['status']); ?></td>
                        <td>
                            <a href="?update=Processing&id=<?= $order['id']; ?>" class="btn btn-warning">Mark as Processing</a>
                            <a href="?update=Completed&id=<?= $order['id']; ?>" class="btn btn-success">Mark as Completed</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body><br>
<form action="admin_dashboard.php" method="post" style="text-align: center; margin-top: 20px;">
    <button type="submit" style="padding: 10px 20px; font-size: 16px; background-color: maroon; color: white; border: none; cursor: pointer;">Exit</button>
</form>

</html>
