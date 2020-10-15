<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class DyscalculiaIndexController extends ControllerBase
{

    public function main()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'dyscalculiaIndex');
        $this->document->addScript("test");
        $this->document->addScript("font-awesome");
        $this->document->addCss('indexStyle');
        $this->document->addCss('orden');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addCss('dyscaulculiaCss' . DS . 'operationalTestsStyle');
        $this->document->addCss('dyscaulculiaCss' . DS . 'PractognosticTestsStyle');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Validations');
        $this->document->addScript("jquery.mousewheel-3.0.4.pack");
        $this->document->addScript("jquery.fancybox-1.3.4.pack");
        $this->document->addScript("jquery.dataTables");
        $this->document->addCss("jquery.fancybox-1.3.4");
        $this->document->setHeader();
        $this->getModel("Cuestionario");
        $cuestionarios = $this->model->getCuestionarios();
        $this->view->setVars('cuestionarios', $cuestionarios);
        $this->view->show();
    }

    public function saveAnswer()
    {
        $this->getModel("User");

        $idUser = $this->model->getUserId();

        $user = $this->model->getUserById($idUser);
        if ($user != false) {

            $birthDate = $user['fechacumple'];

            $birthDateYear = date("Y", strtotime($birthDate));

            $today = getdate();

            $todayYear = $today['year'];

            $finalDate = $todayYear - $birthDateYear;

            if (isset($_POST['data'])) {
                $datos = $_POST['data'];
                $this->getModel("Cuestionario");
                $res = $this->model->addAnswers($datos, $idUser, $finalDate);
                echo json_encode($res);
            } else {
                echo json_encode("Error: No es un método POST");
            }
        }
    }

    public function approveAnswer()
    {
        if (isset($_POST['approve']) && isset($_POST['idAnswer'])) {
            $this->getModel("TestDiscalculia");
            $update = $this->model->updateAnswerGraphic($_POST['idAnswer'], $_POST['approve']);
            echo $update;
        } else {
            echo 'error no se ha enviado id de pregunta o respuesta a validar';
        }
    }

    public function testResult()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'students');
        $this->document->addCss("assets/bootstrap/bootstrap.min");
        $this->document->addScript("bootstrap/jquery");
        $this->document->addScript("bootstrap/popper.min");
        $this->document->addScript("bootstrap/bootstrap.min");
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $usuarios = $this->model->getUsersByTutor();
        $this->view->setVars('usuarios', $usuarios);
        $this->view->show();
    }

    public function detailTest()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'result');
        $this->document->addScript("Chart.min");
        // $this->document->addScript("dyscalculiaScripts/radar");
        $this->document->addCss("Chart.min");
        $this->document->addCss("assets/bootstrap/bootstrap.min");
        $this->document->addScript("bootstrap/jquery");
        $this->document->addScript("bootstrap/popper.min");
        $this->document->addScript("bootstrap/bootstrap.min");
        $this->document->setHeader();

        if (isset($_GET['testid'])) {
            $id = $_GET['testid'];
            $this->getModel("TestDiscalculia");
            $cuestionarios = $this->model->getDetailTest($id);
            $this->view->setVars('cuestionarios', $cuestionarios);
            // agrupas respuestas
            $res = array_reduce($cuestionarios, function (array $accumulator, array $element) {
                $accumulator[$element['tipo']][] = $element;
                return $accumulator;
            }, []);
            // print_r($res);
            $c = 0;
            foreach ($res as $tipo) {
                $prom = 0;
                foreach ($tipo as $r) {
                    if ($r['correcta'] === 't') {
                        $prom++;
                    }
                }
                //echo count($tipo);
                $calificaciones[$c][0] = $tipo[0]['nombreprueba'];
                $calificaciones[$c][1] = $prom / count($tipo);
                $c++;
                //echo ($prom / count($tipo));
                //echo '<br>';
            }
            $this->view->setVars('calificaciones', $calificaciones);
        }
        if (isset($_GET['userId'])) {
            $this->getModel("User");
            $idUser = intval($_GET['userId']);
            $user = $this->model->getUserById($idUser);
            $this->view->setVars('user', $user);
        }
        $this->view->show();
    }

    public function ValidateInitialTest()
    {
        $this->getModel("User");
        $idUser = $this->model->getUserId();
        $user = $this->model->getUserById($idUser);
        if ($user != false) {

            $birthDate = $user['fechacumple'];

            $birthDateYear = date("Y", strtotime($birthDate));

            $today = getdate();

            $todayYear = $today['year'];

            $finalDate = $todayYear - $birthDateYear;

            if ($finalDate > 9 || $finalDate < 6) {
                echo "La edad del usuario no es válida";
                return;
            }

            if ($finalDate == 6) {
                $this->Ideognostic16();
            } elseif ($finalDate == 7) {
                $this->Ideognostic17();
            } elseif ($finalDate == 8) {
                $this->Ideognostic18();
            } elseif ($finalDate == 9) {
                $this->Ideognostic19();
            }
        }
    }

    //Seis años

    public function Ideognostic16()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'IdeognosticTest1_6y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Validations');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Ideognostic26()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'IdeognosticTest2_6y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Validations');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Lexical16()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'LexicalTest1_6y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Validations');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Lexical26()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'LexicalTest2_6y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Validations');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Operational16()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'OperationalTest1_6y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addCss('dyscaulculiaCss' . DS . 'operationalTestsStyle');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Validations');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Operational26()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'OperationalTest2_6y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addCss('dyscaulculiaCss' . DS . 'operationalTestsStyle');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Validations');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Practognostic16()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'PractognosticTest1_6y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addCss('dyscaulculiaCss' . DS . 'PractognosticTestsStyle');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Validations');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Practognostic26()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'PractognosticTest2_6y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addCss('dyscaulculiaCss' . DS . 'PractognosticTestsStyle');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Validations');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Verbal16()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'VerbalTest1_6y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Validations');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Verbal26()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'VerbalTest2_6y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Validations');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Graphic16()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'GraphicTest1_6y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Graphic26()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'GraphicTest2_6y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    //Siete años

    public function Ideognostic17()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'IdeognosticTest1_7y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Validations');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Ideognostic27()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'IdeognosticTest2_7y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Validations');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Lexical17()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'LexicalTest1_7y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Validations');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Lexical27()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'LexicalTest2_7y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Validations');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Operational17()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'OperationalTest1_7y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addCss('dyscaulculiaCss' . DS . 'operationalTestsStyle');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Validations');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Operational27()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'OperationalTest2_7y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addCss('dyscaulculiaCss' . DS . 'operationalTestsStyle');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Validations');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Practognostic17()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'PractognosticTest1_7y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addCss('dyscaulculiaCss' . DS . 'PractognosticTestsStyle');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Validations');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Practognostic27()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'PractognosticTest2_7y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addCss('dyscaulculiaCss' . DS . 'PractognosticTestsStyle');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Validations');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Verbal17()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'VerbalTest1_7y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Validations');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Verbal27()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'VerbalTest2_7y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Validations');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Graphic17()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'GraphicTest1_7y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Graphic27()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'GraphicTest2_7y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    //Ocho años

    public function Ideognostic18()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'IdeognosticTest1_8y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->addScript('dyscalculiaScripts' . DS . 'ValidationInput');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Ideognostic28()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'IdeognosticTest2_8y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->addScript('dyscalculiaScripts' . DS . 'ValidationInput');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Lexical18()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'LexicalTest1_8y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Validations');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Lexical28()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'LexicalTest2_8y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Validations');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Operational18()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'OperationalTest1_8y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addCss('dyscaulculiaCss' . DS . 'operationalTestsStyle');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->addScript('dyscalculiaScripts' . DS . 'ValidationMultipleInputs');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Operational28()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'OperationalTest2_8y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addCss('dyscaulculiaCss' . DS . 'operationalTestsStyle');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->addScript('dyscalculiaScripts' . DS . 'ValidationMultipleInputs');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Practognostic18()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'PractognosticTest1_8y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addCss('dyscaulculiaCss' . DS . 'PractognosticTestsStyle');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->addScript('dyscalculiaScripts' . DS . 'ValidationMultipleInputs');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Practognostic28()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'PractognosticTest2_8y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addCss('dyscaulculiaCss' . DS . 'PractognosticTestsStyle');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Validations');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Verbal18()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'VerbalTest1_8y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->addScript('dyscalculiaScripts' . DS . 'ValidationInput');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Verbal28()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'VerbalTest2_8y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->addScript('dyscalculiaScripts' . DS . 'ValidationInput');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Graphic18()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'GraphicTest1_8y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Graphic28()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'GraphicTest2_8y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    //Nueve años

    public function Ideognostic19()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'IdeognosticTest1_9y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->addScript('dyscalculiaScripts' . DS . 'ValidationInput');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Ideognostic29()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'IdeognosticTest2_9y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->addScript('dyscalculiaScripts' . DS . 'ValidationInput');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Lexical19()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'LexicalTest1_9y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->addScript('dyscalculiaScripts' . DS . 'ValidationInput');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Lexical29()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'LexicalTest2_9y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->addScript('dyscalculiaScripts' . DS . 'ValidationMultipleInputs');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Operational19()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'OperationalTest1_9y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addCss('dyscaulculiaCss' . DS . 'operationalTestsStyle');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->addScript('dyscalculiaScripts' . DS . 'ValidationMultipleInputs');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Operational29()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'OperationalTest2_9y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addCss('dyscaulculiaCss' . DS . 'operationalTestsStyle');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->addScript('dyscalculiaScripts' . DS . 'ValidationMultipleInputs');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Practognostic19()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'PractognosticTest1_9y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addCss('dyscaulculiaCss' . DS . 'PractognosticTestsStyle');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->addScript('dyscalculiaScripts' . DS . 'ValidationMultipleInputs');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Practognostic29()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'PractognosticTest2_9y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addCss('dyscaulculiaCss' . DS . 'PractognosticTestsStyle');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Validations');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Verbal19()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'VerbalTest1_9y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->addScript('dyscalculiaScripts' . DS . 'ValidationInput');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Verbal29()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'VerbalTest2_9y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->addScript('dyscalculiaScripts' . DS . 'ValidationInput');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Graphic19()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'GraphicTest1_9y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Graphic29()
    {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'GraphicTest2_9y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }
}
