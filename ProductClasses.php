<?php

/**
 * Abstract class representing a product.
 */
abstract class Product {
    protected $sku;
    protected $name;
    protected $price;
    protected static $pdo;

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
        if (!$this->validate()) {
            throw new Exception("Validation failed!");
        }
        if (static::checkSKUExists($this->sku)) {
            throw new Exception("SKU already exists. Please use a different SKU.");
        }
        $stmt = self::$pdo->prepare("INSERT INTO products (sku, name, price, type, attributes) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$this->sku, $this->name, $this->price, static::class, json_encode($this->getAttributes())]);
    }

    /**
     * Update the product in the database.
     *
     * @param int $id The ID of the product to update.
     * @throws Exception If validation fails.
     */
    public function update($id) {
        if (!$this->validate()) {
            throw new Exception("Validation failed!");
        }
        $stmt = self::$pdo->prepare("UPDATE products SET name = ?, price = ?, attributes = ? WHERE id = ?");
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
        $stmt = self::$pdo->prepare("SELECT COUNT(*) FROM products WHERE sku = ?");
        $stmt->execute([$sku]);
        return $stmt->fetchColumn() > 0;
    }

    public static function setConnection(PDO $pdo) {
        self::$pdo = $pdo;
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
    public function __construct($sku, $name, $price, $size = null) {
        parent::__construct($sku, $name, $price);
        $this->setSize($size);
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

    // Getter for size
    public function getSize() {
        return $this->size;
    }

    // Setter for size
    public function setSize($size) {
        if (!is_numeric($size) || $size <= 0) {
            throw new Exception("Size must be a positive number.");
        }
        $this->size = $size;
    }

    public function getErrors() {
        $errors = [];
        if (!is_numeric($this->size) || $this->size <= 0) {
            $errors[] = "Size must be a positive number.";
        }
        return $errors;
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
    public function __construct($sku, $name, $price, $weight = null) {
        parent::__construct($sku, $name, $price);
        $this->setWeight($weight);
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

    // Getter for weight
    public function getWeight() {
        return $this->weight;
    }

    // Setter for weight
    public function setWeight($weight) {
        if (!is_numeric($weight) || $weight <= 0) {
            throw new Exception("Weight must be a positive number.");
        }
        $this->weight = $weight;
    }

    public function getErrors() {
        $errors = [];
        if (!is_numeric($this->weight) || $this->weight <= 0) {
            $errors[] = "Weight must be a positive number.";
        }
        return $errors;
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
    public function __construct($sku, $name, $price, $height = null, $width = null, $length = null) {
        parent::__construct($sku, $name, $price);
        $this->setHeight($height);
        $this->setWidth($width);
        $this->setLength($length);
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

    // Getter for height
    public function getHeight() {
        return $this->height;
    }

    // Setter for height
    public function setHeight($height) {
        if (!is_numeric($height) || $height <= 0) {
            throw new Exception("Height must be a positive number.");
        }
        $this->height = $height;
    }

    // Getter for width
    public function getWidth() {
        return $this->width;
    }

    // Setter for width
    public function setWidth($width) {
        if (!is_numeric($width) || $width <= 0) {
            throw new Exception("Width must be a positive number.");
        }
        $this->width = $width;
    }

    // Getter for length
    public function getLength() {
        return $this->length;
    }

    // Setter for length
    public function setLength($length) {
        if (!is_numeric($length) || $length <= 0) {
            throw new Exception("Length must be a positive number.");
        }
        $this->length = $length;
    }

    public function getErrors() {
        $errors = [];
        if (!is_numeric($this->height) || $this->height <= 0) {
            $errors[] = "Height must be a positive number.";
        }
        if (!is_numeric($this->width) || $this->width <= 0) {
            $errors[] = "Width must be a positive number.";
        }
        if (!is_numeric($this->length) || $this->length <= 0) {
            $errors[] = "Length must be a positive number.";
        }
        return $errors;
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