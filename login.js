document
  .getElementById("loginForm")
  .addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent default form submission

    // Create a new FormData object from the form
    const formData = new FormData(this);

    // Send the form data to the server
    fetch("./backend/user/login.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.text()) // Get the response from PHP as plain text
      .then((data) => {
        // Check the response and handle accordingly
        if (data === "Login successful!") {
          alert("Login successful!"); // Show success message
          setTimeout(() => {
            window.location.href = "./home.html"; // Redirect to home page after success
          }, 500); // Small delay for the user to see the message
        } else {
          alert(data); // Show error message from PHP
        }
      })
      .catch((error) => {
        alert("Error: " + error); // Show error message if the request fails
      });
  });
