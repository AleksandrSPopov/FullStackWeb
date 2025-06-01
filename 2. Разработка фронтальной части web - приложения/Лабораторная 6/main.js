element = document.getElementById("change");

function ChangeStyle() {
  element.style.color = "darkgreen";
  element.style.fontSize = "20px";
  element.style.textDecoration = "underline";
  element.style.fontWeight = "bold";
}

/*  ChangeStyle();*/

var link = document.getElementById("link");

link.addEventListener("mouseover", function () {
  ChangeStyle();
});