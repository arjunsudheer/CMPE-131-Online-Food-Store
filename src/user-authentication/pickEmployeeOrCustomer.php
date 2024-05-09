<?php include("authentication_animation.html"); ?>
<style>
<?php include 'mainLogin.css'; ?>
</style>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="mainLogin.css">
</head>

<body>
  <header class="top-bar">
    <a href="../main-page/main-page.php">
        <img src="mainLogo.jpg" alt="OFS" style="width: 100px; height: auto;">
    </a>
  </header>
  <div class="container">
    <div class="box">
      <div class="introMessage">Hello!</div>
      <div class="introMessage">Please select the type of account you want to log in to!</div>
      <a href="customerLogin.php" class="button">Customer</a>
      <a href="employeeLogin.php" class="button">Employee</a>
    </div>
  </div>
</body>

</html>
