var btn = document.getElementById("pressthebutton");

function buttonClicked() {
  btn.removeEventListener("click", buttonClicked);
  document.getElementById("text").innerHTML = '<a href="carselection.html">К выбору авто ...</a>';
}

btn.addEventListener("click", buttonClicked);
