<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Logout extends MY_Controller
{
    public function index()
    {
        $sess_data = ['id', 'nama', 'email', 'telefon', 'ktp', 'role', 'is_login'];
        $this->session->unset_userdata($sess_data);
        $this->session->sess_destroy();
        
        $this->cart->nukeTable();

        redirect(base_url('login'));
    }
}

/* End of file Logout.php */
