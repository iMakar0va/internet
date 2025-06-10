document.getElementById("createForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const form = e.target;
  const formData = new FormData(form);
  const fields = form.querySelectorAll("input,textarea,select");

  let isValid = true;
  let errors = [];

  fields.forEach((el) => {
    el.classList.remove("error");
  });
  document.getElementById("errorMessage").textContent = "";

  const problem = form.problem.value;
  const otherProblem = form.otherProblem.value;
  const date = form.date.value;
  const time = form.time.value;
  const priority = form.priority.value;

  if (!problem) {
    errors.push("Введите проблему");
    form.problem.classList.add("error");
    isValid = false;
  }
  if (problem == "Другое" && !otherProblem) {
    errors.push("Введите проблему");
    form.otherProblem.classList.add("error");
    isValid = false;
  }
  if (!priority) {
    errors.push("Введите приоритет");
    form.priority.classList.add("error");
    isValid = false;
  }
  if (!date) {
    errors.push("Введите дату");
    form.date.classList.add("error");
    isValid = false;
  } else {
    const today = new Date();
    const selectedDate = new Date(date);
    if (today > selectedDate) {
      errors.push("Введите дату позже сегодня");
      form.date.classList.add("error");
      isValid = false;
    }
  }
  if (!time) {
    errors.push("Введите время");
    form.time.classList.add("error");
    isValid = false;
  }
  if (!isValid) {
    document.getElementById("errorMessage").innerHTML = errors.join("<br>");
    return;
  }

  fetch("php/insert_app.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        alert("Вы создали заявку");
        window.location.href = "lk.php";
      } else {
        document.getElementById("errorMessage").innerHTML = data.message;
      }
    })
    .catch((error) => {
      document.getElementById("errorMessage").innerHTML = error.message;
    });
});

document.getElementById("problem").addEventListener("change", function () {
  if (this.value == "Другое") {
    document.getElementById("otherProblem").style.display = "block";
  } else {
    document.getElementById("otherProblem").style.display = "none";
    document.getElementById("otherProblem").value = "";
  }
});
