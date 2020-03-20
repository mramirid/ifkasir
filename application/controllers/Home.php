<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Dashboard
 */
class Home extends MY_Controller 
{
    public function index()
    {
        $data['page']               = 'pages/home/index';
        $data['title']              = 'IFKasir - Dashboard';
        $data['breadcrumb_title']   = 'Hallo Admin 😊';
        $data['breadcrumb_path']    = 'Dashboard';
        
        $this->view($data);
    }
}

/* End of file Home.php */
