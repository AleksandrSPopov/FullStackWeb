window.addEventListener("load", updateTable, false);

function updateTable() {
  var tbody = document.getElementById("output");
  while (tbody.getElementsByTagName("tr").length > 0) {
    tbody.deleteRow(0);
  }
  var row;
  if (localStorage.length == 0) {
    row = tbody.insertRow(i);
    cell = row.insertCell(0);

  }
  for (var i = 0; i < localStorage.length; ++i) {
    row = tbody.insertRow(i);
    cell = row.insertCell(0);
    cell.innerHTML = i;
    cell = row.insertCell(1);
    cell.innerHTML = localStorage.key(i);
    cell = row.insertCell(2);
    cell.innerHTML = localStorage.getItem(localStorage.key(i));
    cell = row.insertCell(3);
    cell.innerHTML = "<img src='./img/close.jpg' onclick='deleteItem(\"" + localStorage.key(i) + "\")'>";
  }
}

function deleteItem(key) {
  if (!confirm("Удалить?")) return;
  localStorage.removeItem(key);
  updateTable();
}

function clearStorage() {
  if (!confirm("Очистить всё?")) return;
  localStorage.clear();
  updateTable();
}

function save() {
  var address = document.getElementById("deliveryaddress").value;
  var notes = document.getElementById("notes").value;
  localStorage.setItem(address, notes);
  updateTable();
  document.getElementById("currentaddress").textContent = address;
}