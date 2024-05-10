<?php
// handles the XMLHTTPRequest from main-page.js
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $productName = json_decode($_POST['name']);
    if (isset($productName) && !empty($productName)) {
        if ($productName[0] === "add-to-cart") {
            createAddToCartPopup();
        } else {
            createProductInformationPopup($productName);
        }
    }
}
// Pop-up menu to show more information about a product
function createProductInformationPopup($productPopup)
{
    // establish connection to database
    $connection = mysqli_connect("localhost", "root", "", "ofs");
    // check connection to database
    if (!$connection) {
        echo 'error';
        die("Connection failed: " . mysqli_connect_error());
    }
    // store the product name and brand in variables
    $product_name = $productPopup[0];
    $product_brand = $productPopup[1];
    // get the product with the specified name
    $sql_get_item = "SELECT * FROM Items WHERE Product = '$product_name' AND Brand = '$product_brand'";
    $product_item = mysqli_query($connection, $sql_get_item);
    // display the product items on the webpage
    if ($product_item) {
        $row = mysqli_fetch_assoc($product_item);
        // create a new product item div on the main page
        $product_type = $row["Type"];
        $product_price = $row["Price"];
        $product_weight = $row["Weight"];
        $product_quantity = $row["inStock"];
        $product_image = "../inventory-page/OFS_Binary/" . $row["Image"];
        echo ("
                <div id=\"product-information-popup-animate\" class=\"main-page-box product-information-popup\">
                    <button id=\"popup-close-button\">Close <i class=\"fa fa-window-close-o\" aria-hidden=\"true\"></i></button>
                    <img src=\"$product_image\" alt=\"product-image\" class=\"product-image-popup\">
                    <div id=\"product-information\">
                        <p class=\"popup-product-info\">$product_name ($product_brand)</p>
                        <p class=\"popup-product-info\"><span class=\"popup-product-label\">Type:</span> $product_type</p>
                        <p class=\"popup-product-info\"><span class=\"popup-product-label\">Product Price:</span> $$product_price</p>
                        <p class=\"popup-product-info\"><span class=\"popup-product-label\">Weight:</span> $product_weight lbs.</p>
                        <p class=\"popup-product-info\"><span class=\"popup-product-label\">Quantity Remaining:</span> $product_quantity</p>
                    </div>
                </div>
                ");
    } else {
        echo mysqli_error($connection);
    }
    // close the database connection
    mysqli_close($connection);
}
// Popup to show success message once item is added to cart
function createAddToCartPopup()
{
    echo ("
                <div id=\"add-to-cart-success-popup\" class=\"main-page-box\">
                Item Added To Cart 🎊
                </div>
            ");
}
?>