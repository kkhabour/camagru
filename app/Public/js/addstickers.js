var stickerwrapper = document.getElementsByClassName("main-content-side")[0];

function addStickers() {
  for (var i = 0; i < 90; i++) {
    var sticker = document.createElement("img");
    sticker.setAttribute("class", "main-content-side-img");
    sticker.setAttribute("onclick", "addsticker(this)");

    sticker.setAttribute("src", "./Public/Images/stickers/" + numberFormatter(i) + ".png");

    stickerwrapper.appendChild(sticker);
  }
}

function numberFormatter(num) {
  if (num < 10) return "0" + num;
  return "" + num;
}

addStickers();


function addsticker(sticker) {
  var parrent = document.getElementsByClassName("main-content-posts-camera")[0];
  var image = document.createElement("img");
  image.setAttribute("class", "main-content-posts-camera-stickerimg");
  image.setAttribute("src", sticker.getAttribute("src"));
  image.setAttribute("style", "top:0; left:0");

  parrent.appendChild(image);
  dragElement(image);
}
