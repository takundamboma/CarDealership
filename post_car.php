<?php
include 'config.php'; // Ensure this file exists and sets up $pdo

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $model = htmlspecialchars(trim($_POST['model']));
    $type = htmlspecialchars(trim($_POST['type']));
    $mileage = intval($_POST['mileage']);
    $contact = htmlspecialchars(trim($_POST['contact']));
    $price = floatval($_POST['price']);
    
    // Check if the uploads directory exists
    $targetDir = 'uploads/';
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true); // Create the directory if it doesn't exist
    }

    // Handle image upload
    $imageName = basename($_FILES['image']['name']);
    $targetFilePath = $targetDir . $imageName;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
        $stmt = $pdo->prepare("INSERT INTO cars (model, mileage, contact, price, image) VALUES (, ?, ?, ?, ?, ?)");
        $stmt->execute([$model, $mileage, $contact, $price, $targetFilePath]);
        header("Location: buying_car.php"); // Redirect to cars listing page
        exit();
    } else {
        // Handle error
        echo "Error uploading the file.";
    }
}

