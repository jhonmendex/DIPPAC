<?php
$estilo = 1;
if (sizeof($reporte) != 0) {
    foreach ($reporte as $value) {
?>
        <input type="hidden" value=<?php echo $value["deutaronapia6"] ?> id="deutaronapia6">
        <input type="hidden" value=<?php echo $value["deutoronomalia6"] ?> id="deutoronomalia6">
        <input type="hidden" value=<?php echo $value["protanomalia6"] ?> id="protanomalia6">
        <input type="hidden" value=<?php echo $value["protanopia6"] ?> id="protanopia6">
        <input type="hidden" value=<?php echo $value["tritanomalia6"] ?> id="tritanomalia6">
        <input type="hidden" value=<?php echo $value["tritanopia6"] ?> id="tritanopia6">
        <input type="hidden" value=<?php echo $value["normal6"] ?> id="normal6">
        <input type="hidden" value=<?php echo $value["deutaronapia7"] ?> id="deutaronapia7">
        <input type="hidden" value=<?php echo $value["deutoronomalia7"] ?> id="deutoronomalia7">
        <input type="hidden" value=<?php echo $value["protanomalia7"] ?> id="protanomalia7">
        <input type="hidden" value=<?php echo $value["protanopia7"] ?> id="protanopia7">
        <input type="hidden" value=<?php echo $value["tritanomalia7"] ?> id="tritanomalia7">
        <input type="hidden" value=<?php echo $value["tritanopia7"] ?> id="tritanopia7">
        <input type="hidden" value=<?php echo $value["normal7"] ?> id="normal7">
        <input type="hidden" value=<?php echo $value["deutaronapia8"] ?> id="deutaronapia8">
        <input type="hidden" value=<?php echo $value["deutoronomalia8"] ?> id="deutoronomalia8">
        <input type="hidden" value=<?php echo $value["protanomalia8"] ?> id="protanomalia8">
        <input type="hidden" value=<?php echo $value["protanopia8"] ?> id="protanopia8">
        <input type="hidden" value=<?php echo $value["tritanomalia8"] ?> id="tritanomalia8">
        <input type="hidden" value=<?php echo $value["tritanopia8"] ?> id="tritanopia8">
        <input type="hidden" value=<?php echo $value["normal8"] ?> id="normal8">
        <input type="hidden" value=<?php echo $value["deutaronapia9"] ?> id="deutaronapia9">
        <input type="hidden" value=<?php echo $value["deutoronomalia9"] ?> id="deutoronomalia9">
        <input type="hidden" value=<?php echo $value["protanomalia9"] ?> id="protanomalia9">
        <input type="hidden" value=<?php echo $value["protanopia9"] ?> id="protanopia9">
        <input type="hidden" value=<?php echo $value["tritanomalia9"] ?> id="tritanomalia9">
        <input type="hidden" value=<?php echo $value["tritanopia9"] ?> id="tritanopia9">
        <input type="hidden" value=<?php echo $value["normal6"] ?> id="normal6">


<?php
        if ($estilo == 1) {
            $estilo = 2;
        } else {
            $estilo = 1;
        }
    }
}
?>
<canvas id="bar-chart-grouped" width="800" height="450"></canvas>