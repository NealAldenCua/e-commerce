<?php

require_once("db_connection.php"); // Include your database connection

if (!function_exists('calculateTotalPrice')) {
    function calculateTotalPrice($connection) {
        // Query the cart items
        $cartItems = getCartItems($connection);

        $totalPrice = 0;

        foreach ($cartItems as $cartItem) {
            // Fetch the price of the product from the "cart" table
            $productId = $cartItem['product_id'];
            $productPrice = getProductPriceFromDatabase($connection, $productId);

            if ($productPrice !== null) {
                $totalPrice += (float)$productPrice * (int)$cartItem['quantity'];
            }
        }

        return $totalPrice;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['productId']) && isset($_POST['quantity'])) {
        $productId = $_POST['productId'];
        $newQuantity = $_POST['quantity'];

        // Perform the database update to set the new quantity for the product in the cart
        $connection = SingletonDB::getConnection();
        $query = "UPDATE cart SET quantity = ? WHERE product_id = ?";

        // Prepare the query
        $stmt = $connection->prepare($query);

        if (!$stmt) {
            die("Query preparation error: " . $connection->error);
        }

        // Bind the parameters and execute the query
        $stmt->bind_param("ii", $newQuantity, $productId);

        if ($stmt->execute()) {
            // Cart updated successfully
            $response = ["success" => true, "message" => "Cart updated successfully"];

            // Calculate the total price after updating the quantity
            $totalPrice = calculateTotalPrice($connection);
            $response["totalPrice"] = $totalPrice;
        } else {
            // Cart update failed
            $response = ["success" => false, "message" => "Failed to update quantity"];
        }

        // Close the statement and database connection
        $stmt->close();
        $connection->close();

        // Return a JSON response
        echo json_encode($response);
    } elseif (isset($_POST['removeProductId'])) {
        $productIdToRemove = $_POST['removeProductId'];

        // Add code here to handle the removal of the product from the cart
        // ...

        //$response = ["success" => true, "message" => "Product removed successfully"];
        
        // Return a JSON response
        //echo json_encode($response);

        //echo '<script>location.reload();</script>';
        header("Location: cart.php");
    } else {
        // Invalid request
        echo json_encode(["success" => false, "message" => "Invalid request"]);
    }
}
?>
