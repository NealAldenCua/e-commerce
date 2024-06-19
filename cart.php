<!DOCTYPE html>
<html>
<head>
	<title>TechGizmo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <link rel="icon" type="image/x-icon" href="./images/iconLogo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="../WEB-SYSINARC-CUA_SORIANO-MP4/css/cart.css"/>
</head>

<body>

    <div class="container-flex">
        <!-- nav and start screen -->
        <div class="banner" id="home">
            <div class="navbar">
                <img src="./images/logo.png" class="logo">
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="index.php">Products</a></li>
                        <li><a href="cart.php">Cart</a></li>
                    </ul>
            </div>
        </div>
        <!-- end of nav and start screen -->

    <!-- cart -->
    <div class="cart-container">
        <?php
            require_once("db_connection.php"); // Include your database connection
            require("update_cart.php");
            // Check if there is an active database connection
            $connection = SingletonDB::getConnection();

            if (!$connection) {
                die("Database connection error.");
            }

            // Query to retrieve items from the cart table
            $cartItems = getCartItems($connection);
            $hasItemsInCart = !empty($cartItems);

            if ($cartItems) { // Check if there are items in the cart
                echo '<h2>Your Shopping Cart</h2>';
                echo '<div style="width: 100%; margin-left: auto; margin-right: auto;">';
                echo '<table class="product_table">';
                echo '<tr>';
                echo '<th style="width: 500px"> Image </th>';
                echo '<th style="width: 900px"> Phone </th>';
                echo '<th style="width: 400px"> Price </th>';
                echo '<th style="width: 300px"> Quantity </th>';
                echo '<th style="width: 300px"> Action </th>';
                echo '</tr>';

                    foreach ($cartItems as $cartItem) { // Display each item in the cart
                        $productDetails = getProductDetails($connection, $cartItem['product_id']);
                        if (isset($productDetails)) {
                            echo '<tr>';
                            //echo '<td> <img style="max-width: 50%;" src="' . $productDetails['image'] . '" alt="' . $productDetails['Phone'] . '"> </td>';
                            echo '<td> <img style="max-width: 50%;" src="' . $productDetails['image'] . '" alt="' . $productDetails['Product'] . '"> </td>';
                            //echo '<td><b>' . $productDetails['Phone'] . '</b></td>';
                            echo '<td><b>' . $productDetails['Product'] . '</b></td>';
                            echo '<td class="product-subtotal">Php ' . number_format($cartItem['quantity'] * (float)$productDetails['price_decimal'], 2, '.', ',') . '</td>';
                            
                            echo '<td>';
                               // echo '<input type="number" name="quantity" value="' . $cartItem['quantity'] . '" min="1" onchange="updatePrice(this, ' . $productDetails['price_decimal'] . ')">';
                               echo '<input type="number" name="quantity" value="' . $cartItem['quantity'] . '" min="1" onchange="updatePrice(this, ' . $productDetails['price_decimal'] . ', ' . $cartItem['product_id'] . ')">';
                            echo '</td>';

                            echo '<td>';
                                echo '<form method="post" action="cart.php">';
                                echo '<input type="hidden" name="removeProductId" value="' . $cartItem['product_id'] . '">';
                                echo '<button type="submit" class="remove-button"><i class="fa fa-trash"></i></button>';
                                echo '</form>';
                            echo '</td>';
                            echo '</tr>';
                        } else {
                            echo '<tr><td colspan="5">Product not found.</td></tr>';
                        }
                    }

                echo '</table>';
                echo '</div>';

                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['removeProductId'])) { // Remove a product from the cart
                    $productId = $_POST['removeProductId'];

                    $connection = SingletonDB::getConnection();
                    $deleteQuery = "DELETE FROM cart WHERE product_id = ?";

                    $stmt = $connection->prepare($deleteQuery);
                    if (!$stmt) {
                        die("Query preparation error: " . $connection->error);
                    }

                    $stmt->bind_param("i", $productId);
                    if ($stmt->execute()) {
                        $response = ["success" => true, "message" => "Item removed successfully"];
                        //echo '<script type="text/javascript">alert("Item Removed!");</script>';
                        //header("Location: cart.php");
                        exit();
                    } else {
                        $response = ["success" => false, "message" => "Item removal failed"];
                    }

                    // Close the statement and database connection
                    $stmt->close();
                }
            } else {
                echo '<h3 style="text-align: center;">Your shopping cart is empty.</h3>';
            }

            // Close the database connection when done
            //$connection->close();

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
        ?>
        </div>

        <div class="cart-container">
            <?php
            function calculateTotalPrice($connection, $cartItems) {
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

            function getProductPriceFromDatabase($connection, $productId) {
                // Query the database to fetch the price of the product based on the product ID
                //$query = "SELECT price FROM samsungphone WHERE id = ?";
                $query = "SELECT price FROM products WHERE id = ?";
            
                // Prepare the query
                $stmt = $connection->prepare($query);
            
                if (!$stmt) {
                    die("Query preparation error: " . $connection->error);
                }
            
                $stmt->bind_param("i", $productId); // Bind the parameter and execute the query
                $stmt->execute();
            
                // Get the result
                $result = $stmt->get_result();
            
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $price = $row['price'];
            
                    // Extract the numeric value from the "price" field (remove "Php" and comma)
                    $price = str_replace('Php ', '', $price);
                    $price = str_replace(',', '', $price);
            
                    // Convert to a floating-point number
                    $price = (float) $price;
                } else {
                    $price = null; // Product not found or price not available
                }
            
                // Close the statement
                $stmt->close();
            
                return $price;
            }                                   

            // Calculate the total price
            $totalPrice = calculateTotalPrice($connection, $cartItems);

            // Display the total price
            echo '<div style="text-align: right;">';
            echo '<b>Total Price: Php ' . number_format($totalPrice, 2) . '</b>';
            echo '</div>';
            ?>

            <!-- Checkout button -->
            <form method="post" action="checkout.php">
                    <button type="submit" class="checkout-button<?php if (!$hasItemsInCart) echo ' disabled'; ?>"<?php if (!$hasItemsInCart) echo ' disabled'; ?>>
                        Checkout
                    </button>
            </form>
        </div>

        </div>
    </div>
    
<!-- end of cart -->

    <!-- start of footer -->
        <div class="footer-dark" id="footer-contact" style="p">
            <footer>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6 col-md-3 item">
                            <h3>Quick Links</h3>
                            <ul>
                                <li><a href="#home">Home</a></li>
                                <li><a href="#product">Products</a></li>
                            </ul>
                        </div>
                    
                        <div class="col-md-6 item text">
                            <h3>TechGizmo</h3>
                            <p>TechGizmo is your one-stop market for all your mobile gadget needs. Our mission is to bring you original brand-new/refurbished mobile devices 
                                from popular manufacturers that are eco-friendly and at the same time affordable.</p>
                        </div>
                        <div class="col item social">
                            <a href="https://www.facebook.com"><i class="icon ion-social-facebook"></i></a>
                            <a href="https://www.twitter.com"><i class="icon ion-social-twitter"></i></a>
                            <a href="https://www.instagram.com"><i class="icon ion-social-instagram"></i></a>
                            <a href="https://www.linkedin.com"><i class="icon ion-social-linkedin"></i></a>
                        </div>
                    </div>
                    <p class="copyright">TechGizmo © 2023</p>
                </div>
            </footer>
        </div>
    <!-- end of footer -->
    </div>
    

</body>
</html>

<script>
    // JavaScript function to update the subtotal based on quantity input
    // function updatePrice(inputElement, price) {
    //     const quantity = inputElement.value;
    //     const subtotal = quantity * price;
    //     const row = inputElement.closest('tr');
    //     const subtotalElement = row.querySelector('.product-subtotal');
    //     subtotalElement.textContent = 'Php ' + subtotal.toFixed(2);
    // }

    function updatePrice(input, price, productId) {
        const quantity = input.value;

        // Use AJAX to update the quantity in the database without refreshing the page
        $.ajax({
            type: 'POST',
            url: 'update_cart.php', // Update this path if needed
            data: {
                productId: productId,
                quantity: quantity
            },
            success: function (response) {
                if (response.success) {
                    // If the update is successful, update the displayed subtotal
                    const subtotal = quantity * price;
                    const formattedSubtotal = 'Php ' + subtotal.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                    const productSubtotal = input.parentElement.parentElement.querySelector('.product-subtotal');
                    productSubtotal.textContent = formattedSubtotal;

                    // Recalculate and update the total cost
                    calculateAndDisplayTotal();
                } else {
                    // Handle the case where the update in the database fails
                    alert('Quantity Updated. Please Refresh!');
                    // You might want to implement a more user-friendly way to handle errors.
                }
            },
            error: function () {
                // Handle the case where the AJAX request fails
                alert('Failed to update quantity. Please try again.');
                // You might want to implement a more user-friendly way to handle errors.
            }
        });
    }
</script>

<script>
    // JavaScript function to update the subtotal based on quantity input
    // function updatePrice(input, price) {
    //     const quantity = input.value;
    //     const subtotal = quantity * price;
    //     const formattedSubtotal = 'Php ' + subtotal.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'); // Formats the number with commas
    //     const productSubtotal = input.parentElement.parentElement.querySelector('.product-subtotal');
    //     productSubtotal.textContent = formattedSubtotal;
    // }

     // Function to recalculate and display the total cost
    function calculateAndDisplayTotal() {
        $.ajax({
            type: 'GET',
            url: 'update_cart.php', // Replace with the actual path to your total calculation script
            success: function (response) {
                if (response.success) {
                    const totalCostElement = document.getElementById('total-cost');
                    totalCostElement.textContent = 'Php ' + response.total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                } else {
                    // Handle the case where the total calculation fails
                    alert('Failed to calculate total cost. Please try again.');
                    // You might want to implement a more user-friendly way to handle errors.
                }
            },
            error: function () {
                // Handle the case where the AJAX request for total calculation fails
                alert('Failed to calculate total cost. Please try again.');
                // You might want to implement a more user-friendly way to handle errors.
            }
        });
    }
</script>