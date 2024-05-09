<?php
session_start(); // Start the session to access session variables
include("../navbar/navbar.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get user ID from session
    $userId = $_SESSION['user_id'];

    // Get user type from session
    $userType = $_SESSION['user_type'];
    $tableName = ($userType == 'employee') ? 'employees' : 'customers';

    // Database connection
    $connection = mysqli_connect("localhost", "root", "", "users");

    // Check connection
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Check if email is submitted and not empty
    if (isset($_POST['email']) && !empty(trim($_POST['email']))) {
        $email = $_POST['email'];

        // Update email based on user type
        $tableName = ($userType == 'employee') ? 'employees' : 'customers';
        $sql = "UPDATE $tableName SET email = '$email' WHERE id = $userId";

        if (mysqli_query($connection, $sql)) {
            echo "Email updated successfully";
        } else {
            echo "Error updating email: " . mysqli_error($connection);
        }
    }

    // Check if password is submitted and not empty
    if (isset($_POST['password']) && !empty(trim($_POST['password']))) {
        $password = $_POST['password'];

        // Update password based on user type
        $tableName = ($userType == 'employee') ? 'employees' : 'customers';
        $sql = "UPDATE $tableName SET password = '$password' WHERE id = $userId";

        if (mysqli_query($connection, $sql)) {
            echo "Password updated successfully";
        } else {
            echo "Error updating password: " . mysqli_error($connection);
        }
    }

    // Fetch user's cart history from the database
    $sql = "SELECT cartHistory FROM $tableName WHERE id = $userId";
    $result = mysqli_query($connection, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $cartHistory = $row['cartHistory'];

        if (isset($cartHistory) && !empty($cartHistory)) {
            // Explode cart history into individual carts
            $carts = explode(";", $cartHistory);

            // Display cart history
            echo "<h2>Cart History</h2>";
            foreach ($carts as $cart) {
                // Separate cart into items and purchase time
                $cartData = explode("|", $cart);
                $purchaseTime = array_pop($cartData);
                $items = implode(", ", $cartData);

                // Check if cart data is not empty
                if (!empty($items)) {
                    // Format and display cart entry
                    echo "<h3>Purchased on: $purchaseTime</h3>";
                    echo "<ul>";
                    $itemDetails = explode(",", $items);
                    foreach ($itemDetails as $item) {
                        $details = explode("|", $item);
                        if (count($details) >= 4) {
                            $productName = $details[0];
                            $productBrand = $details[1];
                            $productPrice = $details[2];
                            $productWeight = $details[3];
                            $quantity = isset($details[4]) ? $details[4] : 1; // Default quantity to 1 if not provided
                            // Display the product details
                            echo "<li>Product: $productName | Brand: $productBrand | Price: $$productPrice | Weight: $productWeight | Quantity: $quantity</li>";
                        } else {
                            // Handle the case where the array keys are undefined
                            echo "<li>Invalid cart entry</li>";
                        }
                    }
                    echo "</ul>";
                }
            }
        } else {
            echo "No cart history found";
        }
    } else {
        echo "No cart history found";
    }

    // Close connection
    mysqli_close($connection);

    // Reload the page to reflect changes
    echo "<script>window.location.href = 'profile.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="../navbar/navbar.css">
</head>
<body>

<?php
// Database connection
$connection = mysqli_connect("localhost", "root", "", "users");
// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
// Fetch user's cart history from the database
$userId = $_SESSION['user_id'];
$userType = $_SESSION['user_type'];
$tableName = ($userType == 'employee') ? 'employees' : 'customers';
$sql = "SELECT firstName, lastName FROM $tableName WHERE id = $userId";
$result = mysqli_query($connection, $sql);

$row = mysqli_fetch_assoc($result);
$user_name = $row['firstName'] . ' ' . $row['lastName'];

$sql = "SELECT email FROM $tableName WHERE id = $userId";
$result = mysqli_query($connection, $sql);

$row = mysqli_fetch_assoc($result);
$email = $row['email'];

 ?>
<!-- Profile Content -->
<div class="profile-container">
  <h1 class="title">Welcome, <?php echo $user_name; ?></h1>
  <div class="profile-info">
      <h2>Edit Profile</h2>
      <form action="#" method="POST">
          <span id="email" class="plaintext"><?php echo "Email: $email"; ?></span>
          <input type="email" id="email-input" name="email" placeholder="Enter your email" autocomplete="off" style="display: none;">
          <button type="button" class="edit-button" onclick="toggleEditMode('email')">✏️</button>

          <label for="password"></label>
          <span id="password" class="plaintext"><?php echo "Password: ********"; ?></span>
          <input type="password" id="password-input" name="password" placeholder="Enter your password" autocomplete="off" style="display: none;">
          <button type="button" class="edit-button" onclick="toggleEditMode('password')">✏️</button>

          <button type="submit" class="button" id="update-button" style="display: none;">Update Profile</button>
      </form>
  </div>

  <script>
    function toggleEditMode(fieldId) {
        var field = document.getElementById(fieldId);
        var inputField = document.getElementById(fieldId + "-input");
        var updateButton = document.getElementById("update-button");

        if (field.style.display === "none") {
            field.style.display = "inline";
            inputField.style.display = "none";
            updateButton.style.display = "none";
        } else {
            field.style.display = "none";
            inputField.style.display = "inline";
            updateButton.style.display = "inline";
        }
    }
</script>

<h2>Edit Payment Information</h2>
<form id="paymentForm" action="#" method="POST" style="display: none;">
    <ul>
        <li>
            <label for="credit_card_number">Credit Card Number:</label>
            <input type="text" id="credit_card_number" name="credit_card_number" placeholder="Enter credit card number">
        </li>
        <li>
            <label for="cardholder_name">Cardholder Name:</label>
            <input type="text" id="cardholder_name" name="cardholder_name" placeholder="Enter cardholder name">
        </li>
        <li>
            <label for="expiration_date">Expiration Date:</label>
            <input type="text" id="expiration_date" name="expiration_date" placeholder="Enter expiration date">
        </li>
        <li>
            <label for="ccv">CCV:</label>
            <input type="text" id="ccv" name="ccv" placeholder="Enter CCV">
        </li>
    </ul>

    <button type="submit" class="button">Update Payment Information</button>
</form>

<button id="editPaymentButton" class="button" onclick="togglePaymentForm()">Edit Payment Information</button>

<script>
    function togglePaymentForm() {
        var paymentForm = document.getElementById("paymentForm");
        var editPaymentButton = document.getElementById("editPaymentButton");

        if (paymentForm.style.display === "none") {
            paymentForm.style.display = "block";
            editPaymentButton.innerText = "Hide Payment Information";
        } else {
            paymentForm.style.display = "none";
            editPaymentButton.innerText = "Edit Payment Information";
        }
    }
</script>

<?php
// Fetch user's current cart from the database
$sql = "SELECT currentCart FROM $tableName WHERE id = $userId";
$result = mysqli_query($connection, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $currentCart = $row['currentCart'];

    // Display currentCart contents
    echo "<h3>Current Cart: </h3>";
    if (!empty($currentCart)) {
        echo "<ul>";
        // Explode the currentCart string into individual items
        $items = explode(",", $currentCart);
        foreach ($items as $item) {
            // Explode each item into product details
            $details = explode("|", $item);
            $productName = $details[0];
            $productBrand = $details[1];
            $productPrice = $details[2];
            $productWeight = $details[3];
            $quantity = isset($details[4]) ? $details[4] : 1; // Default quantity to 1 if not provided
            // Display the product details
            echo "<li>$productName - $productBrand - $$productPrice - $productWeight (x$quantity)</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Cart is empty</p>";
    }
} else {
    echo "<p>No cart found</p>";
}

// Fetch user's cart history from the database
$sql = "SELECT cartHistory FROM $tableName WHERE id = $userId";
$result = mysqli_query($connection, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $cartHistory = $row['cartHistory'];

    if ($cartHistory !== NULL) { // Check if cartHistory is not NULL
        // Explode cart history into individual carts based on purchase times
        $cartHistory = ltrim($cartHistory, ',');
        $carts = explode(";", $cartHistory);

        // Display cart history
        echo "<h2>Cart History</h2>";
        foreach ($carts as $cart) {
            // Separate cart into items and purchase time
            $cartData = explode("|", $cart);
            $purchaseTime = array_pop($cartData);
            $items = implode("|", $cartData);

            // Display purchase time
            echo "<h3>Purchased on: $purchaseTime</h3>";

            // Display cart items
            echo "<ul>";
            $itemDetails = explode(",", $items);
            foreach ($itemDetails as $item) {
                $details = explode("|", $item);
                if (count($details) >= 4) {
                    $productName = $details[0];
                    $productBrand = $details[1];
                    $productPrice = $details[2];
                    $productWeight = $details[3];
                    $quantity = isset($details[4]) ? $details[4] : 1; // Default quantity to 1 if not provided
                    // Display the product details
                    echo "<li>Product: $productName | Brand: $productBrand | Price: $$productPrice | Weight: $productWeight | Quantity: $quantity</li>";
                } else {
                    // Handle the case where the array keys are undefined
                    echo "<li>Invalid cart entry</li>";
                }
            }
            echo "</ul>";
        }
    } else {
        echo "No cart history found";
    }
} else {
    echo "No cart history found";
}

// Close connection
mysqli_close($connection);
?>
</div>

</body>
</html>
