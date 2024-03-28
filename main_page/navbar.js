// set the width of the searchBar
let searchBar = document.getElementById("product-search-bar");
const defaultSearchBarWidth = "85%";
searchBar.style.width = defaultSearchBarWidth;

document.getElementById("cart-button").addEventListener("click", function () {
    // adjust the size of the search bar accordingly
    if (searchBar.style.width == defaultSearchBarWidth) {
        searchBar.style.width = "70%";
    } else {
        searchBar.style.width = defaultSearchBarWidth;
    }
    // show the cart menu on the right side
    document.getElementsByClassName("cart-menu")[0].classList.toggle("show-menu");
});

let quantityAmount = document.getElementById("quantity-amount");
document.getElementById("subtract-quantity").addEventListener("click", function () {
    let currentQuantity = parseInt(quantityAmount.innerHTML);
    if (currentQuantity - 1 >= 0) {
        quantityAmount.innerHTML = (currentQuantity - 1);
    }
});

document.getElementById("add-quantity").addEventListener("click", function () {
    let currentQuantity = parseInt(quantityAmount.innerHTML);
    quantityAmount.innerHTML = (currentQuantity + 1);
});
