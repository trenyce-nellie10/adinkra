// js/login.js
document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("loginForm");
  const message = document.getElementById("message");
  const submitBtn = document.getElementById("loginBtn");

  form.addEventListener("submit", function (e) {
    e.preventDefault();

    // Basic validation
    const formData = new FormData(form);
    const email = formData.get("email").trim();
    const password = formData.get("password");

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
      message.textContent = "Please enter a valid email.";
      return;
    }
    if (password.length < 6) {
      message.textContent = "Password must be at least 6 characters.";
      return;
    }

    // Loading UI
    submitBtn.disabled = true;
    submitBtn.dataset.original = submitBtn.textContent;
    submitBtn.textContent = "Signing in...";

    fetch("actions/login_customer_action.php", {
      method: "POST",
      body: formData
    })
      .then((res) => res.json())
      .then((data) => {
        message.textContent = data.message || "An error occurred";
        if (data.status === "success") {
          setTimeout(() => (window.location.href = "index.php"), 800);
        }
      })
      .catch((err) => {
        message.textContent = "Network error. Try again.";
      })
      .finally(() => {
        submitBtn.disabled = false;
        submitBtn.textContent = submitBtn.dataset.original || "Login";
      });
  });
});
