<?php
// الاتصال بقاعدة البيانات
require 'db.php';

// جلب المنتجات من قاعدة البيانات
$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script src="https://unpkg.com/unlazy@0.11.3/dist/unlazy.with-hashing.iife.js" defer init></script>
        <!-- نقل إعدادات Tailwind إلى ملف خارجي -->
        <script src="tailwind-config.js"></script>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="min-h-screen bg-background text-foreground p-4">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-4xl font-bold text-primary">Product List</h1>
            <div class="flex items-center space-x-4">
                <button class="bg-accent text-accent-foreground hover:bg-accent/80 px-4 py-2 rounded shadow-md flex items-center transition duration-200"
                        onclick="window.location.href='Add Product Page.php'">
                    <img aria-hidden="true" alt="add-icon" src="https://openui.fly.dev/openui/24x24.svg?text=➕" class="mr-2"/>
                    ADD
                </button>
                <form method="POST" action="product_actions.php" id="mass-delete-form"> <!-- Added form ID -->
                    <input type="hidden" name="mass_delete" value="1">
                    <input type="hidden" name="product_ids[]" id="product-ids">
                    <button type="button" id="delete-product-btn" class="bg-destructive text-destructive-foreground hover:bg-destructive/80 px-4 py-2 rounded shadow-md flex items-center transition duration-200">
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
                        if ($product['product_type'] == 'DVD') {
                            echo 'Size: ' . htmlspecialchars($product['size']) . ' MB';
                        } elseif ($product['product_type'] == 'Book') {
                            echo 'Weight: ' . htmlspecialchars($product['weight']) . ' KG';
                        } elseif ($product['product_type'] == 'Furniture') {
                            echo 'Dimensions: ' . htmlspecialchars($product['height']) . 'x' . htmlspecialchars($product['width']) . 'x' . htmlspecialchars($product['length']) . ' CM';
                        }
                        ?>
                    </p>
                    <div class="flex justify-between items-center mt-2">
                        <input type="checkbox" class="delete-checkbox" value="<?php echo htmlspecialchars($product['id']); ?>">
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
                    <form method="POST" action="product_actions.php" class="hidden edit-form mt-4">
                        <input type="hidden" name="edit_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                        <input type="text" name="new_name" value="<?php echo htmlspecialchars($product['name']); ?>" placeholder="New Name" class="bg-input border border-border rounded-md p-2 mb-2 w-full">
                        <input type="number" name="new_price" value="<?php echo htmlspecialchars($product['price']); ?>" placeholder="New Price" class="bg-input border border-border rounded-md p-2 mb-2 w-full">
                        <div class="flex justify-between">
                            <button type="submit" class="bg-primary text-primary-foreground hover:bg-primary/80 px-4 py-2 rounded transition duration-200">Save</button>
                            <button type="button" class="bg-muted text-muted-foreground hover:bg-muted/80 px-4 py-2 rounded transition duration-200 cancel-button">Cancel</button>
                        </div>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- سكريبت التفاعل مع الواجهة -->
<script src="main.js"></script>
<footer class="bg-gray-100 text-center py-4 absolute bottom-0 w-full">
    <p class="text-gray-600">Scandiweb Test assignment</p>
</footer>
</body>
</html>
