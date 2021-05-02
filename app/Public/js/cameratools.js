var pictureButton = document.getElementById("camera_picture_button");
var restoreButton = document.getElementById("camera_restore_button");
var addButton = document.getElementById("camera_add_button");

var postbutton = document.getElementById("camera_post_button");

pictureButton.addEventListener("click", function () {
  if (video.paused == true) return;

  var canvas = document.createElement("canvas");
  canvas.height = height;
  canvas.width = width;

  var context = canvas.getContext("2d");
  context.drawImage(video, 0, 0, width, height);

  var data = canvas.toDataURL("image/png");

  showImage(data);
});

restoreButton.addEventListener("click", function () {
  playVideo();
});

addButton.addEventListener("click", function () {
  var input = document.createElement("input");
  input.setAttribute("type", "file");
  input.click();

  input.addEventListener("change", function () {
    var file = this.files[0];
    if (!isvalid(file))
      return;
    var reader = new FileReader();
    reader.onload = function (event) {
      showImage(this.result);
    };
    reader.readAsDataURL(file);
  });
});

function isvalid(file) {
  var types = ["image/jpeg", "image/png", "image/jpg"];
  var result = false;
  types.forEach(function (type) {
    if (file.type == type) result = true;
  });
  return result;
}

postbutton.addEventListener("click", function () {
  if (video.paused == false) return;

  // get all sticker

  var stickers = document.getElementsByClassName("main-content-posts-camera-stickerimg");
  var srcimage = document.getElementById("camera_image");

  // send photo to server
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "/");

  var data = new FormData();

  data.append("avatar[]", srcimage.getAttribute("src"));
  data.append("avatar[]", srcimage.offsetWidth);
  data.append("avatar[]", srcimage.clientHeight);

  var stickers = document.getElementsByClassName("main-content-posts-camera-stickerimg");

  if (stickers)
    for (i = 0; i < stickers.length; i++) {
      var elem = stickers.item(i);
      var stickername = elem.getAttribute("src").split("/");
      stickername = stickername[stickername.length - 1];
      var sticker = stickername + "," + elem.offsetLeft + "," + elem.offsetTop;
      data.append("stickers[]", sticker);
    }

  xhr.onload = function () {
    if (this.status != 200) return;

    addphototoprevioustaken(this.responseText);
    playVideo();
    cleanstickers();
  };

  xhr.send(data);
});

function addphototoprevioustaken(src) {
  // add photo to previous taken photos list
  var nophoto = document.getElementsByClassName("main-content-posts-photos-wrapper-nophoto")[0];
  nophoto.style.display = "none";

  var div = document.createElement("div");
  div.setAttribute("class", "main-content-posts-photos-wrapper-img");
  div.setAttribute("onmouseover", "delover(this)");
  div.setAttribute("onmouseout", "delout(this)");

  var destimage = document.createElement("img");
  destimage.setAttribute("src", src);
  destimage.setAttribute("onclick", "removeimage(this)");
  div.appendChild(destimage);

  var container = document.getElementsByClassName("main-content-posts-photos-wrapper")[0];
  container.appendChild(div);
}

function playVideo() {
  var video = document.getElementById("camera_video");
  var image = document.getElementById("camera_image");
  image.style.display = "none";
  video.style.display = "block";
  video.play();
}

function showImage(src) {
  var video = document.getElementById("camera_video");
  var image = document.getElementById("camera_image");
  video.style.display = "none";
  image.style.display = "block";
  image.setAttribute("src", src);
  video.pause();
}

function cleanstickers() {
  var stickers = document.getElementsByClassName("main-content-posts-camera-stickerimg");
  while (stickers.length > 0) stickers[0].parentNode.removeChild(stickers[0]);
}
