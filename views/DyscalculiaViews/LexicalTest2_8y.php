<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Prueba de discalculia léxica 2 - 8 años</title>
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
            <h1>Escoge los números<br>presentes en la operación:</h1>

        </div>

        <div id="operation">
            <h1>60 + 60</h1>
            <br>
            <div id="buttons">
                <div id="row1">
                    <button id="answer1" class="btn btn-warning answer">Sesenta + sesenta</button>
                    <button id="answer2" class="btn btn-success answer">Sesenta + cuarenta</button>
                </div>

                <div id="row2">
                    <button id="answer3" class="btn btn-danger answer">Sesenta + Setenta</button>
                    <button id="answer4" class="btn btn-secondary answer">Setenta + Setenta</button>
                </div>

                <div id="finish">
                    <a id="continue" class="btn btn-primary disable-links" href="index.php?controlador=DyscalculiaIndex&accion=Operational18">Continuar</a>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>

<script>
    $(document).ready(function() {
        Timer(30);
        document.querySelectorAll('button.answer').forEach(function(btn) {
            btn.addEventListener('click', function(e) {

                // Get the existing data
                var currentData = localStorage.getItem('dippacAnswers');

                currentData = JSON.parse(currentData);

                var isCorrect = e.target.innerText == "Sesenta + sesenta" ? true : false;

                var answer4 = {
                    type: 2,
                    isCorrect: isCorrect,
                    answer: e.target.innerText,
                    image: null,
                    testName: "Discalculia léxica"
                };

                // Add new data to localStorage Array
                currentData[3] = answer4;

                localStorage.setItem('dippacAnswers', JSON.stringify(currentData))
            })
        })
    })
</script>

</html>