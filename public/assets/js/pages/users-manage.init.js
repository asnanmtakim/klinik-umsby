var avatar = "";
var myModal = new bootstrap.Modal(document.getElementById("cropImage"));
var image = document.getElementById("image-crop-upload");
var cropper = null;

$("#avatar").change(function (event) {
   var files = event.target.files;

   var done = function (url) {
      image.src = url;
      myModal.show();
   };

   if (files && files.length > 0) {
      reader = new FileReader();
      reader.onload = function (event) {
         done(reader.result);
      };
      reader.readAsDataURL(files[0]);
   }
});

const myModalEl = document.getElementById("cropImage");
myModalEl.addEventListener("shown.bs.modal", function () {
   cropper = new Cropper(image, {
      aspectRatio: 1 / 1,
      viewMode: 1,
      preview: ".preview-cropper",
   });
});
myModalEl.addEventListener("hidden.bs.modal", function () {
   cropper.destroy();
   cropper = null;
});

$("#crop-save").click(function () {
   canvas = cropper.getCroppedCanvas({
      width: 400,
      height: 400,
   });

   $("#image-user-show").attr("src", canvas.toDataURL());
   myModal.hide();
   avatar = canvas.toDataURL();
});

$(document).ready(function () {
   $("form").submit(function (e) {
      e.preventDefault();
      $("#loading-ajax").show();
      var formData = new FormData($(this)[0]);
      formData.append("avatar", avatar);
      $.ajax({
         url: $(this).attr("action"),
         data: formData,
         type: $(this).attr("method"),
         dataType: "JSON",
         processData: false,
         contentType: false,
         cache: false,
         timeout: 800000,
         success: function (res) {
            if (res.status == 200) {
               Swal.fire({
                  title: successMessage,
                  text: res.pesan,
                  icon: "success",
                  customClass: { confirmButton: "btn btn-success w-xs me-2 mt-2" },
                  buttonsStyling: !1,
               }).then(function () {
                  location.href = res.url;
               });
            } else {
               if (res.status == 400) {
                  var frm = Object.keys(res.pesan);
                  var val = Object.values(res.pesan);
                  $("form .invalid-feedback").remove();
                  $("form .error-validation").remove();
                  frm.forEach(function (el, ind) {
                     if (val[ind] != "") {
                        $("form #" + el)
                           .removeClass("is-invalid")
                           .addClass("is-invalid");
                        if (el == "group") {
                           var app = '<div id="' + el + '-error" class="error-validation" for="' + el + '">' + val[ind] + "</div>";
                           $("form #" + el)
                              .closest(".form-group")
                              .append(app);
                        } else {
                           var app = '<div id="' + el + '-error" class="invalid-feedback" for="' + el + '">' + val[ind] + "</div>";
                           $("form #" + el)
                              .closest(".form-group")
                              .append(app);
                           $("form #" + el)
                              .closest(".input-group")
                              .append(app);
                           $("form #" + el)
                              .closest(".auth-pass-inputgroup")
                              .append(app);
                        }
                     } else {
                        $("form #" + el).removeClass("is-invalid");
                     }
                  });
               } else {
                  Swal.fire({
                     title: errorMessage,
                     text: res.pesan,
                     icon: "error",
                     customClass: { confirmButton: "btn btn-danger w-xs mt-2" },
                     buttonsStyling: !1,
                  });
               }
            }
         },
         complete: function () {
            $("#loading-ajax").hide();
         },
         error: function (xhr, ajaxOptions, thrownError) {
            Swal.fire({
               title: xhr.responseText,
               text: thrownError,
               icon: "error",
               customClass: { confirmButton: "btn btn-danger w-xs mt-2" },
               buttonsStyling: !1,
            });
         },
      });
   });
});
