<?php
session_start();
require_once "db.php";

if ($_SESSION['role'] !== 'admin') {
    die("Unauthorized access");
}

// Handle new service addition
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_service'])) {
  $name = $_POST['name'];
  $description = $_POST['description'];
  $price = $_POST['price'];
  $image = $_FILES['image']['name'];

  // Ensure correct path before storing in the database
  $filename = basename($_FILES['image']['name']);
$target = "uploads/" . $filename;
move_uploaded_file($_FILES['image']['tmp_name'], $target);

$conn->query("INSERT INTO services (name, description, price, image) VALUES ('$name', '$description', '$price', '$filename')");

  
  if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
      $conn->query("INSERT INTO services (name, description, price, image) 
                    VALUES ('$name', '$description', '$price', '$target')");
      header("Location: manage_services.php");
      exit();
  } else {
      echo "File upload failed!";
  }
}

// Handle delete service
if (isset($_GET['delete_service'])) {
    $id = $_GET['delete_service'];
    $conn->query("DELETE FROM services WHERE id='$id'");
    header("Location: manage_users.php");
    exit();
}

// Fetch all services
$services = $conn->query("SELECT * FROM services");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users & Services</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Manage Services</h2>

        <h3>Add New Service</h3>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Service Name:</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Price:</label>
                <input type="number" name="price" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Description:</label>
                <textarea name="description" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label>Upload Image:</label>
                <input type="file" name="image" class="form-control" required>
            </div>
            <button type="submit" name="add_service" class="btn btn-success">Add Service</button>
        </form>

        <h3 class="mt-4">Existing Services</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($service = $services->fetch_assoc()) { ?>
                    <tr>
                        <td><img src="<?= $service['image']; ?>" width="50"></td>
                        <td><?= $service['name']; ?></td>
                        <td><?= $service['price']; ?></td>
                        <td><?= $service['description']; ?></td>
                        <td>
                            <a href="edit_service.php?id=<?= $service['id']; ?>" class="btn btn-primary">Edit</a>
                            <a href="manage_users.php?delete_service=<?= $service['id']; ?>" class="btn btn-danger" onclick="return confirm('Delete this service?');">Delete</a>
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
