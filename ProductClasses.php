<?php

// الفئة الأساسية Product
class Product {
    protected $sku;
    protected $name;
    protected $price;
    protected $product_type;
    protected static $pdo; // إضافة متغير $pdo لقاعدة البيانات

    public function __construct($sku, $name, $price, $product_type) {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->product_type = $product_type;
    }

    // إعداد الاتصال بقاعدة البيانات
    public static function setConnection($pdo) {
        self::$pdo = $pdo;
    }

    // حفظ المنتج في قاعدة البيانات
    public function save() {
        $stmt = self::$pdo->prepare("INSERT INTO products (sku, name, price, product_type, size, weight, height, width, length) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$this->sku, $this->name, $this->price, $this->product_type, 
                        $this->getSizeOrNull(), $this->getWeightOrNull(), 
                        $this->getHeightOrNull(), $this->getWidthOrNull(), 
                        $this->getLengthOrNull()]);
    }

    // دوال فرعية لاسترجاع البيانات حسب نوع المنتج
    protected function getSizeOrNull() {
        return method_exists($this, 'getSize') ? $this->getSize() : null;
    }

    protected function getWeightOrNull() {
        return method_exists($this, 'getWeight') ? $this->getWeight() : null;
    }

    protected function getHeightOrNull() {
        return method_exists($this, 'getDimensions') ? $this->getDimensions()['height'] : null;
    }

    protected function getWidthOrNull() {
        return method_exists($this, 'getDimensions') ? $this->getDimensions()['width'] : null;
    }

    protected function getLengthOrNull() {
        return method_exists($this, 'getDimensions') ? $this->getDimensions()['length'] : null;
    }

    // جلب جميع المنتجات من قاعدة البيانات
    public static function fetchAll() {
        $stmt = self::$pdo->query("SELECT * FROM products");
        return $stmt->fetchAll();
    }
}

// الفئة الفرعية DVD
class DVD extends Product {
    private $size;

    public function __construct($sku, $name, $price, $size) {
        parent::__construct($sku, $name, $price, 'DVD');
        $this->size = $size;
    }

    public function getSize() {
        return $this->size;
    }
}

// الفئة الفرعية Book
class Book extends Product {
    private $weight;

    public function __construct($sku, $name, $price, $weight) {
        parent::__construct($sku, $name, $price, 'Book');
        $this->weight = $weight;
    }

    public function getWeight() {
        return $this->weight;
    }
}

// الفئة الفرعية Furniture
class Furniture extends Product {
    private $height;
    private $width;
    private $length;

    public function __construct($sku, $name, $price, $height, $width, $length) {
        parent::__construct($sku, $name, $price, 'Furniture');
        $this->height = $height;
        $this->width = $width;
        $this->length = $length;
    }

    public function getDimensions() {
        return [
            'height' => $this->height,
            'width' => $this->width,
            'length' => $this->length
        ];
    }
}

?>
