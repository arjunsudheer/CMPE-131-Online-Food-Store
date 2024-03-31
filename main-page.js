// get all the product information divs and add to cart buttons
let productItems = document.getElementsByClassName("product-item");
let productItemsButtons = document.getElementsByClassName("add-btn");
// store the popup divs in variables
let productInformationPopup;
let addToCartSuccessPopup;
function updatePopupReferences() {
    productInformationPopup = document.getElementById("product-information-popup-animate");
    addToCartSuccessPopup = document.getElementById("add-to-cart-success-popup");
}

// add an event listener to each product information div, when clicked show the product information popup
for (let i = 0; i < productItems.length; i++) {
    productItems[i].addEventListener("click", function (e) {
        /* 
        * don't show the product information popup if the add to cart button was clicked,
        * only create new popup if there isn't already one displayed on the screen
        */
        updatePopupReferences();
        if (e.target !== productItemsButtons[i] && productInformationPopup === null) {
            if (addToCartSuccessPopup !== null) {
                addToCartSuccessPopup.remove();
            }
            invokePopupCreation(productItems[i].getElementsByTagName("p")[0].innerHTML);
        }
    });
}
// add an event listener to each add to cart button, when clicked show the added to cart success popup
for (let i = 0; i < productItemsButtons.length; i++) {
    productItemsButtons[i].addEventListener("click", function () {
        // only create new popup if there isn't already one displayed on the screen
        updatePopupReferences();
        if (productInformationPopup === null) {
            if (addToCartSuccessPopup !== null) {
                addToCartSuccessPopup.remove();
            }
            invokePopupCreation("add-to-cart");
        }
    });
}
// invoke PHP functions to add popup menus
function invokePopupCreation(message) {
    // open a new XMLHttpRequest and use a POST request to popups.php
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "popups.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // append the returned popup to the end of the main-page.php file
            document.body.insertAdjacentHTML("beforeend", xhr.responseText);
            managePopups();
        }
    };
    // send the request to popups.php
    xhr.send("name=" + encodeURIComponent(message));
}

// change the cursor when the user hovers over the add button
let productAddButtons = document.getElementsByClassName("add-btn");
for (let i = 0; i < productAddButtons.length; i++) {
    productAddButtons[i].addEventListener("mouseover", function(event) {
        updatePopupReferences();
        if (productInformationPopup === null) {
            event.target.style.cursor = "pointer";
        } else {
            event.target.style.cursor = "default";
        }
    });
}