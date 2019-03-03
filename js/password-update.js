function hideAllErrors() {
	$("#old-error").removeClass("visible");
  $("#new-error").removeClass("visible");
  $("#confirm-error").removeClass("visible");
}

function showError(element, error) {
  $(element).addClass("visible");
  $(element + "-text").html(error);
}

$(function() {
  $('#my-form').on("submit", function(e) {
    hideAllErrors();
		var oldPass = $("#old").val();
    var newPass = $("#new").val();
		var confirm = $("#confirm").val();

    var isValid = true;

		if (oldPass.length < 8) {
			isValid = false;
			showError("#old-error", "La contrasena debe ser de mas de 8 caracteres");
		}

    if (newPass.length < 8) {
      isValid = false;
      showError("#new-error", "La contrasena debe ser de mas de 8 caracteres");
    }

		if (newPass !== confirm) {
			isValid = false;
			showError("#confirm-error", "Las contrasenas no coinciden");
		}

    if (!isValid) {
      e.preventDefault();
    }
  });
});
