<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_cutiKhusus extends CI_Model {

	public function index()
	{
		$hasil = $this->db->get('tab_cuti_khusus');
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}
	public function find($id){
		//Query mencari record berdasarkan ID-nya
		$hasil = $this->db->where('id', $id)
						  ->limit(1)
						  ->get('tab_cuti_khusus');
		if($hasil->num_rows() > 0){
			return $hasil->row();
		} else {
			return array();
		}
	}

	public function import_data($dt){
		for ($i = 1; $i < count($dt); $i++) {
        $data = array(
			  'keterangan' =>$dt[$i]['keterangan'],
			  'maximal_lama' =>$dt[$i]['lama'],
			  'entry_user' =>$this->session->userdata('username')
			 );
	     $this->db->insert('tab_cuti_khusus',$data);
		}
	}

	public function add($data)
	  {
	      $this->db->insert('tab_cuti_khusus', $data);
	  }
	public function update($id, $data){
		$this->db->where('id', $id)
				 ->update('tab_cuti_khusus', $data);
	}
	public function delete($id){
		$this->db->where('id', $id)
				 ->delete('tab_cuti_khusus');
	}
}