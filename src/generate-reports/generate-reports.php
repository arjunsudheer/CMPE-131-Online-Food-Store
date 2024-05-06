<?php
include("navbar.html");
?>
<!DOCTYPE html>
<html>
<body>
<head>
  <link rel="stylesheet" href="generate-reports.css">
</head>
  <form class=“form-group” action="generate-reports.php" method="post">

    <label for="startTime">Start Date:</label>
    <input type="date" id="startTime" name="startTime">

    <br>

    <label for="endTime">End Date:</label>
    <input type="date" id="endTime" name="endTime">

    <br>

    <input id="submit-btn" type="submit" value="Generate Product Report">
  </form>
  <br>
</body>
</html>

<?php
// check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // get the start time
    $startTime = $_POST['startTime'];
    // get the end time
    $endTime = $_POST['endTime'];

    // connect to the sales database
    $connection = mysqli_connect("localhost", "root", "", "sales");

    // check if there was a successful connection
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // array to store each product's total revenue
    $productRevenue = array();
    // get the required info that falls within the time frame from the product sales table
    $query = "SELECT productType, productName, revenue
              FROM product
              WHERE theDate BETWEEN '$startTime' AND '$endTime'";
    $result = mysqli_query($connection, $query);

    if ($result) {
        // go row by row and fetch each product's type, name, and revenue
        while ($row = mysqli_fetch_assoc($result)) {
            $productType = $row['productType'];
            $productName = $row['productName'];
            $revenue = $row['revenue'];

            // add the product entries into the array along with adding up its revenue
            if (!isset($productRevenue[$productType.' - '.$productName])) {
                $productRevenue[$productType.' - '.$productName] = 0;
            }
            $productRevenue[$productType.' - '.$productName] += $revenue;
        }

        // find the most profitable product
        $maxRevenue = 0;
        $mostProfitableProduct = null;

        // loop through each product's total revenue in the product revenue array
        foreach ($productRevenue as $productName => $totalRevenue) {
          // if the product's total revenue is greater than the current max revenue
          if ($totalRevenue > $maxRevenue) {
            // make that product the mostProfitable and update the maxRevenue
            $maxRevenue = $totalRevenue;
            $mostProfitableProduct = $productName;
          }
        }

        // helper 'merge' functions for mergeSort
        function merge(&$array, $left, $middle, $right) {
          $leftSize = $middle - $left + 1;
          $rightSize = $right - $middle;

          // create temporary arrays
          $tempLeftArray = array();
          $tempRightArray = array();

          // copy data to temporary arrays
          for ($i = 0; $i < $leftSize; $i++)
              $tempLeftArray[$i] = $array[$left + $i];
          for ($j = 0; $j < $rightSize; $j++)
              $tempRightArray[$j] = $array[$middle + 1 + $j];

          // merge the temporary arrays back into original array
          $i = 0;
          $j = 0;
          $k = $left;
          while ($i < $leftSize && $j < $rightSize) {
              if ($tempLeftArray[$i] >= $tempRightArray[$j]) {
                  $array[$k] = $tempLeftArray[$i];
                  $i++;
              }
              else {
                  $array[$k] = $tempRightArray[$j];
                  $j++;
              }
              $k++;
          }

          // copy the remaining elements of tempLeftArray
          while ($i < $leftSize) {
              $array[$k] = $tempLeftArray[$i];
              $i++;
              $k++;
          }

          // copy the remaining elements of tempRightArray
          while ($j < $rightSize) {
              $array[$k] = $tempRightArray[$j];
              $j++;
              $k++;
          }
      }

      // merge sort productRevenue array by descending total revenue
      function mergeSort(&$array, $left, $right) {
          if ($left < $right) {
              $middle = $left + (($right - $left) / 2);

              mergeSort($array, $left, $middle);
              mergeSort($array, $middle + 1, $right);

              merge($array, $left, $middle, $right);
          }
      }

      // sort the productRevenue array by total revenue in descending order
      arsort($productRevenue);

      // display the most profitable products
      if ($mostProfitableProduct !== null) {
        $maxRevenue = number_format($maxRevenue, 2, '.', ',');
        echo "<p id='report-result'>The most profitable product is $mostProfitableProduct making $$maxRevenue.</p>";
?>
<br>
<br>
<?php
        // display all the array's info in a table
        echo "\n";
        echo "<div id='tablewrapper'>";
        echo "<table border='1'>
                <tr>
                  <th>Product Type - Product Name</th>
                  <th>Total Revenue</th>
                </tr>";
        foreach ($productRevenue as $productName => $totalRevenue) {
          $totalRevenue = number_format($totalRevenue, 2, '.', ',');
          echo "<tr>
                  <td>$productName</td>
                  <td>$$totalRevenue</td>
                </tr>";
        }
        echo "</table>";
        echo "</div>";
      }
      // if the chosen time frame is invalid
      else {
        echo "<p id='report-result'>There is no sales data within the chosen time frame. Please try again.</p>";
      }
    }
    else {
        echo "Error fetching product sales data: " . mysqli_error($connection);
    }
    mysqli_close($connection);
}
?>
