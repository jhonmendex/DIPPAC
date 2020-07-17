<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Discalculia ideognostica - Prueba 1</title>
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

            <div id="helper">
                <input type="text">
            </div>

            <h1>4 5 0</h1>
            <h1>2 6 0</h1>
            <hr>
            <div id="result">
                <input type="text">
                <input type="text">
                <input type="text">
            </div>

            <br>
            <br>
            <div id="buttons">
                <button id="answer1">710</button>
                <button id="answer2">720</button>
                <button id="answer3">730</button>

            </div>

            <div id="finish">
                <a id="continue" class="btn btn-primary" href="index.php?controlador=DyscalculiaIndex&accion=Ideognostic16">Continuar</a>
            </div>


        </div>
    </div>
</body>

</html>