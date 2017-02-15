<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_scheduleKaryawan extends CI_Model {

	public function index()
	{
		$hasil = $this->db->join('tab_karyawan b','b.nik=a.nik')
						  ->join('tab_jabatan c','c.id_jabatan=b.jabatan')
						  ->join('tab_cabang d','d.id_cabang=b.cabang')
						  ->select('b.nik,b.nama_ktp,c.jabatan,d.cabang')
						  ->group_by('a.nik')
						  ->order_by('a.nik')
						  ->get('tab_jadwal_karyawan a');
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}

	public function detail($nik,$tgl1,$tgl2)
	{
		if (!empty($tgl1) and !empty($tgl2)) {
			$this->db->where('a.tanggal >=',$tgl1);
			$this->db->where('a.tanggal <=',$tgl2);
		}
		$hasil = $this->db->join('tab_karyawan b','b.nik=a.nik')
						  ->join('tab_jabatan c','c.id_jabatan=b.jabatan')
						  ->join('tab_cabang d','d.id_cabang=b.cabang')
						  ->join('tab_jam_kerja e','e.kode_jam=a.kode_jam','left')
						  ->where('a.nik',$nik)
						  ->order_by('a.tanggal','asc')
						  ->select('*,a.id as id_jadwal,e.kode_jam as kode_jadwal')
						  ->get('tab_jadwal_karyawan a');
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}

	public function all()
	{
		$hasil = $this->db->get('tab_jadwal_karyawan');
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}

	public function import_data($dt){
		for ($i = 1; $i < count($dt); $i++) {
        $data = array(
              'jam_start' => $dt[$i]['jam_start'],
			  'jam_finish' =>$dt[$i]['jam_finish'],
			  'jenis' =>$dt[$i]['jenis'],
			  'departmen' =>$dt[$i]['departmen'],
			  'keterangan' =>$dt[$i]['keterangan'],
			  'lama' =>$dt[$i]['lama'],
			 );
	     $this->db->insert('tab_jadwal_karyawan',$data);
		}
	}

	public function find($id){
		//Query mencari record berdasarkan ID-nya
		$hasil = $this->db->where('id', $id)
						  ->limit(1)
						  ->get('tab_jadwal_karyawan');
		if($hasil->num_rows() > 0){
			return $hasil->row();
		} else {
			return array();
		}
	}
	public function add($data)
	  {
	      $cek=$this->db->where($data)->get('tab_jadwal_karyawan')->num_rows();
	      if ($cek<1) {
		      $this->db->insert('tab_jadwal_karyawan', $data);
	      }
	  }
	public function update($id, $data){
		$this->db->where('id', $id)
				 ->update('tab_jadwal_karyawan', $data);
	}
	public function delete($id){
		$this->db->where('id', $id)
				 ->delete('tab_jadwal_karyawan');
	}
	
	public function cek($nik,$bulan,$tahun){
		$cek=$this->db->where('nik', $nik)
					  ->where('month(tanggal)', $bulan)
					  ->where('year(tanggal)', $tahun)
				 	  ->get('tab_jadwal_karyawan')
				 	  ->num_rows();
		if ($cek>=1) {
			return $cek;
		} else {
			return array();
		}

	}
	
}