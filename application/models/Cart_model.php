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
        $pesananPas = true;
        $id_user    = $this->session->userdata('id_user');
        $cart       = $this->where('id_user', $id_user)->get();
        
        foreach ($cart as $row) {
            $pesanan      = $this->where('id_pesanan', $row->id_pesanan)->first();

            $this->table  = 'stock_barang';
            $barang       = $this->where('id_barang', $pesanan->id_barang)->first();       
            
            if (($barang->qty_inventory - $pesanan->qty_pesanan) < 0) {
                $this->session->set_flashdata("qty_pesanan_$pesanan->id_pesanan", "Stock hanya ada $barang->qty_inventory");

                $pesananPas = false;
            }

            $this->table    = 'keranjang';
        }

        return $pesananPas;
    }
}

/* End of file Cart_model.php */
