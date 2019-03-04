/**
 * Checks the file extension is png or jpeg
 *
 * @param {string} path - the filename including extension
 * @returns {boolean} true iif file has valid extension
 */
function validatePicture(path) {
	if (!path) return false;
	var ext = path.split('.').pop().toLowerCase();
  return $.inArray(ext, ['png','jpg','jpeg']) !== -1;
}

/**
 * Checks the date string has a format mysql can store as data.
 * YYYY-MM-DD
 *
 * @param {string} date - the date the user entered
 * @returns {boolean} true iif string is a valid mysql date representation
 */
function validateDate(date) {
	var regex = /^((19|20)[0-9]{2})-([0-1][0-9])-([0-3][0-9])$/g;
	return regex.test(date);
}

/**
 * Checks if the string matches a simple regex which accepts
 * a street name (composed by n words) and ends by the door number.
 * Valid example: Avenida de la Merluza 123
 * Invalid example: 67 North Street
 *
 * @param {string} address - the address the user entered
 * @returns {boolean} true iif the string is a valid address
 */
function validateAddress(address) {
	var regex = /^([a-z0-9\s]{1,})([0-9]{3,4})$/ig;
	return regex.test(address);
}

/**
 * Checks if the string is a uruguayan cell phone number or landline.
 * Accepts spaces in all cases.
 * Valid cell phone number: 099155578
 * Valid cell phone number: 099 155 578
 * Valid landline: 26196842
 * Valid landline: 2 619 68 42
 *
 * @param {string} phone - the phone number the user entered
 * @returns {boolean} true iif the string is a valid uruguayan phone number
 */
function validatePhone(phone) {
	var regex = /^((09[1-9](\s?)([0-9]{3})(\s?)([0-9]{3}))|((2|4)(\s?)([0-9]{3})(\s?)([0-9]{2})(\s?)([0-9]{2})))$/g;
	return regex.test(phone);
}

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
 * Prepares the form for new member registration.
 * 
 * As its name implies, it clears all fields, hence, sets all values
 * to empty strings, hides all error messages, sets the updating hidden
 * input field to no and makes sure the password and file inputs are
 * being shown.
 */
function clearAllFields() {
	hideAllErrors();
	$('#memberModalLabel').html('Registro de usuario');
	$('input').val('');
	$('#updating').val('no');
	showPasswordAndFileInput();
}

/**
 * Prepares the form for member update.
 * 
 * As its name implies, sets the values for all fields to match
 * those associated to the passed affiliate object, hides all
 * error fields, sets the updating hidden input to yes and the id
 * hidden input to the affiliate id. Lastly it makes sure the password
 * and file inputs are hidden since those cannot be edited.
 *
 * @param {Map<string, string>} affiliate - the affiliate as they are registered
 */
function setAllValues(affiliate) {
	hideAllErrors();
	$('#memberModalLabel').html('Modificación de usuario');
	$('#first_name').val(affiliate.first_name);
	$('#last_name').val(affiliate.last_name);
	$('#birthdate').val(affiliate.birthdate);
	$('#address').val(affiliate.address);
	$('#phone').val(affiliate.phone);
	$('#email').val(affiliate.email);
	$('#updating').val('yes');
	$('#id').val(affiliate.id);
	hidePasswordAndFileInput();
}

/**
 * Shows the password input field and the file input for
 * the avatar.
 */
function showPasswordAndFileInput() {
	$('#password-cont').removeClass('hidden');
  $('#picture-cont').removeClass('hidden');
}

/**
 * Hides the password input and the file input for
 * the avatar
 */
function hidePasswordAndFileInput() {
	$('#password-cont').addClass('hidden');
	$('#picture-cont').addClass('hidden');
}

/**
 * Hides all error messages in the member form
 */
function hideAllErrors() {
  $('#first_name-error').removeClass('visible');
  $('#last_name-error').removeClass('visible');
	$('#birthdate-error').removeClass('visible');
	$('#address-error').removeClass('visible');
	$('#phone-error').removeClass('visible');
	$('#password-error').removeClass('visible');
	$('#email-error').removeClass('visible');
	$('#picture-error').removeClass('visible');
}

/**
 * Shows an error message below an input field in the
 * member form
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
 * Validates the password to be longer than 8 characters,
 * the email to be valid, the first and last names to be
 * defined, the birthdate to be a valid mysql representation
 * of a date, the email to be a valid email according to
 * the standards defined by this application, the address
 * to be a valid representation according to what is defined
 * as a good address in this application and the picture
 * to both be defined and either jpeg or png.
 * 
 * When an error is found it not only shows the error but
 * also by preventing the default action it prevents the
 * delegation to the associated action in the server.
 */
$(function() {
  $('#member-form').on('submit', function(e) {
    hideAllErrors();
    var firstName = $('#first_name').val();
		var lastName = $('#last_name').val();
		var birthdate = $('#birthdate').val();
		var address = $('#address').val();
		var phone = $('#phone').val();
		var email = $('#email').val();
    var password = $('#password').val();
		var picture = $('#picture').val();
		var updating = $('#updating').val() === 'yes';

    var isValid = true;

		if (firstName.length === 0) {
			isValid = false;
			showError('#first_name-error', 'Éste campo es requerido');
		}

		if (lastName.length === 0) {
			isValid = false;
			showError('#last_name-error', 'Éste campo es requerido');
		}

		if (!validateDate(birthdate)) {
			isValid = false;
			showError('#birthdate-error', 'La fecha debe tener el formato YYYY-MM-DD');
		}

		if (!validateAddress(address)) {
			isValid = false;
			showError('#address-error', 'La dirección debe ser el nombre de la calle seguido por el número. Ejemplo: Calle 2 123');
		}

		if (!validatePhone(phone)) {
			isValid = false;
			showError('#phone-error', 'El teléfono puede ser un celular (099 123 345) o fijo (2 623 45 21) uruguayo');
		}

    if (!validateEmail(email)) {
      isValid = false;
      showError('#email-error', 'Dirección de email invalida');
    }

    if (password.length < 8 && !updating) {
      isValid = false;
      showError('#password-error', 'La contraseña debe ser de mas de 8 caracteres');
    }

		if (!validatePicture(picture) && !updating) {
			isValid = false;
			showError('#picture-error', 'El archivo no es valido');
		}

    if (!isValid) {
      e.preventDefault();
    }
  });
});
