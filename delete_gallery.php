<?php
session_start();
require_once "db.php";

if ($_SESSION['role'] !== 'admin') {
    die("Unauthorized access");
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn->query("DELETE FROM gallery WHERE id='$id'");
    header("Location: manage_gallery.php");
    exit();
}
?>
