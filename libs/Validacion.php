<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class Validacion {

    private static $instance;
    protected $db;
    private $config;

    private function __construct() {

        $this->db = DataBase::singleton();
        $this->config = Config::singleton();
    }

    public function isLogged() {
        session_start();
        if (isset($_SESSION['user']) && isset($_SESSION['autentificado']) && isset($_SESSION['certifed'])) {
            $usuario = unserialize($_SESSION['user']);
            if ($_SESSION['autentificado'] == "si" && $_SESSION['certifed'] === str_repeat(strrev(sha1($usuario->getIpUser() . "@pPliccati0N" . date("Y-m-d"))), 6)) {
                return true;
            } else {
                ob_end_clean();
                session_destroy();
                header('location: index.php?controlador=User&accion=Login');
            }
        } else {
            ob_end_clean();
            session_destroy();
            header('location: index.php?controlador=User&accion=Login');
        }
    }

    public function Login($alias, $pass) {
        $query = null;
        if (is_numeric($alias)) {
            $consult = "SELECT * FROM usuarios WHERE idusuario=%s and idestado=2";
            if ($this->config->get('dbtype') == "postgres") {
                $query = str_replace('%s', (int) pg_escape_string($alias), $consult);
            } elseif ($this->config->get('dbtype') == "mysql") {
                $query = sprintf($consult, (int) mysql_real_escape_string($alias));
            }
        } else {
            $consult = "SELECT * FROM usuarios WHERE alias='%s' and idestado=2";
            if ($this->config->get('dbtype') == "postgres") {
                $query = str_replace('%s', pg_escape_string($alias), $consult);
            } elseif ($this->config->get('dbtype') == "mysql") {
                $query = sprintf($consult, mysql_real_escape_string($alias));
            }
        }

        $consulta = $this->db->executeQue($query);

        if ($this->db->numRows($consulta) == 0) {
            session_cache_expire(0);
            session_destroy();
            session_start();
            if (isset($_SESSION['autentificado'])) {
                unset($_SESSION['autentificado']);
            }
            if (isset($_SESSION['user'])) {
                unset($_SESSION['user']);
            }
            if (isset($_SESSION['certifed'])) {
                unset($_SESSION['certifed']);
            }
            return false;
        } else {

            $resultados = $this->db->arrayResult($consulta);
            while ($row = $resultados) {
                if (sha1($pass) == $row['password']) {
                    session_start();
                    if (isset($_SESSION['autentificado'])) {
                        unset($_SESSION['autentificado']);
                    }
                    if (isset($_SESSION['user'])) {
                        unset($_SESSION['user']);
                    }
                    if (isset($_SESSION['certifed'])) {
                        unset($_SESSION['certifed']);
                    }
                    $autentificado = "si";
                    $_SESSION['autentificado'] = $autentificado;
                    $usuario = new GUser($row['idusuario'], $row['nombreusuario'], $row['email'], $row['perfil'], $row['alias'], $row['idbodega']);
                    error_log("\n\nInicio de nueva sesion por: \n", 3, LOGUSER);
                    error_log("Id: " . $row['idusuario'] . " \n", 3, LOGUSER);
                    error_log("Nombre: " . $row['nombreusuario'] . " \n", 3, LOGUSER);
                    error_log("Email: " . $row['email'] . " \n", 3, LOGUSER);
                    error_log("Perfil: " . $row['perfil'] . " \n", 3, LOGUSER);
                    error_log("Alias: " . $row['alias'] . " \n", 3, LOGUSER);
                    error_log("Ip: " . $usuario->getIpUser() . " \n", 3, LOGUSER);
                    error_log("Fecha: " . date("Y-m-d H:i:s") . " \n", 3, LOGUSER);
                    $cadenadeexp = str_repeat(strrev(sha1($usuario->getIpUser() . "@pPliccati0N" . date("Y-m-d"))), 6);
                    $_SESSION['user'] = serialize($usuario);
                    $_SESSION['certifed'] = $cadenadeexp;
                    return true;
                } else {
                    session_destroy();
                    session_cache_expire(0);
                    session_start();
                    if (isset($_SESSION['autentificado'])) {
                        unset($_SESSION['autentificado']);
                    }
                    if (isset($_SESSION['user'])) {
                        unset($_SESSION['user']);
                    }
                    if (isset($_SESSION['certifed'])) {
                        unset($_SESSION['certifed']);
                    }
                    return false;
                }
            }
        }
    }

    function Logout() {
        session_start();
        unset($_SESSION['autentificado']);
        unset($_SESSION['user']);
        unset($_SESSION['certifed']);
        session_destroy();
        session_cache_expire(0);
        header('location: index.php?controlador=User&accion=Login');
    }

    public static function singleton() {
        if (!isset(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c;
        }

        return self::$instance;
    }

}

?>
