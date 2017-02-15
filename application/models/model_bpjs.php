<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_bpjs extends CI_Model {

	public function index()
	{
		$hasil = $this->db->get('tab_master_bpjs');
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}
	
	public function find($id_bpjs){
		//Query mencari record berdasarkan id_bpjs-nya
		$hasil = $this->db->where('id_bpjs', $id_bpjs)
						  ->limit(1)
						  ->get('tab_master_bpjs');
		if($hasil->num_rows() > 0){
			return $hasil->row();
		} else {
			return array();
		}
	}
	
	public function findDetail($id_bpjs){
		//Query mencari record berdasarkan id_bpjs-nya
		$hasil = $this->db->where('id_bpjs', $id_bpjs)
						  ->get('tab_master_bpjs_detail');
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}
	
	public function update($id_bpjs, $data){
		$this->db->where('id_bpjs', $id_bpjs)
				 ->update('tab_master_bpjs', $data);
	}
	
	public function create($data){
		$this->db->insert('tab_master_bpjs', $data);
		return $this->db->insert_id();
	}
}