document.getElementById("loginForm").addEventListener("submit", function(e) {
    e.preventDefault();

    let email = document.getElementById("email").value.trim();
    let password = document.getElementById("password").value.trim();

    let valid = true;

    if (email === "") {
        document.getElementById("errorEmail").innerText = "Email wajib diisi";
        valid = false;
    } else {
        document.getElementById("errorEmail").innerText = "";
    }

    if (password === "") {
        document.getElementById("errorPassword").innerText = "Password wajib diisi";
        valid = false;
    } else {
        document.getElementById("errorPassword").innerText = "";
    }

    if (valid) {
        window.location.href = "soal2.html";
    }
});

document.getElementById("googleBtn").addEventListener("click", function() {
    alert("⚠️ Fitur Sign in with Google belum tersedia");
});



