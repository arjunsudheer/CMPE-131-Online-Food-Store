<?php
session_start(); // Start the session to access session variables
include("../navbar/navbar.php");

// Handle checkout process
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['checkout-button'])) {
    // Retrieve user ID from the session
    $userId = $_SESSION['user_id'];
    $tableName = ($_SESSION['user_type'] == 'employee') ? 'employees' : 'customers';

    // Update cartHistory in the user's table
    $connection = mysqli_connect("localhost", "root", "", "users");
    if (!$connection) {
        echo 'error';
        die("Connection failed: " . mysqli_connect_error());
    }

    // Retrieve currentCart from the database
    $sql_select_cart = "SELECT currentCart FROM $tableName WHERE id = $userId";
    $result_select_cart = mysqli_query($connection, $sql_select_cart);
    if (!$result_select_cart) {
        echo "Error selecting current cart: " . mysqli_error($connection);
        mysqli_close($connection);
        exit();
    }

    // Fetch the currentCart from the result set
    $row = mysqli_fetch_assoc($result_select_cart);
    $currentCart = $row['currentCart'];

    // Append currentCart and submission date to cartHistory in the database
    $submissionDate = date('Y-m-d H:i:s'); // Get the current date and time
    $sql_update_cart = "UPDATE $tableName SET cartHistory = CONCAT_WS(';', '$currentCart|$submissionDate', cartHistory) WHERE id = $userId";


    $result_update_cart = mysqli_query($connection, $sql_update_cart);
    if (!$result_update_cart) {
        echo "Error updating cart history: " . mysqli_error($connection);
        mysqli_close($connection);
        exit();
    }

    // Clear currentCart in the database
    $sql_clear_cart = "UPDATE $tableName SET currentCart = NULL WHERE id = $userId";
    $result_clear_cart = mysqli_query($connection, $sql_clear_cart);
    if (!$result_clear_cart) {
        echo "Error clearing current cart: " . mysqli_error($connection);
        mysqli_close($connection);
        exit();
    }

    // Close the database connection
    mysqli_close($connection);

    // Redirect to a thank you page or home page
    header("Location: ../main-page/main-page.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="../navbar/navbar.css">

<head>
    <title>CheckOutPage</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="CheckOutPage.css">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
</head>

<body>
    <div style="margin: 0 auto;">
        <div class="wrapper">
            <h1>Delivery Address</h1>
            <!-- Map container -->
            <div id="map" style="height: 300px; width: 80%; margin: 0 auto;"></div>
            <!-- Hidden inputs for latitude and longitude -->
            <input type="hidden" id="latitude" name="latitude">
            <input type="hidden" id="longitude" name="longitude">
            <!-- Display address -->
            <div id="address"></div>
            <form method="POST">
                <div class="address-info">
                    <div>
                        <label class="address-labels" for="name">Name of Order:</label>
                        <input class="address-inputs" type="text" id="name" name="name" autocomplete="name" enterkeyhint="next">
                    </div>

                    <div>
                        <label class="address-labels" for="street-address">Street address:</label>
                        <input class="address-inputs" type="text" id="street-address" name="street-address" autocomplete="street-address" enterkeyhint="next"></input>
                    </div>

                    <div>
                        <label class="address-labels" for="postal-code">ZIP or postal code (optional):</label>
                        <input class="address-inputs" id="postal-code" name="postal-code" autocomplete="postal-code" enterkeyhint="next">
                    </div>

                    <div>
                        <label class="address-labels" for="city">City:</label>
                        <input class="address-inputs" type="text" id="city" name="city" autocomplete="address-level2" enterkeyhint="next">
                    </div>
                </div>

                <h2 class="title">Payment Details: </h2>
                <div class="flex-container-hor">
                    <div><!-- Card Number -->
                        <label>Card Number</label>
                        <input class="card-number" placeholder="1234 1234 1234 1234" type="text" maxlength="16" />
                    </div>
                    <div><!-- Card Holder -->
                        <label>Card Holder</label>
                        <input class="card-name" placeholder="FirstName LastName" type="text" />
                    </div>
                    <div><!-- Date -->
                        <label>Exp. Date</label>
                        <input class="card-name" placeholder="10/25" type="text" maxlength="5" />
                    </div>
                    <div><!-- Cvv -->
                        <label>CCV</label>
                        <input class="card-name" placeholder="123" type="text" maxlength="3" />
                    </div>
                </div>
                <button class="button" id="checkout-button" name="checkout-button">Pay</button>

            </form>
        </div>
    </div>
</body>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<!-- Leaflet map initialization -->
<script>
    // Initialize Leaflet map with default coordinates
    var map = L.map('map').setView([37.3352, -121.8811], 13);

    // Add tile layer (OpenStreetMap)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var marker = L.marker([37.3352, -121.8811]).addTo(map);

    // Function to handle click event on map
    function onMapClick(e) {
        // Get latitude and longitude of clicked location
        var latitude = e.latlng.lat;
        var longitude = e.latlng.lng;

        // Set hidden inputs with latitude and longitude values
        document.getElementById('latitude').value = latitude;
        document.getElementById('longitude').value = longitude;

        // Perform reverse geocoding to get address from coordinates
        fetch(`https://nominatim.openstreetmap.org/reverse?lat=${latitude}&lon=${longitude}&format=json`)
            .then(response => response.json())
            .then(data => {
                // Get address components from response data
                var streetAddress = data.address.road;
                var postalCode = data.address.postcode;
                var city = data.address.city;

                // Set values of input fields
                document.getElementById('street-address').value = streetAddress || '';
                document.getElementById('postal-code').value = postalCode || '';
                document.getElementById('city').value = city || '';

                // Get address from response data
                var address = data.display_name;

                // Display address on the page
                document.getElementById('address').innerText = "Address: " + address;
            });
    }

    // Add click event listener to map
    map.on('click', onMapClick);
</script>

</html>