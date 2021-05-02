function delover(obj) {
  var wrapper = document.createElement("div");
  wrapper.style.backgroundColor = "rgba(0,0,0, 0.8)";
  wrapper.style.position = "absolute";
  wrapper.style.display = "flex";
  wrapper.style.justifyContent = "center";
  wrapper.style.alignItems = "center";
  wrapper.style.top = "0";
  wrapper.style.bottom = "0";
  wrapper.style.left = "0";
  wrapper.style.right = "0";
  wrapper.style.pointerEvents = "none";

  var icon = document.createElement("img");
  icon.setAttribute("src", "Public/Images/remove.svg");
  icon.setAttribute("onclick", "removeimage(this)");
  wrapper.appendChild(icon);
  obj.appendChild(wrapper);
}

function delout(obj) {
  var wrapper = obj.lastElementChild;
  obj.removeChild(wrapper);
}

function removeimage(obj) {
  var postid = obj.getAttribute("src");

  var xhr = new XMLHttpRequest();
  var data = new FormData();

  data.append("removepost", postid);
  xhr.open("POST", "/");

  xhr.send(data);

  xhr.onload = function () {
    if (this.status != 200) return;
    // remove image from ui
    var div = obj.parentElement;
    div.parentElement.removeChild(div);
  };
}
