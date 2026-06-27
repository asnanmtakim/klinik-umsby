$(document).ready(function() {
    let table = $('#riwayat-table').DataTable({
        "processing": true,
        "serverSide": false,
        "ajax": {
            "url": urlGetAll,
            "type": "GET",
            "data": function(d) {
                d.status = $("#select_status").val();
            }
        },
        "columns": [
            { 
                "data": null,
                "render": function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            { 
                "data": "created_at",
                "render": function (data, type, row) {
                    if(!data) return "-";
                    // Format waktu menjadi DD/MM/YYYY HH:mm:ss
                    let date = new Date(data);
                    return date.toLocaleDateString('id-ID') + ' ' + date.toLocaleTimeString('id-ID');
                }
            },
            { "data": "nama_panitia" },
            { 
                "data": "qr_token",
                "render": function(data) {
                    return `<span class="font-monospace user-select-all">${data}</span>`;
                }
            },
            { 
                "data": "status_scan",
                "render": function(data) {
                    if (data === 'sukses') {
                        return '<span class="status-badge bg-success-subtle text-success"><i class="ri-check-line align-bottom"></i> SUKSES</span>';
                    } else {
                        return '<span class="status-badge bg-danger-subtle text-danger"><i class="ri-close-line align-bottom"></i> GAGAL</span>';
                    }
                }
            },
            { "data": "keterangan" },
            { 
                "data": "foto_snapshot",
                "render": function(data, type, row) {
                    if (data) {
                        let imgUrl = baseUploadsUrl + data;
                        return `
                            <a class="image-popup" href="${imgUrl}" title="${row.keterangan}">
                                <img src="${imgUrl}" alt="Snapshot" class="snapshot-thumbnail">
                            </a>
                        `;
                    }
                    return '<span class="badge bg-light text-muted">Tidak ada foto</span>';
                }
            }
        ],
        "drawCallback": function(settings) {
            // Re-initialize magnific popup on each table draw
            $('.image-popup').magnificPopup({
                type: 'image',
                closeOnContentClick: true,
                mainClass: 'mfp-img-mobile',
                image: {
                    verticalFit: true
                }
            });
        },
        "order": [[1, "desc"]],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
        }
    });

    $('#btn-refresh').click(function() {
        table.ajax.reload();
    });

    $('#select_status').change(function() {
        table.ajax.reload();
    });
});
