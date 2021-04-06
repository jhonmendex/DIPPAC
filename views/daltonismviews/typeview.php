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

<div class="chart-container" style="height:1000px;width:1000px;responsive:true">
<canvas id="myChart" responsive:true></canvas>
</div>
<div class="chart-container" style="height:1000px;width:1000px;responsive:true;margin-top:-400px">
<canvas id="doughnut-chart" responsive:true></canvas>
</div>
