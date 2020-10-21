<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Prueba de discalculia ideognostica 1 - 9 años</title>
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
            <h1>Realiza la siguiente <br> operación y responde:</h1>

        </div>

        <div id="operation">
            <h1>13 + 15 + 10 + 2</h1>
            <br>
            <div class="input-group-prepend" id="entry">
                <input type="text" class="form-control" id="inputNum">
            </div>
            <div id="buttons">
                <div id="finish">
                    <a id="continue" class="btn btn-primary disable-links" href="index.php?controlador=DyscalculiaIndex&accion=Ideognostic29">Continuar</a>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>
<script>
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
        if (e) {
            answer = e.target.value.replace(/ /g, "");
            isCorrect = answer == "40" ? true : false;
        } else {
            isCorrect = $('#inputNum').val() == 40 ? true : false;
            answer = $('#inputNum').val() === "" ? 'No responde' : false
        }
        var answer1 = {
            type: 1,
            isCorrect: isCorrect,
            answer: answer,
            image: null,
            testName: "Prueba de discalculia ideognostica 1 - 9 años"
        };
        var array = [];

        array.push(answer1);

        localStorage.setItem('dippacAnswers', JSON.stringify(array));
    }
</script>

</html>