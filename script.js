(() => {
  "use strict";

  const form = document.querySelector(".needs-validation");
  const inputs = form.querySelectorAll("input, select, textarea");

  inputs.forEach((input) => {
    input.addEventListener("input", () => {
      validateField(input);
    });
  });

  function validateField(input) {
    if (input.id === "phone") {
      const phonePattern = /^\+?[0-9\s()-]{7,100}$/;
      const feedback = input.parentElement.querySelector(".invalid-feedback");
      if (input.value.trim() === "") {
        input.setCustomValidity("Введите номер телефона.");
        feedback.textContent = "Введите номер телефона.";
      } else if (!phonePattern.test(input.value)) {
        input.setCustomValidity("Некорректный формат телефона.");
        feedback.textContent =
          "Некорректный формат: телефон может содержать цифры и символ '+'";
      } else {
        feedback.textContent = "Введите номер телефона.";
        input.setCustomValidity("");
      }
    }
    if (input.checkValidity()) {
      input.classList.remove("is-invalid");
      input.classList.add("is-valid");
    } else {
      input.classList.remove("is-valid");
      input.classList.add("is-invalid");
    }
  }

  form.addEventListener("submit", (event) => {
    let formIsValid = true;

    inputs.forEach((input) => {
      validateField(input);
      if (!input.checkValidity()) {
        formIsValid = false;
      }
    });

    if (!formIsValid) {
      event.preventDefault();
      event.stopPropagation();
    }

    form.classList.add("was-validated");
  });

  document.addEventListener("DOMContentLoaded", () => {
    const message = sessionStorage.getItem("toastMessage");
    const type = sessionStorage.getItem("toastType") || "success";

    if (message) {
      const toastEl = document.getElementById("liveToast");
      const toastBody = document.getElementById("toastBody");
      toastBody.textContent = message;
      toastEl.className =
        "toast align-items-center border-0 text-bg-" +
        (type === "error" ? "danger" : "success");
      toastEl.style.display = "flex";

      const toast = new bootstrap.Toast(toastEl, { delay: 3000 });
      toast.show();

      sessionStorage.removeItem("toastMessage");
      sessionStorage.removeItem("toastType");
    }
  });
})();
