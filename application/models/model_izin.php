<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_izin extends CI_Model {

	public function index($tgl1,$tgl2)
	{
		$hasil = $this->db->join('tab_karyawan','tab_izin.nik=tab_karyawan.nik','inner')
	                      ->where('tab_izin.tanggal_mulai >=',$tgl1)
	                      ->where('tab_izin.tanggal_mulai <=',$tgl2)->get('tab_izin');
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
						  ->get('tab_izin');
		if($hasil->num_rows() > 0){
			return $hasil->row();
		} else {
			return array();
		}
	}
	public function add($data)
	  {
	      $this->db->insert('tab_izin', $data);
	  }
	public function update($id, $data){
		$this->db->where('id', $id)
				 ->update('tab_izin', $data);
	}
	public function delete($id){
		$this->db->where('id', $id)
				 ->delete('tab_izin');
	}
}