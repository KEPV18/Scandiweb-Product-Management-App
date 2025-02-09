كدا المفروض المشروع كله متوافق مع بعضه ف انا هديك اسم كل ملف و كوده وتراجعهم كلهم وتتأكد ان كلهم تم تحسينهم وكلهم بيوافقوا المتطلبات وكلهم ممتازين وشغالين تمام مع بعض ولو ناقص حاجة قولي ملف كذا محتاج تعديل واديني الكود بتاع الملف كامل كله بعد التعديل Add Product Page.php : <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product - Scandiweb Test Assignment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        button {
            padding: 10px 15px;
            margin-right: 10px;
        }
        #error-message {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <h1>Add New Product</h1>
    <form id="product_form">
        <div id="error-message" style="display:none;"></div>

        <!-- SKU Field -->
        <div class="form-group">
            <label for="sku">SKU</label>
            <input type="text" id="sku" name="sku" required>
        </div>

        <!-- Name Field -->
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" required>
        </div>

        <!-- Price Field -->
        <div class="form-group">
            <label for="price">Price ($)</label>
            <input type="number" id="price" name="price" step="0.01" required>
        </div>

        <!-- Product Type Selector -->
        <div class="form-group">
            <label for="productType">Product Type</label>
            <select id="productType" name="productType" required>
                <option value="" disabled selected>Select a type</option>
                <option value="dvd">DVD</option>
                <option value="book">Book</option>
                <option value="furniture">Furniture</option>
            </select>
        </div>

        <!-- Product-Specific Attributes -->
        <div id="productAttributes">
            <!-- DVD Size -->
            <div id="dvdAttributes" style="display:none;">
                <label for="size">Size (MB):</label>
                <input type="number" id="size" name="size" step="0.01">
            </div>

            <!-- Book Weight -->
            <div id="bookAttributes" style="display:none;">
                <label for="weight">Weight (Kg):</label>
                <input type="number" id="weight" name="weight" step="0.01">
            </div>

            <!-- Furniture Dimensions -->
            <div id="furnitureAttributes" style="display:none;">
                <label for="height">Height (CM):</label>
                <input type="number" id="height" name="height" step="0.01">
                <label for="width">Width (CM):</label>
                <input type="number" id="width" name="width" step="0.01">
                <label for="length">Length (CM):</label>
                <input type="number" id="length" name="length" step="0.01">
            </div>
        </div>

        <!-- Save and Cancel Buttons -->
        <button type="button" onclick="saveProduct()">Save</button>
        <button type="button" onclick="cancelProduct()">Cancel</button>
    </form>

    <script>
        // Show/hide product-specific attributes based on selected type
        document.getElementById('productType').addEventListener('change', function () {
            const productType = this.value;
            const dvdAttributes = document.getElementById('dvdAttributes');
            const bookAttributes = document.getElementById('bookAttributes');
            const furnitureAttributes = document.getElementById('furnitureAttributes');

            dvdAttributes.style.display = 'none';
            bookAttributes.style.display = 'none';
            furnitureAttributes.style.display = 'none';

            if (productType === 'dvd') {
                dvdAttributes.style.display = 'block';
            } else if (productType === 'book') {
                bookAttributes.style.display = 'block';
            } else if (productType === 'furniture') {
                furnitureAttributes.style.display = 'block';
            }
        });

        // Save product function
        function saveProduct() {
            const errorMessage = document.getElementById('error-message');
            errorMessage.style.display = 'none';
            errorMessage.textContent = '';

            const sku = document.getElementById('sku').value.trim();
            const name = document.getElementById('name').value.trim();
            const price = document.getElementById('price').value.trim();
            const productType = document.getElementById('productType').value;

            if (!sku || !name || !price || !productType) {
                errorMessage.textContent = 'Please, submit required data';
                errorMessage.style.display = 'block';
                return;
            }

            let isValid = true;

            switch (productType) {
                case 'dvd':
                    if (!document.getElementById('size').value.trim()) {
                        isValid = false;
                    }
                    break;
                case 'book':
                    if (!document.getElementById('weight').value.trim()) {
                        isValid = false;
                    }
                    break;
                case 'furniture':
                    if (!document.getElementById('height').value.trim() ||
                        !document.getElementById('width').value.trim() ||
                        !document.getElementById('length').value.trim()) {
                        isValid = false;
                    }
                    break;
            }

            if (!isValid) {
                errorMessage.textContent = 'Please, provide the data of indicated type';
                errorMessage.style.display = 'block';
                return;
            }

            alert('Product added successfully!');
            window.location.href = '/'; // Redirect to product list page
        }

        // Cancel product function
        function cancelProduct() {
            window.location.href = '/'; // Redirect to product list page
        }
    </script>
</body>
</html>     وبعدين add_product.php : <?php
session_start(); // Start session for error messages
require 'db.php'; // Database connection
require 'ProductClasses.php'; // Product classes
require 'RequestHandler.php'; // Request handling

// Initialize the database connection
Product::setConnection($pdo);

// Check if the form was submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Get form data using RequestHandler
        $data = RequestHandler::getPostData(['sku', 'name', 'price', 'productType', 'size', 'weight', 'height', 'width', 'length']);
        
        // Extract required fields
        $sku = $data['sku'];
        $name = $data['name'];
        $price = $data['price'];
        $productType = $data['productType'];

        // Validate required fields
        if (empty($sku) || empty($name) || empty($price) || empty($productType)) {
            throw new Exception("Please submit all required data.");
        }

        // Create the product object using the factory pattern
        $attributes = [];
        switch ($productType) {
            case 'DVD':
                if (empty($data['size']) || !is_numeric($data['size'])) {
                    throw new Exception("Please provide a valid size for DVD.");
                }
                $attributes['size'] = $data['size'];
                break;
            case 'Book':
                if (empty($data['weight']) || !is_numeric($data['weight'])) {
                    throw new Exception("Please provide a valid weight for Book.");
                }
                $attributes['weight'] = $data['weight'];
                break;
            case 'Furniture':
                if (empty($data['height']) || empty($data['width']) || empty($data['length']) ||
                    !is_numeric($data['height']) || !is_numeric($data['width']) || !is_numeric($data['length'])) {
                    throw new Exception("Please provide valid dimensions for Furniture.");
                }
                $attributes['height'] = $data['height'];
                $attributes['width'] = $data['width'];
                $attributes['length'] = $data['length'];
                break;
            default:
                throw new Exception("Invalid product type!");
        }

        // Create the product instance
        $product = ProductFactory::create($productType, $sku, $name, $price, $attributes);

        // Save the product to the database
        $product->save();

        // Redirect to the product list page with success message
        $_SESSION['success'] = "Product added successfully!";
        header('Location: index.php');
        exit;

    } catch (Exception $e) {
        // Store the error message in the session and redirect back to the add product page
        $_SESSION['error'] = $e->getMessage();
        header('Location: add_product_page.php');
        exit;
    }
} وبعدين db.php : <?php

/**
 * Database connection configuration.
 * This file handles the connection to the MySQL database using PDO.
 */

// Define database credentials as constants for better security and reusability
define('DB_HOST', 'sql100.infinityfree.com');  // Database host
define('DB_NAME', 'if0_37240897_product_db'); // Database name
define('DB_USER', 'if0_37240897');            // Database username
define('DB_PASS', 'MUaalarYWxQ');             // Database password

/**
 * Function to establish a connection to the database.
 *
 * @return PDO The PDO instance representing the database connection.
 */
function getDatabaseConnection() {
    try {
        // Create DSN (Data Source Name)
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";

        // Set options for PDO
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Enable exceptions for errors
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Fetch results as associative arrays
            PDO::ATTR_EMULATE_PREPARES   => false,                  // Disable emulation of prepared statements
        ];

        // Create a new PDO instance
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);

        return $pdo;

    } catch (PDOException $e) {
        // Handle connection errors gracefully
        error_log("Database connection failed: " . $e->getMessage()); // Log the error message
        die("Database connection failed. Please try again later.");   // Show a user-friendly error message
    }
}

/**
 * Function to close the database connection if needed.
 *
 * @param PDO $pdo The PDO instance to close.
 */
function closeDatabaseConnection($pdo) {
    $pdo = null; // Set the PDO instance to null to close the connection
}

// Example usage:
// $pdo = getDatabaseConnection(); // To get the database connection
// closeDatabaseConnection($pdo);  // To close the database connection وبعدين : index.php : <?php
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
</html> وبعدين : main.js : document.addEventListener('DOMContentLoaded', function () {
    // Handle mass delete button click
    document.getElementById('delete-product-btn').addEventListener('click', function () {
        const selectedProducts = Array.from(document.querySelectorAll('.delete-checkbox:checked')).map(cb => cb.value);

        if (selectedProducts.length === 0) {
            // Display an error message instead of using alert()
            const errorMessage = document.createElement('div');
            errorMessage.className = 'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4';
            errorMessage.textContent = 'Please select at least one product to delete.';
            document.body.insertBefore(errorMessage, document.body.firstChild);
            return;
        }

        const form = document.getElementById('mass-delete-form');
        form.querySelector('#product-ids').value = JSON.stringify(selectedProducts); // Set product IDs as a JSON string
        form.submit(); // Submit the form
    });

    // Toggle edit form visibility
    document.querySelectorAll('.edit-button').forEach(button => {
        button.addEventListener('click', function () {
            const card = this.closest('.bg-card'); // Find the parent card container
            const editForm = card.querySelector('.edit-form'); // Find the edit form inside the card
            if (editForm) {
                editForm.classList.toggle('hidden'); // Toggle visibility of the edit form
            }
        });
    });

    // Cancel button functionality
    document.querySelectorAll('.cancel-button').forEach(button => {
        button.addEventListener('click', function () {
            const editForm = this.closest('.edit-form'); // Find the closest edit form
            if (editForm) {
                editForm.classList.add('hidden'); // Hide the edit form
            }
        });
    });

    // Ensure cards view is visible on page load
    const cardsView = document.getElementById('cards-view');
    if (cardsView) {
        cardsView.classList.remove('hidden'); // Make sure the cards view is visible
    }
}); وبعدين product_actions.php : <?php
session_start(); // Start session for messages
require 'db.php'; // Database connection
require 'ProductClasses.php'; // Product classes

// Handle product actions based on the request method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Delete a single product
        if (isset($_POST['delete_id'])) {
            $deleteId = intval($_POST['delete_id']); // Ensure ID is an integer
            $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
            $stmt->execute([$deleteId]);
            $_SESSION['success'] = "Product deleted successfully!";
        }

        // Mass delete
        if (isset($_POST['mass_delete']) && isset($_POST['product_ids']) && is_array($_POST['product_ids'])) {
            $ids = array_map('intval', $_POST['product_ids']); // Ensure all IDs are integers
            if (!empty($ids)) {
                $placeholders = implode(',', array_fill(0, count($ids), '?'));
                $stmt = $pdo->prepare("DELETE FROM products WHERE id IN ($placeholders)");
                $stmt->execute($ids);
                $_SESSION['success'] = "Selected products deleted successfully!";
            } else {
                $_SESSION['error'] = "No products selected for deletion.";
            }
        }

        // Edit a product
        if (isset($_POST['edit_id'])) {
            $editId = intval($_POST['edit_id']); // Ensure ID is an integer
            $newName = trim($_POST['new_name']);
            $newPrice = floatval($_POST['new_price']); // Ensure price is a float

            if (empty($newName) || $newPrice <= 0) {
                throw new Exception("Invalid data provided for editing.");
            }

            // Fetch the existing product from the database
            $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
            $stmt->execute([$editId]);
            $productData = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$productData) {
                throw new Exception("Product not found.");
            }

            // Create the appropriate product object using Factory Pattern
            $attributes = json_decode($productData['attributes'], true);
            $productType = $productData['type'];
            $product = ProductFactory::create($productType, $productData['sku'], $newName, $newPrice, $attributes);

            // Update the product in the database
            $stmt = $pdo->prepare("UPDATE products SET name = ?, price = ?, attributes = ? WHERE id = ?");
            $stmt->execute([$newName, $newPrice, json_encode($product->getAttributes()), $editId]);

            $_SESSION['success'] = "Product updated successfully!";
        }

        // Redirect to the product list page after processing
        header('Location: index.php');
        exit;

    } catch (Exception $e) {
        // Store error message in session and redirect back
        $_SESSION['error'] = "An error occurred: " . htmlspecialchars($e->getMessage());
        header('Location: index.php');
        exit;
    }
} وبعدين : ProductClasses.php : <?php

/**
 * Abstract class representing a product.
 */
abstract class Product {
    protected $sku;
    protected $name;
    protected $price;

    /**
     * Constructor for the Product class.
     *
     * @param string $sku The SKU of the product.
     * @param string $name The name of the product.
     * @param float $price The price of the product.
     */
    public function __construct($sku, $name, $price) {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
    }

    /**
     * Validate the product data.
     *
     * @return bool True if validation passes, false otherwise.
     */
    abstract public function validate();

    /**
     * Save the product to the database.
     *
     * @throws Exception If validation fails or SKU already exists.
     */
    public function save() {
        global $pdo;
        if (!$this->validate()) {
            throw new Exception("Validation failed!");
        }
        if (static::checkSKUExists($this->sku)) {
            throw new Exception("SKU already exists. Please use a different SKU.");
        }
        $stmt = $pdo->prepare("INSERT INTO products (sku, name, price, type, attributes) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$this->sku, $this->name, $this->price, static::class, json_encode($this->getAttributes())]);
    }

    /**
     * Update the product in the database.
     *
     * @param int $id The ID of the product to update.
     * @throws Exception If validation fails.
     */
    public function update($id) {
        global $pdo;
        if (!$this->validate()) {
            throw new Exception("Validation failed!");
        }
        $stmt = $pdo->prepare("UPDATE products SET name = ?, price = ?, attributes = ? WHERE id = ?");
        $stmt->execute([$this->name, $this->price, json_encode($this->getAttributes()), $id]);
    }

    /**
     * Get the attributes of the product.
     *
     * @return array An associative array of product attributes.
     */
    protected abstract function getAttributes();

    /**
     * Check if a SKU already exists in the database.
     *
     * @param string $sku The SKU to check.
     * @return bool True if SKU exists, false otherwise.
     */
    public static function checkSKUExists($sku) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM products WHERE sku = ?");
        $stmt->execute([$sku]);
        return $stmt->fetchColumn() > 0;
    }
}

/**
 * Class representing a DVD product.
 */
class DVD extends Product {
    private $size;

    /**
     * Constructor for the DVD class.
     *
     * @param string $sku The SKU of the DVD.
     * @param string $name The name of the DVD.
     * @param float $price The price of the DVD.
     * @param float $size The size of the DVD in MB.
     */
    public function __construct($sku, $name, $price, $size) {
        parent::__construct($sku, $name, $price);
        $this->size = $size;
    }

    /**
     * Validate the DVD data.
     *
     * @return bool True if validation passes, false otherwise.
     */
    public function validate() {
        return is_numeric($this->size) && $this->size > 0;
    }

    /**
     * Get the attributes of the DVD.
     *
     * @return array An associative array of DVD attributes.
     */
    protected function getAttributes() {
        return ['size' => $this->size];
    }
}

/**
 * Class representing a Book product.
 */
class Book extends Product {
    private $weight;

    /**
     * Constructor for the Book class.
     *
     * @param string $sku The SKU of the Book.
     * @param string $name The name of the Book.
     * @param float $price The price of the Book.
     * @param float $weight The weight of the Book in KG.
     */
    public function __construct($sku, $name, $price, $weight) {
        parent::__construct($sku, $name, $price);
        $this->weight = $weight;
    }

    /**
     * Validate the Book data.
     *
     * @return bool True if validation passes, false otherwise.
     */
    public function validate() {
        return is_numeric($this->weight) && $this->weight > 0;
    }

    /**
     * Get the attributes of the Book.
     *
     * @return array An associative array of Book attributes.
     */
    protected function getAttributes() {
        return ['weight' => $this->weight];
    }
}

/**
 * Class representing a Furniture product.
 */
class Furniture extends Product {
    private $height;
    private $width;
    private $length;

    /**
     * Constructor for the Furniture class.
     *
     * @param string $sku The SKU of the Furniture.
     * @param string $name The name of the Furniture.
     * @param float $price The price of the Furniture.
     * @param float $height The height of the Furniture in CM.
     * @param float $width The width of the Furniture in CM.
     * @param float $length The length of the Furniture in CM.
     */
    public function __construct($sku, $name, $price, $height, $width, $length) {
        parent::__construct($sku, $name, $price);
        $this->height = $height;
        $this->width = $width;
        $this->length = $length;
    }

    /**
     * Validate the Furniture data.
     *
     * @return bool True if validation passes, false otherwise.
     */
    public function validate() {
        return is_numeric($this->height) && is_numeric($this->width) && is_numeric($this->length) &&
               $this->height > 0 && $this->width > 0 && $this->length > 0;
    }

    /**
     * Get the attributes of the Furniture.
     *
     * @return array An associative array of Furniture attributes.
     */
    protected function getAttributes() {
        return ['height' => $this->height, 'width' => $this->width, 'length' => $this->length];
    }
}

/**
 * Factory class for creating products.
 */
class ProductFactory {
    /**
     * Create a product object based on the given type.
     *
     * @param string $type The type of the product (DVD, Book, Furniture).
     * @param string $sku The SKU of the product.
     * @param string $name The name of the product.
     * @param float $price The price of the product.
     * @param array $attributes An associative array of product attributes.
     * @return Product A product object.
     * @throws Exception If the product type is invalid.
     */
    public static function create($type, $sku, $name, $price, $attributes) {
        switch ($type) {
            case 'DVD':
                return new DVD($sku, $name, $price, $attributes['size']);
            case 'Book':
                return new Book($sku, $name, $price, $attributes['weight']);
            case 'Furniture':
                return new Furniture($sku, $name, $price, $attributes['height'], $attributes['width'], $attributes['length']);
            default:
                throw new Exception("Invalid product type!");
        }
    }
} 