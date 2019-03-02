function validateEmail(email) {
  var regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return regex.test(email);
}

function hideAllErrors() {
  $("#email-error").removeClass("visible");
  $("#password-error").removeClass("visible");
}

function showError(element, error) {
  $(element).addClass("visible");
  $(element + "-text").html(error);
}

$(function() {
  $('#my-form').on("submit", function(e) {
    hideAllErrors();
    var email = $("#email").val();
    var password = $("#password").val();

    var isValid = true;

    if (!validateEmail(email)) {
      isValid = false;
      showError("#email-error", "Direccion de email invalida");
    }

    if (password.length < 8) {
      isValid = false;
      showError("#password-error", "La contrasena debe ser de mas de 8 caracteres");
    }

    if (!isValid) {
      e.preventDefault();
    }
  });
});
