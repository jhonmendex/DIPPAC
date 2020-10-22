<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Prueba de discalculia practognóstica 1 - 7 años</title>
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
            <h1>¿Cuántos lápices ves?</h1>
        </div>

        <div id="operation">

            <div id="elements">
                <div><img id="element1" src="images/discalculia/elements/eraser.svg" /></div>
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
                <div><img id="element1" src="images/discalculia/elements/pencil.svg" /></div>
                <div></div>
                <div><img id="element1" src="images/discalculia/elements/pencil.svg" /></div>
                <div></div>
                <div></div>
                <div><img id="element1" src="images/discalculia/elements/eraser.svg" /></div>
                <div></div>
                <div></div>
                <div></div>
                <div><img id="element1" src="images/discalculia/elements/eraser.svg" /></div>
                <div></div>
                <div><img id="element1" src="images/discalculia/elements/eraser.svg" /></div>
                <div></div>
                <div><img id="element1" src="images/discalculia/elements/eraser.svg" /></div>
                <div><img id="element1" src="images/discalculia/elements/pencil.svg" /></div>
                <div></div>
                <div><img id="element1" src="images/discalculia/elements/eraser.svg" /></div>
                <div><img id="element1" src="images/discalculia/elements/pencil.svg" /></div>
                <div><img id="element1" src="images/discalculia/elements/pencil.svg" /></div>
                <div></div>
            </div>
        </div>

        <div id="buttons">
            <div id="options">
                <button id="answer1" class="btn btn-warning answer">
                    <div id="information">
                        <div></div>
                        <div></div>
                        <div>
                            <h6>5</h6>
                        </div>
                        <div>
                            <img id="quantity1" src="images/discalculia/elements/pencil.svg" />
                        </div>
                        <div></div>
                        <div></div>
                        <div>
                        </div>
                        <div>
                        </div>
                        <div></div>
                        <div></div>
                    </div>

                </button>


                <button id="answer2" class="btn btn-success answer">
                    <div id="information">
                        <div></div>
                        <div></div>
                        <div>
                            <h6>8</h6>
                        </div>
                        <div>
                            <img id="quantity1" src="images/discalculia/elements/pencil.svg" />
                        </div>
                        <div></div>
                        <div></div>
                    </div>

                </button>

                <button id="answer3" class="btn btn-danger answer">
                    <div id="information">
                        <div> </div>
                        <div> </div>
                        <div>
                            <h6>6</h6>
                        </div>
                        <div>
                            <img id="quantity1" src="images/discalculia/elements/pencil.svg" />
                        </div>
                        <div> </div>
                        <div> </div>
                    </div>
                </button>

                <button id="answer4" class="btn btn-secondary answer">
                    <div id="information">
                        <div> </div>
                        <div></div>
                        <div>
                            <h6>7</h6>
                        </div>
                        <div>
                            <img id="quantity1" src="images/discalculia/elements/pencil.svg" />
                        </div>
                        <div> </div>
                        <div> </div>
                    </div>
                </button>
            </div>

            <div id="finish" style="margin-top: -5px;">
                <a id="continue" class="btn btn-primary disable-links" href="index.php?controlador=DyscalculiaIndex&accion=Practognostic27">Continuar</a>
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
        Timer(30);
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
            isCorrect = e.target.innerText.includes("8") ? true : false;
            answer = e.target.innerText
        } else {
            isCorrect = isCorrect === null ? false : isCorrect
            answer = answer === null ? 'No responde' : answer
        }
        var answer7 = {
            type: 4,
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