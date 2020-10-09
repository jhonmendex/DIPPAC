<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Prueba de discalculia operacional 1 - 7 años</title>
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

        <div id="statement" style="margin-bottom: 3%;">
            <h1>Realiza la siguiente <br> operación y responde:</h1>
        </div>

        <div id="operation">

            <div id="helper">
                <input type="text">
            </div>

            <h1>4 5 0</h1>
            <h1 class="relative"><span class="operator">+</span> 2 6 0</h1>
            <h1 class="relative"><span class="operator">+</span> 1 2 0</h1>
            <hr>
            <div id="result">
                <input type="text">
                <input type="text">
                <input type="text">
            </div>

            <div id="buttons">
                <button id="answer1" class="btn btn-warning answer">830</button>
                <button id="answer2" class="btn btn-success answer">845</button>
                <button id="answer3" class="btn btn-danger answer">820</button>
                <button id="answer4" class="btn btn-secondary answer">850</button>
            </div>

            <div id="finish">
                <a id="continue" class="btn btn-primary disable-links" href="index.php?controlador=DyscalculiaIndex&accion=Operational27">Continuar</a>
            </div>


        </div>
    </div>
</body>
<script>
    $(document).ready(function() {
        document.querySelectorAll('button.answer').forEach(function(btn) {
            btn.addEventListener('click', function(e) {

                // Get the existing data
                var currentData = localStorage.getItem('dippacAnswers');

                currentData = JSON.parse(currentData);

                var isCorrect = e.target.innerText == "830" ? true : false;

                var answer5 = {
                    type: 3,
                    isCorrect: isCorrect,
                    answer: e.target.innerText,
                    image: null,
                    testName: "Prueba de discalculia operacional 1 - 7 años"
                };

                // Add new data to localStorage Array
                currentData[4] = answer5;

                localStorage.setItem('dippacAnswers', JSON.stringify(currentData));
            })
        })
    })
</script>

</html>