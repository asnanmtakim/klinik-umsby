let form = document.getElementsByTagName("form")[0];
let loading = document.getElementById("loading-ajax");
form.addEventListener("submit", function (e) {
  e.preventDefault();
  loading.style.display = "block";
  form.submit();
});

function loginWithSSO() {
  loading.style.display = "block";
  // URL Gate SSO Anda, ganti 'URL_GATE_SSO' dan 'APP_KEY_BROKER'
  const gateSSOUrl = SSO_URL + "/sso-authorize/" + SSO_APP_KEY;

  // Buka popup di tengah layar
  const width = 500;
  const height = 600;
  const left = (screen.width - width) / 2;
  const top = (screen.height - height) / 2;

  const ssoWindow = window.open(
    gateSSOUrl,
    "SSOWindow",
    `width=${width},height=${height},top=${top},left=${left}`,
  );

  // Sembunyikan loading jika popup ditutup oleh pengguna
  const checkWindowClosed = setInterval(function () {
    if (ssoWindow && ssoWindow.closed) {
      clearInterval(checkWindowClosed);
      loading.style.display = "none";
    }
  }, 500);
}

// Mendengarkan pesan dari popup (postMessage)
window.addEventListener("message", function (event) {
  // SANGAT PENTING: Validasi origin untuk keamanan (Pastikan pesan datang dari Gate SSO Anda)
  const gateOrigin = SSO_URL; // Ganti dengan origin asli Gate SSO
  if (event.origin !== gateOrigin) {
    return; // Abaikan pesan dari sumber yang tidak dikenal
  }

  if (event.data && event.data.status === "success" && event.data.token) {
    window.location.href = LOGIN_SSO_URL + "?token=" + event.data.token;
  }
});
