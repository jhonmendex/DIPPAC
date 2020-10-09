<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
<h1>
    Estudiantes
</h1>
<div class="container">
    <div class="accordion" id="accordionExample">
        <?php foreach ($usuarios as $key => $usuario) { ?>
            <div class="card">
                <div class="card-header" id="card<?php echo $key ?>">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse<?php echo $key ?>" aria-expanded="true" aria-controls="collapseOne">
                            <?php echo $usuario[0]['nombre'] ?>
                        </button>
                    </h2>
                </div>

                <div id="collapse<?php echo $key ?>" class="collapse show" aria-labelledby="card<?php echo $key ?>" data-parent="#accordionExample">
                    <div class="card-body">
                        <ul>
                            <?php $i = 1;
                            foreach ($usuario as $cuestionario) { ?>
                                <?php echo ('<li> <a href="index.php?controlador=DyscalculiaIndex&accion=detailTest&testid=' . $cuestionario['idCuestionario'] . '&userId=' . $key . '"> Cuestionario ' . $i . ' (' . date("d-m-Y g:i:s a", strtotime($cuestionario['fecha'])) . ')</a></li>'); ?>
                            <?php $i++;
                            }
                            ?>
                        </ul>

                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>