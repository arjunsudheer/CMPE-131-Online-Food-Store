let locationList = document.getElementById("location-list");
let accountList = document.getElementById("account-list");
// show and hide the location dropdown menu when clicked
document.getElementById("location-dropdown").addEventListener("click", function () {
    // show the location dropdown list
    locationList.classList.toggle("show-list");
    // hide the account-dropdown list if it is displayed
    accountList.classList.remove("show-list");
});

// show and hide the location dropdown menu when clicked
document.getElementById("account-dropdown").addEventListener("click", function () {
    // show the account dropdown list
    accountList.classList.toggle("show-list");
    // hide the location-dropdown list if it is displayed
    locationList.classList.remove("show-list");
});

// close the dropdown menu if the user clicks outside of it
window.onclick = function (event) {
    if (!event.target.matches(".navbar-dropdowns")) {
        let dropdowns = document.getElementsByClassName("navbar-item-list");
        // loop through all navbar-list-items and remove the "show-list" class
        for (let i = 0; i < dropdowns.length; i++) {
            if (dropdowns[i].classList.contains("show-list")) {
                dropdowns[i].classList.remove("show-list");
            }
        }
    }
}