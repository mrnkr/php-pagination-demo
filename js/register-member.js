function validatePicture(path) {
	if (!path) return false;
	var ext = path.split('.').pop().toLowerCase();
  return $.inArray(ext, ['png','jpg','jpeg']) !== -1;
}

function validateDate(date) {
	var regex = /^((19|20)[0-9]{2})-([0-1][0-9])-([0-3][0-9])$/g;
	return regex.test(date);
}

function validateAddress(address) {
	var regex = /^([a-z0-9\s]{1,})([0-9]{3,4})$/ig;
	return regex.test(address);
}

function validatePhone(phone) {
	var regex = /^((09[1-9](\s?)([0-9]{3})(\s?)([0-9]{3}))|((2|4)(\s?)([0-9]{3})(\s?)([0-9]{2})(\s?)([0-9]{2})))$/g;
	return regex.test(phone);
}

function validateEmail(email) {
  var regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return regex.test(email);
}

function clearAllFields() {
	hideAllErrors();
	$('#memberModalLabel').html('Registro de usuario');
	$('input').val('');
	$('#updating').val('no');
	showPasswordAndFileInput();
}

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

function showPasswordAndFileInput() {
	$('#password-cont').removeClass('hidden');
  $('#picture-cont').removeClass('hidden');
}

function hidePasswordAndFileInput() {
	$('#password-cont').addClass('hidden');
	$('#picture-cont').addClass('hidden');
}

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

function showError(element, error) {
  $(element).addClass('visible');
  $(element + '-text').html(error);
}

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
