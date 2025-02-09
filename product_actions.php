<?php
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
}