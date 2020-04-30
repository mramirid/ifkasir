<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cart_model extends MY_Model 
{
    public $table = 'keranjang';

    /**
     * Validasi stock dengan membandingkan kuantitas barang di 
     * tabel chart dengan kuantitas barang di tabel stock barang
     */
    public function validateStock()
    {
        $valid   = true;
        $id_user = $this->session->userdata('id_user');
        $cart    = $this->where('id_user', $id_user)->get();
        
        foreach ($cart as $row) {
            $this->table = 'stock_barang';
            $barang      = $this->where('id_barang', $row->id_barang)->first();       
            
            if (($barang->qty_inventory - $row->qty_pesanan) < 0) {
                $this->session->set_flashdata("qty_pesanan_$row->id_pesanan", "Stock hanya ada $barang->qty_inventory");
                $valid = false;
            }

            $this->table = 'keranjang';
        }

        return $valid;
    }
}

/* End of file Cart_model.php */
