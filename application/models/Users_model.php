<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends MY_Model 
{
    protected $table = 'user';

    public function getDefaultValues()
    {
        return [
            'nama'      => '',
            'email'     => '',
            'password'  => '',
            'telefon'   => '',
            'role'      => '',
            'status'    => '',
            'ktp'       => ''
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
            ],
            [
                'field' => 'ktp',
                'label' => 'Nomor KTP',
                'rules' => 'trim|required|callback_unique_ktp'
            ],
            [
                'field' => 'status',
                'label' => 'Status',
                'rules' => 'required'
            ],
            [
                'field' => 'role',
                'label' => 'Role',
                'rules' => 'required'
            ]
        ];

        return $validationRules;
    }
}

/* End of file Users_model.php */
