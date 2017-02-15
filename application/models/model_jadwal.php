<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_jadwal extends CI_Model {

	public function index()
	{
		$hasil = $this->db->get('tab_jam_kerja');
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}

	public function all()
	{
		$hasil = $this->db->get('tab_jam_kerja');
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}

	public function import_data($dt){
		for ($i = 1; $i < count($dt); $i++) {

       $p1=preg_replace("/[^0-9]/", "", $dt[$i]['lama1']);
       $p2=preg_replace("/[^0-9]/", "", $dt[$i]['lama2']);
       $lama=$p1+$p2;
        $data = array(
              'kode_jam' => $dt[$i]['kode_jam'],
			  'jam_start' =>$dt[$i]['jam_start1'],
			  'jam_finish' =>$dt[$i]['jam_finish1'],
			  'jam_start2' =>$dt[$i]['jam_start2'],
			  'jam_finish2' =>$dt[$i]['jam_finish2'],
			  'keterangan' =>$dt[$i]['keterangan'],
			  'lama' =>$lama,
			 );
	    //print_r($data);
	    $this->db->insert('tab_jam_kerja',$data);
		}
	}

	public function find($id){
		//Query mencari record berdasarkan ID-nya
		$hasil = $this->db->where('id', $id)
						  ->limit(1)
						  ->get('tab_jam_kerja');
		if($hasil->num_rows() > 0){
			return $hasil->row();
		} else {
			return array();
		}
	}
	public function add($data)
	  {
	      $this->db->insert('tab_jam_kerja', $data);
	  }
	public function update($id, $data){
		$this->db->where('id', $id)
				 ->update('tab_jam_kerja', $data);
	}
	public function delete($id){
		$this->db->where('id', $id)
				 ->delete('tab_jam_kerja');
	}
}