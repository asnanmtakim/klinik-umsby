const modalElement = document.getElementById("dataModal");
const dataModal = new bootstrap.Modal(modalElement);
var tbData;

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
            data: "tahun_semester",
         },
         {
            data: "active",
            orderable: !1,
         },
         {
            data: "action",
            orderable: !1,
         },
      ],
   });
});

$("#select_active").change(function (event) {
   tbData.ajax.reload();
});

$(".action-sync").click(function (e) {
   e.preventDefault();
   let url = $(this).attr("data-url");
   $("#loading-ajax").show() &&
      $.ajax({
         type: "POST",
         url: url,
         data: {
            [csrfToken]: csrfHash,
         },
         dataType: "JSON",
         success: function (res) {
            if (res.status == 200) {
               Swal.fire({
                  title: successMessage,
                  text: res.message,
                  icon: "success",
                  customClass: { confirmButton: "btn btn-success w-xs me-2 mt-2" },
                  buttonsStyling: !1,
               }).then(() => {
                  tbData.ajax.reload();
               });
            } else {
               Swal.fire({
                  title: errorMessage,
                  text: res.message,
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

$(document)
   .off("click", "button.action-edit")
   .on("click", "button.action-edit", function (e) {
      e.preventDefault();
      let id = $(this).attr("data-id");
      let name = $(this).attr("data-name");
      let url = $(this).attr("data-url");
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
                  let data = res.data;
                  clearFormDataByID("form-data");
                  $("#dataModal .modal-title").html("Perbarui " + name);
                  $("form#form-data [name=id]").val(data.id);
                  $("form#form-data [name=nama_semester]").val(data.nama_semester);
                  $("form#form-data [name=tahun_semester]").val(data.tahun_semester);
                  dataModal.show(modalElement);
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

$("[name=icon_fakultas]").keyup(function () {
   var icon = $(this).val();
   $("#icon_show i").attr("class", icon);
});

$("form#form-data").submit(function (e) {
   e.preventDefault();
   $("#loading-ajax").show();
   var formData = new FormData($(this)[0]);
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
               customClass: { confirmButton: "btn btn-success w-xs mt-2" },
               buttonsStyling: !1,
            }).then(() => {
               dataModal.hide(modalElement);
               tbData.ajax.reload();
            });
         } else {
            if (res.status == 400) {
               var frm = Object.keys(res.pesan);
               var val = Object.values(res.pesan);
               $("form#form-data .invalid-feedback").remove();
               frm.forEach(function (el, ind) {
                  if (val[ind] != "") {
                     $("form#form-data #" + el)
                        .removeClass("is-invalid")
                        .addClass("is-invalid");
                     var app = '<div id="' + el + '-error" class="invalid-feedback" for="' + el + '">' + val[ind] + "</div>";
                     $("form#form-data #" + el)
                        .closest(".form-group")
                        .append(app);
                     $("form#form-data #" + el)
                        .closest(".input-group")
                        .append(app);
                  } else {
                     $("form#form-data #" + el).removeClass("is-invalid");
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
