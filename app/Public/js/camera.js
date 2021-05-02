var width = 1280;
var height = 720;

var constraints = {
  video: {
    width: { min: width },
    height: { min: height },
  },
};

var video = document.getElementById("camera_video");

if (navigator.mediaDevices === undefined) {
  navigator.mediaDevices = {};
}

if (navigator.mediaDevices.getUserMedia === undefined) {
  navigator.mediaDevices.getUserMedia = function (constraints) {

    var getUserMedia = navigator.webkitGetUserMedia || navigator.mozGetUserMedia;


    if (!getUserMedia) {
      return Promise.reject(new Error("getUserMedia is not implemented in this browser"));
    }


    return new Promise(function (resolve, reject) {
      getUserMedia.call(navigator, constraints, resolve, reject);
    });
  };
}

navigator.mediaDevices
  .getUserMedia(constraints)
  .then(function (stream) {

    if ("srcObject" in video) {
      video.srcObject = stream;
    } else {

      video.src = window.URL.createObjectURL(stream);
    }
    video.onloadedmetadata = function (e) {
      video.play();
    };
  })
  .catch(function (err) {
  });
