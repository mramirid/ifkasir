<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends MY_Model 
{
    public function getDefaultValues()
    {
        return [
            'nama'      => '',
            'email'     => '',
            'password'  => '',
            'telefon'   => ''
        ];
    }

    public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'nama',
                'label' => 'Nama Lengkap',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'email',
                'label' => 'E-Mail',
                'rules' => 'trim|required|valid_email|callback_unique_email'
            ],
            [
                'field' => 'telefon',
                'label' => 'Nomor Telefon',
                'rules' => 'trim|required'
            ]
        ];

        return $validationRules;
    }
}

/* End of file User_model.php */
