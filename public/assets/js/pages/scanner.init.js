document.addEventListener("DOMContentLoaded", function () {
   let html5QrcodeScanner;
   let isScanning = true; // Flah untuk mencegah multiple hits

   // Konfigurasi SweetAlert dengan custom class
   const Toast = Swal.mixin({
      toast: true,
      position: "top-end",
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
      customClass: {
         popup: "colored-toast",
      },
   });

   function onScanSuccess(decodedText, decodedResult) {
      // Jika sedang memproses data (jeda), hiraukan scan baru
      if (!isScanning) return;
      isScanning = false;

      // Jeda Scanner (Visual)
      html5QrcodeScanner.pause();

      // Beri tanda suara bahwa QR sudah terbaca
      playAudioRead();

      // Tampilkan UI Hitung Mundur Snapshot
      showPrepUI();

      let counter = 2;
      const countdownEl = document.getElementById("countdown-text");
      countdownEl.innerText = counter;

      const countdownInterval = setInterval(() => {
         counter--;
         if (counter > 0) {
            countdownEl.innerText = counter;
         } else {
            clearInterval(countdownInterval);

            // Tangkap Snapshot dari Kamera (Elemen <video>)
            let base64Snapshot = "";
            const videoEl = document.querySelector("#reader video");
            if (videoEl) {
               const canvas = document.createElement("canvas");
               canvas.width = videoEl.videoWidth;
               canvas.height = videoEl.videoHeight;
               const ctx = canvas.getContext("2d");
               ctx.drawImage(videoEl, 0, 0, canvas.width, canvas.height);
               base64Snapshot = canvas.toDataURL("image/jpeg", 0.8);
            }

            // Suara jepretan kamera buatan (opsional)
            playAudioCapture();

            // Siapkan Data
            let formData = new FormData();
            formData.append("qr_token", decodedText);
            formData.append("snapshot", base64Snapshot);
            formData.append(csrfName, csrfHash);

            // Kirim AJAX ke Backend
            $.ajax({
               url: processUrl,
               type: "POST",
               data: formData,
               processData: false,
               contentType: false,
               dataType: "json",
               success: function (response) {
                  if (response.csrfHash) {
                     csrfHash = response.csrfHash;
                  }
                  showResultUI(response);

                  setTimeout(function () {
                     hideResultUI();
                     html5QrcodeScanner.resume();
                     isScanning = true;
                  }, 3000);
               },
               error: function (xhr) {
                  let msg = "Terjadi kesalahan server saat memproses scan.";
                  if (xhr.responseJSON && xhr.responseJSON.message) {
                     msg = xhr.responseJSON.message;
                  }
                  showResultUI({
                     status: "error",
                     message: msg,
                  });

                  setTimeout(function () {
                     hideResultUI();
                     html5QrcodeScanner.resume();
                     isScanning = true;
                  }, 4000);
               },
            });
         }
      }, 1000); // 1 detik interval
   }

   function onScanFailure(error) {
      // Abaikan peringatan gagal deteksi (berjalan terus menerus)
   }

   // Inisialisasi Scanner dengan aspect ratio lanskap/komputer
   html5QrcodeScanner = new Html5QrcodeScanner(
      "reader",
      {
         fps: 10,
         qrbox: { width: 400, height: 400 },
         aspectRatio: 1.75,
         rememberLastUsedCamera: true,
      },
      /* verbose= */ false,
   );
   html5QrcodeScanner.render(onScanSuccess, onScanFailure);

   function showPrepUI() {
      const idleState = document.getElementById("idle-state");
      const resultState = document.getElementById("result-state");
      const prepState = document.getElementById("prep-state");

      idleState.style.display = "none";
      resultState.classList.remove("active");
      prepState.classList.add("active");
   }

   // Fungsi Pembantu UI Result
   function showResultUI(res) {
      const idleState = document.getElementById("idle-state");
      const resultState = document.getElementById("result-state");
      const prepState = document.getElementById("prep-state");
      const resultCard = document.getElementById("result-card");
      const iconWrap = document.getElementById("result-icon-wrap");
      const iconEl = document.getElementById("result-icon");
      const titleEl = document.getElementById("result-title");
      const namaEl = document.getElementById("result-nama");
      const tipeEl = document.getElementById("result-tipe");
      const messageEl = document.getElementById("result-message");

      idleState.style.display = "none";
      prepState.classList.remove("active");
      resultState.classList.add("active");

      if (res.status === "success") {
         // Card background
         resultCard.classList.remove("state-idle", "state-error");
         resultCard.classList.add("state-success");

         // Ikon
         iconWrap.className = "result-icon-wrap success";
         iconEl.className = "ri-checkbox-circle-fill";

         // Teks
         titleEl.innerHTML = '<span class="text-success">BERHASIL!</span>';
         namaEl.innerHTML = res.data ? `<span class="text-success">${res.data.nama}</span>` : "";
         tipeEl.innerHTML = res.data ? `<span class="result-tipe-badge bg-success-subtle text-success">${res.data.tipe}</span>` : "";
         messageEl.innerHTML = `<i class="ri-time-line align-bottom me-1"></i> Presensi tercatat`;

         playAudioSuccess();
      } else {
         // Card background
         resultCard.classList.remove("state-idle", "state-success");
         resultCard.classList.add("state-error");

         // Ikon
         iconWrap.className = "result-icon-wrap error";
         iconEl.className = "ri-close-circle-fill";

         // Teks
         titleEl.innerHTML = '<span class="text-danger">DITOLAK!</span>';
         namaEl.innerHTML = "";
         tipeEl.innerHTML = "";
         messageEl.innerHTML = res.message;

         playAudioError();
      }
   }

   function hideResultUI() {
      const idleState = document.getElementById("idle-state");
      const resultState = document.getElementById("result-state");
      const prepState = document.getElementById("prep-state");
      const resultCard = document.getElementById("result-card");

      resultState.classList.remove("active");
      prepState.classList.remove("active");
      resultCard.classList.remove("state-success", "state-error");
      resultCard.classList.add("state-idle");
      idleState.style.display = "block";
   }

   // Audio Fallback
   function playAudioRead() {
      try {
         const ctx = new (window.AudioContext || window.webkitAudioContext)();
         const osc = ctx.createOscillator();
         const gain = ctx.createGain();
         osc.connect(gain);
         gain.connect(ctx.destination);

         osc.type = "sine";
         osc.frequency.setValueAtTime(1500, ctx.currentTime);
         gain.gain.setValueAtTime(0.3, ctx.currentTime);
         gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.1);

         osc.start();
         osc.stop(ctx.currentTime + 0.1);
      } catch (e) {}
   }

   function playAudioCapture() {
      try {
         const ctx = new (window.AudioContext || window.webkitAudioContext)();
         const osc = ctx.createOscillator();
         const gain = ctx.createGain();
         osc.connect(gain);
         gain.connect(ctx.destination);

         osc.type = "square";
         osc.frequency.setValueAtTime(400, ctx.currentTime);
         osc.frequency.exponentialRampToValueAtTime(800, ctx.currentTime + 0.05);
         gain.gain.setValueAtTime(0.1, ctx.currentTime);
         gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.05);

         osc.start();
         osc.stop(ctx.currentTime + 0.05);
      } catch (e) {}
   }

   function playAudioSuccess() {
      try {
         const ctx = new (window.AudioContext || window.webkitAudioContext)();
         const osc = ctx.createOscillator();
         const gain = ctx.createGain();
         osc.connect(gain);
         gain.connect(ctx.destination);

         osc.type = "sine";
         osc.frequency.setValueAtTime(800, ctx.currentTime);
         osc.frequency.exponentialRampToValueAtTime(1200, ctx.currentTime + 0.1);

         gain.gain.setValueAtTime(0.5, ctx.currentTime);
         gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.1);

         osc.start();
         osc.stop(ctx.currentTime + 0.1);
      } catch (e) {
         console.log("Audio not supported");
      }
   }

   function playAudioError() {
      try {
         const ctx = new (window.AudioContext || window.webkitAudioContext)();
         const osc = ctx.createOscillator();
         const gain = ctx.createGain();
         osc.connect(gain);
         gain.connect(ctx.destination);

         osc.type = "sawtooth";
         osc.frequency.setValueAtTime(200, ctx.currentTime);
         osc.frequency.exponentialRampToValueAtTime(150, ctx.currentTime + 0.3);

         gain.gain.setValueAtTime(0.5, ctx.currentTime);
         gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.3);

         osc.start();
         osc.stop(ctx.currentTime + 0.3);
      } catch (e) {
         console.log("Audio not supported");
      }
   }
});
