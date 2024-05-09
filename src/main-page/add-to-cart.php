<?php
session_start(); // Start the session

echo "User ID: " . $_SESSION['user_id'] . "<br>";
echo "User Type: " . $_SESSION['user_type'] . "<br>";
$items_added = 0;

// First, retrieve the user_id from the session
$user_id = $_SESSION['user_id'];
$tableName = ($_SESSION['user_type'] == 'employee') ? 'employees' : 'customers';

// Handle form submission to add the product to the user's cart
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_to_cart'])) {
    // Retrieve product data from query parameters
    $productName = $_GET['product_name'];
    $productBrand = $_GET['product_brand'];
    $productPrice = $_GET['product_price'];
    $productWeight = $_GET['product_weight'];


    // Update the employee's cart with the new product
    $connection = mysqli_connect("localhost", "root", "", "users");
    if (!$connection) {
        echo 'error';
        die("Connection failed: " . mysqli_connect_error());
    }
    echo "Hello";

    // Retrieve the current cart data from the database
    $sql_select_cart = "SELECT currentCart FROM $tableName WHERE id = $user_id";
    $result_select_cart = mysqli_query($connection, $sql_select_cart);
    if ($result_select_cart) {
        $row = mysqli_fetch_assoc($result_select_cart);
        $currentCart = $row['currentCart'];
    } else {
        echo "Error: " . mysqli_error($connection);
        mysqli_close($connection);
        exit();
    }

    // Append the new product information to the current cart data
    // Check if $currentCart is not empty
    if (!empty($currentCart)) {
        $updatedCart = $currentCart . ",";
    } else {
        $updatedCart = "";
    }

    // Append the new product information to the current cart data
    $updatedCart .= "$productName|$productBrand|$productPrice|$productWeight";

    // Update the database with the new cart data
    $sql_update_cart = "UPDATE $tableName SET currentCart = '$updatedCart' WHERE id = $user_id";
    $result_update_cart = mysqli_query($connection, $sql_update_cart);
    if ($result_update_cart) {
        echo "Product added to cart successfully.";
    } else {
        echo "Error: " . mysqli_error($connection);
    }

    mysqli_close($connection);
}
  header("Location: ../main-page/main-page.php");
  exit;
?>
