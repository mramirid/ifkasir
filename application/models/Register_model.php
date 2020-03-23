<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Register_model extends MY_Model
{
    protected $table = 'user';

    public function getDefaultValues()
    {
        return [
            'nama'      => '',
            'email'     => '',
            'password'  => '',
            'telefon'   => '',
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
                'rules' => 'trim|required|valid_email|is_unique[user.email]',
                'errors' => [
                    'is_unique' => '<h6>%s sudah digunakan.</h6>'
                ]
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required|min_length[4]',
                'errors' => [
                    'min_length' => '<h6>%s minimal 4 karakter.</h6>'
                ]
            ],
            [
                'field' => 'telefon',
                'label' => 'Nomor Telefon',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'ktp',
                'label' => 'Nomor KTP',
                'rules' => 'trim|required|is_unique[user.ktp]',
                'errors' => [
                    'is_unique' => '<h6>%s sudah digunakan.</h6>'
                ]
            ],
        ];

        return $validationRules;
    }

    /**
     * Melakukan insert user baru ke db
     */
    public function run($input)
    {
        $data = [
            'nama'      => $input->nama,
            'email'     => strtolower($input->email),
            'password'  => hashEncrypt($input->password),
            'telefon'   => $input->telefon,
            'ktp'       => $input->ktp,
            'role'      => 'kasir'
        ];

        $user = $this->create($data);

        return true;
    }
}

/* End of file Register_model.php */
