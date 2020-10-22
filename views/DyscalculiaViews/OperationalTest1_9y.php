<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Prueba de discalculia operacional 1 - 9 años</title>
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
                <input type="text" onkeyup="$(this).next().focus();" maxlength="1">
            </div>

            <h1>4 5 0</h1>
            <h1 class="relative"><span class="operator">+</span> 2 6 0</h1>
            <h1 class="relative"><span class="operator">+</span> 1 2 0</h1>
            <h1 class="relative"><span class="operator">+</span> 1 0 0</h1>
            <hr>
            <div id="result">
                <input id="inputUno" onkeyup="$(this).next().focus();" maxlength="1" type="text">
                <input id="inputDos" onkeyup="$(this).next().focus();" maxlength="1" type="text">
                <input id="inputTres" onkeyup="$(this).next().focus();" maxlength="1" type="text">
            </div>

            <div id="finish">
                <a id="continue" class="btn btn-primary disable-links" href="index.php?controlador=DyscalculiaIndex&accion=Operational29">Continuar</a>
            </div>


        </div>
    </div>
</body>
<script>
    // Get the existing data
    var currentData = localStorage.getItem('dippacAnswers');
    currentData = JSON.parse(currentData);
    var isCorrect = null
    var answer = null
    $(document).ready(function() {
        Timer(90);
        $(document).on('change', 'input', function(e) {
            validateAnswer(e)
        })

        $('#continue').on('click', function() {
            validateAnswer()
        })
    })

    function validateAnswer(e) {
        var inputUno = document.getElementById('inputUno').value.normalize("NFD").replace(/ /g, "").replace(/[\u0300-\u036f]/g, "").toLowerCase();
        var inputDos = document.getElementById('inputDos').value.normalize("NFD").replace(/ /g, "").replace(/[\u0300-\u036f]/g, "").toLowerCase();
        var inputTres = document.getElementById('inputTres').value.normalize("NFD").replace(/ /g, "").replace(/[\u0300-\u036f]/g, "").toLowerCase();
        if (e) {
            answer = inputUno + inputDos + inputTres
            isCorrect = inputUno == "9" && inputDos == "3" && inputTres == "0" ? true : false;
        } else {
            isCorrect = isCorrect === null ? false : isCorrect
            answer = answer === null ? 'No responde' : answer
        }
        var answer5 = {
            type: 3,
            isCorrect: isCorrect,
            answer: inputUno + inputDos + inputTres,
            image: null,
            testName: "Discalculia operacional"
        };

        // Add new data to localStorage Array
        currentData[4] = answer5;

        localStorage.setItem('dippacAnswers', JSON.stringify(currentData));
    }
</script>

</html>