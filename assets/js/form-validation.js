
// form-validation.js

$(document).ready(function() {
    // Initialize form validation
    $("#editProfileForm").validate({
      rules: {
        name: {
          required: true,
          minlength: 3
        },
        email: {
          required: true,
          email: true
        },
        phone: {
          required: true,
          minlength: 10,
          maxlength: 15,
          digits: true
        },
        username: {
          required: true,
          minlength: 3
        },
        password: {
          required: true,
          minlength: 6
        },
        profile_image: {
          accept: "image/*"
        }
      },
      messages: {
        name: {
          required: "Please enter your name.",
          minlength: "Your name must be at least 3 characters long."
        },
        email: {
          required: "Please enter your email.",
          email: "Please enter a valid email address."
        },
        phone: {
          required: "Please enter your phone number.",
          minlength: "Your phone number must be at least 10 digits.",
          maxlength: "Your phone number must not exceed 15 digits.",
          digits: "Please enter a valid phone number."
        },
        username: {
          required: "Please enter your username.",
          minlength: "Your username must be at least 3 characters long."
        },
        password: {
          required: "Please enter your password.",
          minlength: "Your password must be at least 6 characters long."
        },
        profile_image: {
          accept: "Please upload a valid image file (JPEG, PNG, JPG, etc.)."
        }
      },
      errorElement: "span",  // Error messages will be inside <span> tags
      errorClass: "error-message",  // Assign class to the error message
      highlight: function(element) {
        $(element).addClass("is-invalid");  // Add class to highlight invalid fields
      },
      unhighlight: function(element) {
        $(element).removeClass("is-invalid");  // Remove class when field is valid
      }
    });
  });
  