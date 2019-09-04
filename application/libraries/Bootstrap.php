<?php

class CriticalException extends Exception {
} // искючение когда надо вернуть всё назад, что то серьёзное
class WarningException extends Exception {
} // не критичное исключение, от которого хуже не будет


class Bootstrap {

    function __construct()
    {

        $this->CI =& get_instance();
        $this->set_db();

    }
    
    function set_db()
    {
        include_once APPPATH . 'vendor/sparrow.php';

        if (file_exists(APPPATH . 'config/' . PROJECT_CONFIG_PATH . 'database.php'))
        {
            require_once(APPPATH . 'config/' . PROJECT_CONFIG_PATH . 'database.php');
        } else
        {
            if (file_exists(APPPATH . 'config/' . PROJECT_CONFIG_PATH . ENVIRONMENT . '/database.php'))
            {
                require_once(APPPATH . 'config/' . PROJECT_CONFIG_PATH . ENVIRONMENT . '/database.php');
            }
        }

        $this->CI->s = new Sparrow();

        $this->CI->s->setDb(array(
            'type' => 'mysqli',
            'hostname' => $db['default']['pconnect'] === TRUE ? ('p:' . $db['default']['hostname']) : ($db['default']['hostname']),
            'database' => $db['default']['database'],
            'username' => $db['default']['username'],// $db['default']['username'],
            'password' => $db['default']['password']
        ));

        $this->CI->s->sql('SET NAMES utf8')->execute();
        return  TRUE;

    }
}
