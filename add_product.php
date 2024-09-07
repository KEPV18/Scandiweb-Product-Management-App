<?php

require 'db.php'; // ملف الاتصال بقاعدة البيانات
require 'ProductClasses.php'; // ملف الفئات

// إعداد الاتصال بقاعدة البيانات
Product::setConnection($pdo);

// التحقق من وجود بيانات في POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sku = $_POST['sku'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $productType = $_POST['productType'];

    // Check if SKU already exists
    $query = "SELECT * FROM products WHERE sku = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$sku]);

    if ($stmt->rowCount() > 0) {
        // SKU already exists
        $error = "SKU already exists. Please use a different SKU.";
        header("Location: add_product_page.php?error=" . urlencode($error));
        exit;
    }

    // إنشاء الكائن المناسب بناءً على نوع المنتج
    switch ($productType) {
        case 'DVD':
            $size = $_POST['size'];
            $product = new DVD($sku, $name, $price, $size);
            break;
        case 'Book':
            $weight = $_POST['weight'];
            $product = new Book($sku, $name, $price, $weight);
            break;
        case 'Furniture':
            $height = $_POST['height'];
            $width = $_POST['width'];
            $length = $_POST['length'];
            $product = new Furniture($sku, $name, $price, $height, $width, $length);
            break;
        default:
            echo "Invalid product type!";
            exit;
    }

    try {
        // محاولة حفظ المنتج في قاعدة البيانات
        $product->save();
        // إعادة توجيه المستخدم مع رسالة نجاح
        header('Location: index.php?success=1');
    } catch (PDOException $e) {
        // التحقق من نوع الخطأ
        if ($e->getCode() == 1062) {
            $errorMessage = "The SKU you entered already exists. Please enter a unique SKU.";
        } else {
            $errorMessage = "An error occurred while adding the product. Please try again.";
        }
        // إعادة توجيه المستخدم مع رسالة خطأ
        header('Location: Add%20Product%20Page.php?error=' . urlencode($errorMessage));
    }
    exit;
}
