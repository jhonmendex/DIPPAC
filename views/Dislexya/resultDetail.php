<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
    <script>        
        getParticipantById('<?php echo $idparticipant; ?>');
    </script>
   <div id="main" class="margindiv">
        <div id="detailUser" style="margin-top: 10px; margin-bottom: 10px;"></div>
        <div class="container">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Descripcion</th>
                        <th scope="col">Rango porcentaje</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Deficiente</td>
                        <td>0 a 29</td>
                    </tr>
                    <tr>
                        <td>Normal bajo</td>
                        <td>30 a 49</td>
                    </tr>
                    <tr>
                        <td>Promedio</td>
                        <td>50 a 69</td>
                    </tr>
                    <tr>
                        <td>Alto</td>
                        <td>70 a 89</td>
                    </tr>
                    <tr>
                        <td>Muy alto</td>
                        <td>90 a 100</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="canvas" class="image container" style="background-color: blue;"></div>
    </div>
    </canvas>