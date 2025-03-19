<?php
require_once "db.php";

$services = $conn->query("SELECT * FROM services");

$serviceData = [];
while ($service = $services->fetch_assoc()) {
    $imagePath = $service['image'];
    
    // Ensure there is no double "uploads/" prefix
    if (strpos($imagePath, "uploads/") === 0) {
        $cleanImagePath = $imagePath;  // Already prefixed correctly
    } else {
        $cleanImagePath = "uploads/" . $imagePath;
    }

    $serviceData[] = [
        'id' => $service['id'],
        'service_name' => $service['name'],
        'service_description' => $service['description'],
        'service_price' => $service['price'],
        'service_image' => $cleanImagePath
    ];
}

header('Content-Type: application/json');
echo json_encode($serviceData);
?>
