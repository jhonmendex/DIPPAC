<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
<div id="fancybox-title" class="fancybox-title-float" style="display: block; z-index: 50">
    <table cellspacing="0" cellpadding="0" id="fancybox-title-float-wrap">
        <tbody>
            <tr>
                <td id="fancybox-title-float-left"></td>
                <td id="fancybox-title-float-main">Discalculia</td>
                <td id="fancybox-title-float-right"></td>
            </tr>
        </tbody>
    </table>
</div>
<div class="container" style="margin-bottom: 20px; margin-top: 15px">

    <head>
        <meta charset="UTF-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <title>Inicio</title>
    </head>

    <body>

        <div id="container">
            <p class="index-introduction-text">Se conoce como discalculia a aquellas limitaciones que impactan en la formación de los principios de cálculo. Su importancia en cuanto al impacto referente a la población infantil es algo más que un aspecto a tener en cuenta, pues se estima que entre el 3% y el 6% de esta población existen infantes con este tipo de dificultad (De-La-Peña, C. & Bernabéu, E, 2018).El proceso de reconocimiento y detección de problemas de aprendizaje es vital para el correcto desarrollo de habilidades matemáticas y del pensamiento racional, viéndose favorecido por los beneficios de la época actual, donde el mundo tecnológico brinda un sin fin de soluciones que en tiempos pasados eran casi imposibles de imaginar. Por eso, mediante este conjunto de pruebas, se buscará brindar una visión general de cómo está el niño frente a este trastorno, y los distintos tipos de discalculia que este puede sufrir.</p>

            <button class="accordion">Discalculia verbal</button>
            <div class="panel">
                <p>Se pretende evaluar la capacidad que tienen los niños para nombrar y comprender conceptos matemáticos de forma verbal. Se presentarán diferentes audios con números y operaciones, esperando que el niño los escuche, entienda, y por último seleccione o escriba la opción correcta.</p>
            </div>

            <button class="accordion">Discalculia practognóstica</button>
            <div class="panel">
                <p>Se busca evaluar las competencias comparación, enumeración de los niños. Se presentarán diferentes elementos en pantalla buscando que el niño las enumere e identifique el grupo con mayor o menor elementos.</p>
            </div>

            <button class="accordion">Discalculia léxica</button>
            <div class="panel">
                <p>Se quiere estimar la habilidad de los niños para comprender la lectura de símbolos, números y expresiones matemáticas. Para ello se mostrará en pantalla diferentes operaciones matemáticas y se espera que el niño reconozca los números y sus signos.</p>
            </div>

            <button class="accordion">Discalculia gráfica</button>
            <div class="panel">
                <p>Se pretende evaluar la capacidad que tienen los niños para escribir los símbolos matemáticos. Se pondrá a disposición un panel, esperando que dentro de este, el niño trate de dibujar el signo matemático que se le demanda.</p>
            </div>

            <button class="accordion">Discalculia ideognóstica</button>
            <div class="panel">
                <p>Se busca evaluar la habilidad de los niños para realizar operaciones de forma mental. Se mostrarán diferentes operaciones matemáticas, esperando que el niño las desarrolle de forma mental, u en otro caso que identifique el signo correspondiente para que el resultado tenga sentido.</p>
            </div>

            <button class="accordion">Discalculia operacional</button>
            <div class="panel">
                <p>Se quiere estimar la habilidad de los niños para solucionar operaciones aritméticas básicas de forma escrita y verbal, para ello se presentarán diferentes operaciones, en algunos casos dictadas por audio, y se espera que el niño las solucione teniendo como ayuda campos de texto que le sirvieran para escribir.</p>
            </div>
            <?php if (isset($perfil)) {
                if ($perfil == 28) {
            ?>
                    <div style="margin-top: 30px; text-align:center">
                        <a style="padding: 10px; text-decoration: none;" id="startTest" class="btn btn-primary btn-start-test" href="index.php?controlador=DyscalculiaIndex&accion=ValidateInitialTest">Empezar prueba</a>
                    </div>
            <?php
                }
            } ?>

            <script>
                var acc = document.getElementsByClassName("accordion");
                var i;
                for (i = 0; i < acc.length; i++) {
                    acc[i].addEventListener("click", function() {
                        this.classList.toggle("active");
                        var panel = this.nextElementSibling;
                        if (panel.style.display === "block") {
                            panel.style.display = "none";
                        } else {
                            panel.style.display = "block";
                        }
                    });
                }
            </script>


        </div>


    </body>