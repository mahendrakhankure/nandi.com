<?php
defined('BASEPATH') OR exit('No direct script access allowed');



require APPPATH . '/libraries/BaseController.php';

/**

 * Class : Manage_Globles (Manage_Globles)

 * User Class to control all user related operations.

 * @author : Mangesh

 * @version : 1.1

 * @since : 20 April 2021

 */

Class Manage_Globles extends BaseController {


    function __construct(){

        parent::__construct();

        if(! $this->session->userdata('customer'))

        redirect('login');

    }

}

?>