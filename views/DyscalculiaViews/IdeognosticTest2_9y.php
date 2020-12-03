.
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Prueba de discalculia ideognóstica 2 - 9 años</title>
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
            <h1>Escribe el signo correspondiente <br>para realizar la operación:<br>(Los signos válidos son: + , - , / , X)</h1>

        </div>

        <div id="operation">
            <h1>20<label id="sign">_</label> 5 = 4</h1>
            <br>
            <div class="input-group-prepend" id="entry">
                <input type="text" class="form-control" maxlength="1" id="inputNum">
            </div>
            <div id="buttons">
                <div id="finish">
                    <a id="continue" class="btn btn-primary disable-links" href="index.php?controlador=DyscalculiaIndex&accion=Lexical19">Continuar</a>
                </div>
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
        Timer(70);
        $(document).on('change', 'input', function(e) {
            validateAnswer(e)
        })

        $('#continue').on('click', function() {
            validateAnswer()
        })
    })

    function validateAnswer(e) {
        if (e) {
            let val = e.target.value.normalize("NFD").replace(/ /g, "").replace(/[\u0300-\u036f]/g, "").toLowerCase();
            isCorrect = answer == "/" || answer == "÷" ? true : false;
            answer = val
        } else {
            isCorrect = $('#inputNum').val() == "/" || $('#inputNum').val() == "÷" || $('#inputNum').val() == "*" ? true : false;
            answer = $('#inputNum').val() === "" ? 'No responde' : false
        }
        var answer2 = {
            type: 1,
            isCorrect: isCorrect,
            answer: answer,
            image: null,
            testName: "Discalculia ideognóstica"
        };
        // Add new data to localStorage Array
        currentData[1] = answer2;

        localStorage.setItem('dippacAnswers', JSON.stringify(currentData));
    }
</script>

</html>