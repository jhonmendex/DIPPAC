<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Prueba de discalculia practognostica 2 - 9 años</title>
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
            <h1>Establezca la igualdad correcta</h1>
        </div>

        <div id="operation" style="margin-top: 3%;">

            <button id="circle1" disabled>
                <div id="circleElements">
                    <div><img id="element2" src="images/discalculia/elements/pencil.svg" /></div>
                    <div></div>
                    <div><img id="element2" src="images/discalculia/elements/pencil.svg" /></div>
                    <div></div>
                    <div></div>
                    <div><img id="element2" src="images/discalculia/elements/pencil.svg" /></div>
                    <div></div>
                    <div></div>
                    <div><img id="element2" src="images/discalculia/elements/pencil.svg" /></div>
                    <div></div>
                    <div></div>
                    <div><img id="element2" src="images/discalculia/elements/pencil.svg" /></div>
                    <div></div>
                    <div><img id="element2" src="images/discalculia/elements/pencil.svg" /></div>
                </div>
            </button>

            <button id="circle2" disabled>
                <div id="circleElements">
                    <div><img id="element2" src="images/discalculia/elements/eraser.svg" /></div>
                    <div></div>
                    <div><img id="element2" src="images/discalculia/elements/pencil.svg" /></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div><img id="element2" src="images/discalculia/elements/pencil.svg" /></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div><img id="element2" src="images/discalculia/elements/eraser.svg" /></div>
                    <div><img id="element2" src="images/discalculia/elements/pencil.svg" /></div>
                </div>

            </button>

            <div id="operator" style="margin-top: -15%;">
                <h1 id="equality">&nbsp;</h1>
            </div>
        </div>
        <br>
        <div id="buttons">
            <div id="options" style="margin-top: 7%;">
                <button id="answer1" class="btn btn-warning answer" name="<">
                    <h6>
                        <</h6> </button> <button id="answer2" class="btn btn-success answer" name="=">
                            <h6>=</h6>
                </button>

                <button id="answer3" class="btn btn-danger answer" name=">">
                    <h6>></h6>
                </button>
            </div>
            <div id="finish" style="margin-top: -5px;">
                <a id="continue" class="btn btn-primary disable-links" href="index.php?controlador=DyscalculiaIndex&accion=Verbal19">Continuar</a>
            </div>
        </div>
    </div>
    </div>
</body>
<script>
    $(document).ready(function() {
        Timer(40);
        document.querySelectorAll('button.answer').forEach(function(btn) {
            btn.addEventListener('click', function(e) {

                // Get the existing data
                var currentData = localStorage.getItem('dippacAnswers');

                currentData = JSON.parse(currentData);

                var isCorrect = e.target.innerText == ">" ? true : false;

                var answer8 = {
                    type: 4,
                    isCorrect: isCorrect,
                    answer: e.target.innerText,
                    image: null,
                    testName: "Prueba de discalculia practognostica 2 - 9 años"
                };

                // Add new data to localStorage Array
                currentData[7] = answer8;

                localStorage.setItem('dippacAnswers', JSON.stringify(currentData));
            })
        })
    })
</script>

</html>