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
            d.baksos_service_id = $("#filter_service").val();
         }
      },
      order: [],
      columns: [
         { data: "no", orderable: !1 },
         { data: "nama_lengkap" },
         { data: "nik" },
         { data: "umur" },
         { data: "jenis_kelamin" },
         { data: "alamat" },
         { data: "no_hp" },
         { data: "nama_pelayanan" },
         { data: "created_at" },
         { data: "action", orderable: !1 },
      ],
   });

   $("#filter_service").on("change", function () {
      tbData.ajax.reload();
   });
   $("#btn-export").on("click", function () {
      let url = $(this).attr("data-url");
      let serviceId = $("#filter_service").val();
      window.location.href = url + "?baksos_service_id=" + serviceId;
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
            '<div class="mt-3"><lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon><div class="mt-4 pt-2 fs-15 mx-5"><h4>Yakin hapus data ?</h4><p class="text-muted mx-4 mb-0">Hapus pendaftar ' +
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
