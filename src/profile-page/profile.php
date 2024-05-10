<?php
session_start(); // Start the session to access session variables
include("../navbar/navbar.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get user ID from session
    $userId = $_SESSION['user_id'];

    // Get user type from session
    $userType = $_SESSION['user_type'];

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
                        if (count($details) == 4) {
                            $productName = $details[0];
                            $productBrand = $details[1];
                            $productPrice = $details[2];
                            $productWeight = $details[3];
                            // Format and display cart item
                            echo "<li>Product: $productName | Brand: $productBrand | Price: $$productPrice | Weight: $productWeight</li>";
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
 ?>
<!-- Profile Content -->
<div class="profile-container">
    <h1 class="title">Welcome, <?php echo $user_name; ?></h1>
    <div class="profile-info">
        <h2>Edit Profile</h2>
        <form action="#" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" autocomplete="off">

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" autocomplete="off">

            <button type="submit" class="button">Update Profile</button>
        </form>
    </div>

    <?php
    // Database connection
    $connection = mysqli_connect("localhost", "root", "", "users");
    // Check connection
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }
    // Fetch user's cart history from the database
    $userId = $_SESSION['user_id'];
    // Get user type from session
    $userType = $_SESSION['user_type'];
    $tableName = ($userType == 'employee') ? 'employees' : 'customers';
    // Fetch user's cart history from the database
$sql = "SELECT cartHistory FROM $tableName WHERE id = $userId";
$result = mysqli_query($connection, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $cartHistory = $row['cartHistory'];

    if ($cartHistory !== NULL) { // Check if cartHistory is not NULL
        // Trim leading delimiter if present
        $cartHistory = ltrim($cartHistory, ',;');

        // Explode cart history into individual carts based on purchase times
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
                if (count($details) == 4) {
                    $productName = $details[0];
                    $productBrand = $details[1];
                    $productPrice = $details[2];
                    $productWeight = $details[3];
                    // Format and display cart entry
                    echo "<li>Product: $productName | Brand: $productBrand | Price: $$productPrice | Weight: $productWeight</li>";
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
