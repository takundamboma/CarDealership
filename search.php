<?php
// Include database connection
include 'config.php';

// Initialize the SQL query
$sql = "SELECT * FROM cars WHERE 1=1"; // 1=1 to make it easier to append conditions
$conditions = [];

// Check for search query
if (!empty($_GET['query'])) {
    $query = htmlspecialchars(trim($_GET['query']));
    $conditions[] = "(make LIKE '%$query%' OR model LIKE '%$query%')";
}

// Check for type filter
if (!empty($_GET['type'])) {
    $type = htmlspecialchars(trim($_GET['type']));
    $conditions[] = "type = '$type'";
}

// Check for price range
if (!empty($_GET['min_price'])) {
    $min_price = intval($_GET['min_price']);
    $conditions[] = "price >= $min_price";
}

if (!empty($_GET['max_price'])) {
    $max_price = intval($_GET['max_price']);
    $conditions[] = "price <= $max_price";
}

// Check for year range
if (!empty($_GET['min_year'])) {
    $min_year = intval($_GET['min_year']);
    $conditions[] = "year >= $min_year";
}

if (!empty($_GET['max_year'])) {
    $max_year = intval($_GET['max_year']);
    $conditions[] = "year <= $max_year";
}

// Append conditions to query
if (count($conditions) > 0) {
    $sql .= " AND " . implode(" AND ", $conditions);
}

// Execute query
$stmt = $pdo->query($sql);
$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section id="gallery">
    <h2>Search Results</h2>
    <div class="gallery-container">
        <?php if (count($cars) > 0): ?>
            <?php foreach ($cars as $car): ?>
            <div class="gallery-item">
                <img src="<?php echo $car['image']; ?>" alt="<?php echo $car['make'] . ' ' . $car['model']; ?>">
                <div class="overlay">
                    <h3><?php echo $car['make'] . ' ' . $car['model']; ?></h3>
                    <p>$<?php echo number_format($car['price'], 2); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No results found.</p>
        <?php endif; ?>
    </div>
</section>