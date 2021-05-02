function comment(obj) {
    var wrapper = obj.closest('.main-content-posts-article');
    var postID = wrapper.getAttribute('data-id');
    var input = wrapper.getElementsByClassName('comment-input')[0];

    var comment = input.value.trim();


    if (comment == '')
        return ;
    
     var xhr = new XMLHttpRequest();
     var data = new FormData();

     data.append('comment[]', postID);
     data.append('comment[]', comment);

     xhr.open('POST', '/');
     xhr.send(data);
     xhr.onload = function () {
         if (this.status != 200 || this.responseText == '')
            return ;
        var commentParent = wrapper.getElementsByClassName('main-content-posts-article-comment-data')[0];
        commentParent.insertAdjacentHTML('beforeend', this.responseText);
        input.value = "";

        sendmail(postID, comment);
     }

}



function sendmail(postid, comment) {
    var xhr = new XMLHttpRequest;


    var data = new FormData();
    data.append('mailnotification[]', postid);
    data.append('mailnotification[]', comment);

    xhr.open("POST", "/");

    xhr.send(data);




}
