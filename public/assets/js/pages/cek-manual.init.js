"use strict";

// ─── State ───────────────────────────────────────────────────────────────────
let pendingId = null;
let pendingTipe = null;

// ─── Helpers ─────────────────────────────────────────────────────────────────
function showState(state) {
   ["state-empty", "state-loading", "state-notfound", "state-results"].forEach((id) => {
      document.getElementById(id).classList.add("d-none");
   });
   document.getElementById(state).classList.remove("d-none");
}

function avatarColor(tipe) {
   return tipe === "wisudawan" ? "#405189" : "#0ab39c";
}

function avatarInitial(nama) {
   const parts = nama.trim().split(" ");
   return parts.length >= 2 ? (parts[0][0] + parts[1][0]).toUpperCase() : nama.substring(0, 2).toUpperCase();
}

function formatTime(str) {
   if (!str) return "-";
   const d = new Date(str);
   if (isNaN(d)) return str;
   return d.toLocaleString("id-ID", { dateStyle: "medium", timeStyle: "short" });
}

function buildResultItem(item) {
   const isWisudawan = item.tipe === "wisudawan";
   const sudahHadir = item.waktu_presensi && item.waktu_presensi !== "0000-00-00 00:00:00";
   const tipeBadge = isWisudawan ? '<span class="badge bg-primary-subtle text-primary badge-tipe">Wisudawan</span>' : '<span class="badge bg-info-subtle text-info badge-tipe" style="background:#d1faf5;color:#0ab39c;">Tamu</span>';

   const statusBadge = sudahHadir ? `<span class="badge status-hadir"><i class="ri-checkbox-circle-line align-bottom me-1"></i>Sudah Hadir</span>` : `<span class="badge status-belum"><i class="ri-close-circle-line align-bottom me-1"></i>Belum Hadir</span>`;

   const btnHadir = sudahHadir
      ? `<button class="btn btn-light btn-sm btn-hadirkan" disabled>
               <i class="ri-check-line align-bottom me-1"></i> Sudah Hadir
           </button>`
      : `<button class="btn btn-success btn-sm btn-hadirkan btn-hadir-action"
               data-id="${item.id}" data-tipe="${item.tipe}" data-nama="${escapeHtml(item.nama_lengkap)}" data-nim="${escapeHtml(item.nim || "-")}">
               <i class="ri-user-follow-line align-bottom me-1"></i> Hadirkan Manual
           </button>`;

   const prodiOrParent = isWisudawan
      ? `<small class="text-muted">${escapeHtml((item.level_program_studi ? item.level_program_studi + ' ' : '') + (item.nama_prodi || '-'))}</small>`
      : `<small class="text-muted">Tamu dari: ${escapeHtml(item.nama_prodi || "-")}</small>`;

   const nimDisplay = isWisudawan ? `<span class="nim-badge">${escapeHtml(item.nim || "-")}</span>` : `<span class="nim-badge">Tamu Pendamping</span>`;

   return `
    <div class="result-item">
        <div class="d-flex align-items-start gap-3">
            <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold flex-shrink-0 bg-${isWisudawan ? "primary" : "info"}"
                 style="width:46px;height:46px;font-size:1rem;">
                ${avatarInitial(item.nama_lengkap)}
            </div>
            <div class="flex-grow-1">
                <div class="d-flex align-items-center flex-wrap gap-1 mb-1">
                    <h6 class="mb-0 fw-bold me-1">${escapeHtml(item.nama_lengkap)}</h6>
                    ${tipeBadge}
                </div>
                <div class="mb-1">${nimDisplay} ${prodiOrParent}</div>
                <div class="d-flex align-items-center gap-2 flex-wrap mt-2">
                    ${statusBadge}
                    ${sudahHadir ? `<small class="text-muted"><i class="ri-time-line align-bottom"></i> ${formatTime(item.waktu_presensi)}</small>` : ""}
                </div>
            </div>
            <div class="flex-shrink-0">
                ${btnHadir}
            </div>
        </div>
    </div>`;
}

function escapeHtml(str) {
   if (!str) return "";
   return String(str).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;");
}

// ─── Search ───────────────────────────────────────────────────────────────────
function doSearch() {
   const keyword = document.getElementById("input-keyword").value.trim();
   if (!keyword) {
      Swal.fire({ icon: "warning", title: "Perhatian", text: "Masukkan NIM atau nama terlebih dahulu.", confirmButtonColor: "#405189" });
      return;
   }

   showState("state-loading");
   document.getElementById("result-count-badge").classList.add("d-none");

   const formData = new FormData();
   formData.append("keyword", keyword);
   formData.append(csrfName, csrfHash);

   fetch(urlSearch, {
      method: "POST",
      headers: { "X-Requested-With": "XMLHttpRequest" },
      body: formData,
   })
      .then((res) => res.json())
      .then((data) => {
         // Update CSRF
         const newToken = data.csrf;
         if (newToken) csrfHash = newToken;

         if (data.status !== "success" || data.count === 0) {
            showState("state-notfound");
            return;
         }

         const container = document.getElementById("result-list-container");
         container.innerHTML = data.results.map(buildResultItem).join("");

         const badge = document.getElementById("result-count-badge");
         badge.textContent = data.count + " data ditemukan";
         badge.classList.remove("d-none");

         showState("state-results");
      })
      .catch(() => {
         showState("state-empty");
         Swal.fire({ icon: "error", title: "Gagal!", text: "Terjadi kesalahan saat menghubungi server.", confirmButtonColor: "#405189" });
      });
}

// ─── Click: Hadirkan Manual (buka modal konfirmasi) ──────────────────────────
document.addEventListener("click", function (e) {
   const btn = e.target.closest(".btn-hadir-action");
   if (!btn) return;

   pendingId = btn.dataset.id;
   pendingTipe = btn.dataset.tipe;
   const nama = btn.dataset.nama;
   const nim = btn.dataset.nim;

   document.getElementById("modal-nama").textContent = nama;
   document.getElementById("modal-nim").textContent = nim !== "-" ? "NIM: " + nim : "Tamu Pendamping";
   document.getElementById("modal-avatar").textContent = avatarInitial(nama);
   document.getElementById("modal-avatar").style.background = avatarColor(pendingTipe);

   const tipeBadge = pendingTipe === "wisudawan" ? '<span class="badge bg-primary-subtle text-primary">Wisudawan</span>' : '<span class="badge" style="background:#d1faf5;color:#0ab39c;">Tamu Pendamping</span>';
   document.getElementById("modal-tipe-badge").innerHTML = tipeBadge;

   const modal = new bootstrap.Modal(document.getElementById("modal-konfirmasi"));
   modal.show();
});

// ─── Click: Konfirmasi hadirkan (proses ke server) ───────────────────────────
document.getElementById("btn-konfirmasi-hadirkan").addEventListener("click", function () {
   if (!pendingId || !pendingTipe) return;

   const btnKonfirmasi = this;
   btnKonfirmasi.disabled = true;
   btnKonfirmasi.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Memproses...';

   const formData = new FormData();
   formData.append("id", pendingId);
   formData.append("tipe", pendingTipe);
   formData.append(csrfName, csrfHash);

   fetch(urlProcess, {
      method: "POST",
      headers: { "X-Requested-With": "XMLHttpRequest" },
      body: formData,
   })
      .then((res) => res.json())
      .then((data) => {
         // Update CSRF
         if (data.csrf) csrfHash = data.csrf;

         // Tutup modal
         bootstrap.Modal.getInstance(document.getElementById("modal-konfirmasi")).hide();

         btnKonfirmasi.disabled = false;
         btnKonfirmasi.innerHTML = '<i class="ri-user-follow-line align-bottom me-1"></i> Ya, Hadirkan Sekarang';

         if (data.status === "success") {
            Swal.fire({
               icon: "success",
               title: "Berhasil!",
               html: data.message,
               confirmButtonColor: "#0ab39c",
               confirmButtonText: "OK",
            }).then(() => {
               // Re-run search agar status terbaru tampil
               doSearch();
            });
         } else if (data.status === "warning") {
            Swal.fire({ icon: "warning", title: "Perhatian", html: data.message, confirmButtonColor: "#f7b84b" });
         } else {
            Swal.fire({ icon: "error", title: "Gagal!", html: data.message || "Terjadi kesalahan.", confirmButtonColor: "#f06548" });
         }

         pendingId = null;
         pendingTipe = null;
      })
      .catch(() => {
         btnKonfirmasi.disabled = false;
         btnKonfirmasi.innerHTML = '<i class="ri-user-follow-line align-bottom me-1"></i> Ya, Hadirkan Sekarang';
         Swal.fire({ icon: "error", title: "Gagal!", text: "Terjadi kesalahan saat menghubungi server.", confirmButtonColor: "#f06548" });
      });
});

// ─── Event Listeners ──────────────────────────────────────────────────────────
document.getElementById("btn-search").addEventListener("click", doSearch);

document.getElementById("input-keyword").addEventListener("keydown", function (e) {
   if (e.key === "Enter") doSearch();
});
