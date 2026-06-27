var tbData;
$(document).ready(function () {
   tbData = $("#table-tamu").DataTable({
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
         url: $("#table-tamu").attr("data-url"),
         data: function (req) {
            req.id_periode = $("#id_periode").val();
            req.id_program_studi = $("#id_program_studi").val();
         },
      },
      order: [],
      columns: [
         {
            data: "no",
            orderable: !1,
         },
         {
            data: "nama_tamu",
         },
         {
            data: "hubungan_dengan_wisudawan",
         },
         {
            data: "qr_token",
         },
         {
            data: "nim",
         },
         {
            data: "nama_lengkap",
         },
         {
            data: "nama_program_studi",
         },
         {
            data: "nama_periode",
         },
      ],
   });
});

$("#id_periode, #id_program_studi").change(function (event) {
   tbData.ajax.reload();
});
