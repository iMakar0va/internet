document
  .querySelectorAll('input[type="radio"][name^="status_"]')
  .forEach((radio) => {
    radio.addEventListener("change", function () {
      const card = this.closest(".card");
      const btnUpdate = card.querySelector("#btnUpdate");
      btnUpdate.style.display = "block";
    });
  });
document.querySelectorAll("#btnUpdate").forEach((btn) => {
  btn.style.display = "none";
  btn.addEventListener("click", function () {
    const card = this.closest(".card");
    const cardId = card.dataset.id;
    const status = card.querySelector(
      "input[type='radio'][name^='status_']:checked"
    ).value;

    fetch("php/update_app.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        card_id: cardId,
        status: status,
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          alert("Вы обновили статус");
        } else {
          alert(data.message);
        }
      })
      .catch((error) => {
        alert(error.message);
      });
  });
});
