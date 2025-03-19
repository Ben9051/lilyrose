<?php
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {
    $image_name = $_FILES["image"]["name"];
    $image_tmp = $_FILES["image"]["tmp_name"];
    $upload_directory = "uploads/" . $image_name; // Path to save images

    if (move_uploaded_file($image_tmp, $upload_directory)) {
        $stmt = $conn->prepare("INSERT INTO gallery (image) VALUES (?)");
        $stmt->bind_param("s", $upload_directory);
        $stmt->execute();
        echo "Image uploaded successfully!";
    } else {
        echo "Error uploading image.";
    }
}
?>
