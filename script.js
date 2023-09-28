// script.js

// Function to display a confirmation message
function showConfirmation(message) {
    alert(message);
}

// Attach event listener to the form's submit event
document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");

    form.addEventListener("submit", function (event) {
        event.preventDefault(); // Prevent the form from submitting

        // Create a FormData object to collect form data
        const formData = new FormData(form);

        // Send a POST request to process_racer.php to submit the form data
        fetch("process_racer.php", {
            method: "POST",
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show a success message and reset the form
                showConfirmation("Racer is successfully added!");
                form.reset();
            } else {
                // Show an error message if racer creation fails
                showConfirmation("Error: " + data.message);
            }
        })
        .catch(error => {
            console.error("Error:", error);
        });
    });
});
