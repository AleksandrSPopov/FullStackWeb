function AddCategory() {
  const parentElement = document.getElementById("category");
  const newCategory =
    '<div class="cat"><h2>Категория </h2><p>Группа 1</p><p>Группа 2</p><p>Группа 3</p><p>Группа 4</p><p>Группа 5</p></div>';
  parentElement.insertAdjacentHTML("beforeend", newCategory);
}

let data = [
  "Александр Попов",
  "Санкт-Петербург",
  "popov-a-s@mail.ru",
  "+7-812-555-55-55",
];

function AddData() {
  const html = data.map((item) => `<li>${item}</li>`).join("");
  document.querySelector("ul").innerHTML = html;
}
