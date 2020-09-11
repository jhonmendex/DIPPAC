<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Prueba de discalculia ideognostica 1 - 6 años</title>
</head>

<body>
    <div id="background">
        <br>
        <div id="iconTime">
            <img src="images/discalculia/clock.png">
            <div class="item">
                <h5 style="text-align: center;">¡Suerte!</h5>
            </div>
        </div>

        <div id="statement">
            <h1>Realiza la siguiente <br> operación y responde</h1>

        </div>

        <div id="operation">
            <h1>45 + 20</h1>
            <br>
            <div id="buttons">
                <div id="row1">
                    <button id="answer1" class="btn btn-warning answer">65</button>
                    <button id="answer2" class="btn btn-success answer">55</button>
                </div>

                <div id="row2">
                    <button id="answer3" class="btn btn-danger answer">95</button>
                    <button id="answer4" class="btn btn-secondary answer">55</button>
                </div>
                <div id="finish">
                    <a id="continue" class="btn btn-primary disable-links" href="index.php?controlador=DyscalculiaIndex&accion=Ideognostic26">Continuar</a>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>

<script>
$(document).ready(function () {
    document.querySelectorAll('button.answer').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            
            var isCorrect = e.target.innerText == 65 ? true : false;

            var answer1 = {
                isCorrect: isCorrect,
                answer: e.target.innerText,
                type: 1,
                testName: "Prueba de discalculia ideognostica 1 - 6 años"
            };

            var array = [];

            array.push(answer1);

            localStorage.setItem('dippacAnswers', JSON.stringify(array));
        })
    })
})

</script>

</html>