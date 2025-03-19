<?php
session_start();
include '../db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

if (isset($_GET['id']) && isset($_GET['status'])) {
    $order_id = $_GET['id'];
    $new_status = $_GET['status'];

    // Update order status
    $sql = "UPDATE orders SET status = '$new_status' WHERE id = $order_id";
    if (mysqli_query($conn, $sql)) {
        header('Location: admin_orders.php?msg=Order updated');
        exit();
    } else {
        header('Location: admin_orders.php?msg=Error updating order');
        exit();
    }
}
?>
