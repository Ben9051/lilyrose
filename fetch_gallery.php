<?php
require_once "db.php"; // Include database connection

$query = $conn->query("SELECT * FROM gallery ORDER BY id DESC");

while ($row = $query->fetch_assoc()) {
    if (!isset($row["image_path"])) {
        die("Error: 'image_path' column is missing in the database.");
    }

    echo '<div class="gallery-item">';
    echo '<img src="' . htmlspecialchars($row["image_path"]) . '" alt="Gallery Image" width="200" height="150">';
    echo '<p>' . htmlspecialchars($row["description"] ?? ""); // Avoid undefined key error
    echo '</div>';
}
?>
