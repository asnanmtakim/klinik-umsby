const modalElement = document.getElementById("dataModal");
const dataModal = new bootstrap.Modal(modalElement);
var tbData;

$(document).ready(function () {
   tbData = $("#dokumentasiTable").DataTable({
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
         url: $("#dokumentasiTable").attr("data-url") || LOCALE_URL + "/dashboard/dokumentasi-all",
         data: function (req) {
            req.id_periode = $("#select_periode").val() || "";
         },
      },
      order: [],
      columns: [
         {
            data: "no",
            orderable: !1,
         },
         {
            data: "nama_periode",
            render: function (data, type, row) {
               return row.tahun_semester + " - " + row.nama_periode;
            }
         },
         {
            data: "nama_dokumentasi",
         },
         {
            data: "link_url",
            orderable: !1,
         },
         {
            data: "action",
            orderable: !1,
         },
      ],
   });
});

$("#select_periode").change(function (event) {
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
            '<div class="mt-3"><lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon><div class="mt-4 pt-2 fs-15 mx-5"><h4>Yakin hapus data ?</h4><p class="text-muted mx-4 mb-0">Hapus tautan ' +
            name +
            ", data yang dihapus tidak bisa dikembalikan!</p></div></div>",
         showCancelButton: !0,
         customClass: { confirmButton: "btn btn-danger w-xs me-2 mb-1", cancelButton: "btn btn-light w-xs mb-1" },
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

$(".action-add").click(function (e) {
   e.preventDefault();
   dataModal.show(modalElement);
   let title = $(this).attr("data-title");
   $("#dataModal .modal-title").html(title);
   clearFormDataByID("form-data");
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
                  $("form#form-data [name=id_periode]").val(data.id_periode);
                  $("form#form-data [name=nama_dokumentasi]").val(data.nama_dokumentasi);
                  $("form#form-data [name=link_url]").val(data.link_url);
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
