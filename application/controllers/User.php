<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller 
{
    public function __construct()
    {
        parent::__construct();
        
        $is_login = $this->session->userdata('is_login');

        if (!$is_login) {
            $this->session->set_flashdata('warning', 'Anda belum login');
            redirect(base_url('login'));
            return;
        }
    }

    public function index($page = null)
    {
        $data['title']              = 'IFKasir - List Karyawan';
        $data['breadcrumb_title']   = 'List Karyawan';
        $data['breadcrumb_path']    = 'Manajemen Karyawan / List Karyawan';
        $data['content']            = $this->user->paginate($page)->get();
        $data['total_rows']         = $this->user->count();
        $data['pagination']         = $this->user->makePagination(base_url('user'), 2, $data['total_rows']);
        $data['page']               = 'pages/user/index';
        
        $this->view($data);
    }
}

/* End of file User.php */
