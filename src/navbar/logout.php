<?php
session_start();

// Unset session variables
unset($_SESSION['user_id']);
unset($_SESSION['user_type']);

// Set user_id to 0 and user_type to 'logged_out'
$_SESSION['user_id'] = 0;
$_SESSION['user_type'] = 'logged_out';

// Redirect to a specified location
header("Location: ../user-authentication/pickEmployeeOrCustomer.php");
exit;
?>
