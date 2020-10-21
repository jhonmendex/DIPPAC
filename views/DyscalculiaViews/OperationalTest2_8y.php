<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Prueba de discalculia operacional 2 - 8 años</title>
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

        <div id="statement" style="margin-bottom: 2%;">
            <h1>Escucha el siguiente audio:</h1>
        </div>

        <div id="operation">
            <div id="source">
                <audio id="audio" src="audios/OperationalTest2_8y_audio.mp3" preload="none" controls></audio>
            </div>
            <br>
            <div style="margin-bottom: 1%;">
                <h4>Escribe la operación e intenta desarrollarla</h4>
            </div>
            <br>
            <div id="result">
                <input type="text">
                <input type="text">
                <br>
                <input type="text">
                <input type="text">
                <br>
                <input type="text">
                <input type="text">
                <hr>
                <input id="inputUno" type="text">
                <input id="inputDos" type="text">

            </div>


            <div id="buttons">
                <div id="finish">
                    <a id="continue" class="btn btn-primary disable-links" href="index.php?controlador=DyscalculiaIndex&accion=Practognostic18">Continuar</a>
                </div>
            </div>
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
        $(document).on('change', 'input', function(e) {
            validateAnswer(e)
        })
        $('#continue').on('click', function() {
            validateAnswer()
        })
    })

    function validateAnswer(e) {
        var inputUno = document.getElementById('inputUno').value.replace(/ /g, "").replace(/[\u0300-\u036f]/g, "").toLowerCase();
        var inputDos = document.getElementById('inputDos').value.replace(/ /g, "").replace(/[\u0300-\u036f]/g, "").toLowerCase();

        isCorrect = inputUno == "9" && inputDos == "7" ? true : false;
        answer = inputUno + inputDos

        answer = answer.length === 0 ? 'no responde' : answer
        var answer6 = {
            type: 3,
            isCorrect: isCorrect,
            answer: answer,
            image: null,
            testName: "Prueba de discalculia operacional 2 - 8 años"
        };
        // Add new data to localStorage Array
        currentData[5] = answer6;

        localStorage.setItem('dippacAnswers', JSON.stringify(currentData));
    }
</script>

</html>