<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Prueba de discalculia ideognóstica 1 - 8 años</title>
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
            <h1>2 x 2 x 4</h1>
            <br>
            <div class="input-group-prepend" id="entry">
                <input type="text" class="form-control" id="inputNum">
            </div>
            <div id="buttons">
                <div id="finish">
                    <a id="continue" class="btn btn-primary disable-links" href="index.php?controlador=DyscalculiaIndex&accion=Ideognostic28">Continuar</a>
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
        Timer(45);
        $(document).on('change', 'input', function(e) {
            validateAnswer(e)
        })

        $('#continue').on('click', function() {
            validateAnswer()
        })
    })

    function validateAnswer(e) {
        if (e) {
            isCorrect = e.target.value.normalize("NFD").replace(/ /g, "").replace(/[\u0300-\u036f]/g, "").toLowerCase() == 16 ? true : false;
            answer = e.target.value.normalize("NFD").replace(/ /g, "").replace(/[\u0300-\u036f]/g, "").toLowerCase();
        } else {
            isCorrect = $('#inputNum').val() == 16 ? true : false;
            answer = $('#inputNum').val() === "" ? 'No responde' : false
        }
        var answer1 = {
            type: 1,
            isCorrect: isCorrect,
            answer: answer,
            image: null,
            testName: "Discalculia ideognóstica"
        };
        var array = [];

        array.push(answer1);

        localStorage.setItem('dippacAnswers', JSON.stringify(array));
    }
</script>

</html>