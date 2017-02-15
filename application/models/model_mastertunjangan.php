<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_masterTunjangan extends CI_Model {

	public function index()
	{
		$hasil = $this->db->get('tab_master_tunjangan');
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}
	public function find($id_tunjangan){
		//Query mencari record berdasarkan id_tunjangan-nya
		$hasil = $this->db->where('id_tunjangan', $id_tunjangan)
						  ->limit(1)
						  ->get('tab_master_tunjangan');
		if($hasil->num_rows() > 0){
			return $hasil->row();
		} else {
			return array();
		}
	}
	public function add($data)
	  {
	      $this->db->insert('tab_master_tunjangan', $data);
	  }
	public function update($id_tunjangan, $data){
		$this->db->where('id_tunjangan', $id_tunjangan)
				 ->update('tab_master_tunjangan', $data);
	}
	public function delete($id_tunjangan){
		$this->db->where('id_tunjangan', $id_tunjangan)
				 ->delete('tab_master_tunjangan');
	}
}