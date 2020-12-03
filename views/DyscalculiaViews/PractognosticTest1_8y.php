<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Prueba de discalculia practognóstica 1 - 8 años</title>
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
            <h1>¿Cuántos elementos ves de cada tipo?</h1>
        </div>

        <div id="operation">

            <div id="elements">
                <div></div>
                <div></div>
                <div><img id="element1" src="images/discalculia/elements/pencil.svg" /></div>
                <div></div>
                <div></div>
                <div><img id="element1" src="images/discalculia/elements/eraser.svg" /></div>
                <div></div>
                <div><img id="element1" src="images/discalculia/elements/eraser.svg" /></div>
                <div></div>
                <div></div>
                <div></div>
                <div><img id="element1" src="images/discalculia/elements/eraser.svg" /></div>
                <div></div>
                <div><img id="element1" src="images/discalculia/elements/eraser.svg" /></div>
                <div><img id="element1" src="images/discalculia/elements/pencil.svg" /></div>
                <div></div>
                <div><img id="element1" src="images/discalculia/elements/pencil.svg" /></div>
                <div></div>
                <div><img id="element1" src="images/discalculia/elements/eraser.svg" /></div>
                <div></div>
                <div></div>
                <div></div>
                <div><img id="element1" src="images/discalculia/elements/pencil.svg" /></div>
                <div></div>
                <div></div>
                <div><img id="element1" src="images/discalculia/elements/eraser.svg" /></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
            <button id="inputs" disabled>
                <div id="row1"><input id="inputUno" type="number" class="form-control"></div>
                <div id="col1"><img id="element1" src="images/discalculia/elements/pencil.svg" /></div>
                <div id="row2"><input id="inputDos" type="number" class="form-control"></div>
                <div id="col2"><img id="element1" src="images/discalculia/elements/eraser.svg" /></div>
                <br>
            </button>
        </div>

        <div id="buttons">
            <div id="finish" style="margin-top: -5px;">
                <a id="continue" class="btn btn-primary disable-links" href="index.php?controlador=DyscalculiaIndex&accion=Practognostic28">Continuar</a>
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
        Timer(40);
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

        isCorrect = inputUno == 4 && inputDos == 6 ? true : false;
        answer = inputUno + " y " + inputDos,

            answer = answer.length === 0 ? 'no responde' : answer
        var answer7 = {
            type: 3,
            isCorrect: isCorrect,
            answer: answer,
            image: null,
            testName: "Discalculia practognóstica"
        };
        // Add new data to localStorage Array
        currentData[6] = answer7;

        localStorage.setItem('dippacAnswers', JSON.stringify(currentData));
    }
</script>

</html>