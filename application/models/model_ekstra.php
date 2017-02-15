<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_ekstra extends CI_Model {

	public function index($tgl1,$tgl2)
	{
		$hasil = $this->db->join('tab_karyawan','tab_karyawan.nik=tab_extra.nik')
	                      ->where('tab_extra.tanggal_ekstra >=',$tgl1)
	                      ->where('tab_extra.tanggal_ekstra <=',$tgl2)
					      ->order_by('tab_extra.entry_date','desc')
					      ->get('tab_extra');
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
						  ->get('tab_extra');
		if($hasil->num_rows() > 0){
			return $hasil->row();
		} else {
			return array();
		}
	}
	public function add($data)
	  {
	      $this->db->insert('tab_extra', $data);
	  }
	public function update($id, $data){
		$this->db->where('id', $id)
				 ->update('tab_extra', $data);
	}
	public function delete($id){
		$this->db->where('id', $id)
				 ->delete('tab_extra');
	}
}