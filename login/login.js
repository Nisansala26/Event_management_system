document.addEventListener("DOMContentLoaded", () => {
  const loginForm = document.getElementById("loginForm");
  const popup = document.getElementById("popup");
  const togglePassword = document.getElementById("togglePassword");
  const passwordField = document.getElementById("password");

  // Show / Hide password
  togglePassword.addEventListener("click", () => {
    if(passwordField.type === "password"){
      passwordField.type = "text";
      togglePassword.textContent = "Hide";
    } else {
      passwordField.type = "password";
      togglePassword.textContent = "Show";
    }
  });

  // Handle form submit
  loginForm.addEventListener("submit", async (e) => {
    e.preventDefault();

    const email = loginForm.email.value.trim();
    const password = loginForm.password.value.trim();

    try {
      const res = await fetch("login.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ email, password })
      });

      const data = await res.json();

      popup.textContent = data.message;
      popup.className = `popup ${data.status}`;
      popup.style.display = "block";

      setTimeout(() => {
        popup.style.display = "none";
        popup.className = "popup";
      }, 2500);

      if(data.status === "success"){
        setTimeout(() => {
          window.location.href = "../home/home.html"; // redirect after success
        }, 1500);
      }
    } catch(err){
      popup.textContent = "Network error. Please try again!";
      popup.className = "popup error";
      popup.style.display = "block";
      setTimeout(() => { popup.style.display = "none"; popup.className = "popup"; }, 2500);
    }
  });
});
