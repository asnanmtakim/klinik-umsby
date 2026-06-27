$(document).ready(function () {
   $("#btn-save").on("click", function (e) {
      e.preventDefault();

      // Validasi HTML5 dasar
      var form = document.getElementById("form-registrasi-tamu");
      if (!form.checkValidity()) {
         form.classList.add("was-validated");
         Swal.fire({
            icon: "warning",
            title: "Data Belum Lengkap",
            text: "Mohon periksa kembali isian formulir Anda yang ditandai dengan warna merah.",
            customClass: { confirmButton: "btn btn-primary w-xs me-2 mt-2" },
            buttonsStyling: false,
         });
         return false;
      }

      var formData = new FormData(form);

      Swal.fire({
         title: "Simpan Data Tamu?",
         text: "Pastikan nama dan identitas tamu sudah diketik dengan benar.",
         icon: "question",
         showCancelButton: true,
         customClass: { confirmButton: "btn btn-primary w-xs me-2 mt-2", cancelButton: "btn btn-danger w-xs mt-2" },
         confirmButtonText: "Ya, Simpan!",
         cancelButtonText: "Batal",
         buttonsStyling: false,
         showCloseButton: true,
      }).then(function (result) {
         if (result.isConfirmed) {
            Swal.fire({
               title: "Mohon Tunggu!",
               html: "Sedang menyimpan data...",
               allowOutsideClick: false,
               didOpen: () => {
                  Swal.showLoading();
               },
            });

            $.ajax({
               url: url_save,
               type: "POST",
               data: formData,
               processData: false,
               contentType: false,
               dataType: "json",
               success: function (response) {
                  Swal.fire({
                     icon: "success",
                     title: "Berhasil!",
                     text: response.message,
                     customClass: { confirmButton: "btn btn-success w-xs mt-2" },
                     buttonsStyling: false,
                  }).then(function () {
                     location.reload();
                  });
               },
               error: function (xhr) {
                  let msg = "Terjadi kesalahan saat menyimpan data.";
                  if (xhr.responseJSON && xhr.responseJSON.message) {
                     msg = xhr.responseJSON.message;
                  }
                  Swal.fire({
                     icon: "error",
                     title: "Gagal!",
                     text: msg,
                     customClass: { confirmButton: "btn btn-danger w-xs mt-2" },
                     buttonsStyling: false,
                  });
               },
            });
         }
      });
   });
});
