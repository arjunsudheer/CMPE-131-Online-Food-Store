<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $productName = htmlspecialchars($_POST['name']);
    if (isset($productName) && !empty($productName)) {
        if ($productName === "add-to-cart") {
            createAddToCartPopup();
        } else {
            createProductInformationPopup($productName);
        }
    }
}
// Pop-up menu to show more information about a product
function createProductInformationPopup($productPopupName)
{
    echo ("
            <div id=\"product-information-popup-animate\" class=\"main-page-box product-information-popup\">
            <button id=\"popup-close-button\">Close <i class=\"fa fa-window-close-o\" aria-hidden=\"true\"></i></button>
            <img src=\"#\" alt=\"product-image\" id=\"product-image\">
            <div id=\"product-information\">
                <p class=\"popup-product-info\">$productPopupName</p>
                <p class=\"popup-product-info\">Product Price</p>
                <p class=\"popup-product-info\">Product Quantity</p>
                <p class=\"popup-product-info\">Quantity Remaining</p>
            </div>
            </div>
            ");
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
