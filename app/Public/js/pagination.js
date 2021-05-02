var offset = 5;


window.onscroll = function () {

    var totalPageHeight = document.body.scrollHeight;

    var scrollPoint = window.scrollY + window.innerHeight;

    // check if we hit the bottom of the page
    if (scrollPoint >= totalPageHeight) {
        pagination();
    }
}


function pagination() {
    var xhr = new XMLHttpRequest();
    var data = new FormData();

    data.append('offset', offset);
    xhr.open('POST', '/');
    xhr.send(data);

    xhr.onload = function () {
        if (this.status != 200 || this.responseText == '')
            return;

        var wrapper = document.getElementsByClassName('main-content-posts')[0];
        wrapper.insertAdjacentHTML('beforeend', this.responseText);

        offset = offset + 5;
    }
}