
class Reply {

    getAllReplies(postCommentId) {
        fetch('?c=postComments&a=getAllReplies&id=' + postCommentId)
            .then(response => response.json())
            .then(data => {
                let html = "";

                //vlozenie vsetkych replies
                for (let reply of data) {
                    html += "<div>" + reply.text + "</div>";
                }

                //vlozenie formulara na pridanie reply
                html += "<div>" + "<input id=\"replyUsername-" + postCommentId + "\" type=\"text\">" + "</div>";
                html += "<div>" + "<input id=\"replyText-" + postCommentId + "\" type=\"text\">" + "</div>";
                html += "<div>" + "<button id=\"btn-send-" + postCommentId + "\">" + "Odoslat reply" + "</button>" + "</div>";

                document.getElementById(postCommentId).innerHTML = html;

                document.getElementById("btn-send-" + postCommentId).onclick = () => {
                    var reply = new Reply();
                    reply.sendReply(postCommentId);
                }
            });
    }

    sendReply(postCommentId) {
        let text = document.getElementById("replyText-" + postCommentId).value;
        let username = document.getElementById("replyUsername-" + postCommentId).value;

        if (text.length === 0 || username.length === 0) {
            alert("error: formular obsahuje chyby");
            return;
        }

        fetch("?c=postComments&a=addReply", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: "text="+text + "&" + "username="+username + "&" + "post_comments_id="+postCommentId
        })
            .then(response => response.json())
            .then(response => {

                if (response == "error") {
                    alert("Zadane data obsahuju chyby - SERVER");
                }
            });
    }

}

window.onload = function () {
    var reply = new Reply();

    let buttons = document.querySelectorAll("button");
    buttons.forEach(function(item) {
        item.onclick = () => {
            reply.getAllReplies(item.value);
        }
    });



}