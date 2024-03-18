// stores commonly used elements
let productPopup = document.getElementById("product-information-popup-animate");
let mainPageContainers = document.getElementsByClassName("main-page-box");
// check if the productPopup element exists on the page
if (productPopup !== null) {
    // blur all elements except the popup div
    for (let i = 0; i < mainPageContainers.length; i++) {
        if (mainPageContainers[i] !== productPopup) {
            mainPageContainers[i].style.filter = "blur(8px)";
        }
    }
    document.getElementById("product-item-view").style.filter = "blur(8px)";
    document.getElementById("left-sidebar").style.filter = "blur(8px)";
    document.getElementsByClassName("cart-menu")[0].style.filter = "blur(8px)";
    document.getElementById("product-search-bar").style.filter = "blur(8px)";

    // if the close button is pressed, remove the popup div element
    document.getElementById("popup-close-button").addEventListener("click", function () {
        productPopup.remove();
        removeBlurEffect();
    });
    // store all the elements within the popup div container
    let productPopupImage = document.getElementById("product-image");
    let productPopupInformationContainer = document.getElementById("product-information");
    let productPopupInformation = document.getElementsByClassName("popup-product-info");
    // if the user clicks outside of the popup div, then delete the popup div
    document.addEventListener("click", function (e) {
        if (e.target !== productPopup && e.target !== productPopupImage && e.target !== productPopupInformationContainer &&
            e.target !== productPopupInformation[0] && e.target !== productPopupInformation[1] && e.target !== productPopupInformation[2] &&
            e.target !== productPopupInformation[3]) {
            productPopup.remove();
            removeBlurEffect();
        }
    });
}
// remove the blur effect from all other elements on the webpage
function removeBlurEffect() {
    for (let i = 0; i < mainPageContainers.length; i++) {
        if (mainPageContainers[i] !== productPopup) {
            mainPageContainers[i].style.filter = "none";
        }
    }
    document.getElementById("product-item-view").style.filter = "none";
    document.getElementById("left-sidebar").style.filter = "none";
    document.getElementsByClassName("cart-menu")[0].style.filter = "none";
    document.getElementById("product-search-bar").style.filter = "none";
}

// removes the "item added to cart" success message after 3 seconds
let addToCartSuccessPopup = document.getElementById("add-to-cart-success-popup");
if (addToCartSuccessPopup !== null) {
    setTimeout(() => addToCartSuccessPopup.remove(), 3000);
}