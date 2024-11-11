<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Cars for Sale</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .card-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.card {
    border: 1px solid #ddd;
    border-radius: 8px;
    width: 300px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.card img {
    width: 100%;
    height: auto;
}

.card-body {
    padding: 15px;
    text-align: center;
}
    </style>
</head>
<body>

  

    <section id="browse-cars">
        <h2>Available Cars for Sale</h2>
        <div class="card-container">
            <?php
            include 'config.php';
            $stmt = $pdo->query("SELECT * FROM cars");
            $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($cars as $car): ?>
                <div class="card">
                    <img src="<?php echo $car['image']; ?>" alt="<?php echo $car['model']; ?>">
                    <div class="card-body">
                        <h3><?php echo $car['model']; ?></h3>
                        <p>Type: <?php echo $car['type']; ?></p>
                        <p>Mileage: <?php echo number_format($car['mileage']); ?> miles</p>
                        <p>Price: $<?php echo number_format($car['price'], 2); ?></p>
                        <p>Contact: <?php echo $car['contact']; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

</body>
</html>