<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Buat test template aja
 */
class Template extends MY_Controller 
{
    public function index()
    {
        $data['page']               = 'template/index';
        $data['title']              = 'Adminmart Template - The Ultimate Multipurpose admin template';
        $data['breadcrumb_title']   = 'Good Morning Jason!';
        $data['breadcrumb_path']    = 'Dashboard';
        
        $this->view($data);
    }
}

/* End of file Template.php */
