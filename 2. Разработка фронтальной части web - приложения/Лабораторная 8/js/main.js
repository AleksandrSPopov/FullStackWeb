/*--if (window.addEventListener) {
  window.addEventListener("storage", handle_storage, false);
} else {
  window.attachEvent("onstorage", handle_storage);
};

Функция обратного вызова handle_storage будет вызвана с объектом StorageEvent, за исключением Internet Explorer 8, 
где события хранятся в window.event.

function handle_storage(e) {
  if (!e) { e = window.event; }
}
  
В данном случае переменная e будет объектом StorageEvent, который обладает свойствами key, oldValue, newValue и url.--*/

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
    cell.colSpan = "4";
    cell.innerHTML = "Nothing to Show";
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
  if (!confirm("Are you sure you want to delete this item?")) return;
  localStorage.removeItem(key);
  updateTable();
}

function clearStorage() {
  if (!confirm("Are you sure you want to delete all local storage for this domain?")) return;
  localStorage.clear();
  updateTable();
}

function save() {
  var key = document.getElementById("key").value;
  var value = document.getElementById("value").value;
  localStorage.setItem(key, value);
  updateTable();
}
