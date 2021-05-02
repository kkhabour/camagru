var inputElement = document.getElementById("img-open");
var image = document.getElementById("profile-img");

inputElement.addEventListener("change", readfileinput);
image.addEventListener("click", sendimagetoserver);

function sendimagetoserver() {
  inputElement.click();
}

function readfileinput() {
  const file = this.files[0];

  if (file == undefined) return;

  var formdata = new FormData();
  formdata.append("profile-image", file, file.name);

  var xhr = new XMLHttpRequest();
  xhr.open("POST", "/", true);

  xhr.send(formdata);


  xhr.onload = function () {
    if (this.status != 200 || this.responseText == '') return;
    var url = window.location.origin + "/" + this.responseText;
    image.setAttribute("src", url);
  };
}
