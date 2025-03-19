<?php
session_start();
require_once "db.php";

if ($_SESSION['role'] !== 'admin') {
    die("Unauthorized access");
}

// Handle new gallery media addition
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_media'])) {
  $description = $_POST['description'];
  $media = $_FILES['media']['name'];
  $media_type = pathinfo($media, PATHINFO_EXTENSION);

  // Ensure correct path before storing in the database
  $filename = basename($_FILES['media']['name']);
$target = "uploads/" . $filename;
move_uploaded_file($_FILES['media']['tmp_name'], $target);

$conn->query("INSERT INTO gallery (media, media_type, description, likes, dislikes) VALUES ('$filename', '$media_type', '$description', 0, 0)");

  
  if (move_uploaded_file($_FILES['media']['tmp_name'], $target)) {
      $conn->query("INSERT INTO gallery (media, media_type, description, likes, dislikes) 
                    VALUES ('$target', '$media_type', '$description', 0, 0)");
      header("Location: manage_gallery.php");
      exit();
  } else {
      echo "File upload failed!";
  }
}

// Handle delete gallery item
if (isset($_GET['delete_media'])) {
    $id = $_GET['delete_media'];
    $conn->query("DELETE FROM gallery WHERE id='$id'");
    header("Location: manage_gallery.php");
    exit();
}

// Fetch all gallery media
$gallery = $conn->query("SELECT * FROM gallery");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Gallery</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Manage Gallery</h2>

        <h3>Add New Media</h3>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Description:</label>
                <textarea name="description" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label>Upload Image/Video:</label>
                <input type="file" name="media" class="form-control" required>
            </div>
            <button type="submit" name="add_media" class="btn btn-success">Add Media</button>
        </form>

        <h3 class="mt-4">Gallery</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Media</th>
                    <th>Description</th>
                    <th>Likes</th>
                    <th>Dislikes</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($media = $gallery->fetch_assoc()) { 
                    $filename = htmlspecialchars($media['media']); // Ensure safe output
                ?>
                    <tr>
                        <td>
                            <?php if (in_array($media['media_type'], ['jpg', 'jpeg', 'png', 'gif'])) { ?>
                                <img src="uploads/<?= $filename; ?>" width="50">
                            <?php } else { ?>
                                <video width="50" controls>
                                    <source src="uploads/<?= $filename; ?>" type="video/<?= $media['media_type']; ?>">
                                </video>
                            <?php } ?>
                        </td>
                        <td><?= $media['description']; ?></td>
                        <td><?= $media['likes']; ?> <a href="like_media.php?id=<?= $media['id']; ?>" class="btn btn-success">👍</a></td>
                        <td><?= $media['dislikes']; ?> <a href="dislike_media.php?id=<?= $media['id']; ?>" class="btn btn-danger">👎</a></td>
                        <td>
                            <a href="edit_gallery.php?id=<?= $media['id']; ?>" class="btn btn-primary">Edit</a>
                            <a href="manage_gallery.php?delete_media=<?= $media['id']; ?>" class="btn btn-danger" onclick="return confirm('Delete this media?');">Delete</a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5">
                            <form action="comment.php" method="POST">
                                <input type="hidden" name="media_id" value="<?= $media['id']; ?>">
                                <input type="text" name="comment" placeholder="Add a comment..." class="form-control">
                                <button type="submit" class="btn btn-primary mt-1">Comment</button>
                            </form>
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
