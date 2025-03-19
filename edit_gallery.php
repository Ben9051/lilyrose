<?php
session_start();
require_once "db.php";

if ($_SESSION['role'] !== 'admin') {
    die("Unauthorized access");
}

$id = $_GET['id'];
$gallery_query = $conn->query("SELECT * FROM gallery WHERE id='$id'");
$gallery = $gallery_query->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $description = $_POST['description'];

    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $target = "uploads/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
        $conn->query("UPDATE gallery SET image='$target', description='$description' WHERE id='$id'");
    } else {
        $conn->query("UPDATE gallery SET description='$description' WHERE id='$id'");
    }
    
    header("Location: manage_gallery.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Gallery</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Edit Gallery Item</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Description:</label>
                <textarea name="description" class="form-control" required><?= $gallery['description']; ?></textarea>
            </div>
            <div class="mb-3">
                <label>Upload New Image (optional):</label>
                <input type="file" name="image" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>
