
<link rel="icon" type="image/x-icon" href="./images/iconLogo.png">
<?php
session_start(); // Start the session

require 'facade.php';

$cartFacade = new CartFacade();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process the form data
    $name = $_POST['name'];
    $shippingAddress = $_POST['shippingAddress'];
    $billingAddress = $_POST['billingAddress'];
    $contactNo = $_POST['contactNo'];
    $paymentMethod = $_POST['paymentMethod'];
    $creditCardNumber = $_POST['creditCardNumber'];
    $cvv = $_POST['cvv'];
    $expirationDate = $_POST['expirationDate'];

    // Validation (Orderly manner)
    $errorMessage = '';

    // Step 1: Name validation
    if (!preg_match("/^[A-Za-z ]+$/", $name)) {
        $errorMessage = "Invalid name. Please enter letters and spaces only.";
    }
    if ($errorMessage === '') {
        $connection = SingletonDB::getConnection();

        if (!$connection) {
            die("Database connection error.");
        }

        // Query to retrieve items from the cart table
        $cartItems = getCartItems($connection);
        // Check if $_SESSION['cart'] is set and is not empty
        if (isset($_SESSION['shopping_cart']) && is_array($_SESSION['shopping_cart']) && !empty($_SESSION['shopping_cart'])) {
            // foreach ($cartItems as $cartItem) {
            //     if (isset($cartItem['product_id']) && isset($cartItem['quantity'])) {
            //         $productDetails = getProductDetails($connection, $cartItem['product_id']);
            //         $productId = $cartItem['product_id'];
            //         $quantity = $cartItem['quantity'];

            //         $checkoutResult = $cartFacade->checkout($name, $shippingAddress, $billingAddress, $contactNo, $paymentMethod, $creditCardNumber, $cvv, $expirationDate, $productId, $quantity);
    
            //         // Check the result and provide feedback to the user
            //         if ($checkoutResult === "Payment processed successfully") {
            //             // Payment successful for this product
            //             echo '<script type="text/javascript">alert("Thank you for your purchase!");</script>';
            //             echo '<a href="index.php" class="checkout-button"
            //                 style="display: block;
            //                 margin-top: 10px;
            //                 padding: 10px;
            //                 background-color: #009688;
            //                 color: #fff;
            //                 text-align: center;
            //                 border: none;
            //                 border-radius: 5px;
            //                 cursor: pointer;
            //                 text-decoration: none;">Go Back Shopping!</a>';

            //                 // Delete cart items after successful checkout
            //                 deleteCartItems($connection);
            //             return;

            //         } else {
            //             // Payment failed for this product
            //             //echo "Transaction failed!<br>";
            //             $errorMessage = "Checkout failed!";
                        
            //         }
            //     } else {
            //         // Handle missing 'product_id' or 'quantity' keys in cartItem
            //         $errorMessage = "Invalid data found in your cart.";
            //     }
            // }

            foreach ($cartItems as $cartItem) {
                if (isset($cartItem['product_id']) && isset($cartItem['quantity'])) {
                    $productDetails = getProductDetails($connection, $cartItem['product_id']);
                    $productId = $cartItem['product_id'];
                    $quantity = $cartItem['quantity'];
            
                    $checkoutResult = $cartFacade->checkout($name, $shippingAddress, $billingAddress, $contactNo, $paymentMethod, $creditCardNumber, $cvv, $expirationDate, $productId, $quantity);
            
                    // Check the result and accumulate errors
                    if ($checkoutResult !== "Payment processed successfully") {
                        
                        $errorMessages[] = "Checkout Failed! check field inputs if correct.";
                    }
                } else {
                    // Handle missing 'product_id' or 'quantity' keys in cartItem
                    $errorMessages[] = "Invalid data found in your cart for an item!";
                }
            }
            
            // Display accumulated error messages
            if (!empty($errorMessages)) {
                $errorMessage = implode("<br>", $errorMessages);
                // Display or handle the accumulated error messages as needed
            }
        } else {
            // Handle the case where the cart is empty or not set
            $errorMessage = "Your cart is empty. Add products to your cart before checking out.";
        }
    }   

    if ($errorMessage === '') {
        // All products were successfully checked out

        echo '<script type="text/javascript">alert("Thank you for your purchase!");</script>';
        echo '<script type="text/javascript">alert("All products were successfully checked out.");</script>';

        echo '<a href="index.php" class="checkout-button"
        style="display: block;
        margin-top: 10px;
        padding: 10px;
        background-color: #009688;
        color: #fff;
        text-align: center;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;">Go Back Shopping!</a>';
        
        // Delete cart items after successful checkout
        deleteCartItems($connection);

        //add to order table
        $inserted = insertOrder($connection, $name, $shippingAddress, $billingAddress, $contactNo, $paymentMethod, $expirationDate);

        return $inserted;
        exit;
    }else {
        // Display an alert using JavaScript
        echo '<script type="text/javascript">alert("' . $errorMessage . '");</script>';
    }
}

 function getCartItems($connection) {
    // Query the cart items
    $query = "SELECT * FROM cart";
    $result = $connection->query($query);

    $cartItems = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $cartItems[] = $row;
        }   
    }

    return $cartItems;
}

function getProductDetails($connection, $productId) {
    // Fetch product details based on the product ID
    //$query = "SELECT Phone, CAST(REPLACE(SUBSTRING(price, 5), ',', '') AS DECIMAL(10, 2)) AS price_decimal, image, quantity FROM samsungphone WHERE id = ?";
    $query = "SELECT Product, CAST(REPLACE(SUBSTRING(price, 5), ',', '') AS DECIMAL(10, 2)) AS price_decimal, image, quantity FROM products WHERE id = ?";

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

    $stmt->close(); // Close the statement

    return $productDetails;
}


function deleteCartItems($connection) {
    // Delete all cart items from the cart table
    $query = "DELETE FROM cart";
    $result = $connection->query($query);

    if (!$result) {
        die("Error deleting cart items: " . $connection->error);
    }
}

function insertOrder($connection, $name, $shippingAddress, $billingAddress, $contactNo, $paymentMethod, $expirationDate) {
    $query = "INSERT INTO orders (name, shippingAddress, billingAddress, contactNo, paymentMethod, expirationDate) VALUES (?, ?, ?, ?, ?, ?)";

    // Prepare the query
    $stmt = $connection->prepare($query);

    // Check for errors in the prepare statement
    if (!$stmt) {
        die("Error in prepare statement: " . $connection->error);
    }

    // Bind parameters and execute the query
    $stmt->bind_param("ssssss", $name, $shippingAddress, $billingAddress, $contactNo, $paymentMethod, $expirationDate);
    
    // Check for errors in binding parameters
    if (!$stmt) {
        die("Error in bind parameters: " . $stmt->error);
    }

    // Execute the query
    $inserted = $stmt->execute();

    // Check for errors in execution
    if (!$inserted) {
        die("Error in execution: " . $stmt->error);
    }

    // Close the statement
    $stmt->close();

    return $inserted;
}

// Include checkout form HTML
include 'checkout.php';
?>

<!-- Contact No. validation -->
<script>
    document.getElementById("contactNo").addEventListener("input", function () {
        var contactNo = this.value;
        if (contactNo.length !== 11) {
            this.style.borderColor = "red";
            this.setCustomValidity("Your number is not valid.");
        } else {
            this.style.borderColor = ""; // Reset border color
            this.setCustomValidity("");
        }
    });
</script>