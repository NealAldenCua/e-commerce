<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
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
        <!-- Navigation and banner -->
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
        <!-- End of Navigation and banner -->
    </div>

    <!-- Checkout form -->
    <div class="cart-container" style="max-width: 50%;">
        <h2>Checkout</h2>
        <form action="process_checkout.php" method="post" >
            <!-- User Information -->
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="shippingAddress">Shipping Address:</label>
                <input type="text" id="shippingAddress" name="shippingAddress" style="max-width: 300px;" required>
            </div>
            <div class="form-group">
                <label for="billingAddress">Billing Address:</label>
                <input type="text" id="billingAddress" name="billingAddress" style="max-width: 300px;" required>
            </div>
            <div class="form-group">
                <label for="contactNo">Contact No.:</label>
                <input type="tel" id="contactNo" name="contactNo" required maxlength="11">
            </div>

            <!-- Payment Information -->
            <div class="form-group">
                <label for="paymentMethod">Payment Method:</label>
                <select id="paymentMethod" name="paymentMethod" required>
                    <option value="creditCard">Credit Card</option>
                </select>
            </div>
            <div class="form-group">
                <label for="creditCardNumber">Credit Card Number:</label>
                <input type="text" id="creditCardNumber" name="creditCardNumber" required>
            </div>
            <div class="form-group">
                <label for="cvv">CVV:</label>
                <input type="text" id="cvv" name="cvv" style="max-width: 35px;" required maxlength="3">
            </div>
            <div class="form-group">
                <label for="expirationDate">Expiration Date:</label>
                <input type="text" id="expirationDate" name="expirationDate" placeholder="MM/YYYY" style="max-width: 70px;" required>
            </div>

            <!-- <button type="submit" class="checkout-button" onsubmit="return validateForm()">Make Order</button> -->
            <button type="submit" class="checkout-button" >Make Order</button>
        </form>
    </div>
    
    <!-- End of Checkout form -->

    <div id="checkout-result-message"></div>

    <!-- Start of footer -->
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
    <!-- End of footer -->
    
</body>
</html>