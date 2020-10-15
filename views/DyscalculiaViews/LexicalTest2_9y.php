<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Prueba de discalculia léxica 2 - 9 años</title>
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
            <h1>45 ÷ 20</h1>
            <br>
            <div class="input-group-prepend" id="entry" style="margin-top: 0%;">
                <input type="text" class="form-control" id="inputUno">
            </div>

            <div>
                <h1>÷</h1>
            </div>

            <div class="input-group-prepend" id="entry2">
                <input type="text" class="form-control" id="inputDos">
            </div>
            <div id="buttons">
                <div id="finish">
                    <a id="continue" class="btn btn-primary disable-links" href="index.php?controlador=DyscalculiaIndex&accion=Operational19">Continuar</a>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>

<script>
    $(document).ready(function() {
        $(document).on('change', 'input', function(e) {

            // Get the existing data
            var currentData = localStorage.getItem('dippacAnswers');

            currentData = JSON.parse(currentData);

            var inputUno = document.getElementById('inputUno').value.normalize("NFD").replace(/ /g, "").replace(/[\u0300-\u036f]/g, "").toLowerCase();
            var inputDos = document.getElementById('inputDos').value.normalize("NFD").replace(/ /g, "").replace(/[\u0300-\u036f]/g, "").toLowerCase();

            var isCorrect = inputUno == "45" && inputDos == "20" ? true : false;

            var answer4 = {
                type: 2,
                isCorrect: isCorrect,
                answer: inputUno + inputDos,
                image: null,
                testName: "Prueba de discalculia léxica 2 - 9 años"
            };

            // Add new data to localStorage Array
            currentData[3] = answer4;

            localStorage.setItem('dippacAnswers', JSON.stringify(currentData))
        })
    })
</script>

</html>