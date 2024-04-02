<?php include("navbar.html"); ?>
<?php include("search-bar.html"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Main Page</title>
    <link rel="stylesheet" href="main-page.css">
</head>

<body>
    <!-- Icon Filters -->
    <div id="icon-filters-box" class="main-page-box">
        <div class="icon-filters">
            <p>Fruits</p>
            <i class="fa fa-lemon-o" aria-hidden="true"></i>
        </div>
        <div class="icon-filters">
            <p>Vegetables</p>
            <i class="fa fa-leaf" aria-hidden="true"></i>
        </div>
        <div class="icon-filters">
            <p>Dairy</p>
            <i class="fa fa-tint" aria-hidden="true"></i>
        </div>
        <div class="icon-filters">
            <p>Protein</p>
            <i class="fa fa-cutlery" aria-hidden="true"></i>
        </div>
        <div class="icon-filters">
            <p>Sweets</p>
            <i class="fa fa-birthday-cake" aria-hidden="true"></i>
        </div>
    </div>

    <!-- Number of Results and Sort by -->
    <div id="results-and-sort" class="main-page-box">
        <p id="number-of-results"># of Results</p>
        <select name="sort-menu" id="sort-menu" class="sort-by">
            <option value="sort-by">Sort By:</option>
            <option value="weight">Weight</option>
            <option value="price">Price</option>
        </select>
    </div>

    <!-- Shows the product items -->
    <div id="product-item-view">
        <?php
        // keeps track of the number of items added
        $items_added = 0;
        // establish connection to database
        $connection = mysqli_connect("localhost", "root", "", "ofs");
        // check connection to database
        if (!$connection) {
            echo 'error';
            die("Connection failed: " . mysqli_connect_error());
        }
        // get all the product items
        $sql_get_item = "SELECT * FROM Items";
        $product_item = mysqli_query($connection, $sql_get_item);
        // display the product items on the webpage
        if ($product_item) {
            while ($row = mysqli_fetch_assoc($product_item)) {
                // start a new row every 4 product items
                if ($items_added % 4 == 0) {
                    echo '<div class="product-item-row">';
                }
                // create a new product item div on the main page
                $product_type = $row["Type"];
                $product_name = $row["Product"];
                $product_brand = $row["Brand"];
                $product_price = $row["Price"];
                echo ("
                        <div class='product-item $product_type'>
                            <p>$product_name</p>
                            <p><span class='brand-name'>Brand:</span> $product_brand</p>
                            <img src=' alt='product-item'>
                            <div class='price-and-add'>
                                <p>$$product_price</p>
                                <button class='add-btn'>Add</button>
                            </div>
                        </div>
                    ");
                $items_added++;
                // check if the current product row should be ended
                if (($items_added) % 4 == 0) {
                    echo '</div>';
                }
            }
            // check if an closing div tag needs to be added (when last row has less than 4 product items)
            if (($items_added) % 4 != 0) {
                echo '</div>';
            }
        } else {
            echo mysqli_error($connection);
        }
        // close the database connection
        mysqli_close($connection);
        ?>
    </div>
    <script src="main-page.js"></script>
    <script src="popups.js"></script>
</body>

</html>