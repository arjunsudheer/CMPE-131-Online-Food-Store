// get all the product information divs and add to cart buttons
let productItems = document.getElementsByClassName("product-item");
let productItemsButtons = document.getElementsByClassName("add-btn");
// store the popup divs in variables
let productInformationPopup;
let addToCartSuccessPopup;
// reassigns popup variables
function updatePopupReferences() {
    productInformationPopup = document.getElementById("product-information-popup-animate");
    addToCartSuccessPopup = document.getElementById("add-to-cart-success-popup");
}
// adds the event listeners to each product item
function refreshPopupEventListeners() {
    productItems = document.getElementsByClassName("product-item");
    productItemsButtons = document.getElementsByClassName("add-btn");

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
                let productName = productItems[i].getElementsByTagName("p")[0].innerHTML;
                let brandName = productItems[i].getElementsByTagName("p")[1].innerHTML;
                invokePopupCreation([productName, brandName.substring(39, brandName.length)]);
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
                invokePopupCreation(["add-to-cart", ""]);
            }
        });
    }
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
    xhr.send("name=" + encodeURIComponent(JSON.stringify(message)));
}

// change the cursor when the user hovers over the add button
let productAddButtons = document.getElementsByClassName("add-btn");
for (let i = 0; i < productAddButtons.length; i++) {
    productAddButtons[i].addEventListener("mouseover", function (event) {
        updatePopupReferences();
        if (productInformationPopup === null) {
            event.target.style.cursor = "pointer";
        } else {
            event.target.style.cursor = "default";
        }
    });
}

// changes the background colors of the icon filters when clicked and hides/shows the appropriate product items
let iconFilters = document.getElementsByClassName("icon-filters");
let iconFilterColors = ["rgb(237, 205, 116)", "rgb(117, 209, 125)", "rgb(205, 209, 205)", "rgb(207, 141, 138)", "rgb(218, 160, 109)"]; // stores the background colors for each icon filter
for (let i = 0; i < iconFilters.length; i++) {
    iconFilters[i].addEventListener("click", function () {
        if (iconFilters[i].style.backgroundColor === "") {
            iconFilters[i].style.backgroundColor = iconFilterColors[i];
            // icon-filter-active class not used for styling, used for quick access of active filters in toggleProductItemVisibility() function
            iconFilters[i].classList.add("icon-filter-active");
        } else {
            iconFilters[i].style.backgroundColor = "";
            // icon-filter-active class not used for styling, used for quick access of active filters in toggleProductItemVisibility() function
            iconFilters[i].classList.remove("icon-filter-active");
        }
        toggleProductItemVisibility();
    });
}

// removes all existing product items, and invokes invokeProductItemCreation() function for all active icon filters
function toggleProductItemVisibility() {
    // removes all existing product items
    let productRows = document.getElementsByClassName("product-item-row");
    while (productRows.length > 0) {
        productRows[productRows.length - 1].remove();
    }

    // keep track of the number of active filters returned
    let activeIconFilters = document.getElementsByClassName("icon-filter-active");
    // array for the filter strings based on the current active filters
    let productItemCategory = [];
    // specify the searchValue string when looking for product items to add
    productItemCategory.push(searchBar.value);
    // if no filters are selected, show all products
    if (activeIconFilters.length === 0) {
        activeIconFilters = iconFilters;
    }
    // add each filter to the productItemCategory array
    for (let i = 0; i < activeIconFilters.length; i++) {
        productItemCategory.push(activeIconFilters[i].children[0].innerHTML);
    }
    productItemCategory.push(sortMenu.value);
    invokeProductItemCreation(productItemCategory);
}

// adds product items to main page
function invokeProductItemCreation(productFilter) {
    // open a new XMLHttpRequest and use a POST request to add-products.php
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "add-products.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // append the returned popup to the end of the main-page.php file
            document.getElementById("product-item-view").insertAdjacentHTML("beforeend", xhr.responseText);
            // update the number of results
            updateNumberOfResults();
            // refresh the event listeners with the new product items
            refreshPopupEventListeners();
        }
    };
    // send the request to add-products.php
    xhr.send("name=" + encodeURIComponent(JSON.stringify(productFilter)));

}

// updates the product items when the sort menu option is changed
let sortMenu = document.getElementById("sort-menu");
sortMenu.addEventListener("change", function () {
    toggleProductItemVisibility();
});

// store the search bar element
let searchBar = document.getElementById("product-search-bar");
// update the products shown based on the search, updates whenever a key is pressed
searchBar.addEventListener("keyup", function () {
    toggleProductItemVisibility();
});

// sets the number of results equal to the number of product-item divs that are on the webpage
function updateNumberOfResults() {
    document.getElementById("number-of-results").innerHTML = document.getElementsByClassName("product-item").length + " results";
}

updateNumberOfResults();
refreshPopupEventListeners();





$(document).ready(function() {
    $('#addToCartForm').submit(function(event) {
        event.preventDefault(); // Prevent default form submission

        // Perform AJAX request to add product to cart
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: $(this).serialize(),
            success: function(response) {
                // Handle success response
                console.log(response);
            },
            error: function(xhr, status, error) {
                // Handle error response
                console.error(error);
            }
        });
    });
});
