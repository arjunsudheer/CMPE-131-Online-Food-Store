<?php include("authentication_animation.html"); ?>
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
    <a href="../main-page/main-page.php">
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
             $servername = "localhost";
             $username_db = "root";
             $password_db = "";
             $dbname = "users";

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
                 $_SESSION['user_id'] = $employee_data['id']; // Set up account status flags to mark ID and login type
                 $_SESSION['user_type'] = 'employee';

                 echo "User ID: " . $_SESSION['user_id'] . "<br>"; // echo data just for testing purposes, user will not see this
                 echo "User Type: " . $_SESSION['user_type'] . "<br>";

                 // Redirect to main page or dashboard
                 header("Location: ../main-page/main-page.php");
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
             <!-- Stores the email label and input field -->
             <div class="authentication-input">
                 <label for="email">Email:</label>
                 <input type="email" name="email" id="email" placeholder="Enter your email" autocomplete="off"/>
             </div>
             <!-- Stores the password label, input field, and Show/Hide Password toggle -->
             <div class="authentication-input">
                 <div>
                     <label for="password">Password:</label>
                     <input type="password" name="password" id="password-input" placeholder="Enter your password" autocomplete="off"/>
                 </div>
                 <input type="checkbox" id="password-view" name="password-view">Show Password
             </div>
             <!-- "Login" button to submit the form -->
             <button type="submit" class="green-btn" id="registration-button">Log In</button>
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
 </body>
 <script src="checkPassword.js"></script>
 </html>
