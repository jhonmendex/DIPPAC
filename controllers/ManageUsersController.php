<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class ManageUsersController extends ControllerBase
{

    public function main()
    {
        $this->view->setTemplate('user' . DS . 'manager');
        $this->document->addScript("jquery.mousewheel-3.0.4.pack");
        $this->document->addScript("jquery.fancybox-1.3.4.pack");
        $this->document->addScript("jquery.dataTables");
        $this->document->addScript("columnfilter");
        $this->document->addScript("manager");
        $this->document->addCss("jquery.fancybox-1.3.4");
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->addCss("pos");
        $this->document->addCss("demo_page");
        $this->document->addCss("demo_table");
        $this->document->setHeader();
        $this->getModel("ManageUsers");
        $usuarios = $this->model->getUsers();
        $tutores = $this->model->getTutores();
        // $alumnos = $this->model->getAlumnos();
        $asignados = [];
        $sinAsignar = [];
        // foreach ($alumnos as $alumno) {
        //     if (isset($alumno['tutorId'])) {
        //         $asignados[] = $alumno;
        //     } else {
        //         $sinAsignar[] = $alumno;
        //     }
        // }
        $this->view->setVars('usuarios', $usuarios);
        $this->view->setVars('tutores', $tutores);
        // $this->view->setVars('asignados', $asignados);
        // $this->view->setVars('sinAsignar', $sinAsignar);
        $this->view->setVars('alumnos', $alumnos);
        $this->view->show();
    }

    public function createUser()
    {
        $this->view->setTemplate('user' . DS . 'createuser');
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->setHeader();
        $this->getModel("ManageUsers");
        $perfiles = $this->model->getPerfiles();
        $fecha = date("Y-m-d", strtotime(date("Y-m-d") . " -18 year"));
        $fechamax = date("Y-m-d", strtotime($fecha . " -1 day"));
        $arrayfecha = explode("-", $fechamax);
        $dia = $arrayfecha[2];
        $mes = $arrayfecha[1] - 1;
        $ano = $arrayfecha[0];
        $this->view->setVars('dia', $dia);
        $this->view->setVars('mes', $mes);
        $this->view->setVars('ano', $ano);
        $this->view->setVars('perfiles', $perfiles);
        $this->view->show();
    }

    public function insertUser()
    {
        $this->getModel("ManageUsers");
        $this->model->insertUser();
    }

    public function disableUser()
    {
        $this->getModel("ManageUsers");
        $this->model->disableUser();
    }

    public function enableUser()
    {
        $this->getModel("ManageUsers");
        $this->model->enableUser();
    }

    public function editUser()
    {
        $this->view->setTemplate('user' . DS . 'edituser');
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->setHeader();
        $this->getModel("ManageUsers");
        $usuario = $this->model->getUserById($_GET['iduser']);
        $departamentos = $this->model->getDepartamentos();
        $ciudades = $this->model->getCiudades($usuario["iddepartamento"] ? $usuario["iddepartamento"] : $departamentos[0]['id']);
        $localidadvin = $this->model->getLocalidades();
        $barriovin = $this->model->getBarrios($usuario["idlocalidad"] ? $usuario["idlocalidad"] : $localidadvin[0]['id']);
        $fecha = explode("-", $usuario['fechanacimiento']);
        $ano2 = $fecha[0];
        $mes2 = $fecha[1] - 1;
        $dia2 = $fecha[2];
        $fecha = date("Y-m-d", strtotime(date("Y-m-d") . " -18 year"));
        $fechamax = date("Y-m-d", strtotime($fecha . " -1 day"));
        $arrayfecha = explode("-", $fechamax);
        $dia = $arrayfecha[2];
        $mes = $arrayfecha[1] - 1;
        $ano = $arrayfecha[0];
        $this->view->setVars('dia', $dia);
        $this->view->setVars('mes', $mes);
        $this->view->setVars('ano', $ano);
        $this->view->setVars('departamentos', $departamentos);
        $this->view->setVars('ciudades', $ciudades);
        $this->view->setVars('localidades', $localidadvin);
        $this->view->setVars('barrios', $barriovin);
        $this->view->setVars('usuario', $usuario);
        $this->view->setVars('ano2', $ano2);
        $this->view->setVars('mes2', $mes2);
        $this->view->setVars('dia2', $dia2);
        $this->view->show();
    }

    public function editBasicUser()
    {
        $this->getModel("ManageUsers");
        $this->model->editBasicUser();
    }

    public function editPassUser()
    {
        $this->getModel("ManageUsers");
        $this->model->editPassUser();
    }

    public function editAssociatedUser()
    {
        $this->getModel("ManageUsers");
        $this->model->editAssociatedUser();
    }

    public function editProfile()
    {
        $this->view->setTemplate('user' . DS . 'editProfile');
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->setHeader();
        $this->getModel("ManageUsers");
        $usuario = $this->model->getUserById($_GET['iduser']);
        $perfiles = $this->model->getPerfiles2(array('Estudiante', 'Profesional'));
        $this->view->setVars('usuario', $usuario);
        $this->view->setVars('perfiles', $perfiles);
        $this->view->show();
    }

    public function ajaxCiudades()
    {
        $this->getModel("ManageUsers");
        $ciudades = $this->model->getCiudades($_POST['iddepartamento']);
        echo json_encode($ciudades);
    }

    public function ajaxBarrios()
    {
        $this->getModel("ManageUsers");
        $barrios = $this->model->getBarrios($_POST['idlocalidad']);
        echo json_encode($barrios);
    }

    public function ajaxAlumnos()
    {
        $this->getModel("ManageUsers");
        $alumnos = $this->model->getAlumnos($_POST['idTutor']);
        $noasignados = $this->model->getAlumnosNoAsignados();
        $envio = array('alumnos' => $alumnos, 'noasignados' => $noasignados);
        echo json_encode($envio);
    }

    public function asignarAlumnos()
    {
        $this->getModel("ManageUsers");
        $alumnos = $this->model->updateAlumnos($_POST['estudiantes'], intval($_POST['tutorid']), true);
        echo $alumnos;
    }

    public function removerAlumnos()
    {
        $this->getModel("ManageUsers");
        $alumnos = $this->model->updateAlumnos($_POST['estudiantes'], intval($_POST['tutorid']), false);
        echo $alumnos;
    }

    public function updateProfile()
    {
        $this->getModel("ManageUsers");
        $this->model->updateProfile();
    }
}
