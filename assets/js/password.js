document.addEventListener("DOMContentLoaded", function() {
  var showHideElements = document.querySelectorAll(".show-hide");
  var passwordInput = document.querySelector('input[name="password"]'); // Select the password input
  var showHideSpan = document.querySelector(".show-hide span"); // Select the show-hide span element
  var submitButton = document.querySelector('form button[type="submit"]'); // Select the submit button

  // Ensure the show-hide element is visible
  showHideElements.forEach(function(element) {
    element.style.display = "block";
  });

  // Initially set the show-hide span to "Show" (meaning password is hidden)
  showHideSpan.classList.add("show");

  // Event listener for toggling password visibility
  showHideSpan.addEventListener("click", function() {
    if (showHideSpan.classList.contains("show")) {
      // If the span is in "show" state, change the input type to text
      passwordInput.setAttribute("type", "text");
      showHideSpan.classList.remove("show"); // Switch to "Hide"
    } else {
      // If the span is in "hide" state, change the input type back to password
      passwordInput.setAttribute("type", "password");
      showHideSpan.classList.add("show"); // Switch to "Show"
   
    }
  });

  // When submitting, ensure the password field is hidden again
  submitButton.addEventListener("click", function() {
    showHideSpan.classList.add("show");
    passwordInput.setAttribute("type", "password");
  });
});
