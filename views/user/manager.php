<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
<div id="main">
    <div class="maxcontent" id="content">
        <div id="fancybox-title" class="fancybox-title-float" style="display: block; z-index: 50">
            <table cellspacing="0" cellpadding="0" id="fancybox-title-float-wrap">
                <tbody>
                    <tr>
                        <td id="fancybox-title-float-left"></td>
                        <td id="fancybox-title-float-main">Administraci&oacute;n de usuarios</td>
                        <td id="fancybox-title-float-right"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="container" style="margin-bottom: 20px; margin-top: 15px">
            <div style="float: left;width: 40%;">
                <fieldset class="colorleyend" style="width: 100%">
                    <legend class="colorleyendinto">Opciones</legend>
                    <div id="cajaselect" style="margin-bottom: 15px">
                        <a class="various3" title="Crear usuario" href="index.php?controlador=ManageUsers&accion=createUser">
                            + Crear nuevo usuario
                        </a>
                    </div>
                </fieldset>
            </div>
            <div style="clear: left"></div>
            <fieldset class="colorleyend" style="width: 100%;">
                <legend class="colorleyendinto">Lista de usuarios</legend>
                <div style="float: left;">
                    <img class="delete" src="images/edit.png" width="15px" height="15px" />: Editar un usuario
                </div>
                <div style="float: left; margin-left: 30px">
                    <img src="images/user_group.png" width="15px" height="15px" />: Cambiar perfil de un usuario
                </div>
                <div style="float: left; height: 16px; margin-left: 30px">
                    <img src="images/enable.png" />: usuario activo
                </div>
                <div style="float: left; margin-left: 30px; height: 16px">
                    <img class="delete" src="images/disable.png" />: usuario inactivo
                </div>
                <div style="float: left; margin-left: 30px; height: 16px; padding-top: 7px;">
                    (<a style="cursor: default; color: #005500; font-weight: bold;">inactivar</a>) : Inactivar un usuario
                </div>

                <div style="float: left;height: 16px; margin-top: 10px; padding-top: 7px;">
                    (<a style="cursor: default; color: #005500; font-weight: bold;">activar</a>) : Activar un usuario
                </div>
                <div style="clear: both; margin-bottom: 15px"></div>
                <div>
                    <table class="table" border="0" cellspacing="0" cellpadding="3" id="mytable">
                        <thead>
                            <tr class="headall">
                                <th class="headinit" style="cursor: pointer">Nombre de usuario</th>
                                <th class="head">Nombre de usuario</th>
                                <th class="head" style="cursor: pointer">Codigo</th>
                                <th class="head">Cedula</th>
                                <th class="head">Perfil</th>
                                <th class="head">Estado</th>
                                <th class="head" style="cursor: pointer">Fecha de Ingreso</th>
                                <th class="head">Editar</th>
                                <th class="head">Cambiar Perfil</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $estilo = 1;
                            if (sizeof($usuarios) != 0) {
                                foreach ($usuarios as $value) {
                            ?>
                                    <tr class="class<?php echo $estilo; ?>">
                                        <td class="init2" id="nombre<?php echo $value['id']; ?>">
                                            <?php echo $value['nombre']; ?>
                                        </td>
                                        <td class="item2">
                                            <?php echo $value['alias']; ?>
                                        </td>
                                        <td class="item2">
                                            <?php echo $value['id']; ?>
                                        </td>
                                        <td class="item2" id="cedula<?php echo $value['id']; ?>">
                                            <?php echo $value['cedula']; ?>
                                        </td>
                                        <td class="item2" id="perfil<?php echo $value['id']; ?>">
                                            <?php echo $value['perfil']; ?>
                                        </td>
                                        <td class="item2">
                                            <?php if ($value['estado'] == "inactivo") { ?>
                                                <div id="state<?php echo $value['id']; ?>" style="height: 0px">
                                                    <img class="delete" src="images/disable.png" />
                                                </div>
                                                <br>
                                                <div id="otrootro<?php echo $value['id']; ?>" style="height: 4px">
                                                    (<a id="dell2<?php echo sha1($value['id']); ?>" callback="<?php echo $value['nombre']; ?>" tar="index.php?controlador=ManageUsers&accion=enableUser" verify="<?php echo strrev(urlencode(base64_encode($value['id']))); ?>" href="#" onclick="confirmfunction2($(this).attr('id'))" style="cursor: pointer; color: #005500; font-weight: bold;">activar</a>)
                                                </div>
                                            <?php } else { ?>
                                                <div id="state<?php echo $value['id']; ?>" style="height: 0px">
                                                    <img class="delete" src="images/enable.png" />
                                                </div>
                                                <br>
                                                <div id="otrootro<?php echo $value['id']; ?>" style="height: 4px">
                                                    (<a id="dell<?php echo sha1($value['id']); ?>" callback="<?php echo $value['nombre']; ?>" tar="index.php?controlador=ManageUsers&accion=disableUser" verify="<?php echo strrev(urlencode(base64_encode($value['id']))); ?>" href="#" onclick="confirmfunction($(this).attr('id'))" style="cursor: pointer; color: #005500; font-weight: bold;">inactivar</a>)
                                                </div>
                                            <?php } ?>
                                        </td>
                                        <td class="item2"><?php echo $value['fecha']; ?></td>
                                        <td class="item2" style="width: 20px; text-align: center">
                                            <a class="various4" title="Editar usuario" href="index.php?controlador=ManageUsers&accion=editUser&iduser=<?php echo $value['id']; ?>" style="width: 15px; margin-left: auto; margin-right: auto;">
                                                <img src="images/edit.png" width="22px" height="22px" title="Editar inmformacion" />
                                            </a>
                                        </td>
                                        <td class="item2" style="width: 20px; text-align: center">
                                            <?php if ($value['grupo'] != 'No usuario') { ?>
                                                <a class="various2" title="Cambiar perfil" href="index.php?controlador=ManageUsers&accion=editProfile&iduser=<?php echo $value['id']; ?>" style="width: 15px; margin-left: auto; margin-right: auto;">
                                                    <img src="images/user_group.png" width="22px" height="22px" title="Cambiar perfil" />
                                                </a>
                                            <?php } ?>
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
                                <th>Nombre de Usuario</th>
                                <th>Alias</th>
                                <th>Codigo</th>
                                <th>Cedula</th>
                                <th id="perfilfilter">Perfil</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </fieldset>

            <div style="clear: left"></div>
            <fieldset class="colorleyend" style="width: 100%;">
                <legend class="colorleyendinto">Añadir usuarios a Docentes</legend>
                <div style="clear: both; margin-bottom: 15px"></div>
                <table class="table" border="0" cellspacing="0" cellpadding="3" id="mytable">
                    <tbody>
                        <tr>
                            <td colspan="2">
                                <div class="form-group">
                                    <label for="tutor">Tutores</label>
                                    <select name="tutor" class="form-control" id="tutor">
                                        <option value="null" selected>Seleccione</option>
                                        <?php
                                        if (sizeof($tutores) != 0) {
                                            foreach ($tutores as $tutor) {
                                        ?>
                                                <option value="<?php echo $tutor['id']; ?>"><?php echo $tutor['nombre']; ?></option>
                                                <?php print_r($tutor); ?>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <fieldset class="colorleyend">
                                    <legend class="colorleyendinto">Estudiantes Asignados</legend>
                                    <div style="float: left;">
                                        <img class="delete" src="images/edit.png" width="15px" height="15px" />: Editar usuarios asignados
                                    </div>
                                    <div style="clear: both; margin-bottom: 15px"></div>
                                    <div class="no-result1"></div>
                                    <label for="asignados">Seleccione uno o varios alumnos</label>
                                    <select name="asignados" id="asignados" multiple>
                                    </select>
                                    <button class="btn-admin-user" id="remover-est">eliminar estudiantes de tutor</button>
                                </fieldset>
                            </td>
                            <td>
                                <fieldset class="colorleyend">
                                    <legend class="colorleyendinto">Estudiantes por asignar</legend>
                                    <div style="float: left;">
                                        <img class="delete" src="images/edit.png" width="15px" height="15px" />: Añadir usuarios
                                    </div>
                                    <div style="clear: both; margin-bottom: 15px"></div>
                                    <div class="no-result"></div>
                                    <label for="noasignados">Seleccione uno o varios alumnos</label>
                                    <select name="noasignados" id="noasignados" multiple>
                                    </select>
                                    <button class="btn-admin-user" id="asignar-est">Asignar estudiantes a tutor</button>
                                </fieldset>
                            </td>
                        </tr>
                    </tbody>
                </table>
        </div>
        </fieldset>
    </div>
</div>
</div>
<div style="display: none">
    <div id="contentcall">
        <div style="text-align: center; margin-bottom: 12px;margin-top: 40px;padding-left: 20px;padding-right: 20px; font-size: 12px">
            Esta seguro de desactivar el usuario <strong id="nombrecalldel"></strong>?
        </div>
        <div style="text-align: center; margin-bottom: 12px;">
            <button class="buscarButton" id="accept">ACEPTAR</button>
            <button style="margin-left: 10px" class="buscarButton" id="cancel">CANCELAR</button>
        </div>
    </div>
</div>
<div style="display: none">
    <a href="#contentcall" class="callback">Open Example</a>
</div>
<div style="display: none">
    <div id="contentcall2">
        <div style="text-align: center; margin-bottom: 12px;margin-top: 40px;padding-left: 20px;padding-right: 20px; font-size: 12px">
            Esta seguro de activar el usuario <strong id="nombrecalldel2"></strong>?
        </div>
        <div style="text-align: center; margin-bottom: 12px;">
            <button class="buscarButton" id="accept2">ACEPTAR</button>
            <button style="margin-left: 10px" class="buscarButton" id="cancel2">CANCELAR</button>
        </div>
    </div>
</div>
<div style="display: none">
    <a href="#contentcall2" class="callback2">Open Example</a>
</div>
<style>
    .btn-admin-user {
        background-color: #d3d6ff;
        width: 100%;
        font-weight: bold;
    }

    .no-result,
    .no-result1 {
        text-align: center;
        font-weight: bold;
        color: red;
        font-size: 20px;
        margin: 20px;
    }
</style>