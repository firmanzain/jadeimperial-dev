<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_dokumen extends CI_Model {

    public function index()
    {
        $hasil = $this->db->get('tab_dokumen');
        if($hasil->num_rows() > 0){
            return $hasil->result();
        } else {
            return array();
        }
    }
    public function find($id){
        //Query mencari record berdasarkan ID-nya
        $hasil = $this->db->where('id_doc', $id)
                          ->limit(1)
                          ->get('tab_dokumen');
        if($hasil->num_rows() > 0){
            return $hasil->row();
        } else {
            return array();
        }
    }
    public function add($data)
      {
          $this->db->insert('tab_dokumen', $data);
      }
    public function update($id, $data){
        $this->db->where('id_doc', $id)
                 ->update('tab_dokumen', $data);
    }
    public function delete($id){
        $this->db->where('id_doc', $id)
                 ->delete('tab_dokumen');
    }
}