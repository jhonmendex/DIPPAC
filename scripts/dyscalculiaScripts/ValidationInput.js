//Here, i used Jquery CR7
$(function selectedAnswer() {
    $('#inputNum').keyup(function (event) {
        if (event.target.value !== "") {
            document.getElementById('continue').classList.remove("disable-links");
        } else {
            document.getElementById('continue').classList.add("disable-links");
        }
    });
});