<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Prueba de discalculia léxica 1 - 9 años</title>
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
            <h1>Escoge el signo matemático de<br>la siguiente operación:</h1>

        </div>

        <div id="operation">
            <h1>45 ÷ 20</h1>
            <br>
            <div class="input-group-prepend" id="entry">
                <input type="text" class="form-control" id="inputNum">
            </div>
            <div id="buttons">
                <div id="finish">
                    <a id="continue" class="btn btn-primary disable-links" href="index.php?controlador=DyscalculiaIndex&accion=Lexical29">Continuar</a>
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

            var isCorrect = e.target.value == "División" || e.target.value == "división" || e.target.value == "division" ? true : false;

            var answer3 = {
                type: 2,
                isCorrect: isCorrect,
                answer: e.target.value,
                image: null,
                testName: "Discalculia Léxica - Prueba 1 - 9 años"
            };

            // Add new data to localStorage Array
            currentData[2] = answer3;

            localStorage.setItem('dippacAnswers', JSON.stringify(currentData));
        })
    })
</script>

</html>