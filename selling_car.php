<?php
include 'config.php'; // Include your database connection

// Initialize variables for form data
$model = $type = $mileage = $contact = $price = $targetFilePath = '';
$uploadError = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process form submission
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
        // Prepare and execute the insert statement
        $stmt = $pdo->prepare("INSERT INTO cars (model, `type`, mileage, contact, price, image) VALUES (?, ?, ?, ?, ?, ?)");
        $success = $stmt->execute([$model, $type, $mileage, $contact, $price, $targetFilePath]);

        if ($success) {
            header("Location: buying_car.php"); // Redirect to cars listing page
            exit();
        } else {
            echo "Error inserting data.";
        }
    } else {
        $uploadError = "Error uploading the file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sell Your Car</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
</head>
<body>

    <header>
        <h1>Sell Your Car</h1>
    </header>

    <section id="sell-car">
        <h2>Upload Your Car Details</h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="text" name="model" placeholder="Model" value="<?php echo htmlspecialchars($model); ?>" required />
            <input type="text" name="type" placeholder="Type (e.g., SUV, Sedan)" value="<?php echo htmlspecialchars($type); ?>" required />
            <input type="number" name="mileage" placeholder="Mileage" value="<?php echo htmlspecialchars($mileage); ?>" required />
            <input type="text" name="contact" placeholder="Your Contact Info" value="<?php echo htmlspecialchars($contact); ?>" required />
            <input type="number" name="price" placeholder="Price" value="<?php echo htmlspecialchars($price); ?>" required />
            <input type="file" name="image" required />
            <button type="submit">Upload Car</button>
        </form>
        <?php if ($uploadError): ?>
            <p style="color: red;"><?php echo $uploadError; ?></p>
        <?php endif; ?>
    </section>

    <footer>
        <p>&copy; 2024 Car Dealership. All rights reserved. &copy; Taku Code</p>
    </footer>

</body>
</html>