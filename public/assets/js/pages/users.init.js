var tbData;
const resetPWModal = new bootstrap.Modal(document.getElementById("resetPWModal"));

$(document).ready(function () {
   tbData = $("#tb-data").DataTable({
      processing: !0,
      language: {
         url: "https://cdn.datatables.net/plug-ins/2.0.5/i18n/" + (LOCALE !== "id" ? "en-GB" : "id") + ".json",
      },
      lengthMenu: [
         [10, 25, 50, 75, 100, -1],
         [10, 25, 50, 75, 100, "All"],
      ],
      serverSide: !0,
      autoWidth: !1,
      responsive: !0,
      fixedHeader: !0,
      ajax: {
         url: $("#tb-data").attr("data-url"),
         data: function (req) {
            req.active = $("#select_active").val();
         },
      },
      order: [],
      columns: [
         {
            data: "no",
            orderable: !1,
         },
         {
            data: "fullname",
         },
         {
            data: "username",
         },
         {
            data: "gender",
         },
         {
            data: "groups",
         },
         {
            data: "avatar",
         },
         {
            data: "active",
         },
         {
            data: "action",
            orderable: !1,
         },
      ],
   });
});

$(document)
   .off("click", ".popup-image")
   .on("click", ".popup-image", function (e) {
      e.preventDefault();
      $(this)
         .magnificPopup({
            type: "image",
            mainClass: "mfp-with-zoom", // this class is for CSS animation below

            zoom: {
               enabled: true, // By default it's false, so don't forget to enable it
               duration: 300, // duration of the effect, in milliseconds
               easing: "ease-in-out", // CSS transition easing function
               opener: function (openerElement) {
                  return openerElement.is("img") ? openerElement : openerElement.find("img");
               },
            },
         })
         .magnificPopup("open");
   });

$("#select_active").change(function (event) {
   tbData.ajax.reload();
});

$(document)
   .off("click", "button.action-delete")
   .on("click", "button.action-delete", function (e) {
      e.preventDefault();
      let id = $(this).attr("data-id");
      let name = $(this).attr("data-name");
      let url = $(this).attr("data-url");
      Swal.fire({
         html:
            '<div class="mt-3"><lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon><div class="mt-4 pt-2 fs-15 mx-5"><h4>Yakin hapus data ?</h4><p class="text-muted mx-4 mb-0">Hapus data ' +
            name +
            ", data yang dihapus tidak bisa dikembalikan!</p></div></div>",
         showCancelButton: !0,
         customClass: {
            confirmButton: "btn btn-danger w-xs me-2 mb-1",
            cancelButton: "btn btn-light w-xs mb-1",
         },
         confirmButtonText: "Ya, Hapus!",
         buttonsStyling: !1,
         showCloseButton: !0,
      }).then(function (t) {
         t.value &&
            $("#loading-ajax").show() &&
            $.ajax({
               type: "POST",
               url: url,
               data: {
                  id: id,
                  [csrfToken]: csrfHash,
               },
               dataType: "JSON",
               success: function (res) {
                  if (res.status == 200) {
                     Swal.fire({
                        title: successMessage,
                        text: res.pesan,
                        icon: "success",
                        customClass: { confirmButton: "btn btn-success w-xs me-2 mt-2" },
                        buttonsStyling: !1,
                     }).then(() => {
                        tbData.ajax.reload();
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

$(document)
   .off("click", "button.action-status")
   .on("click", "button.action-status", function (e) {
      e.preventDefault();
      let id = $(this).attr("data-id");
      let name = $(this).attr("data-name");
      let url = $(this).attr("data-url");
      Swal.fire({
         title: "Ubah Status Data?",
         text: "Pilih ubah status data yg diinginkan dibawah ini!",
         icon: "question",
         showDenyButton: !0,
         showCancelButton: !0,
         buttonsStyling: !1,
         customClass: {
            confirmButton: "btn btn-success w-xs me-2 mb-1",
            denyButton: "btn btn-danger w-xs me-2 mb-1",
            cancelButton: "btn btn-light w-xs mb-1",
         },
         confirmButtonText: "Activate",
         denyButtonText: "Deactivate",
         cancelButtonText: "Batal",
      }).then(function (result) {
         if (result.isConfirmed || result.isDenied) {
            let status;
            if (result.isConfirmed) {
               status = 1;
            } else {
               status = 0;
            }
            $("#loading-ajax").show() &&
               $.ajax({
                  type: "POST",
                  url: url,
                  data: {
                     id: id,
                     status: status,
                     [csrfToken]: csrfHash,
                  },
                  dataType: "json",
                  success: function (res) {
                     if (res.status == 200) {
                        Swal.fire({
                           title: successMessage,
                           text: res.pesan,
                           icon: "success",
                           customClass: { confirmButton: "btn btn-success w-xs me-2 mt-2" },
                           buttonsStyling: !1,
                        }).then(() => {
                           tbData.ajax.reload();
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
         }
      });
   });

const characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
function generateString(length) {
   let result = "";
   const charactersLength = characters.length;
   for (let i = 0; i < length; i++) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
   }

   return result;
}

$(document)
   .off("click", "button.reset-pw")
   .on("click", "button.reset-pw", function (e) {
      e.preventDefault();
      let id = $(this).attr("data-id");
      let name = $(this).attr("data-name");
      $("#resetPWModal .modal-title").html(changePassword + " " + name);
      $("#form-reset-pw input[name=user_id]").val(id);
      $("#form-reset-pw input[name=new_password]").val(generateString(8));
      resetPWModal.show();
   });

async function copyPassword() {
   try {
      await navigator.clipboard.writeText($("#form-reset-pw input[name=new_password]").val());
      console.log("Successfully copied password");
      Swal.fire({
         position: "top-end",
         icon: "success",
         title: "Password berhasil disalin!",
         showConfirmButton: false,
         timer: 1000,
      });
   } catch (err) {
      console.error("Failed to copy: ", err);
   }
}
async function generatePassword() {
   try {
      await $("#form-reset-pw input[name=new_password]").val(generateString(8));
      console.log("Successfully generated password");
   } catch (err) {
      console.error("Failed to generate: ", err);
   }
}

$("form#form-reset-pw").submit(function (e) {
   e.preventDefault();
   $("#loading-ajax").show();
   var formData = new FormData($(this)[0]);
   var action = $(this).attr("action");
   var method = $(this).attr("method");
   $.ajax({
      url: action,
      data: formData,
      type: method,
      dataType: "JSON",
      processData: false,
      contentType: false,
      cache: false,
      timeout: 800000,
      success: function (res) {
         if (res.status == 200) {
            Swal.fire({
               title: "Yakin Reset Password?",
               text: "Reset dan ganti password untuk " + res.data.fullname + "!",
               icon: "warning",
               showCancelButton: !0,
               customClass: {
                  confirmButton: "btn btn-primary w-xs me-2 mt-2",
                  cancelButton: "btn btn-danger w-xs mt-2",
               },
               confirmButtonText: "Ya, reset!",
               buttonsStyling: !1,
               showCloseButton: !0,
            }).then(function (t) {
               t.value && $("#loading-ajax").show() && formData.append("confirm", "OK");
               $.ajax({
                  type: method,
                  url: action,
                  data: formData,
                  dataType: "JSON",
                  processData: false,
                  contentType: false,
                  cache: false,
                  timeout: 800000,
                  success: function (response) {
                     if (response.status == 200) {
                        Swal.fire({
                           title: successMessage,
                           text: response.pesan,
                           icon: "success",
                           customClass: { confirmButton: "btn btn-success w-xs me-2 mt-2" },
                           buttonsStyling: !1,
                        }).then(() => {
                           resetPWModal.hide();
                           tbData.ajax.reload();
                        });
                     } else {
                        Swal.fire({
                           title: errorMessage,
                           text: response.pesan,
                           icon: "error",
                           customClass: { confirmButton: "btn btn-danger w-xs mt-2" },
                           buttonsStyling: !1,
                        });
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
         } else {
            if (res.status == 400) {
               var frm = Object.keys(res.pesan);
               var val = Object.values(res.pesan);
               $("form .invalid-feedback").remove();
               frm.forEach(function (el, ind) {
                  if (val[ind] != "") {
                     $("form #" + el)
                        .removeClass("is-invalid")
                        .addClass("is-invalid");
                     var app = '<div id="' + el + '-error" class="invalid-feedback" for="' + el + '">' + val[ind] + "</div>";
                     $("form #" + el)
                        .closest(".auth-pass-inputgroup")
                        .append(app);
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
