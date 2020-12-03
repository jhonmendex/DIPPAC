//Here, i used Jquery CR7
$(function selectedAnswer() {
    $(document).on('click', 'button', function (event) {

        if (event.target.type !== "submit") {
            return;
        }

        let id = this.id;
        let name = this.name;
        if (document.getElementById('answer1') !== null && id == 'answer1') {
            document.getElementById('answer1').style.cssText = 'border-color: black; border-style: solid; border-width: 4px;';
            document.getElementById('answer2').style.cssText = 'opacity: 0.6;';
            document.getElementById('answer3').style.cssText = 'opacity: 0.6;';
            if (document.getElementById('answer4') !== null) {
                document.getElementById('answer4').style.cssText = 'opacity: 0.6;';
            }
            document.getElementById('continue').classList.remove("disable-links");

        }
        if (document.getElementById('answer2') !== null && id == 'answer2') {
            document.getElementById('answer2').style.cssText = 'border-color: black; border-style: solid; border-width: 4px;';
            document.getElementById('answer1').style.cssText = 'opacity: 0.6;';
            document.getElementById('answer3').style.cssText = 'opacity: 0.6;';
            if (document.getElementById('answer4') !== null) {
                document.getElementById('answer4').style.cssText = 'opacity: 0.6;';
            }
            document.getElementById('continue').classList.remove("disable-links");
        }
        if (document.getElementById('answer3') !== null && id == 'answer3') {
            document.getElementById('answer3').style.cssText = 'border-color: black; border-style: solid; border-width: 4px;';
            document.getElementById('answer1').style.cssText = 'opacity: 0.6;';
            document.getElementById('answer2').style.cssText = 'opacity: 0.6;';
            if (document.getElementById('answer4') !== null) {
                document.getElementById('answer4').style.cssText = 'opacity: 0.6;';
            }
            document.getElementById('continue').classList.remove("disable-links");
        }
        if (document.getElementById('answer4') !== null && id == 'answer4') {
            document.getElementById('answer4').style.cssText = 'border-color: black; border-style: solid; border-width: 4px;';
            document.getElementById('answer1').style.cssText = 'opacity: 0.6;';
            document.getElementById('answer2').style.cssText = 'opacity: 0.6;';
            document.getElementById('answer3').style.cssText = 'opacity: 0.6;';
            document.getElementById('continue').classList.remove("disable-links");
        }

        if (document.getElementById('circle1') !== null && id == 'circle1') {
            document.getElementById('circle1').style.cssText = 'border-color: #29950E; border-style: solid; border-width: 4px;';
            document.getElementById('circle2').style.cssText = 'border-color: #FFFFFF; border-style: solid; opacity: 0.6;';
            document.getElementById('continue').classList.remove("disable-links");
        }
        if (document.getElementById('circle2') !== null && id == 'circle2') {
            document.getElementById('circle2').style.cssText = 'border-color: #29950E; border-style: solid; border-width: 4px;';
            document.getElementById('circle1').style.cssText = 'border-color: #FFFFFF; border-style: solid; opacity: 0.6;';
            document.getElementById('continue').classList.remove("disable-links");
        }

        if (name == '=') {
            document.getElementById('equality').innerHTML = "=";
        }
        if (name == '<') {
            document.getElementById('equality').innerHTML = "<";
        }
        if (name == '>')
            document.getElementById('equality').innerHTML = ">";
    });
});