<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OFS - Login</title>
    <link rel="stylesheet" href="authentication.css">
</head>
<body>
    <header class="top-bar">
      <a href="/main-page/main-page.php">
          <img src="mainLogo.jpg" style="width: 100px; height: auto;">
      </a>
    </header>
    <div id="authentication-box">
        <div id="switch-authentication">
            <p>If you don't have an account, please click "Register".</p>
            <button class="green-btn"><a href="customerRegister.php">Register</a></button>
        </div>
        <!-- User ID and Password registration form -->
        <?php
        session_start(); // Start the session

        // PHP code for form submission handling
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve form data
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

            // Prepare SQL statement to check if user exists
            $sql = "SELECT * FROM customers WHERE email = '$email' AND password = '$password'";
            $result = $conn->query($sql);

            if ($result->num_rows == 1) {
                // Login successful
                $user_data = $result->fetch_assoc();
                $_SESSION['user_id'] = $user_data['id']; // Assuming 'id' is the column name for user ID
                $_SESSION['user_type'] = 'customer';

                // Redirect to main page or dashboard
                header("Location: /main-page/main-page.php");
                exit();
            } else {
                // Login failed
                echo "<div style='color: red;'>Invalid email or password</div>";
            }

            // Close connection
            $conn->close();
        }
        ?>


        <form action="" method="post">
            <h3>Customer Login</h3>
            <!-- Stores the email label and input field -->
            <div class="authentication-input">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" placeholder="Enter your email" autocomplete="off"/>
            </div>
            <!-- Stores the password label, input field, and Show/Hide Password toggle -->
            <div class="authentication-input">
                <div>
                    <label for="password" id="password">Password:</label>
                    <input type="password" name="password" id="password-input" placeholder="Enter your password" autocomplete="off"/>
                </div>
                <input type="checkbox" id="password-view" name="password-view">Show Password
            </div>
            <!-- "Login" button to submit the form -->
            <button type="submit" class="green-btn" id="registration-button">Log In</button>
        </form>
        <a id="back-btn" href="pickEmployeeOrCustomer.html"><-- Back</a>

    </div>
    <script>
    // JavaScript code to clear password field and uncheck "Show Password" checkbox after form submission
    document.getElementById('login-form').addEventListener('submit', function() {
        document.getElementById('password-input').value = ''; // Clear password field
        document.getElementById('password-view').checked = false; // Uncheck "Show Password" checkbox
    });
</script>
</body>
<script src="authentication.js"></script>
</html>
