<?php include("authentication_animation.html"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>OFS - Customer Registration</title>
    <link rel="stylesheet" href="authentication.css">
    <!-- Load an icon library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <header class="top-bar">
        <a href="/main-page/main-page.php">
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
                // Prepare SQL statement to insert user registration data
                $sql = "INSERT INTO customers (firstName, lastName, email, password)
                        VALUES ('$firstName', '$lastName', '$email', '$password')";

                if ($conn->query($sql) === TRUE) {
                    // Registration successful
                    echo "<div style='color: green;'>Registration successful!</div>";

                    // Retrieve the ID of the newly registered user
                    $userID = $conn->insert_id;

                    // Set session variable to indicate user is logged in
                    $_SESSION['user_id'] = $userID;
                    $_SESSION['user_type'] = 'customer';

                    // Redirect to main page
                    header("Location: /main-page/main-page.php");
                    exit(); // Terminate script execution after redirection
                } else {
                    // Check if the error is due to duplicate email
                    if ($conn->errno == 1062) { // Error code for duplicate entry
                        echo "<div style='color: red;'>Error: Email address already exists!</div>";
                    } else {
                        // Other registration errors
                        echo "<div style='color: red;'>Error: " . $conn->error . "</div>";
                    }
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
            </div>
            <div>
                <input type="checkbox" id="password-view">Show Password
            </div>
            <!-- Registration Button -->
            <button type="submit" class="green-btn" id="registration-button">Sign Up</button>
        </form>
        <!-- Back Button -->
        <a id="back-btn" href="customerLogin.php"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> Back</a>
    </div>
</body>
<script src="authentication.js"></script>

</html>