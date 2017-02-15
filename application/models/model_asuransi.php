<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_asuransi extends CI_Model {

	public function index()
	{
		$hasil = $this->db->get('tab_asuransi');
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}
	
	public function find($id){
		//Query mencari record berdasarkan id-nya
		$hasil = $this->db->where('id', $id)
						  ->limit(1)
						  ->get('tab_asuransi');
		if($hasil->num_rows() > 0){
			return $hasil->row();
		} else {
			return array();
		}
	}
	
	public function update($id, $data){
		$this->db->where('id', $id)
				 ->update('tab_asuransi', $data);
	}

	public function add($data){
		$this->db->insert('tab_asuransi', $data);
	}

	public function delete($id){
		$this->db->where('id', $id)->delete('tab_asuransi');
	}
}