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

