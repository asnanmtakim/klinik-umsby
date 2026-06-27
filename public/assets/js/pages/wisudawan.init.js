var tbData;

$(document).ready(function () {
   tbData = $("#wisudawanTable").DataTable({
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
         url: $("#wisudawanTable").attr("data-url"),
         data: function (req) {
            req.id_periode = $("#select_periode").val() || "";
            req.id_program_studi = $("#select_program_studi").val() || "";
         },
      },
      order: [],
      columns: [
         {
            data: "no",
            orderable: !1,
         },
         {
            data: "nim",
         },
         {
            data: "nama_lengkap",
         },
         {
            data: "jenis_kelamin",
         },
         {
            data: "nomor_kursi",
         },
         {
            data: "status_tamu_lengkap",
         },
         {
            data: "nama_program_studi",
         },
         {
            data: "nama_periode",
         },
         {
            data: "action",
            orderable: !1,
         },
      ],
   });
});

$("#select_periode, #select_program_studi").change(function (event) {
   tbData.ajax.reload();
});

$(document)
   .off("click", "button.action-sync")
   .on("click", "button.action-sync", function (e) {
      e.preventDefault();
      let url = $(this).attr("data-url");
      let id_periode = $("#select_periode").val();

      if (id_periode === "") {
         Swal.fire({
            title: "Peringatan",
            text: "Silakan pilih Periode Wisuda terlebih dahulu sebelum melakukan sinkronisasi.",
            icon: "warning",
            customClass: { confirmButton: "btn btn-warning w-xs mt-2" },
            buttonsStyling: !1,
         });
         return;
      }

      Swal.fire({
         html: '<div class="mt-3"><lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon><div class="mt-4 pt-2 fs-15 mx-5"><h4>Sinkronisasi Data Wisudawan?</h4><p class="text-muted mx-4 mb-0">Pastikan Anda telah memilih periode yang benar sebelum sinkronisasi.</p></div></div>',
         showCancelButton: !0,
         customClass: { confirmButton: "btn btn-primary w-xs me-2 mb-1", cancelButton: "btn btn-light w-xs mb-1" },
         confirmButtonText: "Ya, Sinkronisasikan!",
         cancelButtonText: "Batal",
         buttonsStyling: !1,
         showCloseButton: !0,
      }).then(function (t) {
         if (t.value) {
            $("#loading-ajax").show();
            $.ajax({
               type: "POST",
               url: url,
               data: {
                  id_periode: id_periode,
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
         }
      });
   });

$(document)
   .off("click", "button.action-generate")
   .on("click", "button.action-generate", function (e) {
      e.preventDefault();
      let url = $(this).attr("data-url");
      let id_periode = $("#select_periode").val();

      if (id_periode === "") {
         Swal.fire({
            title: "Peringatan",
            text: "Silakan pilih Periode Wisuda terlebih dahulu sebelum melakukan generate nomor kursi.",
            icon: "warning",
            customClass: { confirmButton: "btn btn-warning w-xs mt-2" },
            buttonsStyling: !1,
         });
         return;
      }

      Swal.fire({
         html: '<div class="mt-3"><lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon><div class="mt-4 pt-2 fs-15 mx-5"><h4>Generate Nomor Kursi?</h4><p class="text-muted mx-4 mb-0">Nomor kursi wisudawan pada periode yang dipilih akan digenerate secara berurutan sesuai dengan asal program studi dan kelamin.</p></div></div>',
         showCancelButton: !0,
         customClass: { confirmButton: "btn btn-primary w-xs me-2 mb-1", cancelButton: "btn btn-light w-xs mb-1" },
         confirmButtonText: "Ya, Generate!",
         cancelButtonText: "Batal",
         buttonsStyling: !1,
         showCloseButton: !0,
      }).then(function (t) {
         if (t.value) {
            $("#loading-ajax").show();
            $.ajax({
               type: "POST",
               url: url,
               data: {
                  id_periode: id_periode,
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
         }
      });
   });

const modalElement = document.getElementById("dataModal");
const dataModal = new bootstrap.Modal(modalElement);

$(".action-add").click(function (e) {
   e.preventDefault();
   let title = $(this).attr("data-title");
   $("#dataModal .modal-title").html(title);
   clearFormDataByID("form-data");
   dataModal.show(modalElement);
});

$("#btn-search-nim").click(function (e) {
   e.preventDefault();
   let nim = $("#nim").val();
   let url = $(this).attr("data-url");

   if (nim === "") {
      Swal.fire({
         title: "Peringatan",
         text: "NIM wajib diisi sebelum mencari data.",
         icon: "warning",
         customClass: { confirmButton: "btn btn-warning w-xs mt-2" },
         buttonsStyling: !1,
      });
      return;
   }

   $("#loading-ajax").show();
   $.ajax({
      type: "POST",
      url: url,
      data: {
         nim: nim,
         [csrfToken]: csrfHash,
      },
      dataType: "JSON",
      success: function (res) {
         if (res.status == 200) {
            let data = res.data;
            $("form#form-data [name=nama_lengkap]").val(data.nama_lengkap);
            $("form#form-data [name=jenis_kelamin]").val(data.jenis_kelamin);
            $("form#form-data [name=jenis_kelas]").val(data.jenis_kelas);
            if (data.id_program_studi !== null) {
               $("form#form-data [name=id_program_studi]").val(data.id_program_studi);
            }
            Swal.fire({
               title: successMessage,
               text: "Berhasil mendapatkan data mahasiswa",
               icon: "success",
               customClass: { confirmButton: "btn btn-success w-xs mt-2" },
               buttonsStyling: !1,
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
                  $("form#form-data [name=nim]").val(data.nim);
                  $("form#form-data [name=nama_lengkap]").val(data.nama_lengkap);
                  $("form#form-data [name=jenis_kelamin]").val(data.jenis_kelamin);
                  $("form#form-data [name=jenis_kelas]").val(data.jenis_kelas);
                  $("form#form-data [name=nomor_kursi]").val(data.nomor_kursi);
                  $("form#form-data [name=id_periode]").val(data.id_periode);
                  $("form#form-data [name=id_program_studi]").val(data.id_program_studi);
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
