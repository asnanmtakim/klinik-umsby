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
         type: "POST",
         data: function (d) {
            d[csrfToken] = csrfHash;
         }
      },
      order: [],
      columns: [
         { data: "no", orderable: !1 },
         { data: "nama_pelayanan" },
         { data: "kuota" },
         {
            data: "sisa_kuota",
            render: function (data, type, row) {
               if (data <= 0) {
                  return '<span class="badge bg-danger">Penuh (0)</span>';
               }
               return '<span class="badge bg-success">' + data + ' Tersedia</span>';
            }
         },
         { data: "deskripsi" },
         { data: "action", orderable: !1 },
      ],
   });
});

// Reset Modal when clicking Add button
$(document).on("click", ".action-add", function (e) {
   clearFormDataByID("form-data");
   $("#dataModal .modal-title").html("Tambah Layanan Baru");
   $("form#form-data [name=id]").val("");
});

// Handle Edit Button Click
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
                  $("#dataModal .modal-title").html("Perbarui Layanan: " + name);
                  $("form#form-data [name=id]").val(data.id);
                  $("form#form-data [name=nama_pelayanan]").val(data.nama_pelayanan);
                  $("form#form-data [name=kuota]").val(data.kuota);
                  $("form#form-data [name=deskripsi]").val(data.deskripsi);
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

// Handle Delete Button Click
$(document)
   .off("click", "button.action-delete")
   .on("click", "button.action-delete", function (e) {
      e.preventDefault();
      let id = $(this).attr("data-id");
      let name = $(this).attr("data-name");
      let url = $(this).attr("data-url");

      Swal.fire({
         html:
            '<div class="mt-3"><lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon><div class="mt-4 pt-2 fs-15 mx-5"><h4>Yakin hapus data ?</h4><p class="text-muted mx-4 mb-0">Hapus data layanan ' +
            name +
            ", data yang dihapus tidak bisa dikembalikan!</p></div></div>",
         showCancelButton: !0,
         customClass: { confirmButton: "btn btn-danger w-xs me-2 mb-1", cancelButton: "btn btn-light w-xs mb-1" },
         confirmButtonText: "Ya, Hapus!",
         buttonsStyling: !1,
         showCloseButton: !0,
      }).then(function (result) {
         if (result.value) {
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
                           customClass: { confirmButton: "btn btn-success w-xs mt-2" },
                           buttonsStyling: !1,
                        });
                        tbData.ajax.reload();
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

// Handle Form Submission
$("form#form-data").submit(function (e) {
   e.preventDefault();
   $("#loading-ajax").show();
   
   // Clean previous error marks
   $(".is-invalid").removeClass("is-invalid");
   $(".invalid-feedback").remove();
   
   var formData = new FormData($(this)[0]);
   formData.append(csrfToken, csrfHash);
   
   $.ajax({
      url: $(this).attr("action"),
      data: formData,
      type: $(this).attr("method"),
      dataType: "JSON",
      processData: false,
      contentType: false,
      cache: false,
      success: function (res) {
         if (res.status == 200) {
            Swal.fire({
               title: successMessage,
               text: res.pesan,
               icon: "success",
               customClass: { confirmButton: "btn btn-success w-xs mt-2" },
               buttonsStyling: !1,
            });
            dataModal.hide();
            tbData.ajax.reload();
         } else if (res.status == 0 && typeof res.pesan === "object") {
            // Validation errors
            $.each(res.pesan, function (key, value) {
               var field = $("form#form-data [name=" + key + "]");
               field.addClass("is-invalid");
               field.after('<div class="invalid-feedback">' + value + '</div>');
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
