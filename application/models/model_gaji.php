<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_gaji extends CI_Model {

  // tampilkan rekap gaji per cabang
  public function index()
  {
    $hasil = $this->db->join('tab_cabang','tab_cabang.id_cabang=tab_karyawan.cabang')
                //->join('tab_pph','tab_karyawan.nik=tab_pph.nik')
                ->join('tab_pph_new','tab_karyawan.nik=tab_pph_new.nik')
                ->join('tab_kontrak_kerja','tab_kontrak_kerja.nik=tab_karyawan.nik')
                ->not_like('tab_kontrak_kerja.status_kerja','casual')
                //->select("*,sum(tab_kontrak_kerja.gaji_pokok) as gaji,count(tab_pph.nik) as jml_karyawan,sum(tab_pph.jml_pph) as total_pph,sum(tunjangan_jabatan) as tot_tunjangan",false)
                ->select("*,sum(tab_kontrak_kerja.gaji_pokok) as gaji,count(tab_pph_new.nik) as jml_karyawan,sum(tab_pph_new.jml_pph) as total_pph,sum(tunjangan_jabatan) as tot_tunjangan",false)
                ->group_by('tab_karyawan.cabang')
                ->get('tab_karyawan');
    if($hasil->num_rows() > 0){
      return $hasil->result();
    } else {
      return array();
    }
  }

  public function indexnew($bln,$thn)
  {
    $hasil = $this->db->query(
      '
      SELECT c.id_cabang, c.cabang, COUNT(a.nik) AS field1, SUM(a.gaji_karyawan) AS field2, 
      SUM(a.tunjangan_jabatan) AS field3, SUM(a.gaji_ekstra) AS field4, SUM(a.potongan_cuti) AS field5, 
      SUM(a.pinjaman) AS field6, SUM(a.pph21) AS field7, SUM(a.bea_jht) AS field8, SUM(a.bea_jpk) AS field9, 
      SUM(a.gaji_diterima) AS field10, a.potongan_bpjs_id as field11, a.potongan_bpjs_id_detail as field12, a.potongan_bpjs as field13, SUM(a.total_potongan_bpjs) as field14 
      FROM tab_gaji_karyawan_new a 
      INNER JOIN tab_karyawan b ON b.nik=a.nik  
      LEFT JOIN tab_cabang c ON c.id_cabang=b.cabang 
      WHERE MONTH(a.tanggal_gaji)="'.date($bln).'" 
      AND YEAR(a.tanggal_gaji)="'.date($thn).'"  
      GROUP BY c.cabang
      '
    );
    if($hasil->num_rows() > 0){
      return $hasil->result();
    } else {
      return array();
    }
  }

  public function indexnew2($bln,$thn)
  {
    $hasil = $this->db->query(
      '
      SELECT c.id_cabang, c.cabang, COUNT(a.nik) AS field1, SUM(a.gaji_karyawan) AS field2, 
      SUM(a.tunjangan_jabatan) AS field3, SUM(a.gaji_ekstra) AS field4, SUM(a.potongan_cuti) AS field5, 
      SUM(a.pinjaman) AS field6, SUM(a.pph21) AS field7, SUM(a.bea_jht) AS field8, SUM(a.bea_jpk) AS field9, 
      SUM(a.gaji_diterima) AS field10, a.approval AS field11 , SUM(a.total_potongan_bpjs) as field12 
      FROM tab_gaji_karyawan_new a
      INNER JOIN tab_karyawan b ON b.nik=a.nik  
      LEFT JOIN tab_cabang c ON c.id_cabang=b.cabang 
      WHERE MONTH(a.tanggal_gaji)="'.date($bln).'" 
      AND YEAR(a.tanggal_gaji)="'.date($thn).'" and approval != 2
      GROUP BY c.cabang
      '
    );
    if($hasil->num_rows() > 0){
      return $hasil->result();
    } else {
      return array();
    }
  }

  // ketika button detail diklik
  public function detail_gaji($id_cabang,$bln,$thn) {
    /*$hasil = $this->db->join('tab_cabang','tab_cabang.id_cabang=tab_karyawan.cabang')
                ->join('tab_pph','tab_karyawan.nik=tab_pph.nik','left')
                ->join('tab_jabatan','tab_jabatan.id_jabatan=tab_karyawan.jabatan')
                ->join('tab_department','tab_department.id_department=tab_karyawan.department')
                ->join('tab_kontrak_kerja','tab_kontrak_kerja.nik=tab_karyawan.nik')
                ->join('tab_gaji_karyawan','tab_gaji_karyawan.nik=tab_karyawan.nik','left')
                ->where('month(tab_pph.entry_date)',date('m'))
                ->where('tab_karyawan.cabang',$id_cabang)
                ->not_like('tab_kontrak_kerja.status_kerja','Casual')
                ->select('*,tab_karyawan.nik as nik_karyawan')
                ->get('tab_karyawan');*/
    $hasil = $this->db->query(
      '
      SELECT a.id_gaji_karyawan, c.id_cabang, c.cabang, a.nik AS field1, b.nama_ktp AS field2, 
      d.jabatan AS field3, e.department AS field4, a.gaji_bpjs AS field5, 
      a.gaji_karyawan AS field6, a.tunjangan_jabatan AS field7, 
      a.gaji_ekstra AS field8, a.potongan_cuti AS field9, 
      a.pinjaman AS field10, a.pph21 AS field11, a.bea_jht AS field12, 
      a.bea_jpk AS field13, a.gaji_diterima AS field14, a.approval AS field15, 
      a.keterangan AS field16, a.potongan_bpjs_id as field17, a.potongan_bpjs_id_detail as field18, a.potongan_bpjs as field19 
      FROM tab_gaji_karyawan_new a
      INNER JOIN tab_karyawan b ON b.nik=a.nik  
      LEFT JOIN tab_cabang c ON c.id_cabang=b.cabang 
      LEFT JOIN tab_jabatan d ON d.id_jabatan=b.jabatan 
      LEFT JOIN tab_department e ON e.id_department=b.department 
      WHERE c.id_cabang='.$id_cabang.'
      AND MONTH(a.tanggal_gaji)="'.date($bln).'" 
      AND YEAR(a.tanggal_gaji)="'.date($thn).'" 
      ORDER BY b.nama_ktp 
      '
    );
    if($hasil->num_rows() > 0){
      return $hasil->result();
    } else {
      return array();
    }
  }

  public function detail_gaji_rekap($id_cabang,$bln,$thn) {
    $hasil = $this->db->query(
      '
      SELECT a.id_gaji_karyawan, c.id_cabang, c.cabang, a.nik AS field1, b.nama_ktp AS field2, 
      d.jabatan AS field3, e.department AS field4, a.gaji_bpjs AS field5, 
      a.gaji_karyawan AS field6, a.tunjangan_jabatan AS field7, 
      a.gaji_ekstra AS field8, a.potongan_cuti AS field9, 
      a.pinjaman AS field10, a.pph21 AS field11, a.bea_jht AS field12, 
      a.bea_jpk AS field13, a.gaji_diterima AS field14, a.approval AS field15, 
      a.keterangan AS field16, a.potongan_bpjs_id as field17, a.potongan_bpjs_id_detail as field18, a.potongan_bpjs as field19  
      FROM tab_gaji_karyawan_new a
      INNER JOIN tab_karyawan b ON b.nik=a.nik  
      LEFT JOIN tab_cabang c ON c.id_cabang=b.cabang 
      INNER JOIN tab_jabatan d ON d.id_jabatan=b.jabatan 
      INNER JOIN tab_department e ON e.id_department=b.department 
      WHERE c.id_cabang='.$id_cabang.' 
      AND MONTH(a.tanggal_gaji)="'.$bln.'"
      AND YEAR(a.tanggal_gaji)="'.$thn.'" 
      ORDER BY b.nama_ktp 
      '
    );
    if($hasil->num_rows() > 0){
      return $hasil->result();
    } else {
      return array();
    }
  }

  public function detail_gaji_resign($bln,$thn) {
    $hasil = $this->db->query(
      '
      SELECT a.id_gaji_karyawan, c.id_cabang, c.cabang, a.id_gaji_karyawan, a.nik AS field1, 
      b.nama_ktp AS field2, d.jabatan AS field3, e.department AS field4, a.gaji_bpjs AS field5, 
      a.gaji_karyawan AS field6, a.tunjangan_jabatan AS field7, 
      a.gaji_ekstra AS field8, a.potongan_cuti AS field9, 
      a.pinjaman AS field10, a.pph21 AS field11, a.bea_jht AS field12, 
      a.bea_jpk AS field13, a.gaji_diterima AS field14, a.approval AS field15, 
      a.keterangan AS field16, a.tambahan_cuti AS field17 
      FROM tab_gaji_karyawan_resign a
      INNER JOIN tab_karyawan b ON b.nik=a.nik  
      LEFT JOIN tab_cabang c ON c.id_cabang=b.cabang 
      INNER JOIN tab_jabatan d ON d.id_jabatan=b.jabatan 
      INNER JOIN tab_department e ON e.id_department=b.department 
      WHERE MONTH(a.tanggal_gaji)="'.$bln.'" 
      AND YEAR(a.tanggal_gaji)="'.$thn.'"
      '
    );
    if($hasil->num_rows() > 0){
      return $hasil->result();
    } else {
      return array();
    }
  }

  public function detail_gaji_casual($id_cabang,$bln,$thn)
  {
    $hasil = $this->db->query(
      '
      SELECT 
        c.id_cabang, 
        c.cabang, 
        a.nik AS nik, 
        b.nama_ktp AS nama_ktp, 
        f.status_kerja as status_kerja, 
        if(g.no_npwp is not null, no_npwp, "-") as no_npwp,
        b.alamat_ktp AS alamat_ktp, 
        h.pajak as pajak,
        b.nama_rekening as nama_rekening,
        b.no_rekening as no_rekening,
        a.gaji_casual as gaji_casual,
        a.jml_hadir1 as jml_hadir,
        a.uang_makan_real as uang_makan_real,
        a.gaji_ekstra_1 as gaji_ekstra,
        a.pph21_1 as pph, 
        a.gaji_diterima_1 as gaji_diterima,
        a.jml_hadir2 as jml_hadir2,
        a.gaji_ekstra_2 as gaji_ekstra2,
        a.pph21_2 as pph2, 
        a.gaji_diterima_2 as gaji_diterima2,
        a.approval as approval
      FROM tab_gaji_casual_new a 
      LEFT JOIN tab_karyawan b ON b.nik=a.nik 
      LEFT JOIN tab_cabang c ON c.id_cabang=b.cabang 
      LEFT JOIN tab_jabatan d ON d.id_jabatan=b.jabatan 
      LEFT JOIN tab_department e ON e.id_department=b.department 
      LEFT JOIN tab_kontrak_kerja f ON f.nik=b.nik 
      LEFT JOIN tab_npwp g ON g.nik=b.nik 
      LEFT JOIN tab_pajak h ON h.id_pajak=b.status_pajak 
      WHERE c.id_cabang='.$id_cabang.' 
      AND MONTH(a.tanggal_gaji_1)="'.date($bln).'" 
      AND MONTH(a.tanggal_gaji_2)="'.date($bln).'" 
      AND YEAR(a.tanggal_gaji_1)="'.date($thn).'" 
      AND YEAR(a.tanggal_gaji_2)="'.date($thn).'" 
      '
    );
    if($hasil->num_rows() > 0){
      return $hasil->result();
    } else {
      return array();
    }
  }

  public function count_absen_casual($nik,$date)
  {
    $hasil = $this->db->query(
      '
      SELECT * 
      FROM tab_absensi 
      WHERE nik='.$nik.' 
      AND tgl_kerja>="'.date('Y-m-01',strtotime($date)).'" 
      AND tgl_kerja<="'.date('Y-m-d',strtotime($date)).'" 
      '
    );
    if($hasil->num_rows() > 0){
      return $hasil->result();
    } else {
      return array();
    }
  }

  public function count_absen_casual2($nik,$date)
  {
    $hasil = $this->db->query(
      '
      SELECT * 
      FROM tab_absensi 
      WHERE nik='.$nik.' 
      AND tgl_kerja>="'.date('Y-m-16',strtotime($date)).'" 
      AND tgl_kerja<="'.date('Y-m-d',strtotime($date)).'" 
      '
    );
    if($hasil->num_rows() > 0){
      return $hasil->result();
    } else {
      return array();
    }
  }

  public function indexcasualnew($bln,$thn)
  {
    $hasil = $this->db->query(
      '
      SELECT 
        c.id_cabang, 
        c.cabang, 
        COUNT(a.nik) AS jml, 
        SUM(a.gaji_casual) AS gaji_netto, 
        SUM(a.uang_makan_real) AS uang_makan_real, 
        SUM(a.gaji_casual) + SUM(a.uang_makan_real) as t_gaji, 
        SUM(a.gaji_ekstra_1) AS ekstra, 
        (SUM(a.gaji_casual) + SUM(a.uang_makan_real)) + SUM(a.gaji_ekstra_1) as t_gaji_bruto, 
        SUM(a.uang_makan) AS uang_makan,
        SUM(a.pph21_1) AS pph, 
        SUM(a.gaji_diterima_1) AS t_gaji_terima, 
        SUM(a.gaji_casual) AS gaji_netto2, 
        SUM(a.uang_makan_real) AS uang_makan_real2, 
        SUM(a.gaji_casual) + SUM(a.uang_makan_real) as t_gaji2, 
        SUM(a.gaji_ekstra_2) AS ekstra2, 
        (SUM(a.gaji_casual) + SUM(a.uang_makan_real)) + SUM(a.gaji_ekstra_2) as t_gaji_bruto2, 
        SUM(a.uang_makan) AS uang_makan2,
        SUM(a.pph21_2) AS pph2, 
        SUM(a.gaji_diterima_2) AS t_gaji_terima2, 
        a.approval AS approval 
      FROM tab_gaji_casual_new a 
      INNER JOIN tab_karyawan b ON b.nik=a.nik 
      LEFT JOIN tab_cabang c ON c.id_cabang=b.cabang 
      WHERE MONTH(a.tanggal_gaji_1)="'.date($bln).'" 
      AND MONTH(a.tanggal_gaji_2)="'.date($bln).'" 
      AND YEAR(a.tanggal_gaji_1)="'.date($thn).'" 
      AND YEAR(a.tanggal_gaji_2)="'.date($thn).'" 
      GROUP BY c.cabang
      '
    );
    if($hasil->num_rows() > 0){
      return $hasil->result();
    } else {
      return array();
    }
  }

  public function gaji_casual() {
    $hasil = $this->db->join('tab_cabang','tab_cabang.id_cabang=tab_karyawan.cabang')
                      ->join('tab_jabatan','tab_jabatan.id_jabatan=tab_karyawan.jabatan')
                      ->join('tab_department','tab_department.id_department=tab_karyawan.department')
                      ->join('tab_kontrak_kerja','tab_kontrak_kerja.nik=tab_karyawan.nik')
                      ->like('tab_kontrak_kerja.status_kerja','Casual')
                      ->select('*,tab_karyawan.nik as nik_karyawan')
                      ->get('tab_karyawan');
    if($hasil->num_rows() > 0){
      return $hasil->result();
    } else {
      return array();
    }
  }

  public function rekap_casual($bln,$thn)
  {
    $hasil = $this->db->query(
      '
      SELECT 
        c.id_cabang, 
        c.cabang, 
        COUNT(a.nik) AS jml, 
        SUM(a.gaji_casual) AS gaji_netto, 
        SUM(a.uang_makan_real) AS uang_makan_real, 
        SUM(a.gaji_casual) + SUM(a.uang_makan_real) as t_gaji, 
        SUM(a.gaji_ekstra_1) AS ekstra, 
        (SUM(a.gaji_casual) + SUM(a.uang_makan_real)) + SUM(a.gaji_ekstra_1) as t_gaji_bruto, 
        SUM(a.uang_makan) AS uang_makan,
        SUM(a.pph21_1) AS pph, 
        SUM(a.gaji_diterima_1) AS t_gaji_terima, 
        SUM(a.gaji_casual) AS gaji_netto2, 
        SUM(a.uang_makan_real) AS uang_makan_real2, 
        SUM(a.gaji_casual) + SUM(a.uang_makan_real) as t_gaji2, 
        SUM(a.gaji_ekstra_2) AS ekstra2, 
        (SUM(a.gaji_casual) + SUM(a.uang_makan_real)) + SUM(a.gaji_ekstra_2) as t_gaji_bruto2, 
        SUM(a.uang_makan) AS uang_makan2,
        SUM(a.pph21_2) AS pph2, 
        SUM(a.gaji_diterima_2) AS t_gaji_terima2, 
        a.approval AS field10 
      FROM tab_gaji_casual_new a 
      INNER JOIN tab_karyawan b ON b.nik=a.nik 
      LEFT JOIN tab_cabang c ON c.id_cabang=b.cabang 
      WHERE MONTH(a.tanggal_gaji_1)="'.$bln.'" 
      AND MONTH(a.tanggal_gaji_2)="'.$bln.'" 
      AND YEAR(a.tanggal_gaji_1)="'.$thn.'" 
      AND YEAR(a.tanggal_gaji_2)="'.$thn.'" 
      GROUP BY c.cabang
      '
    );
    if($hasil->num_rows() > 0){
      return $hasil->result();
    } else {
      return array();
    }
  }

  public function detail_gaji_casual_rekap($bln,$thn,$id_cabang)
  {
    $hasil = $this->db->query(
      '
      SELECT 
        c.id_cabang, 
        c.cabang, 
        a.nik AS nik, 
        b.nama_ktp AS nama_ktp, 
        f.status_kerja as status_kerja, 
        if(g.no_npwp is not null, no_npwp, "-") as no_npwp,
        b.alamat_ktp AS alamat_ktp, 
        h.pajak as pajak,
        b.nama_rekening as nama_rekening,
        b.no_rekening as no_rekening,
        a.gaji_casual as gaji_casual,
        a.jml_hadir1 as jml_hadir,
        a.uang_makan_real as uang_makan_real,
        a.gaji_ekstra_1 as gaji_ekstra,
        a.pph21_1 as pph, 
        a.gaji_diterima_1 as gaji_diterima,
        a.jml_hadir2 as jml_hadir2,
        a.gaji_ekstra_2 as gaji_ekstra2,
        a.pph21_2 as pph2, 
        a.gaji_diterima_2 as gaji_diterima2,
        a.approval as approval
      FROM tab_gaji_casual_new a 
      LEFT JOIN tab_karyawan b ON b.nik=a.nik 
      LEFT JOIN tab_cabang c ON c.id_cabang=b.cabang 
      LEFT JOIN tab_jabatan d ON d.id_jabatan=b.jabatan 
      LEFT JOIN tab_department e ON e.id_department=b.department 
      LEFT JOIN tab_kontrak_kerja f ON f.nik=b.nik 
      LEFT JOIN tab_npwp g ON g.nik=b.nik 
      LEFT JOIN tab_pajak h ON h.id_pajak=b.status_pajak 
      WHERE c.id_cabang="'.$id_cabang.'" 
      AND MONTH(a.tanggal_gaji_1)="'.$bln.'" 
      AND MONTH(a.tanggal_gaji_2)="'.$bln.'" 
      AND YEAR(a.tanggal_gaji_1)="'.$thn.'" 
      AND YEAR(a.tanggal_gaji_2)="'.$thn.'" 
      '
    );
    if($hasil->num_rows() > 0){
      return $hasil->result();
    } else {
      return array();
    }
  }

	//public function rekap_gaji($tgl1,$tgl2) {
  public function rekap_gaji($bln) {
		/*if (!empty($tgl1) && !empty($tgl2)) {
			$this->db->where("(tab_gaji_karyawan.tanggal_gaji between '".$tgl1."' and '".$tgl2."')",null);
		}
		$hasil = $this->db->join('tab_cabang','tab_cabang.id_cabang=tab_karyawan.cabang')
					      ->join('tab_pph','tab_karyawan.nik=tab_pph.nik','left')
					      ->join('tab_jabatan','tab_jabatan.id_jabatan=tab_karyawan.jabatan')
					      ->join('tab_department','tab_department.id_department=tab_karyawan.department')
					      ->join('tab_kontrak_kerja','tab_kontrak_kerja.nik=tab_karyawan.nik')
					      ->join('tab_gaji_karyawan','tab_gaji_karyawan.nik=tab_karyawan.nik')
                ->not_like('tab_kontrak_kerja.status_kerja','Casual')
					      ->select('*,tab_karyawan.nik as nik_karyawan')
					      ->order_by('tab_gaji_karyawan.tanggal_gaji','desc')
					      ->get('tab_karyawan');*/
    
    $hasil = $this->db->query(
      '
      SELECT c.id_cabang, c.cabang, COUNT(a.nik) AS field1, SUM(a.gaji_karyawan) AS field2, 
      SUM(a.tunjangan_jabatan) AS field3, SUM(a.gaji_ekstra) AS field4, SUM(a.potongan_cuti) AS field5, 
      SUM(a.pinjaman) AS field6, SUM(a.pph21) AS field7, SUM(a.bea_jht) AS field8, SUM(a.bea_jpk) AS field9, 
      SUM(a.gaji_diterima) AS field10, SUM(a.total_potongan_bpjs) as field11  
      FROM tab_gaji_karyawan_new a
      INNER JOIN tab_karyawan b ON b.nik=a.nik  
      LEFT JOIN tab_cabang c ON c.id_cabang=b.cabang 
      WHERE MONTH(a.tanggal_gaji)="'.$bln.'"
      GROUP BY c.cabang
      '
    );
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}

	public function import_data($dt){
		for ($i = 0; $i < count($dt); $i++) {
	        $data = array(
	              /*'nik' => $dt[$i]['nik'],
      				  'biaya_jabatan' =>$dt[$i]['biaya_jabatan'],
      				  'ptkp' =>$dt[$i]['ptkp'],
      				  'jht' =>$dt[$i]['jht'],
      				  'pkp' =>$dt[$i]['pkp'],
      				  'pkp_real' =>$dt[$i]['pkp_real'],
      				  'pkp_real_tahunan' =>$dt[$i]['pkp_real_tahunan'],
      				  'pph_21_tahunan' =>$dt[$i]['pph21_tahunan'],
      				  'pph_21_bulanan' =>$dt[$i]['pph21_bulanan'],
      				  'pph_program' =>$dt[$i]['pph21_program'],
      				  'jml_pph' =>$dt[$i]['jml_pph'],
      				  'entry_user' => $this->session->userdata('username')*/
                'nik'     => $dt[$i]['nik'],
                'tgl_pph' => $dt[$i]['tgl_pph'],
                'jml_pph' => $dt[$i]['jml_pph']
      				 );
	        /*$cek=$this->db->where('nik',$dt[$i]['nik'])
	        			  ->where('month(entry_date)',date('m'))
	        			  ->get('tab_pph')
	        			  ->num_rows();*/
          $cek=$this->db->where('nik',$dt[$i]['nik'])
                  ->where('month(tgl_pph)',date('m'))
                  ->get('tab_pph_new')
                  ->num_rows();
	        if ($cek>=1) {
	        	$pesan['gagal'][]=$dt[$i]['nik'];
	        }else {
				//$this->db->insert('tab_pph',$data);
            $this->db->insert('tab_pph_new',$data);
	        	$pesan['berhasil'][]=$dt[$i]['nik'];
			}
		}
		return $pesan;
	}

	public function rincian_gaji_cabang($id,$jml_hari){
		$ekstra=$this->db->join('tab_karyawan a','a.nik=b.nik')
                     ->where('a.cabang',$id)
                     ->where('(Year(b.entry_date)=year(now()))',null)
                     ->where('(month(b.entry_date)=month(now()))',null)
                     ->where('b.vakasi','Dibayar')
                     ->or_where('b.vakasi','Ekstra Lain')
                     ->where('b.approved','Ya')
                     ->select('sum(jumlah_vakasi) as total_vakasi')
                     ->get('tab_extra b')->row();
    $cuti=$this->db->join('tab_karyawan a','a.nik=b.nik')
                   ->join('tab_kontrak_kerja c','c.nik=a.nik')
                   ->where('a.cabang',$id)
                   ->where('(month(b.entry_date)=month(now()))',null)
                   ->where('(Year(b.entry_date)=year(now()))',null)
                   ->where('b.saldo_cuti < ',0)
                   ->select("sum((c.gaji_pokok/$jml_hari)*b.saldo_cuti) as total_cuti",false)
                   ->get('tab_master_dp b')
                   ->row();
    $pinjaman=$this->db->join('tab_karyawan a','a.nik=b.nik')
                       ->select('sum(b.jml_pinjam) as total_pinjam')
                       ->where('a.cabang',$id)
                       ->where('month(b.tanggal_pinjam)',date('m'))
                       ->get('tab_pinjaman b')->row();
    $jpk_val=$this->db->join('tab_bpjs_karyawan a','a.nik=c.nik')
                      ->join('tab_master_bpjs b','b.id_bpjs=a.id_bpjs')
                      //->join('tab_pph d','d.nik=c.nik')
                      ->join('tab_pph_new d','d.nik=c.nik')
                      //->where('(month(d.entry_date)=month(now()))',null)
                  	  //->where('(Year(d.entry_date)=year(now()))',null)
                      ->where('(month(d.tgl_pph)=month(now()))',null)
                      ->where('(Year(d.tgl_pph)=year(now()))',null)
                      ->where('b.id_bpjs',2)
                      ->where('c.cabang',$id)
                      ->where('a.no_bpjs !=','')
                      ->select('count(a.nik) as emp_jpk,b.jpk_2')
                      ->get('tab_karyawan c')
                      ->row();
    $jht_val=$this->db->join('tab_bpjs_karyawan a','a.nik=c.nik')
                      ->join('tab_master_bpjs b','b.id_bpjs=a.id_bpjs')
                      //->join('tab_pph d','d.nik=c.nik')
                      ->join('tab_pph_new d','d.nik=c.nik')
                      //->where('(month(d.entry_date)=month(now()))',null)
                      //->where('(Year(d.entry_date)=year(now()))',null)
                      ->where('(month(d.tgl_pph)=month(now()))',null)
                      ->where('(Year(d.tgl_pph)=year(now()))',null)
                  	  ->where('b.id_bpjs',1)
                      ->where('c.cabang',$id)
                      ->where('a.no_bpjs !=','')
                      ->select('count(a.nik) as emp_jpk,b.jht_2')
                      ->get('tab_karyawan c')
                      ->row();
    $data= array(
              "ekstra" => $ekstra->total_vakasi,
              "cuti" => $cuti->total_cuti,
              "pinjaman" => $pinjaman->total_pinjam,
              "karyawan_jpk"   => $jpk_val->emp_jpk,
              "karyawan_jht"   => $jht_val->emp_jpk,
              "jpk"   => $jpk_val->jpk_2,
              "jht"   => $jht_val->jht_2,
          );
    return $data;
	}

	public function rincian_gaji_karyawan($nik,$jml_hari){
	$ekstra=$this->db->join('tab_karyawan a','a.nik=b.nik')
                     ->where('a.nik',$id)
                     ->where('(Year(b.entry_date)=year(now()))',null)
                     ->where('(month(b.entry_date)=month(now()))',null)
                     ->where('b.vakasi','Dibayar')
                     ->or_where('b.vakasi','Ekstra Lain')
                     ->where('b.approved','Ya')
                     ->select('sum(jumlah_vakasi) as total_vakasi')
                     ->get('tab_extra b')->row();
    $cuti=$this->db->join('tab_karyawan a','a.nik=b.nik')
                   ->join('tab_kontrak_kerja c','c.nik=a.nik')
                   ->where('a.nik',$nik)
                   ->where('(month(b.entry_date)=month(now()))',null)
                   ->where('(Year(b.entry_date)=year(now()))',null)
                   ->where('b.saldo_cuti < ',0)
                   ->select("sum((c.gaji_pokok/$jml_hari)*b.saldo_cuti) as total_cuti",false)
                   ->get('tab_master_dp b')
                   ->row();
    $pinjaman=$this->db->join('tab_karyawan a','a.nik=b.nik')
                       ->select('sum(b.jml_pinjam) as total_pinjam')
                       ->where('a.nik',$nik)
                       ->where('month(b.tanggal_pinjam)',date('m'))
                       ->get('tab_pinjaman b')->row();
    $jpk_val=$this->db->join('tab_master_bpjs b','b.id_bpjs=a.id_bpjs')
                      ->where('b.id_bpjs',2)
                      ->where('a.nik',$nik)
                      ->where('a.no_bpjs !=','')
                      ->select('b.jpk_2')
                      ->get('tab_bpjs_karyawan a')
                      ->row();
    $jht_val=$this->db->join('tab_master_bpjs b','b.id_bpjs=a.id_bpjs')
                      ->where('b.id_bpjs',1)
                      ->where('a.nik',$nik)
                      ->where('a.no_bpjs !=','')
                      ->select('b.jht_2')
                      ->get('tab_bpjs_karyawan a')
                      ->row();
    $data= array(
              "ekstra" => $ekstra->total_vakasi,
              "cuti" => $cuti->total_cuti,
              "pinjaman" => $pinjaman->total_pinjam,
              "karyawan_jpk"   => $jpk_val->emp_jpk,
              "karyawan_jht"   => $jht_val->emp_jpk,
              "jpk"   => $jpk_val->jpk_2,
              "jht"   => $jht_val->jht_2,
          );
    return $data;
	}

  public function keterangan_casual($nik){
   $masuk1=$this->db->where('date(jam_masuk)>=',date('Y-m-01'))
                    ->where('date(jam_masuk)<=',date('Y-m-15'))
                    ->where('nik',$nik)
                    ->select('count(nik) as jml_1')
                    ->group_by('date(jam_masuk)')
                    ->get('tab_absensi_masuk')->row();
    $masuk2=$this->db->where('date(jam_masuk)>=',date('Y-m-16'))
                    ->where('date(jam_masuk)<=',date('Y-m-t'))
                    ->where('nik',$nik)
                    ->select('count(nik) as jml_2')
                    ->group_by('date(jam_masuk)')
                    ->get('tab_absensi_masuk')->row();
    $gaji=$this->db->where('nik',$nik)->get('tab_kontrak_kerja')->row();
    $jml_gaji1=($gaji->gaji_casual+$gaji->uang_makan)*$masuk1->jml_1;
    $jml_gaji2=($gaji->gaji_casual+$gaji->uang_makan)*$masuk1->jml_2;
    $data= array(
              "masuk1"   => $masuk1->jml_1,
              "masuk2"   => $masuk2->jml_2,
              "gaji_1"   => $jml_gaji1,
              "gaji_2"   => $jml_gaji2
          );
    return $data; 
  }

  public function get_casual()
  {
    $hasil=$this->db->join('tab_kontrak_kerja b','b.nik=a.nik')
                    ->join('tab_jabatan c','c.id_jabatan=a.jabatan')
                    ->join('tab_cabang d','d.id_cabang=a.cabang')
                    ->where('a.nik !=','null')
                    ->like('b.status_kerja','casual')
                    ->get('tab_karyawan a');
    if ($hasil->num_rows() >= 1) {
      return $hasil->result();
    }else{
      return array();
    }
  }

  public function input_pph($data)
  {
    $cek=$this->db->where('nik',$data['nik'])
                  ->where('month(tgl_pph)',date('m',strtotime($data['tgl_pph'])))
                  ->get('pph_casual')->num_rows();
    if ($cek>=1) {
      $this->db->where('nik',$data['nik'])
               ->where('month(tgl_pph)',date('m',strtotime($data['tgl_pph'])))
               ->update('pph_casual',$data);
    }else{
      $this->db->insert('pph_casual',$data);
    }
  }
}