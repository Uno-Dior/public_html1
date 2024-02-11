const actionButtons = document.querySelectorAll(".actionButton");
    const loginForm = document.getElementById("loginForm");
    const signupForm = document.getElementById("signupForm");
    const closeButtons = document.querySelectorAll(".close-popup");

actionButtons.forEach((button) => {
  button.addEventListener("click", (event) => {
    const action = button.getAttribute("data-action");
    if (action === "login") {
      loginForm.style.display = "flex";
      signupForm.style.display = "none";
    } else if (action === "signup") {
      loginForm.style.display = "none";
      signupForm.style.display = "flex";
    }
  });
});

closeButtons.forEach((closeButton) => {
  closeButton.addEventListener("click", (event) => {
    const action = closeButton.getAttribute("data-action");
    if (action === "login") {
      loginForm.style.display = "none";
    } else if (action === "signup") {
      signupForm.style.display = "none";
    }
  });
});

window.addEventListener("click", (event) => {
  if (event.target === loginForm) {
    loginForm.style.display = "none";
  } else if (event.target === signupForm) {
    signupForm.style.display = "none";
  }
});