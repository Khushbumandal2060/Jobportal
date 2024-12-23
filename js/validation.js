// Form Validation for Login and Registration
document.addEventListener("DOMContentLoaded", function () {
    const forms = document.querySelectorAll("form");

    forms.forEach((form) => {
        form.addEventListener("submit", function (event) {
            const email = form.querySelector('input[name="email"]');
            const password = form.querySelector('input[name="password"]');

            // Validate Email
            if (email && !validateEmail(email.value)) {
                event.preventDefault();
                alert("Please enter a valid email address.");
                email.focus();
                return false;
            }

            // Validate Password (Minimum 6 characters)
            if (password && password.value.length < 6) {
                event.preventDefault();
                alert("Password must be at least 6 characters.");
                password.focus();
                return false;
            }
        });
    });
});

// Email Validation Regex
function validateEmail(email) {
    const re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    return re.test(email);
}
