
function like(obj) {
    var wrapper = obj.closest('.main-content-posts-article');
    var postID = wrapper.getAttribute('data-id');
    var icon = wrapper.getElementsByClassName('main-content-posts-article-comment-like')[0].getElementsByTagName('img')[0];


    var xhr = new XMLHttpRequest();
    var data = new FormData();



    data.append('like', postID);
    xhr.open('POST', '/');
    xhr.send(data);

    xhr.onload = function () {
        if (this.status != 200 || this.responseText == '')
            return;
        var response = this.responseText.split(',');
        var likesText = icon.closest('.main-content-posts-article-comment-like');

        icon.setAttribute('src', response[0]);
        likesText.lastElementChild.textContent = response[1] + ' likes';
    }
}

