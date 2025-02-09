<?php
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

        // Use setters to set attributes
        $product->setSku($sku);
        $product->setName($name);
        $product->setPrice($price);
        foreach ($attributes as $key => $value) {
            $product->{"set" . ucfirst($key)}($value);
        }

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
}