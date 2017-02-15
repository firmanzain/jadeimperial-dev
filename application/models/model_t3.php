<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_t3 extends CI_Model {

	public function index()
	{
		$hasil = $this->db->join('tab_karyawan b','b.nik=e.nik')
						  ->join('tab_jabatan a','a.id_jabatan=b.jabatan')
                          ->join('tab_cabang c','c.id_cabang=b.cabang')
                          ->join('tab_department d','d.id_department=b.department')
                          ->select('*,e.id as id_t3')
                          ->get('tab_master_t3 e');

		if($hasil->num_rows() > 0)
		{
			return $hasil->result();
		} 
		else 
		{
			return array();
		}
	}


	public function add($data){
		$this->db->insert('tab_master_t3', $data);
	}


	public function find($id){
		$hasil = $this->db->join('tab_karyawan b','b.nik=e.nik')
						  ->where('e.id', $id)
						  ->join('tab_jabatan a','a.id_jabatan=b.jabatan')
                          ->join('tab_cabang c','c.id_cabang=b.cabang')
                          ->join('tab_department d','d.id_department=b.department')
						  ->get('tab_master_t3 e');
		if($hasil->num_rows() > 0){
			return $hasil->row();
		} else {
			return array();
		}
	}

	public function update($id, $data){
		$this->db->where('id', $id)
				 ->update('tab_master_t3', $data);
	}

	public function delete($id){
		$this->db->where('id', $id)->delete('tab_master_t3');
	}

/**
Transaksi T3
*/
	public function show($field1,$field2)
	{
		$hasil = $this->db->select('e.id as id_real, e.*, a.*, b.*, c.*, d.*')
						  ->from('tab_t3 e')
						  ->join('tab_karyawan b','b.nik=e.nik')
						  ->join('tab_jabatan a','a.id_jabatan=b.jabatan')
                          ->join('tab_cabang c','c.id_cabang=b.cabang')
                          ->join('tab_master_t3 d', 'd.nik = e.nik')
                          //->join('tab_department d','d.id_department=b.department')
                          ->where('e.tanggal >=',$field1)
                          ->where('e.tanggal <=',$field2)
                          ->get();
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return false;
		}
	}

	public function show2($field1,$field2)
	{
		$hasil = $this->db->join('tab_karyawan b','b.nik=e.nik')
						  ->join('tab_jabatan a','a.id_jabatan=b.jabatan')
                          ->join('tab_cabang c','c.id_cabang=b.cabang')
                          ->join('tab_master_t3 d', 'd.nik = e.nik')
                          //->join('tab_department d','d.id_department=b.department')
                          ->where('e.tanggal >=',$field1)
                          ->where('e.tanggal <=',$field2)
                          ->get('tab_t3 e');
		if($hasil->num_rows() > 0){
			return true;
		} else {
			return false;
		}
	}


	public function get_show()
	{	
		$this->db->select('a.nik,a.nama_ktp,b.tarif,c.jabatan,d.cabang');
		$this->db->from('tab_karyawan a');
		// $this->db->join('tab_master_t3 b', 'b.nik = a.nik', 'inner');
		$this->db->join('tab_master_bonus b', 'b.nik = a.nik', 'inner');
		$this->db->join('tab_jabatan c', 'c.id_jabatan = a.jabatan', 'inner');
		$this->db->join('tab_cabang d', 'd.id_cabang = a.cabang', 'inner');
		$hasil = $this->db->get();

		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}

/**
Approvement
*/
	public function approv($field1,$field2)
	{
		$this->db->select('a.*,b.nama_ktp,c.tarif,d.jabatan,e.cabang');
		$this->db->from('tab_t3 a');

		$this->db->join('tab_karyawan b','b.nik=a.nik');
		$this->db->join('tab_master_t3 c', 'c.nik = a.nik');
		$this->db->join('tab_jabatan d', 'd.id_jabatan = b.jabatan');
		
		$this->db->join('tab_cabang e', 'e.id_cabang = b.cabang');
		$this->db->where('a.tanggal >=',$field1);
        $this->db->where('a.tanggal <=',$field2);
		$hasil = $this->db->get();
		/*$hasil = $this->db->join('tab_karyawan b','b.nik=e.nik')
						  ->join('tab_jabatan a','a.id_jabatan=b.jabatan')
                          ->join('tab_cabang c','c.id_cabang=b.cabang')
                          ->join('tab_master_t3 d', 'd.nik = e.nik')
                          //->join('tab_department d','d.id_department=b.department')
                          ->where('e.tanggal >=',$field1)
                          ->where('e.tanggal <=',$field2)
                          ->get('tab_t3 e');*/
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}


/**
Rekapitulasi
*/

	public function rekapitulasi($tgl1,$tgl2,$cabang)
	{
		if (!empty($tgl1) && !empty($tgl2)) 
		{
            $this->db->where("(e.tanggal between '".$tgl1."' and '".$tgl2."')",null);
        }else
        {
            $this->db->where("month(e.tanggal)",date('m'));
        }


        if (!empty($cabang)) 
        {
            $this->db->where('c.id_cabang',$cb);   
        }

		$hasil = $this->db->join('tab_karyawan b','b.nik=e.nik')
						  ->join('tab_jabatan a','a.id_jabatan=b.jabatan')
                          ->join('tab_cabang c','c.id_cabang=b.cabang')
                          ->join('tab_master_t3 f','f.nik=e.nik')
                          ->join('tab_department d','d.id_department=b.department')
                          ->order_by('e.tanggal','desc')
                          ->get('tab_t3 e');
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}


	public function karyawan($cabang,$jabatan)
	{
		if (!empty($cabang)) {
			$this->db->where('b.cabang',$cabang);
		}
		if (!empty($jabatan)) {
			$this->db->where('b.jabatan',$jabatan);
		}
		$hasil = $this->db->join('tab_jabatan a','a.id_jabatan=b.jabatan')
                          ->join('tab_cabang c','c.id_cabang=b.cabang')
                          ->join('tab_department d','d.id_department=b.department')
                          ->get('tab_karyawan b');
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}
	

	


}