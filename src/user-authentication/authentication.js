function togglePasswordVisibility() {
    // Store commonly used elements
    let passwordView = document.getElementById("password-view");
    let passwordInput = document.getElementById("password-input");
    // Show/Hides the password when the toggle is clicked
    passwordView.addEventListener("click", function () {
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
        } else {
            passwordInput.type = "password";
        }
    });
}

togglePasswordVisibility();