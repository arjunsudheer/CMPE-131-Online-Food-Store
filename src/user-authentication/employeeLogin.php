<?php
session_start(); // Start the session
?>

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
            <p>Don't have an account?</p>
            <button class="green-btn"><a href="employeeRegister.php">Register</a></button>
        </div>
        <?php
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

             // Prepare SQL statement to check if employee exists
             $sql = "SELECT * FROM employees WHERE email = '$email' AND password = '$password'";
             $result = $conn->query($sql);

             if ($result->num_rows == 1) {
                 // Login successful
                 $employee_data = $result->fetch_assoc();
                 $_SESSION['user_id'] = $employee_data['id']; // Assuming 'id' is the column name for employee ID
                 $_SESSION['user_type'] = 'employee';

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
             <h3>Employee Login</h3>
             <div class="authentication-input">
                 <label for="email">E-Mail:</label>
                 <input type="text" id="email" name="email" required autocomplete="off">
             </div>
             <div class="authentication-input">
                 <label for="password">Password:</label>
                 <input type="password" id="password" name="password" required autocomplete="off">
             </div>
             <button type="submit" class="green-btn">Login</button>
         </form>

         <a id="back-btn" href="pickEmployeeOrCustomer.html"> <-- Back</a>
    </div>
    <script>
        // JavaScript code to clear password field after form submission
        document.getElementById('login-form').addEventListener('submit', function() {
            document.getElementById('password').value = ''; // Clear password field
        });
    </script>
</body>
<script src="authentication.js"></script>
</html>
