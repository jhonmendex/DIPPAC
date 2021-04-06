<div id="main">
    <div style="margin-left:-25px;margin-top:50px">
                <div style="clear: left"></div>
                <div>
                    <table class="table " border="0" cellspacing="0" cellpadding="3" id="mytable">
                        <thead>
                            <tr class="headall">
                                <th class="headinit" style="cursor: pointer">Nombre</th>
                                <th class="head" style="cursor: pointer">Edad</th>
                                <th class="head">Fecha presentacion</th>
                                <th class="head">Normales</th>
                                <th class="head">Deutaronapia</th>
                                <th class="head" style="cursor: pointer">Deutoronomalia</th>
                                <th class="head">Protanomalia</th>
                                <th class="head">Protanopia</th>
                                <th class="head">Tritanomalia</th>
                                <th class="head">Tritanopia</th>
                                <th class="head">Resultado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $estilo = 1;
                            if (sizeof($reporte) != 0) {
                                foreach ($reporte as $value) {
                            ?>
                                    <tr class="class<?php echo $estilo; ?>">
                                        <td class="init2" id="nombre">
                                            <?php echo $value['nombre']; ?>
                                        </td>
                                        <td " style="width: 20px; text-align: center">
                                            <?php echo $value['edad']; ?>
                                        </td>
                                        <td class="item2" style="width: 20px; text-align: center">
                                            <?php echo $value['fechapresentacion']; ?>
                                        </td>
                                        <td class="item2" style="width: 20px; text-align: center">
                                            <?php echo $value['normales']; ?>
                                        </td>
                                        <td class="item2" style="width: 20px; text-align: center">
                                            <?php echo $value['deutaronapia']; ?>
                                        </td>
                                        <td class="item2" style="width: 20px; text-align: center">
                                            <?php echo $value['deutoronomalia']; ?>
                                        </td>
                                        <td class="item2" style="width: 20px; text-align: center">
                                            <?php echo $value['protanomalia']; ?></td>
                                        <td class="item2" style="width: 20px; text-align: center">
                                            <?php echo $value['protanopia']; ?>
                                        </td>
                                        <td class="item2" style="width: 20px; text-align: center">
                                            <?php echo $value['tritanomalia']; ?>
                                        </td>
                                        <td class="item2" style="width: 20px; text-align: center">
                                            <?php echo $value['tritanopia']; ?>
                                        </td>
                                        <td class="item2" style="width: 20px; text-align: center">
                                            <?php echo $value['conclusion']; ?>
                                        </td>

                                    </tr>
                            <?php
                                    if ($estilo == 1) {
                                        $estilo = 2;
                                    } else {
                                        $estilo = 1;
                                    }
                                }
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Nombre</th>
                                <th>Edad</th>
                                <th>Fecha presentacion</th>
                                <th>Normales</th>
                                <th>Deutaronapia</th>
                                <th>Deutoronomalia</th>
                                <th>Protanomalia</th>
                                <th>Protanopia</th>
                                <th>Tritanomalia</th>
                                <th>Tritanopia</th>
                                <th>Resultado</th>
                            </tr>
                     
	                         <td><input type="button" id="cargar_primera_pagina" value="<< Primero"/></td>
                            <td><input type="button" id="cargar_anterior_pagina" value="< Anterior"/></td>
                            <td id="indicador_paginas"></td>
                            <td><input type="button" id="cargar_siguiente_pagina" value="Siguiente >"/></td>
                            <td><input type="button" id="cargar_ultima_pagina" value="Ultimo >>"/></td>

                            
                        </tfoot>
                    </table>
                </div>
                </fieldset>
    

    </div>