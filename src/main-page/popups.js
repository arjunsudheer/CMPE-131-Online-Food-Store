// call functions to take care of popup interactions
function managePopups() {
    createProductInformationPopup();
    createCartAddSuccessPopup();
}
let productPopup;
let mainPageContainers;
// adds event listeners to close the product information popup window
function createProductInformationPopup() {
    // stores commonly used elements
    productPopup = document.getElementById("product-information-popup-animate");
    mainPageContainers = document.getElementsByClassName("main-page-box");
    // check if the productPopup element exists on the page
    if (productPopup !== null) {
        // blur all elements except the popup div
        manageBlurEffect(true);
    
        // if the close button is pressed, remove the popup div element
        document.getElementById("popup-close-button").addEventListener("click", function () {
            productPopup.remove();
            manageBlurEffect(false);
        });
        // store all the elements within the popup div container
        let productPopupImage = document.getElementById("product-image");
        let productPopupInformationContainer = document.getElementById("product-information");
        let productPopupInformation = document.getElementsByClassName("popup-product-info");
        // if the user clicks outside of the popup div, then delete the popup div
        let deleteOutsideClickListener = document.addEventListener("click", function (e) {
            if (productPopup !== null && e.target !== productPopup && e.target !== productPopupImage && e.target !== productPopupInformationContainer &&
                e.target !== productPopupInformation[0] && e.target !== productPopupInformation[1] && e.target !== productPopupInformation[2] &&
                e.target !== productPopupInformation[3]) {
                productPopup.remove();
                manageBlurEffect(false);
                document.removeEventListener("click", deleteOutsideClickListener);
            }
        });
    }
}
// add the blur effect from all other elements on the webpage
function manageBlurEffect(isBlurred) {
    // store navbar and searchbar elements
    let productItemView = document.getElementById("product-item-view");
    let leftSideBar = document.getElementById("left-sidebar");
    let cartMenu = document.getElementsByClassName("cart-menu")[0];
    let productSearchBar = document.getElementById("product-search-bar");
    // store the blur style
    let blurStyle = isBlurred ? "blur(8px)" : "none";
    for (let i = 0; i < mainPageContainers.length; i++) {
        if (mainPageContainers[i] !== productPopup) {
            mainPageContainers[i].style.filter = blurStyle;
        }
    }
    productItemView.style.filter = blurStyle;
    leftSideBar.style.filter = blurStyle;
    cartMenu.style.filter = blurStyle;
    productSearchBar.style.filter = blurStyle;
}

// deletes the cart success popup after 3 seconds
function createCartAddSuccessPopup() {
    let addToCartSuccessPopup = document.getElementById("add-to-cart-success-popup");
    if (addToCartSuccessPopup !== null) {
        setTimeout(() => addToCartSuccessPopup.remove(), 3000);
    }
}