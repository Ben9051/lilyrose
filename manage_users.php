<?php
session_start();
require_once "db.php";

if ($_SESSION['role'] !== 'admin') {
    die("Unauthorized access");
}

// Handle new cashier addition
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_cashier'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 

    $conn->query("INSERT INTO users (name, email, password, role, status) VALUES ('$name', '$email', '$password', 'cashier', 'active')");
    header("Location: manage_users.php");
    exit();
}

// Handle block/unblock user
if (isset($_GET['block'])) {
    $id = $_GET['block'];
    $conn->query("UPDATE users SET status='blocked' WHERE id='$id'");
    header("Location: manage_users.php");
    exit();
}

if (isset($_GET['unblock'])) {
    $id = $_GET['unblock'];
    $conn->query("UPDATE users SET status='active' WHERE id='$id'");
    header("Location: manage_users.php");
    exit();
}

// Handle delete user
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM users WHERE id='$id'");
    header("Location: manage_users.php");
    exit();
}

// Fetch all users (except admin)
$users = $conn->query("SELECT * FROM users WHERE role != 'admin'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Manage Users (Cashiers Only)</h2>

        <h3>Add Cashier</h3>
        <form method="POST">
            <div class="mb-3">
                <label>Cashier Name:</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Cashier Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password:</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" name="add_cashier" class="btn btn-success">Add Cashier</button>
        </form>

        <h3 class="mt-4">All Users (Cashiers & Customers)</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = $users->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $user['name']; ?></td>
                        <td><?= $user['email']; ?></td>
                        <td><?= ucfirst($user['role']); ?></td>
                        <td><?= ucfirst($user['status']); ?></td>
                        <td>
                            <a href="view_user.php?id=<?= $user['id']; ?>" class="btn btn-primary">View</a>
                            <?php if ($user['status'] === 'active') { ?>
                                <a href="manage_users.php?block=<?= $user['id']; ?>" class="btn btn-warning">Block</a>
                            <?php } else { ?>
                                <a href="manage_users.php?unblock=<?= $user['id']; ?>" class="btn btn-success">Unblock</a>
                            <?php } ?>
                            <a href="manage_users.php?delete=<?= $user['id']; ?>" class="btn btn-danger" onclick="return confirm('Delete this user?');">Delete</a>
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
