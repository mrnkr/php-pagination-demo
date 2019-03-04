/**
 * Uses a regex to validate email addresses.
 * KNOWN ISSUES: "n@ai" complies with the RFC822 standard but fails the test
 *
 * @param {string} email
 * @returns {boolean} true iif email address is valid
 */
function validateEmail(email) {
  var regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return regex.test(email);
}

/**
 * Hides all error messages in the login form
 */
function hideAllErrors() {
  $('#email-error').removeClass('visible');
  $('#password-error').removeClass('visible');
}

/**
 * Shows an error message below an input field in the
 * login form
 *
 * @param {string} element - element id in the markup code for the error container div
 * @param {string} error - error message to show
 */
function showError(element, error) {
  $(element).addClass('visible');
  $(element + '-text').html(error);
}

/**
 * Listen to form submission and intercept it
 * to perform validation before running the associated
 * action in the server.
 * 
 * Validates the password to be longer than 8 characters
 * and the email to be valid.
 * 
 * When an error is found it not only shows the error but
 * also by preventing the default action it prevents the
 * delegation to the associated action in the server.
 */
$(function () {
  $('#my-form').on('submit', function (e) {
    hideAllErrors();
    var email = $('#email').val();
    var password = $('#password').val();

    var isValid = true;

    if (!validateEmail(email)) {
      isValid = false;
      showError('#email-error', 'Dirección de email invalida');
    }

    if (password.length < 8) {
      isValid = false;
      showError('#password-error', 'La contraseña debe ser de más de 8 caracteres');
    }

    if (!isValid) {
      e.preventDefault();
    }
  });
});
