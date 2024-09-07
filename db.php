<?php
$host = 'sql100.infinityfree.com';  // المضيف المقدم من InfinityFree
$db = 'if0_37240897_product_db';    // اسم قاعدة البيانات
$user = 'if0_37240897';             // اسم المستخدم الخاص بقاعدة البيانات
$pass = 'MUaalarYWxQ';              // كلمة مرور قاعدة البيانات

try {
    $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit;
}
?>
