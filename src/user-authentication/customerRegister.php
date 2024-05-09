<?php include("authentication_animation.php"); ?>
<style>
<?php include "authentication.css"?>
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OFS - Customer Registration</title>
</head>
<body>
  <div class="content">
  <header class="top-bar">
    <a href="../main-page/main-page.php">
        <img src="mainLogo.jpg" style="width: 100px; height: auto;">
    </a>
  </header>
    <div id="authentication-box">
        <h3>Customer Registration</h3>
        <p>Enter your information below:</p>
        <!-- PHP code for form submission handling -->
        <?php
        session_start(); // Start the session

        // PHP code for form submission handling
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve form data
            $firstName = $_POST['first-name'];
            $lastName = $_POST['last-name'];
            $email = $_POST['email-address'];
            $password = $_POST['password'];

            // Perform email validation
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                // Invalid email address format
                echo "<div style='color: red;'>Invalid email address format!</div>";
            } else {
                // Database connection parameters
                $servername = "localhost"; // Change to your MySQL server name
                $username_db = "root"; // Change to your MySQL username
                $password_db = ""; // Change to your MySQL password
                $dbname = "users"; // Change to your MySQL database name

                // Create connection
                $conn = new mysqli($servername, $username_db, $password_db, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Prepare SQL statement to insert user registration data
                $sql = "INSERT INTO customers (firstName, lastName, email, password)
                        VALUES ('$firstName', '$lastName', '$email', '$password')";

                if ($conn->query($sql) === TRUE) {
                    // Registration successful
                    echo "<div style='color: green;'>Registration successful!</div>";

                    // Retrieve the ID of the newly registered user
                    $userID = $conn->insert_id;

                    // Prepend '1' to the auto-generated ID
                    $customerID = '1' . str_pad($userID, 5, '0', STR_PAD_LEFT);

                    // Update the record with the new customer ID
                    $update_sql = "UPDATE customers SET id = '$customerID' WHERE id = '$userID'";
                    if ($conn->query($update_sql) === TRUE) {
                        // Set session variable to indicate user is logged in
                        $_SESSION['user_id'] = $customerID;
                        $_SESSION['user_type'] = 'customer';

                        // Redirect to main page
                        header("Location: ../main-page/main-page.php");
                        exit(); // Terminate script execution after redirection
                    } else {
                        // Error updating record
                        echo "<div style='color: red;'>Error updating customer ID: " . $conn->error . "</div>";
                    }
                } else {
                    // Registration error
                    echo "<div style='color: red;'>Error inserting customer record: " . $conn->error . "</div>";
                }

                // Close connection
                $conn->close();
            }
        }
        ?>


        <!-- Your form with action set to empty string to submit to the same page -->
        <form action="" method="post">
            <!-- First Name -->
            <div class="authentication-input">
                <label for="first-name">First Name:</label>
                <input type="text" name="first-name" id="first-name" placeholder="Enter your first name" required autocomplete="off">
            </div>
            <!-- Last Name -->
            <div class="authentication-input">
                <label for="last-name">Last Name:</label>
                <input type="text" name="last-name" id="last-name" placeholder="Enter your last name" required autocomplete="off">
            </div>
            <!-- Email Address -->
            <div class="authentication-input">
                <label for="email-address">Email Address:</label>
                <input type="email" name="email-address" id="email-address" placeholder="Enter your email" required autocomplete="off">
            </div>
            <!-- Password -->
            <div class="authentication-input">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password-input" placeholder="Enter your password" required autocomplete="off">
                <input type="checkbox" id="password-view">Show Password
            </div>
            <!-- Registration Button -->
            <button type="submit" class="green-btn" id="registration-button">Sign Up</button>
        </form>
        <!-- Back Button -->
        <a id="back-btn" href="pickEmployeeOrCustomer.php"><-- Back</a>
    </div>
</div>
</body>
<script src="checkPassword.js"></script>
</html>
