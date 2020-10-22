<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Prueba de discalculia ideognóstica 2 - 7 años</title>
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
            <h1>Selecciona el signo correspondiente<br> para realizar la operación:</h1>

        </div>

        <div id="operation">
            <h1>52 <label id="sign">_</label> 40 = 12</h1>
            <br>
            <div id="buttons">
                <div id="row1">
                    <button id="answer1" class="btn btn-warning answer">Suma</button>
                    <button id="answer2" class="btn btn-success answer">Resta</button>
                </div>

                <div id="row2">
                    <button id="answer3" class="btn btn-danger answer">Multiplicación</button>
                    <button id="answer4" class="btn btn-secondary answer">División</button>
                </div>

                <div id="finish">
                    <a id="continue" class="btn btn-primary disable-links" href="index.php?controlador=DyscalculiaIndex&accion=Lexical17">Continuar</a>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>
<script>
    $(document).ready(function() {
        Timer(65);
        document.querySelectorAll('button.answer').forEach(function(btn) {
            btn.addEventListener('click', function(e) {

                // Get the existing data
                var currentData = localStorage.getItem('dippacAnswers');

                currentData = JSON.parse(currentData);

                var isCorrect = e.target.innerText == "Resta" ? true : false;

                var answer2 = {
                    type: 1,
                    isCorrect: isCorrect,
                    answer: e.target.innerText,
                    image: null,
                    testName: "Discalculia ideognóstica"
                };

                // Add new data to localStorage Array
                currentData[1] = answer2;

                localStorage.setItem('dippacAnswers', JSON.stringify(currentData));
            })
        })
    })
</script>

</html>