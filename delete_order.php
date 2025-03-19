<?php
session_start();
include '../db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

if (isset($_GET['id'])) {
    $order_id = $_GET['id'];

    // Delete order
    $sql = "DELETE FROM orders WHERE id = $order_id";
    if (mysqli_query($conn, $sql)) {
        header('Location: admin_orders.php?msg=Order deleted');
        exit();
    } else {
        header('Location: admin_orders.php?msg=Error deleting order');
        exit();
    }
}
?>
