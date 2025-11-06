document.addEventListener("DOMContentLoaded", function() {
  const form = document.getElementById("registerForm");
  const message = document.getElementById("message");

  form.addEventListener("submit", function(e) {
    e.preventDefault();

    let formData = new FormData(form);

    // Email validation
    let email = formData.get("email");
    let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
      message.innerHTML = "Invalid email format";
      return;
    }

    // Phone validation
    let phone = formData.get("contact_number");
    let phoneRegex = /^[0-9]{7,15}$/;
    if (!phoneRegex.test(phone)) {
      message.innerHTML = "Invalid phone number";
      return;
    }

    fetch("actions/register_customer_action.php", {
      method: "POST",
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      message.innerHTML = data.message;
      if (data.status === "success") {
        setTimeout(() => {
          window.location.href = "login.php";
        }, 1500);
      }
    })
    .catch(err => {
      message.innerHTML = "Error: " + err;
    });
  });
});
