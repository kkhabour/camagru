

var xhr = new XMLHttpRequest();


xhr.open('GET', '/posts');


xhr.onload = function () {
    if (this.status != 200 || this.responseText == '')
        return;

    var nophoto = document.getElementsByClassName("main-content-posts-photos-wrapper-nophoto")[0];
    nophoto.style.display = "none";

    var wrapper = document.getElementsByClassName('main-content-posts-photos-wrapper')[0];
    wrapper.innerHTML += (this.responseText);

}


xhr.send();