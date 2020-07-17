<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Discalculia ideognostica - Prueba 2 - 6 y 7 años</title>
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
            <h1>Busca el signo correspondiente<br> para realizar la operación</h1>

        </div>

        <div id="operation">
            <h1>52 <label id="sign">_</label> 40 = 12</h1>
            <br>
            <div id="buttons">
                <div id="row1">
                    <button id="answer1" class="btn btn-warning">Suma</button>
                    <button id="answer2" class="btn btn-success ">Resta</button>
                </div>

                <div id="row2">
                    <button id="answer3" class="btn btn-danger">Multiplicación</button>
                    <button id="answer4" class="btn btn-secondary">División</button>
                </div>

                <div id="finish">
                    <a id="continue" class="btn btn-primary" href="index.php?controlador=DyscalculiaIndex&accion=Ideognostic28">Continuar</a>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>

</html>