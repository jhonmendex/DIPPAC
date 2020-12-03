<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-1.6.2.min.js" integrity="sha256-0W0HoDU0BfzslffvxQomIbx0Jfml6IlQeDlvsNxGDE8=" crossorigin="anonymous"></script>
    <script src="scripts/dyscalculiaScripts/DrawingValidations.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Prueba de discalculia gráfica 2 - 8 años</title>
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
            <h1>Dibuja el signo de menor que:</h1>
        </div>

        <div id="space" style="margin-top: -2%;">
            <canvas id="canvas-display" width="300" height="300"></canvas>
            <br />

            <div id="control-buttons">
                <div style="float:left;">

                    <br>
                </div>
                <div style="float:left;margin-left: 22px;text-align: center;width: 130px;">

                    <input name="brush" id="brush_size" type="range" value="5" min="0" max="20" />
                </div>
            </div>
        </div>
        <br>
        <br>
        <div id="finish">
            <div>
                <button id="clear" class=" btn btn-danger">Borrar</button>
                <button id="save" onclick="saveImage()" class="btn btn-secondary answer">Guardar</button>
            </div>
            <br>
            <a id="continue" class="btn btn-primary disable-links" style="color: white;">Continuar</a>
        </div>
    </div>
    </div>
</body>
<script>
    var imagen = "test";
    $(document).ready(function() {
        Timer(40);
        $('#canvas-display').paintBrush();
        document.querySelectorAll('button.answer').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                // Get the existing data
                var currentData = localStorage.getItem('dippacAnswers');

                currentData = JSON.parse(currentData);

                var answer12 = {
                    type: 0,
                    isCorrect: null,
                    answer: "Dibuja el signo de menor que:",
                    image: imagen,
                    testName: "Discalculia gráfica"
                };

                // Add new data to localStorage Array
                currentData[11] = answer12;

                localStorage.setItem('dippacAnswers', JSON.stringify(currentData));
            })
        })
        $('#continue').click(function(e) {
            sendAnswer(e);
        });
    })

    function saveImage(e) {
        var canvas = document.getElementById("canvas-display");
        imagen = canvas.toDataURL("image/png").toString();
        document.getElementById('continue').classList.remove("disable-links");
    }

    function sendAnswer(e) {
        e.preventDefault()
        $.ajax({
            url: "index.php?controlador=DyscalculiaIndex&accion=saveAnswer", //Leerá la url en la etiqueta action del formulario (archivo.php)
            type: "POST", //Leerá el método en etiqueta method del formulario
            data: {
                data: JSON.parse(localStorage.getItem('dippacAnswers'))
            },
            dataType: "json"
        }).done(function(respuesta) {
            console.log(respuesta);
        }).fail(function(error) {
            console.log(error);
        });

        window.location.href = "index.php?controlador=DyscalculiaIndex&accion=main";
    }
</script>

</html>