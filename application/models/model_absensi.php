<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_absensi extends CI_Model {

	public function index()
	{
		$hasil = $this->db->select('a.*,b.*,c.*,d.*,e.nik as nik_resign, e.tanggal_resign as tgl_resign')
						  ->from('tab_karyawan a')
						  ->join('tab_jabatan b','b.id_jabatan=a.jabatan')
						  ->join('tab_department c','c.id_department=a.department')
						  ->join('tab_kontrak_kerja d','d.nik=a.nik')
						  ->join('tab_resign e','e.nik=a.nik','left')
						  //->where('d.tanggal_resign','0000-00-00')
						  ->get();
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}

	public function detail($nik,$tgl1,$tgl2)
	{
		/*if (!empty($bulan) && !empty($tahun)) {
			$this->db->where('month(jam_masuk)',$bulan)
					 ->where('Year(jam_masuk)',$tahun);
		}
		if (!empty($nik)) {
			$this->db->where('tab_karyawan.nik',$nik);
		}
		$hasil = $this->db->join('tab_karyawan','tab_karyawan.nik=tab_absensi_masuk.nik')
							->join('tab_absensi_keluar','tab_absensi_masuk.nik=tab_absensi_keluar.nik')
							->join('tab_jabatan','tab_jabatan.id_jabatan=tab_karyawan.jabatan')
							->join('tab_cabang','tab_cabang.id_cabang=tab_karyawan.cabang')
							->join('tab_kontrak_kerja','tab_kontrak_kerja.nik=tab_karyawan.nik')
							->join('tab_jadwal_karyawan','tab_jadwal_karyawan.nik=tab_karyawan.nik','left')
							->join('tab_jam_kerja','tab_jam_kerja.kode_jam=tab_jadwal_karyawan.kode_jam')
							->join('tab_department','tab_department.id_department=tab_karyawan.department')
							->select('*,tab_absensi_masuk.id as id_absen')
							->where('(tab_jadwal_karyawan.tanggal=date(tab_absensi_masuk.jam_masuk))',null)
							->order_by('month(tab_absensi_masuk.jam_masuk)','desc')
					 		->order_by('Year(tab_absensi_masuk.jam_masuk)','desc')
							->get('tab_absensi_masuk');*/
		$this->db->select('a.*,a.id as id_absen,b.*,b.nik as nik_real,c.jabatan as jabatan_real,
				 d.cabang as cabang_real,e.*,a.kode_jam as kode_jam_real,g.*,h.department as department_real');
		$this->db->from('tab_absensi a');
		$this->db->join('tab_karyawan b','b.nik=a.nik','left');
		$this->db->join('tab_jabatan c','c.id_jabatan=b.jabatan','left');
		$this->db->join('tab_cabang d','d.id_cabang=b.cabang','left');
		$this->db->join('tab_kontrak_kerja e','e.nik=b.nik','left');
		$this->db->join('tab_jadwal_karyawan f','f.nik=a.nik','f.nik=a.nik','left');
		$this->db->join('tab_jam_kerja g','g.kode_jam=a.kode_jam','left');
		$this->db->join('tab_department h','h.id_department=b.department','left');
		$this->db->where('a.nik',$nik);
		$this->db->where('a.tgl_kerja >=',$tgl1);
		$this->db->where('a.tgl_kerja <=',$tgl2);
		$this->db->group_by('a.tgl_kerja');


		$hasil = $this->db->get();
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return false;
		}
	}

	public function rekap_cabang()
	{
		$hasil = $this->db->order_by('date(jam_masuk)','desc')
						  ->get('tab_absensi_masuk');
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}



	public function date_absen($tgl1,$tgl2)
	{
		if (empty($tgl1) && empty($tgl2)) {
			$this->db->where('tgl_kerja >=',date('Y-m-01'))
					 ->where('tgl_kerja <=',date('Y-m-t'));
		} else {
			$this->db->where('tgl_kerja >=',$tgl1)
					 ->where('tgl_kerja <=',$tgl2);
		}
		$hasil = $this->db->group_by('tgl_kerja')
						  ->order_by('tgl_kerja','asc')
						  ->select('tgl_kerja as tanggal')
						  ->get('tab_absensi');
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}

	//public function rekap_absen($tgl1,$tgl2,$cabang)
	public function rekap_absen($cabang)
	{
		/*if (empty($tgl)) {
			$this->db->where('date(f.jam_masuk)',date('Y-m-d'));
		} else {
			$this->db->where('date(f.jam_masuk)',$tgl);
		}
		if (!empty($cabang)) {
			$this->db->where('c.id_cabang',$cabang);
		}
		$hasil = $this->db->join('tab_karyawan b','b.nik=f.nik')
						  ->join('tab_jabatan a','a.id_jabatan=b.jabatan')
                          ->join('tab_cabang c','c.id_cabang=b.cabang')
                          ->join('tab_department d','d.id_department=b.department')
                          ->join('tab_kontrak_kerja e','e.nik=b.nik')
                          ->get('tab_absensi_masuk f');*/

		/*if (!empty($cabang)) {
	        $hasil = $this->db->query(
	        	'
				SELECT c.id_cabang as field0, c.cabang as field1, COUNT(a.nik) as field2 
				FROM tab_absensi a 
				INNER JOIN tab_karyawan b ON b.nik=a.nik 
				INNER JOIN tab_cabang c  ON c.id_cabang=b.cabang 
				WHERE a.tgl_kerja >= "'.$tgl1.'" 
				AND a.tgl_kerja <= "'.$tgl2.'" 
				AND c.id_cabang="'.$cabang.'"
				GROUP BY c.cabang
	        	'
	        );	
		} 
		else 
		{
	        $hasil = $this->db->query(
	        	'
				SELECT c.id_cabang as field0, c.cabang as field1, COUNT(a.nik) as field2 
				FROM tab_absensi a 
				INNER JOIN tab_karyawan b ON b.nik=a.nik 
				INNER JOIN tab_cabang c  ON c.id_cabang=b.cabang 
				WHERE a.tgl_kerja >= "'.$tgl1.'" 
				AND a.tgl_kerja <= "'.$tgl2.'" 
				GROUP BY c.cabang
	        	'
	        );	
		}*/
		if (!empty($cabang)) {
	        $hasil = $this->db->query(
	        	'
				SELECT c.id_cabang as field0, c.cabang as field1, COUNT(a.nik) as field2 
				FROM tab_absensi a 
				INNER JOIN tab_karyawan b ON b.nik=a.nik 
				INNER JOIN tab_cabang c  ON c.id_cabang=b.cabang 
				AND c.id_cabang="'.$cabang.'"
				GROUP BY c.cabang
	        	'
	        );	
		} 
		else 
		{
	        $hasil = $this->db->query(
	        	'
				SELECT c.id_cabang as field0, c.cabang as field1, COUNT(a.nik) as field2 
				FROM tab_absensi a 
				INNER JOIN tab_karyawan b ON b.nik=a.nik 
				INNER JOIN tab_cabang c  ON c.id_cabang=b.cabang 
				GROUP BY c.cabang
	        	'
	        );	
		}
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}

	//public function rekap_absen_plant($bln,$thn,$cabang)
	public function rekap_absen_plant($cabang)
	{
        /*$hasil = $this->db->query(
        	'
			SELECT a.nik AS field1, b.nama_ktp AS field2, d.jabatan AS field3, e.department AS field4 
			FROM tab_absensi a 
			INNER JOIN tab_karyawan b ON b.nik=a.nik 
			INNER JOIN tab_cabang c  ON c.id_cabang=b.cabang 
			INNER JOIN tab_jabatan d ON d.id_jabatan=b.jabatan 
			INNER JOIN tab_department e ON e.id_department=b.department 
			WHERE MONTH(a.tgl_kerja)= "'.$bln.'" 
			AND YEAR(a.tgl_kerja)= "'.$thn.'" 
			AND c.id_cabang="'.$cabang.'"
			GROUP BY a.nik
        	'
        );*/
        $hasil = $this->db->query(
        	'
			SELECT a.nik AS field1, b.nama_ktp AS field2, d.jabatan AS field3, e.department AS field4 
			FROM tab_absensi a 
			INNER JOIN tab_karyawan b ON b.nik=a.nik 
			INNER JOIN tab_cabang c  ON c.id_cabang=b.cabang 
			INNER JOIN tab_jabatan d ON d.id_jabatan=b.jabatan 
			INNER JOIN tab_department e ON e.id_department=b.department 
			AND c.id_cabang="'.$cabang.'"
			GROUP BY a.nik
        	'
        );
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}

	public function rekap_absen_detail($cabang,$nik,$tgl1,$tgl2)
	{
		$this->db->select('a.*,a.id as id_absen,b.*,b.nik as nik_real,c.jabatan as jabatan_real,
				 d.cabang as cabang_real,e.*,a.kode_jam as kode_jam_real,g.*,h.department as department_real');
		$this->db->from('tab_absensi a');
		$this->db->join('tab_karyawan b','b.nik=a.nik','inner');
		$this->db->join('tab_jabatan c','c.id_jabatan=b.jabatan','inner');
		$this->db->join('tab_cabang d','d.id_cabang=b.cabang','inner');
		$this->db->join('tab_kontrak_kerja e','e.nik=b.nik','inner');
		$this->db->join('tab_jadwal_karyawan f','f.nik=a.nik','f.nik=a.nik','inner');
		$this->db->join('tab_jam_kerja g','g.kode_jam=a.kode_jam','left');
		$this->db->join('tab_department h','h.id_department=b.department','left');
		$this->db->where('a.nik',$nik);
		$this->db->where('a.tgl_kerja >=',$tgl1);
		$this->db->where('a.tgl_kerja <=',$tgl2);
		$this->db->group_by('a.tgl_kerja');
		$hasil = $this->db->get();

		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}
	
	public function delete($id){
		$this->db->where('id', $id)
				 ->delete('tab_absensi_masuk');
	}
	public function import_data($dt){
		for ($i = 1; $i < count($dt); $i++) {
	        $jam=date('H:i:s',strtotime($dt[$i]['tanggal_absen']));
	        $nik=$dt[$i]['nik'];
	        $jadwal=$this->db->join('tab_jam_kerja','tab_jam_kerja.kode_jam=tab_jadwal_karyawan.kode_jam')
	        				 ->where('nik',$nik)
	        				 ->get('tab_jadwal_karyawan')
	        				 ->row();
	        $jam_masuk="";
	        $jam_keluar="";
	        $param_jamF=$jadwal->jam_finish+"01:00:00";
	        if ($jam<=$jadwal->jam_start || $jam>$jadwal->jam_start && $jam<$jadwal->jam_finish) {
	        	$jam_masuk=$jam;
	        } else if ($jam>=$jadwal->jam_finish && $jam<$param_jamF) {
	        	$jam_keluar=$jam;
	        }
	        $data = array(
	              'nik' => $dt[$i]['nik'],
				  'kode_jam' =>$dt[$i]['tanggal_selesai'],
				  'jam_masuk' =>$dt[$i]['cuti_khusus'],
				  'jam_keluar' =>$dt[$i]['keterangan'],
				  'hari' =>$dt[$i]['lama'],
				 );
		     //$this->db->insert('tab_absensi',$data);
	        return $jam_masuk;
		}
	}

	public function hitung_karyawan($cb){
		if (!empty($cb)) {
			$this->db->where('cabang',$cb);
		}
		$hasil=$this->db->get('tab_karyawan')->num_rows();

		return $hasil;
	}
	public function hitung_masuk($tgl,$cb){
		if (!empty($cb)) {
			$this->db->where('b.cabang',$cb);
		}
		$hasil=$this->db->join('tab_karyawan b','b.nik=a.nik')
						->where('tgl_kerja',$tgl)
						->get('tab_absensi a')->num_rows();

		return $hasil;
	}
	public function hitung_cuti($tgl,$cb){
		if (!empty($cb)) {
			$this->db->where('b.cabang',$cb);
		}
		$hasil=$this->db->join('tab_karyawan b','b.nik=a.nik')
						->where('a.tanggal_mulai >=',$tgl)
						->where('a.tanggal_finish <=',$tgl)
						->get('tab_cuti a')->num_rows();

		return $hasil;
	}

	public function hitung_izin($tgl,$cb){
		if (!empty($cb)) {
			$this->db->where('b.cabang',$cb);
		}
		$hasil=$this->db->join('tab_karyawan b','b.nik=a.nik')
						->where('a.tanggal_mulai >=',$tgl)
						->where('a.tanggal_finish <=',$tgl)
						->where('a.jenis_izin','Tidak Dapat Masuk')
						->get('tab_izin a')->num_rows();

		return $hasil;
	}

	public function add($data1,$data2)
	{
		$this->db->insert('tab_absensi_masuk',$data1);
		$this->db->insert('tab_absensi_keluar',$data2);
	}

	public function find($id){
		/*$hasil = $this->db->join('tab_absensi_keluar b', 'a.nik=b.nik')
						  ->where('(date(a.jam_masuk)=date(b.jam_keluar))',null)
						  ->limit(1)
						  ->get('tab_absensi_masuk a');*/
		$hasil = $this->db->where('id',$id)
						  ->get('tab_absensi');
		if($hasil->num_rows() > 0){
			return $hasil->row();
		} else {
			return array();
		}
	}

	public function update($id,$data1,$data2)
	{
		$this->db->where('id',$id)->update('tab_absensi_masuk',$data1);
		$this->db->where('nik',$data1['nik'])->where('date(jam_keluar)',date('Y-m-d',strtotime($data1['jam_masuk'])))->update('tab_absensi_keluar',$data2);
	}

	function get_employe ($cabang){
		if (!empty($cabang)) {
			$this->db->where('c.id_cabang',$cabang);
		}
        $baca = $this->db->join('tab_jabatan a','a.id_jabatan=b.jabatan')
                         ->join('tab_cabang c','c.id_cabang=b.cabang')
                         ->join('tab_department d','d.id_department=b.department')
                         ->join('tab_kontrak_kerja e','e.nik=b.nik')
                         ->get('tab_karyawan b');
        if($baca->num_rows() > 0){
            return $baca->result();
        }else{
            return array();
        }
    }
}