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
                html += "<div>" + "<input id=\"replyText-" + postCommentId + "\" type=\"text\">" + "</div>";
                html += "<div>" + "<input id=\"replyUsername-" + postCommentId + "\" type=\"text\">" + "</div>";
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

function checkFormState() {
    if (document.querySelectorAll(".error").length == 0) {
        document.getElementById("submit").disabled = false;
        document.getElementById("submit-info").style.display = "none";
    } else {
        document.getElementById("submit").disabled = true;
        document.getElementById("submit-info").style.display = "block";
    }
}

function validateInput(element, validationFunction) {
    element.oninput = function (event) {
        let result = validationFunction(event.target.value);

        let erId = "er-" + element.id;
        let errorEle = document.getElementById(erId);

        if (result != null) {
            if (errorEle == null) {
                errorEle = document.createElement("div")
                errorEle.classList.add("error");
                errorEle.id = erId;
            }
            errorEle.innerText = result;
            element.after(errorEle);
            element.parentElement.classList.add("has-error");
        } else {
            errorEle?.remove()
            element.parentElement.classList.remove("has-error");
        }
        checkFormState();
    }
    element.dispatchEvent(new Event('input'));
}

window.onload = () => {
    //diskusia k clankom
    var reply = new Reply();

    let buttons = document.querySelectorAll("button");
    buttons.forEach(function(item) {
        item.onclick = () => {
            reply.getAllReplies(item.value);
        }
    });

    //validovanie formularov
    validateInput(document.getElementById("title"), function (value = null) {
        if (value == null || value.length == 0) {
            return "Titulok musí byť zadaný";
        }
    });

    validateInput(document.getElementById("text"), function (value = null) {
        if (value == null || value.length == 0) {
            return "Text musí byť zadaný";
        }
    });

    validateInput(document.getElementById("img"), function (value = null) {
        var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

        if (!allowedExtensions.exec(value)) {
            return "Zlý typ súboru, alebo obrázok nieje vybratý";
        }
    });






}

