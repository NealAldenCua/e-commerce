<?php
session_start();
require("db_connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['productId'])) {
    $productId = $_POST['productId'];

    // Fetch product details from the database based on the product ID
    $product = getDetailsForProductId($productId);

    if ($product) {
        // $Phone = $product['Phone'];
        $Product = $product['Product'];
        $image = $product['image'];

        // Add the product to the shopping cart in the database
        $addedToCart = addToCart($productId, $product, $Product, $image);
        if ($addedToCart) {
            echo 'Product added to the cart successfully.';
        } else {
            echo 'Failed to add the product to the cart.';
        }
    } else {
        echo 'Product not found.';
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['removeProductId'])) {
    // Retrieve the product ID to be removed
    $productId = $_POST['removeProductId'];

    // Remove the product from the cart
    $removed = removeFromCart($productId);

    if ($removed) {
        echo 'Product removed from the cart.';
    } else {
        echo 'Failed to remove the product from the cart.';
    }
} else {
    echo 'Invalid request.';
}

function getDetailsForProductId($productId) {
    $connection = SingletonDB::getConnection();
   // $query = "SELECT Phone, image FROM samsungphone WHERE id = ?";
   $query = "SELECT Product, image FROM products WHERE id = ?";

    // Prepare the query
    $stmt = $connection->prepare($query);

    if (!$stmt) {
        die("Query preparation error: " . $connection->error);
    }

    // Bind the parameter and execute the query
    $stmt->bind_param("i", $productId);
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $productDetails = $result->fetch_assoc();
    } else {
        $productDetails = null;
    }

    // Close the statement
    $stmt->close();
    return $productDetails;
}

function addToCart($productId, $product, $Product, $image) {
    // Check if the shopping cart session variable exists; if not, create it
    if (!isset($_SESSION['shopping_cart'])) {
        $_SESSION['shopping_cart'] = array();
    }

    // Add the product to the shopping cart session variable
    $_SESSION['shopping_cart'][] = $product;

    // Insert the product into the cart table in the database
    $quantity = 1; // You can modify this as needed

    // Insert the product into the cart table in the database
    $inserted = insertProductIntoCart($productId, $quantity, $Product, $image);

    return $inserted;
}

function insertProductIntoCart($productId, $quantity, $Product, $image) {
    // Connect to your database (modify as needed)
    $connection = SingletonDB::getConnection();

    // Modify this SQL query to match your database schema
    //$query = "INSERT INTO cart (product_id, quantity, Phone, image) VALUES (?, ?, ?, ?)";
    $query = "INSERT INTO cart (product_id, quantity, Product, image) VALUES (?, ?, ?, ?)";
    
    // Prepare the query
    $stmt = $connection->prepare($query);

    // Bind parameters and execute the query
    $stmt->bind_param("iiss", $productId, $quantity, $Product, $image);
    $inserted = $stmt->execute();

    // Close the statement and the database connection
    $stmt->close();
    $connection->close();

    return $inserted;
}
?>
