<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_libur extends CI_Model {

	public function index($tgl1,$tgl2)
	{
		$hasil = $this->db->query(
			'select * from tab_hari_libur where tanggal_mulai>="'.$tgl1.'"
			and tanggal_selesai<="'.$tgl2.'"'
		);
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
						  ->get('tab_hari_libur');
		if($hasil->num_rows() > 0){
			return $hasil->row();
		} else {
			return array();
		}
	}

	public function import_data($dt){
		for ($i = 1; $i < count($dt); $i++) {
        $data = array(
              'tanggal_mulai' => $dt[$i]['tanggal_mulai'],
			  'tanggal_selesai' =>$dt[$i]['tanggal_selesai'],
			  'cuti_khusus' =>$dt[$i]['cuti_khusus'],
			  'keterangan' =>$dt[$i]['keterangan'],
			  'lama' =>$dt[$i]['lama'],
			 );
	     $this->db->insert('tab_hari_libur',$data);
		}
	}

	public function add($data)
	  {
	      $this->db->insert('tab_hari_libur', $data);
	  }
	public function update($id, $data){
		$this->db->where('id', $id)
				 ->update('tab_hari_libur', $data);
	}
	public function delete($id){
		$this->db->where('id', $id)
				 ->where('tanggal_selesai > ', date('Y-m-d'))
				 ->delete('tab_hari_libur');
		return $this->db->affected_rows();
	}
}