<?php
session_start(); // Start session for messages
require 'db.php'; // Database connection
require 'ProductClasses.php'; // Product classes

// Fetch products from the database
try {
    $stmt = $pdo->query("SELECT * FROM products ORDER BY id ASC");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

// Handle mass delete action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mass_delete'])) {
    if (isset($_POST['product_ids']) && is_array($_POST['product_ids'])) {
        $productIds = array_map('intval', $_POST['product_ids']);
        try {
            $stmt = $pdo->prepare("DELETE FROM products WHERE id IN (" . implode(',', $productIds) . ")");
            $stmt->execute();
            $_SESSION['success'] = "Selected products deleted successfully!";
        } catch (PDOException $e) {
            $_SESSION['error'] = "An error occurred while deleting products.";
        }
    }
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <link rel="stylesheet" href="styles.css">
    <title>Product List</title>
</head>
<body>
<div class="min-h-screen bg-background text-foreground p-4">
    <div class="max-w-7xl mx-auto">
        <!-- Display success or error messages -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div class="flex justify-between items-center mb-4">
            <h1 class="text-4xl font-bold text-primary">Product List</h1>
            <div class="flex items-center space-x-4">
                <button class="bg-accent text-accent-foreground hover:bg-accent/80 px-4 py-2 rounded shadow-md flex items-center transition duration-200"
                        onclick="window.location.href='add_product_page.php'">
                    <img aria-hidden="true" alt="add-icon" src="https://openui.fly.dev/openui/24x24.svg?text=➕" class="mr-2"/>
                    ADD
                </button>
                <form method="POST" action="index.php" id="mass-delete-form">
                    <input type="hidden" name="mass_delete" value="1">
                    <button type="submit" id="delete-product-btn" class="bg-destructive text-destructive-foreground hover:bg-destructive/80 px-4 py-2 rounded shadow-md flex items-center transition duration-200">
                        <img aria-hidden="true" alt="delete-icon" src="https://openui.fly.dev/openui/24x24.svg?text=🗑️" class="mr-2"/>
                        MASS DELETE
                    </button>
                </form>
            </div>
        </div>

        <div id="cards-view" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-4 transition duration-300 ease-in-out">
            <?php foreach ($products as $product): ?>
                <div class="bg-card text-card-foreground rounded-lg shadow-lg p-4 transition duration-200 hover:shadow-xl">
                    <h2 class="text-lg font-bold mb-2"><?php echo htmlspecialchars($product['name']); ?></h2>
                    <p class="text-muted-foreground mb-2">SKU: <?php echo htmlspecialchars($product['sku']); ?></p>
                    <p class="text-muted-foreground mb-2">Price: $<?php echo htmlspecialchars($product['price']); ?></p>
                    <p class="text-muted-foreground mb-2">
                        <?php
                        $attributes = json_decode($product['attributes'], true);
                        if ($product['type'] == 'DVD') {
                            echo 'Size: ' . htmlspecialchars($attributes['size']) . ' MB';
                        } elseif ($product['type'] == 'Book') {
                            echo 'Weight: ' . htmlspecialchars($attributes['weight']) . ' KG';
                        } elseif ($product['type'] == 'Furniture') {
                            echo 'Dimensions: ' . htmlspecialchars($attributes['height']) . 'x' . htmlspecialchars($attributes['width']) . 'x' . htmlspecialchars($attributes['length']) . ' CM';
                        }
                        ?>
                    </p>
                    <div class="flex justify-between items-center mt-2">
                        <input type="checkbox" class="delete-checkbox" name="product_ids[]" value="<?php echo htmlspecialchars($product['id']); ?>">
                        <div class="flex space-x-2">
                            <button class="bg-accent text-accent-foreground hover:bg-accent/80 px-2 py-1 rounded transition duration-200 edit-button">
                                <img aria-hidden="true" alt="edit-icon" src="https://openui.fly.dev/openui/24x24.svg?text=✏️"/>
                            </button>
                            <form method="POST" action="product_actions.php" class="inline">
                                <input type="hidden" name="delete_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                                <button type="submit" class="bg-destructive text-destructive-foreground hover:bg-destructive/80 px-2 py-1 rounded transition duration-200">
                                    <img aria-hidden="true" alt="delete-icon" src="https://openui.fly.dev/openui/24x24.svg?text=🗑️"/>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<footer class="bg-gray-100 text-center py-4 absolute bottom-0 w-full">
    <p class="text-gray-600">Scandiweb Test assignment</p>
</footer>

<!-- JavaScript for UI interactions -->
<script>
    document.getElementById('mass-delete-form').addEventListener('submit', function (event) {
        const checkboxes = document.querySelectorAll('.delete-checkbox:checked');
        if (checkboxes.length === 0) {
            event.preventDefault();
            alert('Please select at least one product to delete.');
        } else {
            const productIds = Array.from(checkboxes).map(checkbox => checkbox.value);
            document.querySelector('#mass-delete-form input[name="product_ids[]"]').value = JSON.stringify(productIds);
        }
    });
</script>
</body>
</html>