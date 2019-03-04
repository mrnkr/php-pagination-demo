/**
 * Hides all errors in the password update form
 */
function hideAllErrors() {
  $('#old-error').removeClass('visible');
  $('#new-error').removeClass('visible');
  $('#confirm-error').removeClass('visible');
}

/**
 * Shows an error message below an input field in the
 * password update form
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
 * Validates all passwords to be longer than 8 characters
 * and for the new password to be equal to the confirm
 * field contents.
 * 
 * When an error is found it not only shows the error but
 * also by preventing the default action it prevents the
 * delegation to the associated action in the server.
 */
$(function () {
  $('#my-form').on('submit', function (e) {
    hideAllErrors();
    var oldPass = $('#old').val();
    var newPass = $('#new').val();
    var confirm = $('#confirm').val();

    var isValid = true;

    if (oldPass.length < 8) {
      isValid = false;
      showError('#old-error', 'La contraseña debe ser de más de 8 caracteres');
    }

    if (newPass.length < 8) {
      isValid = false;
      showError('#new-error', 'La contraseña debe ser de más de 8 caracteres');
    }

    if (newPass !== confirm) {
      isValid = false;
      showError('#confirm-error', 'Las contraseñas no coinciden');
    }

    if (!isValid) {
      e.preventDefault();
    }
  });
});
