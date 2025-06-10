document.getElementById("regForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const form = e.target;
  const formData = new FormData(form);
  const fields = form.querySelectorAll("input");

  let isValid = true;
  let errors = [];

  fields.forEach((el) => {
    el.classList.remove("error");
  });
  document.getElementById("errorMessage").textContent = "";

  const namePattern = /^[А-Яа-яЁё\s]+$/;
  const phonePattern = /^\+7\(\d{3}\)\d{3}\-\d{2}\-\d{2}$/;
  const emailPattern = /^[^@\s]+@[^@\s]+\.[^@\s]+$/;

  const lastName = form.last_name.value;
  const firstName = form.first_name.value;
  const fatherName = form.father_name.value;
  const login = form.login.value;
  const password = form.password.value;
  const email = form.email.value;
  const phone = form.phone.value;

  if (!namePattern.test(lastName) || !lastName) {
    errors.push("Введите фамилию");
    form.last_name.classList.add("error");
    isValid = false;
  }
  if (!namePattern.test(firstName) || !firstName) {
    errors.push("Введите имя");
    form.first_name.classList.add("error");
    isValid = false;
  }
  if (!namePattern.test(fatherName) || !fatherName) {
    errors.push("Введите отчество");
    form.father_name.classList.add("error");
    isValid = false;
  }
  if (!emailPattern.test(email) || !email) {
    errors.push("Введите почту");
    form.email.classList.add("error");
    isValid = false;
  }
  if (!phonePattern.test(phone) || !phone) {
    errors.push("Введите телефон");
    form.phone.classList.add("error");
    isValid = false;
  }
  if (!login) {
    errors.push("Введите логин");
    form.login.classList.add("error");
    isValid = false;
  }
  if (password.length < 4 || !password) {
    errors.push("Введите пароль");
    form.password.classList.add("error");
    isValid = false;
  }
  if (!isValid) {
    document.getElementById("errorMessage").innerHTML = errors.join("<br>");
    return;
  }

  fetch("php/insert_user.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        alert("Вы зарегистрировались!");
        window.location.href = "auth.php";
      } else {
        document.getElementById("errorMessage").innerHTML = data.message;
        if (data.message == "Неуникальный логин!") {
          form.login.classList.add("error");
        }
      }
    })
    .catch((error) => {
      document.getElementById("errorMessage").innerHTML = error.message;
    });
});
