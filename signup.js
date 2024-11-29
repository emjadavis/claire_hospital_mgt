// JavaScript to handle form submission via AJAX
document.getElementById("signupForm").addEventListener("submit", function (e) {
  e.preventDefault(); // Prevent the form from submitting normally

  const formData = new FormData(this); // Get form data

  // Perform an AJAX POST request to signup.php
  fetch("./backend/user/signup.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.text()) // Get the response from PHP
    .then((data) => {
      if (data === "Signup successful") {
        // Show alert
        alert("Signup successful!");
        // Redirect to the dashboard after 2 seconds (to allow the alert to show)
        setTimeout(() => {
          window.location.href = "./home.html";
        }, 500);
      } else {
        alert(data);
      }
    })
    .catch((error) => {
      alert("Error: " + error); // Show error message if request fails
    });
});
