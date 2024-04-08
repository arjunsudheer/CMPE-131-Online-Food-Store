<?php
// keeps track of the number of items added
$items_added = 0;

// handles the XMLHTTPRequest from main-page.js
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $filter = htmlspecialchars($_POST['name']);
    if (isset($filter) && !empty($filter)) {
        if ($filter === "results-count") {
            echo $GLOBALS["items_added"];
        } else {
            // set the item_added count to 0
            $GLOBALS["items_added"] = 0;
            addProductItems($filter);
        }
    }
}

// adds product items by querying database, default parameters selects all product items from database
function addProductItems($productFilter = "*")
{
    // establish connection to database
    $connection = mysqli_connect("localhost", "root", "", "ofs");
    // check connection to database
    if (!$connection) {
        echo 'error';
        die("Connection failed: " . mysqli_connect_error());
    }
    // get all the product items if no productFilter is specified
    if ($productFilter === "*") {
        $sql_get_item = "SELECT * FROM Items";
        // get all product items where the Type of the product is productFilter
    } else {
        $sql_get_item = "SELECT * FROM Items WHERE Type = '$productFilter'";
    }
    $product_item = mysqli_query($connection, $sql_get_item);
    // display the product items on the webpage
    if ($product_item) {
        while ($row = mysqli_fetch_assoc($product_item)) {
            // start a new row every 4 product items
            if ($GLOBALS['items_added'] % 4 == 0) {
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
                    <img src='' alt='product-item'>
                    <div class='price-and-add'>
                        <p>$$product_price</p>
                        <button class='add-btn'>Add</button>
                    </div>
                </div>
            ");
            $GLOBALS["items_added"]++;
            // check if the current product row should be ended
            if (($GLOBALS["items_added"]) % 4 == 0) {
                echo '</div>';
            }
        }
        // check if an closing div tag needs to be added (when last row has less than 4 product items)
        if (($GLOBALS["items_added"]) % 4 != 0) {
            echo '</div>';
        }
    } else {
        echo mysqli_error($connection);
    }
    // close the database connection
    mysqli_close($connection);
}
