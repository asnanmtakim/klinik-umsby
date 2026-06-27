(document.querySelectorAll("[toast-list]") || document.querySelectorAll("[data-choices]") || document.querySelectorAll("[data-provider]")) &&
   (document.writeln("<script type='text/javascript' src='https://cdn.jsdelivr.net/npm/toastify-js'><\/script>"),
   document.writeln("<script type='text/javascript' src='/assets/libs/choices.js/public/assets/scripts/choices.min.js'><\/script>"),
   document.writeln("<script type='text/javascript' src='/assets/libs/flatpickr/flatpickr.min.js'><\/script>"));

function clearFormDataByID(id_form) {
   $("form#" + id_form + " input[type=text]").val("");
   $("form#" + id_form + " input[type=number]").val("");
   $("form#" + id_form + " input[type=hidden]").val("");
   $("form#" + id_form + " input[type=checkbox]").prop("checked", false);
   $("form#" + id_form + " input[type=radio]").prop("checked", false);
   $("form#" + id_form + " input[type=file]").val("");
   $("form#" + id_form + " textarea").val("");
   $("form#" + id_form + " select").val("");
   $("form#" + id_form + " .invalid-feedback").remove();
   $("form#" + id_form + " .error-validation").remove();
   $("form#" + id_form + " input").removeClass("is-invalid");
   $("form#" + id_form + " textarea").removeClass("is-invalid");
   $("form#" + id_form + " select").removeClass("is-invalid");
   $("form#" + id_form + " input[name=" + csrfToken + "]").val(csrfHash);
}
