<?php
require 'db_connection.php';

class CartFacade {    
    public function checkout($name, $shippingAddress, $billingAddress, $contactNo, $paymentMethod, $creditCardNumber, $cvv, $expirationDate, $productId, $quantity) {
        // Step 2: Validate credit card using Luhn's algorithm
        if (!$this->validateCreditCard($creditCardNumber)) {
            echo '<script type="text/javascript">alert("Invalid credit card number!");</script>';
            return "Invalid credit card number.";
        }
        
        //ccv or date is wrong
        if (!$this->validateCVV($cvv) || !$this->validateExpirationDate($expirationDate)) {
            echo '<script type="text/javascript">alert("Invalid CVV or expiration date.");</script>';
            return "Invalid CVV or expiration date.";
        }

        // Step 4: Deduct the item quantity from the database
        if (!$this->deductQuantity($productId, $quantity)) {
            
            return "Error deducting item quantity.";
        }
        
        return "Payment processed successfully";
    }

    private function validateCreditCard($creditCardNumber) {
        // Implement Luhn's algorithm credit card validation
        settype($creditCardNumber, 'string');
        $sumTable = array(
            array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9),
            array(0, 2, 4, 6, 8, 1, 3, 5, 7, 9)
        );
        $sum = 0;
        $flip = 0;
    
        for ($i = strlen($creditCardNumber) - 1; $i >= 0; $i--) {
            $sum += $sumTable[$flip++ & 0x1][$creditCardNumber[$i]];
        }
    
        // Check if the sum is a multiple of 10
        return $sum % 10 === 0;
    }

    private function deductQuantity($productId, $quantity) {
        $connection = SingletonDB::getConnection();
    
        // Check if the product is in stock
        $product = $this->getProductById($productId);
    
        if (!$product) {
            return "Product not found.";
        }
    
        if ($product['quantity'] < $quantity) {
            return "Not enough stock.";
        }
    
        // Deduct the quantity from the database using a prepared statement
        $updateQuery = "UPDATE products SET quantity = quantity - ? WHERE id = ?";
        
        $stmt = $connection->prepare($updateQuery);
    
        if (!$stmt) {
            return "Error preparing update statement: " . $connection->error;
        }
    
        // Bind the parameters
        $stmt->bind_param("ii", $quantity, $productId);
    
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return "Error updating product quantity: " . $connection->error;
        }
    }

    private function validateCVV($cvv) {
        // CVV should be a 3 or 4-digit number
        return preg_match('/^\d{3,4}$/', $cvv) === 1;
    }

    private function validateExpirationDate($expirationDate) {
        // Expiration date should be in MM/YY or MM/YYYY format
        $pattern = '/^(0[1-9]|1[0-2])\/(20\d{2}|[3-9]\d)$/'; // MM/YYYY or MM/YY
        return preg_match($pattern, $expirationDate) === 1;
    }

    private function getProductById($productId) {
        $products = SingletonDB::getProducts();

        foreach ($products as $product) {
            if ($product['id'] == $productId) {
                return $product;
            }
        }

        return null;
    }
}
?>
