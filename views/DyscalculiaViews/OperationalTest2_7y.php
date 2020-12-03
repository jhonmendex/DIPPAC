<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Prueba de discalculia operacional 2 - 7 años</title>
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
            <h1>Escucha el siguiente audio.</h1>
        </div>

        <div id="operation">
            <div id="source">
                <audio id="audio" src="audios/OperationalTest2_7y_audio.mp3" preload="none" controls></audio>
            </div>
            <br>
            <div style="margin-bottom: 1%;">
                <h4>Escribe la operación e intenta desarrollarla:</h4>
            </div>
            <br>
            <div id="result">
                <input onkeyup="$(this).next().focus();" maxlength="1" type="text">
                <input onkeyup="$(this).next().focus();" maxlength="1" type="text">
                <input onkeyup="$(this).nextAll('input').first().focus();" maxlength="1" type="text">
                <br>
                <h1 class="relative"><span class="operator span-no-click">+</span></h1>
                <input onkeyup="$(this).next().focus();" maxlength="1" type="text">
                <input onkeyup="$(this).next().focus();" maxlength="1" type="text">
                <input onkeyup="$(this).nextAll('input').first().focus();" maxlength="1" type="text">
                <hr>
                <input onkeyup="$(this).next().focus();" maxlength="1" type="text">
                <input onkeyup="$(this).next().focus();" maxlength="1" type="text">
                <input onkeyup="$(this).next().focus();" maxlength="1" type="text">

            </div>


            <div id="buttons">
                <button id="answer1" class="btn btn-warning answer">510</button>
                <button id="answer2" class="btn btn-success answer">520</button>
                <button id="answer3" class="btn btn-danger answer">530</button>
                <button id="answer4" class="btn btn-secondary answer">540</button>
                <div id="finish">
                    <a id="continue" class="btn btn-primary disable-links" href="index.php?controlador=DyscalculiaIndex&accion=Practognostic17">Continuar</a>
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
        Timer(80);
        document.querySelectorAll('button.answer').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                validateAnswer(e)

            })
        })
        $('#continue').on('click', function() {
            validateAnswer()
        })
    })

    function validateAnswer(e) {
        if (e) {
            isCorrect = e.target.innerText == "510" ? true : false;
            answer = e.target.innerText
        } else {
            isCorrect = isCorrect === null ? false : isCorrect
            answer = answer === null ? 'No responde' : answer
        }
        var answer6 = {
            type: 3,
            isCorrect: isCorrect,
            answer: e.target.innerText,
            image: null,
            testName: "Discalculia operacional"
        };

        // Add new data to localStorage Array
        currentData[5] = answer6;

        localStorage.setItem('dippacAnswers', JSON.stringify(currentData));
    }
</script>

</html>