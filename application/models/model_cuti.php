<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_cuti extends CI_Model {

	public function index($tgl1,$tgl2)
	{
		$hasil = $this->db->join('tab_karyawan','tab_karyawan.nik=tab_cuti.nik','left')
						  ->join('tab_cuti_khusus','tab_cuti_khusus.id=tab_cuti.detail_cuti','left')
						  ->select('*,tab_cuti.keterangan as keterangan_cuti, tab_cuti.id as id_cuti')
	                      ->where('tab_cuti.tanggal_mulai >=',$tgl1)
	                      ->where('tab_cuti.tanggal_mulai <=',$tgl2)
	                      ->where('tab_cuti.tanggal_finish >=',$tgl1)
	                      ->where('tab_cuti.tanggal_finish <=',$tgl2)
						  ->order_by('tab_cuti.tanggal_mulai','desc')
						  ->get('tab_cuti');
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
						  ->get('tab_cuti');
		if($hasil->num_rows() > 0){
			return $hasil->row();
		} else {
			return array();
		}
	}
	public function add($data)
	  {
	      $this->db->insert('tab_cuti', $data);
	  }
	public function update($id, $data){
		$this->db->where('id', $id)
				 ->update('tab_cuti', $data);
	}
	public function delete($id){
		$this->db->where('id', $id)
				 ->delete('tab_cuti');
	}
}