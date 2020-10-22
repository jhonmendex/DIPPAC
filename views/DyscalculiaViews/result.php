<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <h1>
                Informe
            </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-3">
            <!-- informacion estudiante -->
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col" style="text-align: center;">Estudiante</th>
                        <th scope="col" style="text-align: center;">Edad</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th><?php echo $user['nombre'] ?></th>
                        <td style="text-align: center;"><?php echo $cuestionarios[0]['edad'] ?></td>
                    </tr>
                </tbody>
            </table>
            <!-- discalculias evaluadas -->
            <table class="table mt-5 table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col" style="text-align: center;">Discalculias evaluadas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $res = array_reduce($cuestionarios, function (array $accumulator, array $element) {
                        $accumulator[$element['tipo']][] = $element;
                        return $accumulator;
                    }, []);

                    foreach ($res as $cuestionario) {
                    ?>
                        <?php echo '<tr><th>' . $cuestionario[0]['nombreprueba'] . '</th></tr>'; ?>
                    <?php
                    } ?>
                </tbody>
            </table>
        </div>
        <div class="col-6">
            <!-- Explicación -->
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col" style="text-align: center;">Calificación</th>
                        <th scope="col" style="text-align: center;">Explicación</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th style="text-align: center;">0.0</th>
                        <td>Ninguna respuesta fue correcta</td>
                    </tr>
                    <tr>
                        <th style="text-align: center;">0.5</th>
                        <td>La mitad de respuestas fueron correctas</td>
                    </tr>
                    <tr>
                        <th style="text-align: center;">1.0</th>
                        <td>Todas las respuestas fueron correctas</td>
                    </tr>
                    <tr>
                        <th style="text-align: center;">General</th>
                        <td>Es el resultado de dividir la cantidad de respuestas correctas sobre la totalidad de respuestas registradas</td>
                    </tr>
                </tbody>
            </table>
            <canvas id="spider" />
        </div>
        <div class="col-3">
            <!-- Calificación estudiante -->
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col" style="text-align: center;">Calificación general</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th style="text-align: center;"><?php echo number_format($cuestionarios[0]['calificacion'], 2, '.', '.'); ?></th>
                    </tr>
                </tbody>
            </table>
            <!-- conclusiones -->
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col" style="text-align: center;">Conclusiones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $conclusiones = explode(";", $cuestionarios[0]['conclusion']);
                    foreach ($conclusiones as $conclusion) {
                    ?>
                        <?php echo '<tr><th>' . $conclusion . '</th></tr>'; ?>
                    <?php
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div>
    <?php $m = 0;
    foreach ($cuestionarios as $cuestionario) {
        if ($cuestionario['correcta'] == "null" || $cuestionario['correcta'] == null) {
            echo 'null';
    ?>
            <!-- Modal -->
            <div class="modal fade" id="respuesta<?php echo $cuestionario['idrespuesta'] ?>" position="<?php echo $m ?>" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle"><?php echo $cuestionario['nombreprueba'] ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <h1><?php if (isset($cuestionario['respuesta'])) {
                                    echo $cuestionario['respuesta'];
                                } ?></h1>
                            <br>
                            <?php if (isset($cuestionario['imagen'])) { ?>
                                <img src="<?php echo $cuestionario['imagen'] ?>" />
                            <?php } ?>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="button" class="btn btn-success check-answer" answer="<?php echo $cuestionario['idrespuesta'] ?>" value="true">Aprobar</button>
                            <button type="button" class="btn btn-danger check-answer" answer="<?php echo $cuestionario['idrespuesta'] ?>" value="false">Rechazar</button>
                        </div>
                    </div>
                </div>
            </div>
    <?php
            $m++;
        } else {
            //print_r($cuestionario['respuesta']);
        }
        echo '</br>';
    }
    ?>
</div>

<script>
    var respuestasNull = []
    $(document).ready(function() {
        <?php $i = 1;
        foreach ($cuestionarios as $cuestionario) {
            if ($cuestionario['correcta'] == "null" || $cuestionario['correcta'] == null) {
                echo 'respuestasNull.push({ modal: ' . $cuestionario["idrespuesta"] . ', show: false});';
        ?>
                $('#respuesta<?php echo $cuestionario["idrespuesta"] ?>').on('hidden.bs.modal', function(e) {
                    respuestasNull[e.target.getAttribute('position')].show = true
                    openNextModal()
                })
        <?php
            }
        }
        ?>
        if (respuestasNull.length > 0) {
            $('#respuesta' + respuestasNull[0].modal).modal('show')
        }

        var ctx = document.getElementById("spider");
        var data = {
            labels: [<?php foreach ($calificaciones as $calificacion) {
                            echo "'" . $calificacion[0] . "', ";
                        } ?>],
            datasets: [{
                label: "<?php echo $user['nombre'] ?>",
                backgroundColor: "rgba(200,0,0,0.2)",
                data: [<?php foreach ($calificaciones as $calificacion) {
                            echo "'" . $calificacion[1] . "', ";
                        } ?>],
            }, ],
        };
        var myRadarChart = new Chart(ctx, {
            type: "radar",
            data: data,
            options: {
                responsive: true,
                scale: {
                    ticks: {
                        beginAtZero: true,
                        min: 0,
                        max: 1,
                        stepSize: 0.1
                    },
                    pointLabels: {
                        fontSize: 15
                    }
                },
                tooltips: {
                    enabled: true,
                    mode: 'nearest',
                    callbacks: {
                        title: function(tooltipItem, data) {
                            return data.labels[tooltipItem[0].index];
                        },
                        label: function(tooltipItems, data) {
                            return "Total: " + tooltipItems.yLabel;
                        },
                    }
                }
            },
        });

        $('.check-answer').on('click', function(e) {
            let approve = null
            let idAnswer = $(this).attr('answer')
            if ($(this).val() === 'true') {
                approve = true
            } else {
                approve = false
            }
            let data = {
                'approve': approve,
                'idAnswer': idAnswer
            }
            e.preventDefault()
            $.ajax({
                url: "index.php?controlador=DyscalculiaIndex&accion=approveAnswer", //Leerá la url en la etiqueta action del formulario (archivo.php)
                type: "POST", //Leerá el método en etiqueta method del formulario
                data: data,
                dataType: "json"
            }).done(function(respuesta) {
                console.log(respuesta);
                if (respuesta == 1) {
                    $('#respuesta' + idAnswer).modal('hide')
                }
            }).fail(function(error) {
                console.log(error);
            });
        })
    });

    function openNextModal() {
        next = respuestasNull.find(function(r) {
            return r.show == false
        }, false)
        console.log(next)
        if (next) {
            $('#respuesta' + next.modal).modal('show')
        } else {
            $.ajax({
                url: "index.php?controlador=DyscalculiaIndex&accion=rateTest&testid=" + <?php echo $cuestionarios[0]['idCuestionario'] ?>, //Leerá la url en la etiqueta action del formulario (archivo.php)
                type: "GET", //Leerá el método en etiqueta method del formulario
                data: null,
                dataType: "json"
            }).done(function(respuesta) {
                location.reload();
            }).fail(function(error) {
                console.log(error);
            });
        }
    }
</script>