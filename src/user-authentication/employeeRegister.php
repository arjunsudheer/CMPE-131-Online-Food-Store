<?php include("authentication_animation.html"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>OFS - Employee Registration</title>
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
        <h3>Employee Registration</h3>
        <p>Enter your information below:</p>
        <!-- PHP code for form submission handling -->
        <?php
        session_start(); // Start the session

        // PHP code for form submission handling
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve form data
            $employeeID = $_POST['employee-id'];
            $email = $_POST['email'];
            $password = $_POST['password'];

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

            // Prepare SQL statement to check if the employee ID already exists
            $check_sql = "SELECT * FROM employees WHERE employeeID = '$employeeID'";
            $result = $conn->query($check_sql);

            if ($result->num_rows > 0) {
                // Employee ID already exists
                echo "<div style='color: red;'>Employee ID already exists!</div>";
            } else {
                // Prepare SQL statement to insert employee registration data
                $sql = "INSERT INTO employees (employeeID, email, password)
                        VALUES ('$employeeID', '$email', '$password')";

                if ($conn->query($sql) === TRUE) {
                    // Registration successful
                    echo "<div style='color: green;'>Registration successful!</div>";
                    // Set session variable to indicate employee is logged in
                    $_SESSION['user_id'] = $employeeID;
                    $_SESSION['user_type'] = 'employee';
                    // Redirect to main page
                    header("Location: /main-page/main-page.php");
                    exit(); // Terminate script execution after redirection
                } else {
                    // Registration failed
                    echo "<div style='color: red;'>Error: " . $conn->error . "</div>";
                }
            }

            // Close connection
            $conn->close();
        }
        ?>


        <!-- Employee registration form with client-side validation -->
        <form action="#" method="post" onsubmit="return validateEmployeeID()">
            <div class="authentication-input">
                <label for="employee-id">Employee ID:</label>
                <input type="text" id="employee-id" name="employee-id" placeholder="Enter your employee id" required autocomplete="off">
            </div>
            <div class="authentication-input">
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" placeholder="Enter your email" required autocomplete="off">
            </div>
            <div class="authentication-input">
                <label for="password">Password:</label>
                <input type="password" id="password-input" name="password" placeholder="Enter your password" required autocomplete="off">
            </div>
            <div>
                <input type="checkbox" id="password-view">Show Password
            </div>

            <button type="submit" class="green-btn">Sign Up</button>
        </form>
        <a id="back-btn" href="employeeLogin.php"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> Back</a>
    </div>
</body>
<script src="authentication.js"></script> <!-- Include the JavaScript file -->

</html>