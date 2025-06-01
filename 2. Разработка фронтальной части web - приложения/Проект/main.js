function AddCategory() {

  const parentElement = document.getElementById("category");
  const newCategory = '<div class="cat"><h2>Категория </h2><p>Группа 1</p><p>Группа 2</p><p>Группа 3</p><p>Группа 4</p><p>Группа 5</p></div>';
  parentElement.insertAdjacentHTML('beforeend', newCategory);
}