<?php

defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        $model = strtolower(get_class($this));  // This mewakili file2 yang ada di folder Controllers
        // Apakah terdapat file model yang namanya sama dengan controller saat ini?
        if (file_exists(APPPATH . 'models/' . ucfirst($model) . '_model.php')) {
            // Param 1: load model, 2: nama controller - pasang model pada controller saat ini
            $this->load->model(ucfirst($model) . '_model', $model, true);
        }
    }

    /**
     * Load view with default layouts
     */
    public function view($data, $openLoginPage = false)
    {
        if ($openLoginPage) {
            $this->load->view('pages/auth/login', $data);
        } else {
            $this->load->view('layouts/dashboard', $data);
        }
    }
}

/* End of file MY_Controller.php */
