//Here, i used Jquery CR7
$(function selectedAnswer() {
    $('input').keyup(function (event) {
        if (document.getElementById('inputTres') !== null) {
            if (document.getElementById('inputUno').value !== "" &&
                document.getElementById('inputDos').value !== "" &&
                document.getElementById('inputTres').value !== "") {
                document.getElementById('continue').classList.remove("disable-links");
            } else {
                document.getElementById('continue').classList.add("disable-links");
            }
        } else {
            if (document.getElementById('inputUno').value !== "" &&
                document.getElementById('inputDos').value !== "") {
                document.getElementById('continue').classList.remove("disable-links");
            } else {
                document.getElementById('continue').classList.add("disable-links");
            }
        }
    });
});