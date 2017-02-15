<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_jamPindah extends CI_Model {

	public function index($tgl1,$tgl2)
	{
		$hasil = $this->db->join('tab_karyawan','tab_karyawan.nik=tab_pindah_jam.nik','inner')
					      ->select('*,tab_pindah_jam.id as id_pindah')
	                      ->where('tab_pindah_jam.tanggal_pindah >=',$tgl1)
	                      ->where('tab_pindah_jam.tanggal_pindah <=',$tgl2)
					      ->get('tab_pindah_jam');
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}
	public function find($id){
		$hasil = $this->db->where('id', $id)
						  ->limit(1)
						  ->get('tab_pindah_jam');
		if($hasil->num_rows() > 0){
			return $hasil->row();
		} else {
			return array();
		}
	}
	
	public function cek($nik,$bln,$thn){
		$hasil = $this->db->join('tab_karyawan b', 'b.nik=a.nik')
						  ->where('a.nik',$nik)
						  ->where('month(a.tanggal)',date($bln))
						  ->where('year(a.tanggal)',date($thn))
						  ->get('tab_jadwal_karyawan a');
		if($hasil->num_rows() > 0){
			return $hasil;
		} else {
			return array();
		}
	}

	public function add($data)
	  {
	      /*$cek=$this->db->where('tanggal_pindah',$data['tanggal_pindah'])->get('tab_pindah_jam')->num_rows();
	      if ($cek<1) {
	      	  $this->db->insert('tab_pindah_jam', $data);

	      	  return 1;
	      }else{
	      	return 0;
	      }*/
	      $this->db->insert('tab_pindah_jam', $data);
	  }
	
	public function delete($id){
		$this->db->where('id', $id)
				 ->delete('tab_pindah_jam');
	}
}