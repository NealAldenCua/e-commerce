<?php
class SingletonDB {
    private static $serverName = "localhost";
    private static $userName = "root";
    private static $password = "";
    private static $databaseName = "sysinarch";
    private static $connection;

    //table for products
    public static $createProducts = "CREATE TABLE IF NOT EXISTS products ( 
        `id` INT NOT NULL AUTO_INCREMENT,
        `Product` VARCHAR(750) NOT NULL,
        `price` VARCHAR(750) NOT NULL,
        `quantity` INT NOT NULL,
        `image` VARCHAR(250) NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE = InnoDB";

    //table for cart
    public static $createCart = "CREATE TABLE IF NOT EXISTS cart (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `Product` VARCHAR(750) NOT NULL,
        `product_id` INT NOT NULL,
        `quantity` INT NOT NULL,
        `image` VARCHAR(250) NOT NULL
    ) ENGINE = InnoDB";

    public static $createOrders = "CREATE TABLE IF NOT EXISTS orders (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255),
        shippingAddress VARCHAR(255),
        billingAddress VARCHAR(255),
        contactNo VARCHAR(15),
        paymentMethod VARCHAR(50),
        expirationDate VARCHAR(255)
    ) ENGINE = InnoDB";
    
    private function __construct() {}

    public static function createDatabase() {
        $connection = new mysqli(self::$serverName, self::$userName, self::$password);

        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }

        // Check if the database exists before creating it
        $checkDatabaseSQL = "CREATE DATABASE IF NOT EXISTS " . self::$databaseName;

        if ($connection->query($checkDatabaseSQL) === true) {
            //echo "Database created or already exists.\n";
        } else {
            echo "Error creating database: " . $connection->error;
        }

        $connection->close();
    }

    public static function getConnection() {
        if (self::$connection === null) {
            self::$connection = new mysqli(self::$serverName, self::$userName, self::$password, self::$databaseName);

            if (self::$connection->connect_error) {
                die("Connection failed: " . self::$connection->connect_error);
            }
        }

        return self::$connection;
    }

    public static function getProducts() {
        $connection = self::getConnection();
    
        $query = "SELECT * FROM products";
        $result = $connection->query($query);
    
        $products = array();
    
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    
        return $products;
    }

    public static function getProductById() {
        $connection = self::getConnection();
    
        $query = "SELECT id FROM products";
        $result = $connection->query($query);
    
        $productId = array();
    
        while ($row = $result->fetch_assoc()) {
            $productId[] = $row['id'];
        }
    
        return $productId;
    }

    // auto insert data if table it not populated
    public static function populateProductsTable() {
        $connection = self::getConnection();

         // Check if data already exists
        $checkDataSQL = "SELECT COUNT(*) as count FROM products";
        $result = $connection->query($checkDataSQL);
    
        if ($result && $result->fetch_assoc()['count'] > 0) {
            //echo "Data already exists in the products table. Skipping insertion.\n";
            return;
        }

        $insertDataSQL = "
            INSERT INTO products (Product, price, quantity, image) VALUES
            ('Galaxy S23 Ultra', 'Php 81,990.00', '50', './images/s23ultra.png'),
            ('Galaxy S23 Plus', 'Php 68,990.00', '50', './images/s23+.png'),
            ('Galaxy S23', 'Php 53,990.00', '50', './images/s23.png'),
            ('Galaxy Z Flip 5', 'Php 64,990.00', '50', './images/zflip5.png'),
            ('Galaxy Z Flip 4', 'Php 43,990.00', '50', './images/zflip4.png'),
            ('Galaxy Z Flip 3', 'Php 18,450.00', '50', './images/zflip3.png'),
            ('Marshall Mode EQ', 'Php 3,750.00', '50', './images/marshallmodeeq.png'),
            ('Samsung Galaxy Buds 2', 'Php 12,990.00', '50', './images/galaxybuds2.png'),
            ('Samsung AKG', 'Php 400.00', '50', './images/samsungakg.png')
        ";

        if ($connection->query($insertDataSQL) === true) {
            echo "Data inserted successfully\n";
        } else {
            echo "Error inserting data: " . $connection->error . "\n";
        }
    }
}

// Create the database
SingletonDB::createDatabase();

// Create the product table
$connection = SingletonDB::getConnection(); // Get the database connection

if ($connection->query(SingletonDB::$createProducts) === true) {
    //populate the products table
    SingletonDB::populateProductsTable();
} else {
    echo "Error creating table: " . $connection->error . "\n";
}

//create cart table
if ($connection->query(SingletonDB::$createCart) === true) {

} else {
    echo "Error creating table: " . $connection->error . "\n";
}

//create orders table
if ($connection->query(SingletonDB::$createOrders) === true) {

} else {
    echo "Error creating table: " . $connection->error . "\n";
}
?>