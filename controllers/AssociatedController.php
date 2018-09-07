<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class AssociatedController extends ControllerBase {

    public function main() {
        $this->contract();
    }

    public function contract() {
 
        $this->view->setTemplate('associated' . DS . 'contract');
        $this->document->addScript("jquery.mCustomScrollbar");          
        $this->document->addCss("jquery.mCustomScrollbar");
        $this->document->addCss("insertForm");
        $this->document->addCss("jquery.fancybox-1.3.4");
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->addCss("pos");
        $this->document->setHeader();
        $assoc = $this->getModel("Associated");
        $this->getModel("User");
        $idUser = (int) $assoc->getSponsor();
        $perfil = $assoc->getGrupoPerfil($this->model->getUserProfile());        
        if ($idUser == 0) {
            $idUser = $this->model->getUserId();
            $nameUser = $this->model->getUserName(); 
            $verificared = $this->model->verifyNet($idUser);           
        } else {
            $sponsor_user = $this->model->getUserById($idUser);
            $nameUser = $sponsor_user['nombre'];
        }
        $this->view->setVars('id', $idUser); 
        $this->view->setVars('verifynet', $verificared);
        $this->view->setVars('nameSpon', $nameUser);
        $this->view->setVars('perfil', $perfil);
        $this->view->show();
    }

    public function formInscription() {
        $this->view->setTemplate('associated' . DS . 'formInscription');
        $this->document->addCss("insertForm");
        $this->document->addCss("jquery.fancybox-1.3.4");
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->addCss("pos");
        $this->document->setHeader();
        $usmodel = $this->getModel("User");
        $this->getModel("Associated");
        if (isset($_SESSION['new_user'])) {
            $usuario = $this->model->getNewUser();
            $beneficiario = $this->model->getBeneficiario();
            $localidad = $this->model->getIdLocalidad($usuario->getBarrio());
            $departamento = $this->model->getIdDepartamento($usuario->getCiudad());
            $departamentoBen = $this->model->getIdDepartamento($beneficiario->getCiudad());
            $departamentos = $this->model->getSelectDepartamentos();
            $ciudades = $this->model->getSelectCiudades($departamento);
            $localidadvin = $this->model->getSelectLocalidades('locvin');
            $barriovin = $this->model->getSelectBarrios($localidad, 'barrvin');
            $departamentosben = $this->model->getSelectDepartamentos('depben');
            $ciudadesben = $this->model->getSelectCiudades($departamentoBen, 'cidben');
        } else {
            $usuario = false;
            $beneficiario = false;
            $localidad = false;
            $departamento = 6;
            $departamentoBen = 6;
            $departamentos = $this->model->getSelectDepartamentos();
            $ciudades = $this->model->getSelectCiudades(6);
            $localidadvin = $this->model->getSelectLocalidades('locvin');
            $barriovin = $this->model->getSelectBarrios(0, 'barrvin');
            $departamentosben = $this->model->getSelectDepartamentos('depben');
            $ciudadesben = $this->model->getSelectCiudades(6, 'cidben');
        }
        if (isset($_GET['sponsor'])) {
            $this->model->setSponsor();
        }
        $sponsor = $this->model->getSponsor();
        $sponsor_user = $usmodel->getUserById($sponsor);
        $fecha = date("Y-m-d", strtotime(date("Y-m-d") . " -18 year"));
        $fechamax = date("Y-m-d", strtotime($fecha . " -1 day"));
        $arrayfecha = explode("-", $fechamax);
        $dia = $arrayfecha[2];
        $mes = $arrayfecha[1] - 1;
        $ano = $arrayfecha[0];
        $this->view->setVars('localidad', $localidad);
        $this->view->setVars('departamento', $departamento);
        $this->view->setVars('departamentoBen', $departamentoBen);
        $this->view->setVars('sponsor', $sponsor_user);
        $this->view->setVars('usuario', $usuario);
        $this->view->setVars('beneficiario', $beneficiario);
        $this->view->setVars('deps', $departamentos);
        $this->view->setVars('cids', $ciudades);
        $this->view->setVars('depsben', $departamentosben);
        $this->view->setVars('cidsben', $ciudadesben);
        $this->view->setVars('locvin', $localidadvin);
        $this->view->setVars('barrvin', $barriovin);
        $this->view->setVars('dia', $dia);
        $this->view->setVars('mes', $mes);
        $this->view->setVars('ano', $ano);
        $this->view->show();
    }

    public function prepareUser() {
        $this->getModel("User");
        $this->getModel("Associated");
        $this->model->prepareUser();
        echo json_encode(array("url" => "index.php?controlador=Associated&accion=createAssociated"));
    }

    public function createAssociated() {
        $this->view->setTemplate('associated' . DS . 'associatedSell');
        $this->document->addCss("insertForm");
        $this->document->addCss("jquery.fancybox-1.3.4");
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->addCss("pos");
        $this->document->setHeader();

//Modelo UserModel
        $usmodel = $this->getModel("User");
//Modelo AssociatedModel$this->getModel("Associated");
        /*
         * crear usuario y obtenerlo, obtener patrocinador con nombre y nombre de la ciudad
         */
        //$this->model->prepareUser();
        $this->getModel("Associated");
        /*
         * crear usuario y obtenerlo, obtener patrocinador con nombre y nombre de la ciudad
         */
        //$this->model->prepareUser();
        $sponsor = $this->model->getSponsor();
        $newUser = $this->model->getNewUser();
        $beneficiario = $this->model->getBeneficiario();
        $city_nameBen = $this->model->getcityNameById($beneficiario->getCiudad());
        $city_name = $this->model->getcityNameById($newUser->getCiudad());
        $sponsor_user = $usmodel->getUserById($newUser->getIdPadre());
        $soponsor_name = $sponsor_user['nombre'];

        $this->model->createVenta();
        $detalle = $this->model->getDetalle();
        $barrio = $this->model->getNombreBarrio($newUser->getBarrio());
        $departamento = $this->model->getNombreDepartamento($newUser->getCiudad());
        $departamentoBen = $this->model->getNombreDepartamento($beneficiario->getCiudad());

        $this->view->setVars('usuario', $newUser);
        $this->view->setVars('departamento', $departamento);
        $this->view->setVars('departamentoBen', $departamentoBen);
        $this->view->setVars('barrio', $barrio);
        $this->view->setVars('patrocinador', $sponsor);
        $this->view->setVars('city_name', $city_name);
        $this->view->setVars('city_nameBen', $city_nameBen);
        $this->view->setVars('soponsor_name', $soponsor_name);
        $this->view->setVars('detail', $detalle);
        $this->view->setVars('beneficiario', $beneficiario);
        $this->view->show();
    }

    public function finishVinculate() {
//Modelo UserModel
        $usmodel = $this->getModel("User");
//Modelo AssociatedModel
        $this->getModel("Associated");
//insertar nuevo usuario
        $infoUser = $this->model->getNewUser();
        $newUser = $this->model->createUser($infoUser);
//sponsor_info
        $sponsor = $this->model->getSponsor();
        $sponsoruser = $usmodel->getUserById($newUser->getIdPadre());
        $sponsor_name = $sponsoruser['nombre'];
        $sponsor_email = $sponsoruser['email'];
//info venta
        $detalle = $this->model->getDetalle();
        $subtotal = $detalle->getProducto()->getPrecio() * $detalle->getCantidad();
        $iva = ($detalle->getProducto()->getIva() * $detalle->getProducto()->getPrecio()) / 100;
        unset($_SESSION["pdfinfo"]);
        $_SESSION["pdfinfo"]["nombre"] = $newUser->getNombre();
        $_SESSION["pdfinfo"]["codigo"] = $newUser->getId();
        $_SESSION["pdfinfo"]["fecha"] = date("Y-m-d");
        $_SESSION["pdfinfo"]["iva"] = ($detalle->getProducto()->getIva() * $detalle->getProducto()->getPrecio()) / 100;
        $_SESSION["pdfinfo"]["subtotal"] = $detalle->getProducto()->getPrecio() * $detalle->getCantidad();
        $_SESSION["pdfinfo"]["detalle"][] = array("cantidad" => $detalle->getCantidad(),
            "nombre" => $detalle->getProducto()->getNombre(),
            "referencia" => $detalle->getProducto()->getReferencia(),
            "preciounitarioiva" => $detalle->getProducto()->getPrecio() + (($detalle->getProducto()->getIva() * $detalle->getProducto()->getPrecio()) / 100),
            "preciototalitem" => ($detalle->getProducto()->getPrecio() + (($detalle->getProducto()->getIva() * $detalle->getProducto()->getPrecio()) / 100)) * $detalle->getCantidad());
        $idfactura = $this->model->crearFactura($newUser->getId(), $subtotal, $iva, $detalle);
        $_SESSION["pdfinfo"]["numeroorden"] = $idfactura;
        $this->model->createAndSavePdf($_SESSION["pdfinfo"]);
        if ($newUser->getEmail() != "" || $newUser->getEmail() != null) {
            $this->model->enviarcorreo($newUser, $idfactura, $_SESSION["pdfinfo"]["archivo"]);
            if ($sponsor_email != "" || $sponsor_email != null) {
                $this->model->enviarcorreo($newUser, $idfactura, $_SESSION["pdfinfo"]["archivo"], $sponsor_name, $sponsor_email);
            }
        }
        echo json_encode(array("url" => "index.php?controlador=Associated&accion=pantallafinal"));
    }

    public function pantallafinal() {
        $this->view->setTemplate('associated' . DS . 'finCompra');
        $this->document->addCss("jquery.fancybox-1.3.4");
        $this->document->addCss("factura");
        $this->document->addCss("pos");
        $this->document->setHeader();
//Modelo UserModel
        $usmodel = $this->getModel("User");
//Modelo AssociatedModel
        $this->getModel("Associated");
//insertar nuevo usuario
        $newUser = $this->model->getNewUser();
//sponsor_info
        $sponsor = $this->model->getSponsor();
        $sponsoruser = $usmodel->getUserById($newUser->getIdPadre());
        $sponsor_name = $sponsoruser['nombre'];
        $sponsor_email = $sponsoruser['email'];
//info venta
        $detalle = $this->model->getDetalle();
        $subtotal = $detalle->getProducto()->getPrecio() * $detalle->getCantidad();
        $iva = number_format(($detalle->getProducto()->getIva() * $detalle->getProducto()->getPrecio()) / 100, 0, '.', '');
        $idfactura = $_SESSION["pdfinfo"]["numeroorden"];
        unset($_SESSION['detalleVinculacion']);
        unset($_SESSION['new_user']);
        unset($_SESSION['beneficiario']);
        unset($_SESSION['sponsor']);
        unset($_SESSION['pdfinfo']);
        $imagen = IMAGES . SL . 'bancobogota.gif';
        $this->view->setVars('facturaNum', $idfactura);
        $this->view->setVars('sponsor', $sponsor);
        $this->view->setVars('subtotal', $subtotal);
        $this->view->setVars('detalle', $detalle);
        $this->view->setVars('user', $newUser);
        $this->view->setVars('iva', $iva);
        $this->view->setVars('bogota', $imagen);
        $this->view->show();
    }

    public function ajaxName() {
        $this->getModel("User");
        $name = $this->model->getUserNameAjax();
        if ($name == null) {
            $this->document->texto('ASSOCIATE_NOT_FOUND');
        } else {
            echo $name;
        }
    }

    public function existSponsor() {
        $this->getModel("User");
        $name = $this->model->getUserNameAjax();
        if ($name == null) {
            echo json_encode(array("respuesta" => "no", "mensaje" => $this->document->texto('ASSOCIATE_NOT_FOUND')));
        } else {
            echo json_encode(array("respuesta" => "si"));
        }
    }

    public function ajaxCiudades() {
        $this->getModel("Associated");
        $ciudades = $this->model->getChangeCiudades();
        echo $ciudades;
    }

    public function ajaxBarrios() {
        $this->getModel("Associated");
        $barrios = $this->model->getChangeBarrios();
        echo $barrios;
    }

    public function downcontract() {
        $this->getModel("Associated");
        $this->model->downloadContract($this->document->t('CONTRACT_CONTENT'));
    }
    

}
?>

