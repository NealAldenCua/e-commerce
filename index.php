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
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.min.js"></script>

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

<!-- Custom Stylesheet -->
<link rel="stylesheet" href="../WEB-SYSINARC-CUA_SORIANO-MP4/css/style.css" />
</head>

<body>
    <!-- nav and start screen -->
    <div class="banner" id="home">
        <div class="navbar">
            <img src="./images/logo.png" class="logo">
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#product">Products</a></li>
                    <li><a href="cart.php">Cart</a></li>
                </ul>
        </div>
        <div class="content">
            <h1>WHERE THE FUN BEGINS</h1>
            <p>HIGH-END PHONES FOR YOUR SATISFACTION</p>
            <div>
                <button type="button" class="bu"><span class="spa"></span><a href="#product"> PURCHASE NOW</button>
                <button type="button" class="bu"><span class="spa"></span><a href="#footer-contact"> CONTACT US</a></button>
            </div>
        </div>
    </div>
    <!-- end of nav and start screen -->

<!-- products; changed include to require -->
<?php require ("db_connection.php"); 
    require ("abstract_factory.php");

// Create the database
SingletonDB::createDatabase();

// Create the product table
$connection = SingletonDB::getConnection(); // Get the database connection

if ($connection->query(SingletonDB::$createProducts) === true) {
    //echo "Table 'samsungphone' created successfully\n";
} else {
    //echo "Error creating table: " . $connection->error . "\n";
}

// Execute the CREATE TABLE query for the "cart" table
if ($connection->query(SingletonDB::$createCart) === true) {
    //echo "Table 'cart' created successfully.";
} else {
    //echo "Error creating table: " . $connection->error;
}

// Instantiate the abstract factories
$phoneFactory = new PhoneFactory();
$earphonesFactory = new EarphonesFactory();
?>

<!-- products -->
<div class="product-container" id="product">
    <?php
    // Fetch product data from the database
    $productData = SingletonDB::getProducts();

    $modalId = 1;
    
    // Iterate through product data
    foreach ($productData as $product) {
        $className = str_replace(' ', '', $product['Product']);
        $className = ucfirst($className);
    
        if (class_exists($className)) {
            if (in_array('Phone', class_implements($className))) {
                $phone = $phoneFactory->createPhone($product['Product']);
    
                if ($phone instanceof Phone) {
                    echo '<div class="product-card">';
                    echo '<center><img src="'.$product['image'].'"></center>';
                    echo '<div class="product-details">';
        
                    $phone->populate($product);
                    $phone->details();
        
                    echo '</div>';
                    echo '<center><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#productModal' . $modalId . '">More Details</button></center>';
                    echo '</div>';
        
                    // Modal for each product
                    echo '<div class="modal fade" id="productModal' . $modalId . '" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">';
                    echo '<div class="modal-dialog" role="document">';
                        echo '<div class="modal-content">';
                            echo '<div class="modal-header">';
                                echo '<h3 class="modal-title" id="productModalLabel">' . $product['Product'] . ' Details</h3>';
                                echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                                    echo '<span aria-hidden="true">&times;</span>';
                                echo '</button>';
                        echo '</div>';
                        echo '<div class="modal-body">';
                            echo '<div id="productDetailsContent">';
                                // Product details will be dynamically loaded here
                                    echo '<center><img src="'.$product['image'].'"></center>';
                                    $phone->details();
                                    $phone->moredetails();
                                echo '</div>';
                                echo '<center>';
                                    echo '<button type="button" class="btn btn-primary" id="addToCartButton" onclick="addToCart(' . $modalId . ')">';
                                    echo '<span class="spa"></span>Add to Cart';
                                    echo '</button>';
                                echo '</center>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } elseif (in_array('Earphones', class_implements($className))) {
                $earphones = $earphonesFactory->createEarphones($product['Product']);
    
                if ($earphones instanceof Earphones) {
                    echo '<div class="product-card">';
                    echo '<center><img src="'.$product['image'].'"></center>';
                    echo '<div class="product-details">';
        
                    $earphones->populate($product);
                    $earphones->details();
        
                    echo '</div>';
                    echo '<center><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#productModal' . $modalId . '">More Details</button></center>';
                    echo '</div>';
        
                    // Modal for each product
                    echo '<div class="modal fade" id="productModal' . $modalId . '" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">';
                    echo '<div class="modal-dialog" role="document">';
                        echo '<div class="modal-content">';
                            echo '<div class="modal-header">';
                                echo '<h3 class="modal-title" id="productModalLabel">' . $product['Product'] . ' Details</h3>';
                                echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                                echo '<span aria-hidden="true">&times;</span>';
                            echo '</button>';
                        echo '</div>';
                        echo '<div class="modal-body">';
                            echo '<div id="productDetailsContent">';
                                // Product details will be dynamically loaded here
                                    echo '<center><img src="'.$product['image'].'"></center>';
                                    $earphones->details();
                                    $earphones->moredetails();
                                    echo '</div>';
                                    echo '<center>';
                                echo '<button type="button" class="btn btn-primary" id="addToCartButton" onclick="addToCart(' . $modalId . ')">';
                                echo '<span class="spa"></span>Add to Cart';
                                echo '</button>';
                                echo '</center>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            }
        }
        //echo 'ID: ' . $modalId . '.';
        //echo 'Creating class: ' . $className . '!';
        $modalId++;
    }

    ?>
</div>
<!-- end of products -->

<!-- start of footer -->
    <div class="footer-dark" id="footer-contact">
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

<script>
// JavaScript function to load product details in the modal
    function loadProductDetails(productName) {
        var productDetailsContent = document.getElementById('productDetailsContent');
        var addToCartButton = document.getElementById('addToCartButton');

        // Load product details based on the product name (you can implement this logic)
        if (productName === 'GalaxyS23Ultra') {
            productDetailsContent.innerHTML = "Details for Galaxy S23 Ultra go here.";
        } else if (productName === 'AnotherProduct') {
            productDetailsContent.innerHTML = "Details for AnotherProduct go here.";
        } // Add more product details as needed

        // Show the modal using Bootstrap's modal method
        $('#productModal').modal('show');  
    }
    
    function addToCart(productId) {
        $.ajax({
            type: 'POST',
            url: 'add_to_cart.php',
            data: { productId: productId },
            success: function (response) {
                // Check if the response is not empty and contains the expected message
                if (response) {
                    alert(response);
                } else {
                    alert('Empty response or unexpected format.');
                }
            },
            error: function () {
                alert('Error occurred during the AJAX request.');
            }
        });
    }

    function updateQuantity(productId, newQuantity) {
    $.ajax({
        type: "POST",
        url: "update_cart.php",
        data: { productId: productId, quantity: newQuantity },
        success: function(response) {
            if (response.success) {
                // Update the cart display or handle success messages
                // You can update the displayed quantity and price here
                // For example, you can update the price by multiplying newQuantity with the product price
                var updatedPrice = newQuantity * response.productPrice;
                // Update the displayed quantity and price in the HTML
                var quantityField = document.getElementById('quantityField_' + productId);
                var priceField = document.getElementById('priceField_' + productId);
                quantityField.innerText = newQuantity;
                priceField.innerText = updatedPrice;
            } else {
                // Handle errors
                alert(response.message);
            }
        },
        error: function() {
            alert('Error occurred during the AJAX request.');
        }
    });
}

</script>

</body>
</html>