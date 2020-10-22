<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Prueba de discalculia verbal 1 - 9 años</title>
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

        <div id="statement" style="margin-bottom: 4%;">
            <h1>Escucha el siguiente audio:</h1>
        </div>

        <div id="operation">
            <div id="source">
                <audio id="audio" src="audios/VerbalTest1_9y_audio.mp3" preload="none" controls></audio>
            </div>
            <div style="margin-top: 2%;">
                <h4>Escribe la operación que escuchaste:</h4>
            </div>
            <br>
            <div class="input-group-prepend" id="entry">
                <input type="text" class="form-control" id="inputNum">
            </div>
            <div id="buttons">
                <div id="finish">
                    <a id="continue" class="btn btn-primary disable-links" href="index.php?controlador=DyscalculiaIndex&accion=Verbal29">Continuar</a>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>
<script>
    $(document).ready(function() {
        Timer(40);
        $(document).on('change', 'input', function(e) {
            // Get the existing data
            var currentData = localStorage.getItem('dippacAnswers');

            currentData = JSON.parse(currentData);

            var answer = e.target.value.normalize("NFD").replace(/ /g, "").replace(/[\u0300-\u036f]/g, "").toLowerCase();

            var isCorrect = answer == "37+65" ? true : false;

            var answer9 = {
                type: 5,
                isCorrect: isCorrect,
                answer: answer,
                image: null,
                testName: "Discalculia verbal"
            };

            // Add new data to localStorage Array
            currentData[8] = answer9;

            localStorage.setItem('dippacAnswers', JSON.stringify(currentData));
        })
    })
</script>

</html>