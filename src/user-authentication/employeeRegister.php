<?php include("authentication_animation.php"); ?>
<style>
<?php include "authentication.css"?>
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OFS - Employee Registration</title>
</head>
<body>
    <div class="content">
    <header class="top-bar">
        <a href="../main-page/main-page.php">
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
            $firstName = $_POST['first-name'];
            $lastName = $_POST['last-name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Validation for first name and last name
            $nameError = '';
            if (!preg_match("/^[a-zA-Z]+$/", $firstName)) {
                $nameError .= "First name should contain only alphabetic characters!<br>";
            }
            if (!preg_match("/^[a-zA-Z]+$/", $lastName)) {
                $nameError .= "Last name should contain only alphabetic characters!";
            }

            if (!empty($nameError)) {
                echo "<div style='color: red;'>$nameError</div>";
            } else {
                // Check if the email is in a valid format
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    echo "<div style='color: red;'>Invalid email format!</div>";
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

                    // Check if the input is a 5-digit number
                    if (strlen($employeeID) == 5 && is_numeric($employeeID)) {
                        // Concatenate '2' with the user input to form the final ID
                        $employeeID = '2' . $employeeID;

                        // Prepare SQL statement to check if the employee ID already exists
                        $check_sql = "SELECT * FROM employees WHERE id = '$employeeID'";
                        $result = $conn->query($check_sql);

                        if ($result->num_rows > 0) {
                            // Employee ID already exists
                            echo "<div style='color: red;'>Employee ID already exists!</div>";
                        } else {
                            // Prepare SQL statement to insert employee registration data
                            $sql = "INSERT INTO employees (id, firstName, lastName, email, password)
                                VALUES ('$employeeID', '$firstName', '$lastName', '$email', '$password')";

                            if ($conn->query($sql) === TRUE) {
                                // Registration successful
                                echo "<div style='color: green;'>Registration successful!</div>";
                                // Set session variable to indicate employee is logged in
                                $_SESSION['user_id'] = $employeeID;
                                $_SESSION['user_type'] = 'employee';
                                // Redirect to main page
                                header("Location: ../main-page/main-page.php");
                                exit(); // Terminate script execution after redirection
                            }
                        }
                    } else {
                        // Error: Input is not a 5-digit number
                        echo "<script>alert('Please enter a 5-digit number!');</script>";
                    }

                    // Close connection
                    $conn->close();
                }
            }
        }
        ?>


        <!-- Employee registration form with client-side validation -->
        <form action="#" method="post" onsubmit="return validateEmployeeID()">
            <div class="authentication-input">
                <label for="employee-id">Employee ID:</label>
                <input type="text" id="employee-id" name="employee-id" placeholder="Enter your employee ID" required autocomplete="off">
            </div>
            <div class="authentication-input">
                <label for="first-name">First Name:</label>
                <input type="text" name="first-name" id="first-name" placeholder="Enter your first name" required autocomplete="off">
            </div>
            <!-- Last Name -->
            <div class="authentication-input">
                <label for="last-name">Last Name:</label>
                <input type="text" name="last-name" id="last-name" placeholder="Enter your last name" required autocomplete="off">
            </div>
            <div class="authentication-input">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required autocomplete="off"  pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}\.[cC][oO][mM]$">
            </div>
            <div class="authentication-input">
                <div>
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password-input" placeholder="Enter your password" autocomplete="off"/>
                </div>
                <input type="checkbox" id="password-view" name="password-view">Show Password
            </div>
            <!-- "Login" button to submit the form -->
            <button type="submit" class="green-btn" id="registration-button">Register</button>
        </form>
        <a id="back-btn" href="pickEmployeeOrCustomer.php"><-- Back</a>

    </div>
    <script>
        // JavaScript code to clear password field and uncheck "Show Password" checkbox after form submission
        document.getElementById('login-form').addEventListener('submit', function() {
            document.getElementById('password-input').value = ''; // Clear password field
            document.getElementById('password-view').checked = false; // Uncheck "Show Password" checkbox
        });
    </script>
  </div>
</div>
</body>
<script src="checkPassword.js"></script>
</html>
