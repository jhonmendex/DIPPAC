<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Prueba de discalculia operacional 2 - 6 años</title>
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
            <h1>Escucha el siguiente audio.</h1>
        </div>

        <div id="operation">
            <div id="source">
                <audio id="audio" src="audios/audio.mpeg" preload="none" controls></audio>
            </div>
            <br>
            <div style="margin-bottom: 1%;">
                <h4>Escribe la operación e intenta desarrollarla</h4>
            </div>
            <br>
            <div id="result">
                <input type="text">
                <input type="text">
                <input type="text">
                <br>
                <input type="text">
                <input type="text">
                <input type="text">
                <hr>
                <input type="text">
                <input type="text">
                <input type="text">

            </div>


            <div id="buttons">
                <button id="answer1" class="btn btn-warning answer">710</button>
                <button id="answer2" class="btn btn-success answer">720</button>
                <button id="answer3" class="btn btn-danger answer">730</button>
                <button id="answer4" class="btn btn-secondary answer">740</button>
                <div id="finish">
                    <a id="continue" class="btn btn-primary disable-links" href="index.php?controlador=DyscalculiaIndex&accion=Practognostic16">Continuar</a>
                </div>
            </div>
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

                var isCorrect = e.target.innerText == "710" ? true : false;

                var answer6 = {
                    isCorrect: isCorrect,
                    answer: e.target.innerText,
                    type: 3,
                    testName: "Prueba de discalculia operacional 2 - 6 años"
                };

                // Add new data to localStorage Array
                currentData[5] = answer6;

                localStorage.setItem('dippacAnswers', JSON.stringify(currentData));
            })
        })
    })
</script>

</html>