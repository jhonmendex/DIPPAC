<?php
$estilo = 1;
if (sizeof($reporte) != 0) {
    foreach ($reporte as $value) {
?>
        <input type="hidden" value=<?php echo $value["deutaronapia"] ?> id="deutaronapia">
        <input type="hidden" value=<?php echo $value["deutoronomalia"] ?> id="deutoronomalia">
        <input type="hidden" value=<?php echo $value["protanomalia"] ?> id="protanomalia">
        <input type="hidden" value=<?php echo $value["protanopia"] ?> id="protanopia">
        <input type="hidden" value=<?php echo $value["tritanomalia"] ?> id="tritanomalia">
        <input type="hidden" value=<?php echo $value["tritanopia"] ?> id="tritanopia">
        <input type="hidden" value=<?php echo $value["normal"] ?> id="normal">


<?php
        if ($estilo == 1) {
            $estilo = 2;
        } else {
            $estilo = 1;
        }
    }
}
?>


<canvas id="myChart" width="100" height="100"></canvas>
<canvas id="doughnut-chart" width="100" height="100"></canvas>