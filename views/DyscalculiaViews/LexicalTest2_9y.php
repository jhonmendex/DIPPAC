<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Discalculia Léxica - Prueba 2 - 9 años</title>
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
            <h1>Escribe los números de <br>la siguiente operación</h1>

        </div>

        <div id="operation">
            <h1>45 ÷ 20 </h1>
            <br>
            <div class="input-group-prepend" id="entry" style="margin-top: 0%;">
                <div class="input-group-text" id="iconCheck">☑</div>

                <input type="text" class="form-control" id="inputNum">
            </div>

            <div>
                <h1>÷</h1>
            </div>

            <div class="input-group-prepend" id="entry2">
                <div class="input-group-text" id="iconCheck">☑</div>

                <input type="text" class="form-control" id="inputNum">
            </div>

            <div id="buttons">
                <div id="finish">
                    <a id="continue" class="btn btn-primary" href="index.php?controlador=DyscalculiaIndex&accion=main">Continuar</a>
                </div>

            </div>
        </div>
    </div>
    </div>
</body>

</html>