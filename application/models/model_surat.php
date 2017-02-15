<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_surat extends CI_Model {

	public function index()
	{
		$hasil = $this->db->get('tab_surat_lain');
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}
	public function find($id){
		//Query mencari record berdasarkan ID-nya
		$hasil = $this->db->where('id_surat', $id)
						  ->or_where('no_surat',$id)
						  ->limit(1)
						  ->get('tab_surat_lain');
		if($hasil->num_rows() > 0){
			return $hasil->row();
		} else {
			return array();
		}
	}
	public function add($data)
	  {
	      $this->db->insert('tab_surat_lain', $data);
	  }
	public function update($id, $data){
		$this->db->where('id_surat', $id)
				 ->update('tab_surat_lain', $data);
	}
	public function delete($id){
		$this->db->where('id_surat', $id)
				 ->delete('tab_surat_lain');
	}
}