//Here, i used Jquery CR7
$(function selectedAnswer() {
    $(document).on('click', 'button', function (event) {
        
        if (event.target.type !== "submit") {
           return;
        }

        let id = this.id;
        if (id == 'answer1') {
            document.getElementById('answer1').style.cssText = 'border-color: black; border-style: solid; border-width: 4px;';
            document.getElementById('answer2').style.cssText = 'opacity: 0.6;';
            document.getElementById('answer3').style.cssText = 'opacity: 0.6;';
            document.getElementById('answer4').style.cssText = 'opacity: 0.6;';
            document.getElementById('continue').classList.remove("disable-links");

        }
        else if (id == 'answer2') {
            document.getElementById('answer2').style.cssText = 'border-color: black; border-style: solid; border-width: 4px;';
            document.getElementById('answer1').style.cssText = 'opacity: 0.6;';
            document.getElementById('answer3').style.cssText = 'opacity: 0.6;';
            document.getElementById('answer4').style.cssText = 'opacity: 0.6;';
            document.getElementById('continue').classList.remove("disable-links");
        }
        else if (id == 'answer3') {
            document.getElementById('answer3').style.cssText = 'border-color: black; border-style: solid; border-width: 4px;';
            document.getElementById('answer1').style.cssText = 'opacity: 0.6;';
            document.getElementById('answer2').style.cssText = 'opacity: 0.6;';
            document.getElementById('answer4').style.cssText = 'opacity: 0.6;';
            document.getElementById('continue').classList.remove("disable-links");
        }
        else if (id == 'answer4') {
            document.getElementById('answer4').style.cssText = 'border-color: black; border-style: solid; border-width: 4px;';
            document.getElementById('answer1').style.cssText = 'opacity: 0.6;';
            document.getElementById('answer2').style.cssText = 'opacity: 0.6;';
            document.getElementById('answer3').style.cssText = 'opacity: 0.6;';
            document.getElementById('continue').classList.remove("disable-links");
        }
    });
});

// function imagenAleatoria()
// {
//     var elemento=document.body
//     var cantidadImágenes=10
//     var aleatorio=Math.floor(Math.random()*cantidadImágenes)
//     elemento.innerHTML="<img src=\"images/elements/pencil"+aleatorio+".svg\"></img>"
//     setTimeout(imagenAleatoria,1000)
// }

// imagenAleatoria();