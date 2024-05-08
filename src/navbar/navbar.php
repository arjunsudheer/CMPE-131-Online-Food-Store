<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../navbar/navbar.css">
    <!-- Load an icon library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <!-- Left side bar -->
    <div id="left-sidebar">
        <h1>OFS</h1>
        <p>At Downtown San Jose</p>
        <a href="../main-page/main-page.php"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
        <?php
        // Start the session
       // session_start();
       if (isset($_SESSION['user_type']) && $_SESSION['user_type'] !== 'logged_out') {
            echo '<a href="../profile/profile.php"><i class="fa fa-fw fa-dollar"></i> Profile</a>';
            //echo '<a href="../checkout/CheckOutPage.php"><i class="fa fa-fw fa-dollar"></i> Checkout</a>';
       }
        // Check if the user is an employee
        if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'employee') {
            echo '<a href="../inventory/inventoryPage.php"><i class="fa fa-cube" aria-hidden="true"></i> Inventory</a>';
        }
        ?>
        <a id="cart-button" href="#"><i class="fa fa-fw fa-shopping-cart"></i> Cart</a>
        <a href="../about-page/about-page.php"><i class="fa fa-store" aria-hidden="true"></i> About Us</a>

        <a href="../navbar/logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>


    </div>
    <!-- Cart menu, will hide and show whenever the cart button is pressed -->
    <div class="cart-menu">
        <h3>Shopping Cart</h3>
        <div class="cart-item">
            <img src="#" alt="Shopping cart item">
            <p>Apples</p>
            <p>$5.00</p>
            <p>2 lbs.</p>
            <div class="product-quantity-adjustment">
                <i id="subtract-quantity" class="fa fa-minus" aria-hidden="true"></i>
                <p id="quantity-amount">1</p>
                <i id="add-quantity" class="fa fa-plus" aria-hidden="true"></i>
            </div>
            <div id="checkout-total">
                <p>Subtotal = cost</p>
                <p>Weight = lbs</p>
                <a href="../checkout/CheckOutPage.php"><button type="submit" id="checkout-button">Checkout</button></a>
            </div>
        </div>
    </div>
</body>

<script src="../navbar/navbar.js"></script>

</html>
