<?php
require 'db.php'; // الاتصال بقاعدة البيانات

// التحقق من نوع الطلب
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // حذف منتج واحد
    if (isset($_POST['delete_id'])) {
        $deleteId = $_POST['delete_id'];
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$deleteId]);
    }

    // حذف جماعي
    if (isset($_POST['mass_delete']) && !empty($_POST['product_ids'])) {
        $ids = $_POST['product_ids']; // مصفوفة معرفات المنتجات
        if (is_array($ids)) { // تأكد من أن $ids هو مصفوفة
            $placeholders = implode(',', array_fill(0, count($ids), '?'));
            $stmt = $pdo->prepare("DELETE FROM products WHERE id IN ($placeholders)");
            $stmt->execute($ids); // سيتم حذف كل المنتجات المحددة
        }
    }        

    // تعديل منتج
    if (isset($_POST['edit_id'])) {
        $editId = $_POST['edit_id'];
        $newName = $_POST['new_name'];
        $newPrice = $_POST['new_price'];
        $stmt = $pdo->prepare("UPDATE products SET name = ?, price = ? WHERE id = ?");
        $stmt->execute([$newName, $newPrice, $editId]);
    }

    // إعادة التوجيه بعد المعالجة
    header('Location: index.php');
    exit;
}
