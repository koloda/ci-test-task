<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Exceptions Class
 *
 * @package        CodeIgniter
 * @subpackage    Libraries
 * @category    Exceptions
 * @author        EllisLab Dev Team
 * @link        http://codeigniter.com/user_guide/libraries/exceptions.html
 */
class MY_Exceptions extends CI_Exceptions {

    private $CI;


    /**
     * Class constructor
     *
     * @return    void
     */
    public function __construct()
    {

        parent::__construct();
    }

}

