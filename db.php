<?php

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
// closeDatabaseConnection($pdo);  // To close the database connection