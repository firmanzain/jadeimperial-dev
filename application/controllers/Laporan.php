<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporan extends CI_Controller {
  public function __construct(){
    parent::__construct();
      $this->auth->restrict();
    $this->load->helper('timezone');
    $this->load->model('model_resign');
    $this->load->library('PHPExcel');
    $this->load->library('PHPExcel/IOFactory');
    $this->load->library('mpdf');
  }
  
    public function bpjs()
    {
      $data['cabang']=$this->db->get('tab_cabang')->result();
      $data['halaman']=$this->load->view('laporan/rekap_bpjs_page',$data,true);
      $this->load->view('beranda',$data);
    }
/*
     public function bpjs_print()
    {
      $jenis=$this->input->post('jenis');
      $data['bulan']=$this->format->BulanIndo($this->input->post('bulan'));
      $data['tahun']=$this->input->post('tahun');
      if (!empty($this->input->post('cabang'))) {
          $cabang="(tab_cabang.id_cabang='".$this->input->post('cabang')."')";
      }else{
          $cabang="(tab_cabang.id_cabang != '')";
      }
      $data['data']=$this->db->join('tab_kontrak_kerja','tab_kontrak_kerja.nik=tab_karyawan.nik')
                             ->join('tab_bpjs_karyawan','tab_bpjs_karyawan.nik=tab_karyawan.nik')
                             ->join('tab_cabang','tab_cabang.id_cabang=tab_karyawan.cabang')
                             ->where('tab_bpjs_karyawan.id_bpjs',$jenis)
                             ->where('tab_bpjs_karyawan.no_bpjs != ','')
                             ->where($cabang,null)
                             ->where('tab_kontrak_kerja.tanggal_resign','0000-00-00')
                             ->get('tab_karyawan')
                             ->result();
      $data['jumlah_karyawan']=$this->db->select('gaji_bpjs,count(tab_karyawan.nik) as jml_emp')
                                        ->join('tab_kontrak_kerja','tab_kontrak_kerja.nik=tab_karyawan.nik')
                                        ->join('tab_cabang','tab_cabang.id_cabang=tab_karyawan.cabang')
                                        ->where('tab_bpjs_karyawan.id_bpjs',$jenis)
                                        ->join('tab_bpjs_karyawan','tab_bpjs_karyawan.nik=tab_karyawan.nik')
                                        ->where($cabang,null)
                                        ->where('tab_bpjs_karyawan.no_bpjs != ','')
                                        ->where('tab_karyawan.gaji_bpjs != ',0)
                                        ->where('tab_kontrak_kerja.tanggal_resign','0000-00-00')
                                        ->group_by('tab_karyawan.gaji_bpjs')->get('tab_karyawan')->result();
      $data['cabang']=$this->db->where('id_cabang',$this->input->post('cabang'))->get('tab_cabang')->row();
      if ($jenis==1) {
        $html1=$this->load->view('laporan/iuran_jamsostek',$data,true);
        $html2=$this->load->view('laporan/rekap_bpjs_print',$data,true);
      }else{
        $html1=$this->load->view('laporan/iuran_bpjs_kesehatan',$data,true);
        $html2=$this->load->view('laporan/rekap_bpjs_kesehatan',$data,true);
      }
          $this->mpdf=new mPDF();
          $this->mpdf->addPage('P','utf-8', 'A4', 11, 'arial','5','5','5','5');
          $this->mpdf->WriteHTML($html1);
          $this->mpdf->addPage('L','utf-8', 'A4', 11, 'arial','5','5','5','5','on');
          $this->mpdf->WriteHTML($html2);
          $name='HRD'.time().'.pdf';
          $this->mpdf->Output();
          exit();
    }
*/
    public function bpjs_print_new()
    {
      error_reporting(E_ALL);
      $tanggal=time();
      header("Content-type: application/x-msdownload");
      header("Content-Disposition: attachment; filename=DATA_KARYAWAN_".$tanggal.".xls");
      header("Pragma: no-cache");
      header("Expires: 0");


      $jenis=$this->input->post('jenis');
      $data['bulan']=$this->format->BulanIndo($this->input->post('bulan'));
      $data['tahun']=$this->input->post('tahun');
      $tgl_awal   = date('Y-m-01',strtotime($this->input->post('tahun')."-".$this->input->post('bulan')));
      $tgl_akhir  = date('Y-m-t',strtotime($this->input->post('tahun')."-".$this->input->post('bulan')));
      $tgl_jht    = date('Y-m-20',strtotime($this->input->post('tahun')."-".$this->input->post('bulan')));
      $tgl_jpk    = date('Y-m-10',strtotime($this->input->post('tahun')."-".($this->input->post('bulan')-1)));
      // echo $tgl;

      if ($this->input->post('cabang')!=NULL) {
          $cabang="(tab_cabang.id_cabang='".$this->input->post('cabang')."')";
      }else{
          $cabang="(tab_cabang.id_cabang != '')";
      }


      // $data['data']=$this->db->select('tab_karyawan.*,tab_kontrak_kerja.*,tab_bpjs_karyawan.*,tab_resign.*,
      //   tab_resign.nik as nik_resign,tab_cabang.*')
      //                        ->from('tab_karyawan')
      //                        ->join('tab_kontrak_kerja','tab_kontrak_kerja.nik=tab_karyawan.nik','left')
      //                        ->join('tab_bpjs_karyawan','tab_bpjs_karyawan.nik=tab_karyawan.nik','left')
      //                        ->join('tab_resign','tab_resign.nik=tab_karyawan.nik','left','left')
      //                        ->join('tab_cabang','tab_cabang.id_cabang=tab_karyawan.cabang','left')
      //                        ->where('tab_bpjs_karyawan.id_bpjs',$jenis)
      //                        ->where('tab_bpjs_karyawan.no_bpjs != ','')
      //                        ->where($cabang,null)
      //                        //->where('tab_kontrak_kerja.tanggal_resign','0000-00-00')
      //                        ->get()
      //                        ->result();

      if ($jenis==1) {
        $data['data']=$this->db->query("SELECT tab_karyawan.*,tab_history_kontrak_kerja.*, 
        tab_bpjs_karyawan.*,tab_resign.*,tab_resign.nik as nik_resign,tab_cabang.* 
        FROM tab_karyawan 
        iNNER JOIN (
          SELECT tab_history_kontrak_kerja.* FROM tab_history_kontrak_kerja
          LEFT JOIN tab_resign ON tab_resign.nik = tab_history_kontrak_kerja.nik 
          WHERE (tab_history_kontrak_kerja.tanggal_masuk > tab_resign.tanggal_resign 
          OR tab_resign.nik IS NULL OR tab_resign.tanggal_resign >= '".$tgl_jht."')
          GROUP BY tab_history_kontrak_kerja.nik
        )
        tab_history_kontrak_kerja ON tab_history_kontrak_kerja.nik = tab_karyawan.nik  
        LEFT JOIN tab_cabang ON tab_cabang.id_cabang = tab_karyawan.cabang 
        LEFT JOIN tab_bpjs_karyawan ON tab_bpjs_karyawan.nik = tab_karyawan.nik 
        LEFT JOIN tab_resign ON tab_resign.nik = tab_karyawan.nik 
        WHERE tab_bpjs_karyawan.id_bpjs = ".$jenis." AND ".$cabang." AND tab_bpjs_karyawan.no_bpjs != '' 
        AND tab_karyawan.gaji_bpjs !=0 AND tab_bpjs_karyawan.bulan_ambil <= '".$tgl_akhir."'
        AND (tab_history_kontrak_kerja.tanggal_masuk > tab_resign.tanggal_resign 
        OR tab_resign.nik IS NULL OR tab_resign.tanggal_resign >= '".$tgl_jht."')
        GROUP BY tab_karyawan.nik ORDER BY tab_karyawan.nama_ktp")->result();
      } else if ($jenis==2) {
        $data['data']=$this->db->query("SELECT tab_karyawan.*,tab_history_kontrak_kerja.*, 
        tab_bpjs_karyawan.*,tab_resign.*,tab_resign.nik as nik_resign,tab_cabang.* 
        FROM tab_karyawan 
        iNNER JOIN (
          SELECT tab_history_kontrak_kerja.* FROM tab_history_kontrak_kerja
          LEFT JOIN tab_resign ON tab_resign.nik = tab_history_kontrak_kerja.nik 
          WHERE (tab_history_kontrak_kerja.tanggal_masuk > tab_resign.tanggal_resign 
          OR tab_resign.nik IS NULL OR tab_resign.tanggal_resign >= '".$tgl_jht."')
          GROUP BY tab_history_kontrak_kerja.nik
        )
        tab_history_kontrak_kerja ON tab_history_kontrak_kerja.nik = tab_karyawan.nik 
        LEFT JOIN tab_cabang ON tab_cabang.id_cabang = tab_karyawan.cabang 
        LEFT JOIN tab_bpjs_karyawan ON tab_bpjs_karyawan.nik = tab_karyawan.nik 
        LEFT JOIN tab_resign ON tab_resign.nik = tab_karyawan.nik 
        WHERE tab_bpjs_karyawan.id_bpjs = ".$jenis." AND ".$cabang." AND tab_bpjs_karyawan.no_bpjs != '' 
        AND tab_karyawan.gaji_bpjs !=0 AND tab_bpjs_karyawan.bulan_ambil <= '".$tgl_akhir."'
        AND (tab_history_kontrak_kerja.tanggal_masuk > tab_resign.tanggal_resign 
        OR tab_resign.nik IS NULL OR tab_resign.tanggal_resign >= '".$tgl_jpk."') 
        AND tab_history_kontrak_kerja.tanggal_masuk < '".$tgl_awal."' 
        GROUP BY tab_karyawan.nik ORDER BY tab_karyawan.nama_ktp")->result();

        // print_r($this->db->last_query());
        // echo "<br>";
      }

      // print_r($this->db->last_query());

      //print_r($data['data']);
      /*$data['jumlah_karyawan']=$this->db->select('gaji_bpjs,COUNT(IF(tab_kontrak_kerja.tanggal_masuk > tab_resign.tanggal_resign,IF(tab_resign.nik != '',NULL,tab_karyawan.nik),0)) jml,count(tab_karyawan.nik) as jml_emp,tab_karyawan.cabang as cabang')
      //gaji_bpjs,count(tab_karyawan.nik) as jml_emp,tab_karyawan.cabang as cabang
      //gaji_bpjs,COUNT(IF(`tab_kontrak_kerja`.tanggal_masuk > `tab_resign`.tanggal_resign,IF(`tab_resign`.nik != '',NULL,`tab_karyawan`.nik),0)) jml,count(tab_karyawan.nik) as jml_emp,tab_karyawan.cabang as cabang
                                        ->join('tab_kontrak_kerja','tab_kontrak_kerja.nik=tab_karyawan.nik','left')
                                        ->join('tab_cabang','tab_cabang.id_cabang=tab_karyawan.cabang','left')
                                        ->where('tab_bpjs_karyawan.id_bpjs',$jenis)
                                        ->join('tab_bpjs_karyawan','tab_bpjs_karyawan.nik=tab_karyawan.nik','left')
                                        ->join('tab_resign','tab_resign.nik=tab_karyawan.nik','left')
                                        ->where($cabang,null)
                                        ->where('tab_bpjs_karyawan.no_bpjs != ','')
                                        ->where('tab_karyawan.gaji_bpjs != ',0)
                                        ->group_by('tab_karyawan.gaji_bpjs')->get('tab_karyawan')->result();*/
      // $data['jumlah_karyawan']=$this->db->query("SELECT gaji_bpjs,COUNT(IF(tab_kontrak_kerja.tanggal_masuk > tab_resign.tanggal_resign,IF(tab_resign.nik != '',NULL,tab_karyawan.nik),0)) jml,COUNT(tab_karyawan.nik) AS jml_emp,tab_karyawan.cabang AS cabang FROM tab_karyawan 
      //         LEFT JOIN tab_kontrak_kerja ON tab_kontrak_kerja.nik=tab_karyawan.nik 
      //         LEFT JOIN tab_cabang ON tab_cabang.id_cabang=tab_karyawan.cabang 
      //         LEFT JOIN tab_bpjs_karyawan ON tab_bpjs_karyawan.nik=tab_karyawan.nik 
      //         LEFT JOIN tab_resign ON tab_resign.nik=tab_karyawan.nik 
      //         WHERE tab_bpjs_karyawan.id_bpjs = ".$jenis." AND ".$cabang." 
      //         AND tab_bpjs_karyawan.no_bpjs != '' AND tab_karyawan.gaji_bpjs != 0 
      //         GROUP BY tab_karyawan.gaji_bpjs")->result();


      if ($jenis==1) {
        $data['jumlah_karyawan']=$this->db->query("SELECT gaji_bpjs,COUNT(DISTINCT tab_karyawan.nik) jml,
        tab_karyawan.cabang AS cabang 
        FROM tab_karyawan 
        iNNER JOIN (
          SELECT tab_history_kontrak_kerja.* FROM tab_history_kontrak_kerja
          LEFT JOIN tab_resign ON tab_resign.nik = tab_history_kontrak_kerja.nik 
          WHERE (tab_history_kontrak_kerja.tanggal_masuk > tab_resign.tanggal_resign 
          OR tab_resign.nik IS NULL OR tab_resign.tanggal_resign >= '".$tgl_jht."')
          GROUP BY tab_history_kontrak_kerja.nik
        )
        tab_history_kontrak_kerja ON tab_history_kontrak_kerja.nik = tab_karyawan.nik  
        LEFT JOIN tab_cabang ON tab_cabang.id_cabang = tab_karyawan.cabang 
        LEFT JOIN tab_bpjs_karyawan ON tab_bpjs_karyawan.nik = tab_karyawan.nik 
        LEFT JOIN tab_resign ON tab_resign.nik = tab_karyawan.nik 
        WHERE tab_bpjs_karyawan.id_bpjs = ".$jenis." AND ".$cabang." AND tab_bpjs_karyawan.no_bpjs != '' 
        AND tab_karyawan.gaji_bpjs !=0 AND tab_bpjs_karyawan.bulan_ambil <= '".$tgl_akhir."'
        AND (tab_history_kontrak_kerja.tanggal_masuk > tab_resign.tanggal_resign 
        OR tab_resign.nik IS NULL OR tab_resign.tanggal_resign >= '".$tgl_jht."')
        GROUP BY tab_karyawan.gaji_bpjs")->result();

        $data['jumlah_karyawan2']=$this->db->query("SELECT tab_karyawan.*,tab_history_kontrak_kerja.*, 
        tab_bpjs_karyawan.*,tab_resign.*,tab_resign.nik AS nik_resign,tab_cabang.*, 
        SUM(gaji_bpjs) AS total,COUNT(DISTINCT tab_karyawan.nik) AS jml,
        tab_karyawan.cabang AS cabang, tab_cabang.cabang AS nama_cabang 
        FROM tab_karyawan 
        iNNER JOIN (
          SELECT tab_history_kontrak_kerja.* FROM tab_history_kontrak_kerja
          LEFT JOIN tab_resign ON tab_resign.nik = tab_history_kontrak_kerja.nik 
          WHERE (tab_history_kontrak_kerja.tanggal_masuk > tab_resign.tanggal_resign 
          OR tab_resign.nik IS NULL OR tab_resign.tanggal_resign >= '".$tgl_jht."')
          GROUP BY tab_history_kontrak_kerja.nik
        )
        tab_history_kontrak_kerja ON tab_history_kontrak_kerja.nik = tab_karyawan.nik 
        LEFT JOIN tab_cabang ON tab_cabang.id_cabang = tab_karyawan.cabang 
        LEFT JOIN tab_bpjs_karyawan ON tab_bpjs_karyawan.nik = tab_karyawan.nik 
        LEFT JOIN tab_resign ON tab_resign.nik = tab_karyawan.nik 
        WHERE tab_bpjs_karyawan.id_bpjs = ".$jenis." AND ".$cabang." AND tab_bpjs_karyawan.no_bpjs != '' 
        AND tab_karyawan.gaji_bpjs !=0 AND tab_bpjs_karyawan.bulan_ambil <= '".$tgl_akhir."'
        AND (tab_history_kontrak_kerja.tanggal_masuk > tab_resign.tanggal_resign 
        OR tab_resign.nik IS NULL OR tab_resign.tanggal_resign >= '".$tgl_jht."')
        GROUP BY tab_karyawan.cabang")->result();
      } else if ($jenis==2) {
        $data['jumlah_karyawan']=$this->db->query("SELECT gaji_bpjs,COUNT(DISTINCT tab_karyawan.nik) jml,
        tab_karyawan.cabang AS cabang 
        FROM tab_karyawan 
        iNNER JOIN (
          SELECT tab_history_kontrak_kerja.* FROM tab_history_kontrak_kerja
          LEFT JOIN tab_resign ON tab_resign.nik = tab_history_kontrak_kerja.nik 
          WHERE (tab_history_kontrak_kerja.tanggal_masuk > tab_resign.tanggal_resign 
          OR tab_resign.nik IS NULL OR tab_resign.tanggal_resign >= '".$tgl_jht."')
          GROUP BY tab_history_kontrak_kerja.nik
        )
        tab_history_kontrak_kerja ON tab_history_kontrak_kerja.nik = tab_karyawan.nik 
        LEFT JOIN tab_cabang ON tab_cabang.id_cabang = tab_karyawan.cabang 
        LEFT JOIN tab_bpjs_karyawan ON tab_bpjs_karyawan.nik = tab_karyawan.nik 
        LEFT JOIN tab_resign ON tab_resign.nik = tab_karyawan.nik 
        WHERE tab_bpjs_karyawan.id_bpjs = ".$jenis." AND ".$cabang." AND tab_bpjs_karyawan.no_bpjs != '' 
        AND tab_karyawan.gaji_bpjs !=0 AND tab_bpjs_karyawan.bulan_ambil <= '".$tgl_akhir."'
        AND (tab_history_kontrak_kerja.tanggal_masuk > tab_resign.tanggal_resign 
        OR tab_resign.nik IS NULL OR tab_resign.tanggal_resign >= '".$tgl_jpk."') 
        AND tab_history_kontrak_kerja.tanggal_masuk < '".$tgl_akhir."' 
        AND tab_history_kontrak_kerja.tanggal_masuk < '".$tgl_awal."' 
        GROUP BY tab_karyawan.gaji_bpjs")->result();

        // print_r($this->db->last_query());
        // echo "<br>";

        $data['jumlah_karyawan2']=$this->db->query("SELECT tab_karyawan.*,tab_history_kontrak_kerja.*, 
        tab_bpjs_karyawan.*,tab_resign.*,tab_resign.nik AS nik_resign,tab_cabang.*, 
        SUM(gaji_bpjs) AS total,COUNT(DISTINCT tab_karyawan.nik) AS jml,
        tab_karyawan.cabang AS cabang, tab_cabang.cabang AS nama_cabang 
        FROM tab_karyawan 
        iNNER JOIN (
          SELECT tab_history_kontrak_kerja.* FROM tab_history_kontrak_kerja
          LEFT JOIN tab_resign ON tab_resign.nik = tab_history_kontrak_kerja.nik 
          WHERE (tab_history_kontrak_kerja.tanggal_masuk > tab_resign.tanggal_resign 
          OR tab_resign.nik IS NULL OR tab_resign.tanggal_resign >= '".$tgl_jht."')
          GROUP BY tab_history_kontrak_kerja.nik
        )
        tab_history_kontrak_kerja ON tab_history_kontrak_kerja.nik = tab_karyawan.nik 
        LEFT JOIN tab_cabang ON tab_cabang.id_cabang = tab_karyawan.cabang 
        LEFT JOIN tab_bpjs_karyawan ON tab_bpjs_karyawan.nik = tab_karyawan.nik 
        LEFT JOIN tab_resign ON tab_resign.nik = tab_karyawan.nik 
        WHERE tab_bpjs_karyawan.id_bpjs = ".$jenis." AND ".$cabang." AND tab_bpjs_karyawan.no_bpjs != '' 
        AND tab_karyawan.gaji_bpjs !=0 AND tab_bpjs_karyawan.bulan_ambil <= '".$tgl_akhir."'
        AND (tab_history_kontrak_kerja.tanggal_masuk > tab_resign.tanggal_resign 
        OR tab_resign.nik IS NULL OR tab_resign.tanggal_resign >= '".$tgl_jpk."') 
        AND tab_history_kontrak_kerja.tanggal_masuk < '".$tgl_akhir."' 
        AND tab_history_kontrak_kerja.tanggal_masuk < '".$tgl_awal."' 
        GROUP BY tab_karyawan.cabang")->result();
      }
      
      // print_r($this->db->last_query());

      $data['nama_cabang'] = $this->db->get('tab_cabang')->result();

      $data['cabang']=$this->db->where('id_cabang',$this->input->post('cabang'))->get('tab_cabang')->row();
      if ($jenis==1) {
        $html1=$this->load->view('laporan/iuran_jamsostek',$data,true);
        $html2=$this->load->view('laporan/rekap_bpjs_print',$data,true);
      }else{
        $html1=$this->load->view('laporan/iuran_bpjs_kesehatan',$data,true);
        $html2=$this->load->view('laporan/rekap_bpjs_kesehatan',$data,true);
      }
      
      
      echo $html1;
      echo "<br><br>";
      echo $html2;
      exit();
    }
    
    public function absensi()
    {
      $this->table->set_heading(array('<input type=checkbox name=cekall id=cekall onclick="return checkedAll(form_data);">','Nama Perusahaan','Plant','Department','Golongan','NIK','Nama Employe','Jabatan','Tanggal Absensi','Jadwal Masuk','Jadwal Keluar','Jam Masuk','Jam Keluar','Keterangan','Alpha','Masuk','Kode Shift','Lama Kerja STD','Lama Kerja Real','Keterangan Ekstra','Jumlah Ekstra','Real Lembur DP','Keterangan Jam Kerja ','Tindakan'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
          'thead_open'=>'<thead>',
          'thead_close'=> '</thead>',
          'tbody_open'=> '<tbody>',
          'tbody_close'=> '</tbody>',
        );
        $this->table->set_template($tmp);
        $no=1;
        $bln=$this->input->post('bulan');
        $thun=$this->input->post('tahun');
        $data=$this->model_absensi->find($bln,$thun);
        foreach ($data as $rs){
            $q_jdwal=$this->db->join('tab_jam_kerja b','b.kode_jam=a.kode_jam')
                              ->where('a.nik',$karyawan->nik)
                              ->where('a.tanggal',date('Y-m-d',strtotime($rs)))
                              ->get('tab_jadwal_karyawan a')
                              ->row();
            $q_absen=$this->db->join('tab_absensi_keluar b','b.nik=a.nik')
                              ->where('date(a.jam_masuk)',date('Y-m-d',strtotime($tgl_absen)))
                              ->where('date(b.jam_keluar)',date('Y-m-d',strtotime($tgl_absen)))
                              ->where('a.nik',$karyawan->nik)
                              ->get('tab_absensi_masuk a')
                              ->row();
            $q_ekstra=$this->db
                              ->where('tanggal_ekstra',date('Y-m-d',strtotime($tgl_absen)))
                              ->where('nik',$karyawan->nik)
                              ->get('tab_extra')
                              ->row();
            if(count($q_jdwal)==0) {
                $ktr="Libur";
                $alpha=0;
                $lama_real=0;
                $hadir=0;
            }else {
              if ($q_absen->status=="On Time") {
                $ktr="Masuk";
                $alpha=0;
                $hadir=1;
                $lama_real=date("H:i:s",strtotime($q_absen->jam_keluar))-date("H:i:s",strtotime($q_absen->jam_masuk));
              }elseif ($q_absen->status=="Terlambat") {
                $ktr="Masuk tidak lengkap";
                $alpha=0;
                $hadir=1;
                $lama_real=date("H:i:s",strtotime($q_absen->jam_keluar))-date("H:i:s",strtotime($q_absen->jam_masuk));
              }else{
                $ktr="Alpha";
                $alpha=1;
                $hadir=0;
                $lama_real=0;
              }
            }
            if (isset($q_absen->nik)) {
              $link=anchor('absensi/'.$q_absen->id.'/edit','<i class="fa pencil-square-o"></i><span class="label label-warning">Edit</span>');
            }else{
              $link="";
            }
            $this->table->add_row('<input type=checkbox name=cb_data[] id=cb_data[] value='.$tampil->id.'>','CRN',$karyawan->cabang,$karyawan->department,$karyawan->status_kerja,$karyawan->nik,$karyawan->nama_ktp,$karyawan->jabatan,$this->format->TanggalIndo($tgl_absen),$q_jdwal->jam_start,$q_jdwal->jam_finish,$q_absen->jam_masuk,$q_absen->jam_keluar,$ktr,$alpha,$hadir,'',$q_jdwal->lama,$lama_real,'',$q_ekstra->lama_jam,'','',$link);
        $no++;
        }
        $tabel=$this->table->generate();
        echo $tabel;
    }
    
  public function ex_karyawan(){
    $this->load->model('karyawan');
    $tanggal=time();
    header("Content-type: application/x-msdownload");
    header("Content-Disposition: attachment; filename=DATA_KARYAWAN_".$tanggal.".xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    
    $id_cabang=$this->input->post('cabang');
    $ketenaga = $this->db->where('id_bpjs','1')->get('tab_master_bpjs')->row();
    $kesehatan = $this->db->where('id_bpjs',2)->get('tab_master_bpjs')->row();
    $excel=$this->karyawan->karyawan_show($id_cabang);
    $rw=count($excel);?>
        <table class="table table-hover table-striped table-bordered">
        <tr>
          <th rowspan="2">No</th>
          <th rowspan="2">NIK</th>
          <th rowspan="2">Nama</th>
          <th rowspan="2">Alamat KTP</th>
          <th rowspan="2">Alamat Domsisili</th>
          <th rowspan="2">Pendidikan Terakhir</th>
          <th rowspan="2">Telp</th>
          <th rowspan="2">Telp Emergency</th>
          <th rowspan="2">Status Hubungan</th>
          <th rowspan="2">Tanggal Lahir</th>
          <th rowspan="2">Status Perkawinan</th>
          <th rowspan="2">Tanggungan</th>
          <th rowspan="2">Jenis Kelamin</th>
          <th rowspan="2">BPJS Keketenaga Kerjaan</th>
          <th rowspan="2">BPJS Keketenaga Kesehatan</th>
          <th rowspan="2">Nama Rekening</th>
          <th rowspan="2">No Rekening</th>
          <th rowspan="2">Tanggal Awal Masuk</th>
          <th rowspan="2">Jabatan</th>
          <th rowspan="2">NO NPWP</th>
          <th rowspan="2">Nama NPWP</th>
          <th rowspan="2">Status Pajak</th>
          <th rowspan="2">Status</th>
          <th colspan="2">Tanggal Status</th>
          <th rowspan="2">Tanggal Resign</th>
          <th colspan="1">Asuransi</th>
          <th colspan="2">Bonus</th>
          <th colspan="3">T3 <?=date('Y')?></th>
          <th colspan="1">Komisi</th>
          <th rowspan="2">Gaji Pokok</th>
          <th rowspan="2">Tunjangan Jabatan</th>
          <th rowspan="2">Standar Hadir</th>
          <th rowspan="2">Uang Makan</th>
          <th rowspan="2">Gaji BPJS</th>
          <th colspan="2">JHT</th>
          <th colspan="1">JKK</th>
          <th colspan="1">JKM</th>
          <th colspan="2">BPJS Kesehatan</th>
          <th colspan="1">Total BPJS</th>
          <th rowspan="2">JPK, JKM,JKK Beban Perusahaan</th>
        </tr>
        <tr>
          <th>Awal</th>
          <th>Akhir</th>
          <!--<th>Vendor</th>
          <th>Asuransi</th>
          <th>No Premi</th>-->
          <th>Tarif</th>
          <th>Grade</th>
          <th>Bonus Terkini</th>
          <!--<th>Rata-rata</th>-->
          <th>Hari</th>
          <th>Tarif/Hari</th>
          <th>Total T3</th>
          <!--<th>Rata-rata</th>-->
          <th>Komisi Terkini</th>
          <!--<th>Rata-rata</th>-->
          <th><?=$ketenaga->jht_1?>%</th>
          <th><?=$ketenaga->jht_2?>%</th>
          <th><?=$ketenaga->jkk?>%</th>
          <th><?=$ketenaga->jkm?>%</th>
          <th><?=$kesehatan->jpk_1?>%</th>
          <th><?=$kesehatan->jpk_2?>%</th>
          <th>Biaya BPJS Perusahaan</th>
        </tr>
<?php        
       if($rw>0){
         $no=1;
        foreach ($excel as $tampil){
          $total_tanggungan=($ketenaga->jht_1/100*$tampil->gaji_bpjs)+($ketenaga->jkk/100*$tampil->gaji_bpjs)+($ketenaga->jkm/100*$tampil->gaji_bpjs)+($kesehatan->jpk_1/100*$tampil->gaji_bpjs);
          $keluarga=$this->db->where('nik',$tampil->nik_karyawan)->get('tab_keluarga')->result();
          $tenaga=$this->db->where('nik',$tampil->nik_karyawan)->where('id_bpjs',1)->get('tab_bpjs_karyawan')->row();
          $ks=$this->db->where('nik',$tampil->nik_karyawan)->where('id_bpjs',2)->get('tab_bpjs_karyawan')->row();
          $komisi=$this->db->where('nik',$tampil->nik_karyawan)->where('month(bulan)',date('m'))->select('sum(komisi) as jml_komisi')->get('tab_komisi')->row();
          $t3=$this->db->where('nik',$tampil->nik_karyawan)->where('month(tanggal)',date('m'))->get('tab_t3')->row();
          $bonus=$this->db->where('nik',$tampil->nik_karyawan)->where('month(tanggal_bonus)',date('m'))->select('sum(bonus_nominal+senioritas+grade+bonus_prosen+bonus_prorata) as jml_bonus')->get('tab_bonus_karyawan')->row();
          $telp=array();
          $hub=array();
          foreach ($keluarga as $rs_kel) {
            $telp[]=$rs_kel->nomor_telp;
            $hub[]=$rs_kel->hubungan;
          }
          $tel_kel=implode("<br>", $telp);
          $hubungan=implode('<br>', $hub);
          $tarif_t3=($t3->total_t3!=0) ? $t3->total_t3/$t3->jml_hadir:0;
          $total2=($ketenaga->jkk/100*$tampil->gaji_bpjs)+($ketenaga->jkm/100*$tampil->gaji_bpjs)+($kesehatan->jpk_1/100*$tampil->gaji_bpjs);

          //hitung rata bonus
          $all_bonus=$this->db->where('nik',$tampil->nik_karyawan)->select('sum(bonus_nominal+senioritas+grade+bonus_prosen+bonus_prorata) as jml_bonus,count(nik) as kali')->get('tab_bonus_karyawan');
          $rata_bonus=($all_bonus->jml_bonus!= 0)?$all_bonus->jml_bonus/$all_bonus->kali:0;

          //hitung rata t3
          $all_t3=$this->db->where('nik',$tampil->nik_karyawan)->select('sum(total_t3) as jml_t3,count(nik) as kali')->get('tab_t3');
          $rata_t3=($all_t3->jml_t3 != 0)?$all_t3->jml_t3/$all_t3->kali:0;

          //hitung komisi
          $all_komisi=$this->db->where('nik',$tampil->nik_karyawan)->select('sum(komisi) as jml_komisi,count(nik) as kali')->get('tab_komisi');
          $rata_komisi=( $all_komisi->jml_komisi !=0)?$all_komisi->jml_komisi/$all_komisi->kali:0;       
          echo "<tr>
                    <td>$no</td>
                    <td>$tampil->nik_karyawan</td>
                    <td>$tampil->nama_ktp</td>
                    <td>$tampil->alamat_ktp</td>
                    <td>$tampil->alamat_domisili</td>
                    <td>$tampil->pendidikan_terakhir</td>
                    <td>".str_replace(':', '<br>', $tampil->telepon)."</td>
                    <td>$tel_kel</td>
                    <td>$hubungan</td>
                    <td>".$this->format->TanggalIndo($tampil->tanggal_lahir)."</td>
                    <td>$tampil->status_perkawinan</td>
                    <td>$tampil->tanggungan</td>
                    <td>$tampil->jenis_kelamin</td>
                    <td>$tenaga->no_bpjs</td>
                    <td>$ks->no_bpjs</td>
                    <td>$tampil->nama_rekening</td>
                    <td>$tampil->no_rekening</td>
                    <td>".date('d-m-Y',strtotime($tampil->tanggal_awal))."</td>
                    <td>$tampil->jabatan</td>
                    <td>$tampil->no_npwp</td>
                    <td>$tampil->nama_npwp</td>
                    <td>$tampil->pajak</td>
                    <td>$tampil->status_kerja</td>
                    <td>".$this->format->TanggalIndo($tampil->tanggal_masuk)."</td>
                    <td>".$this->format->TanggalIndo($tampil->tanggal_resign)."</td>
                    <td>".$this->format->TanggalIndo($tampil->tanggal_resign)."</td>
                    <td>".$this->format->indo($tampil->nominal_asuransi)."</td>
                    <td>$tampil->grade</td>
                    <td>".$this->format->indo($bonus->jml_bonus)."</td>
                    <td>$t3->jml_hadir</td>
                    <td>".$this->format->indo($tarif_t3)."</td>
                    <td>".$this->format->indo($t3->total_t3)."</td>
                    <td>".$this->format->indo($komisi->jml_komisi)."</td>
                    <td>".$this->format->indo($tampil->gaji_pokok)."</td>
                    <td>".$this->format->indo($tampil->tunjangan_jabatan)."</td>
                    <td>$tampil->standard_hadir</td>
                    <td>".$this->format->indo($tampil->uang_makan)."</td>
                    <td>".$this->format->indo($tampil->gaji_bpjs)."</td>
                    <td>".$this->format->indo($ketenaga->jht_1/100*$tampil->gaji_bpjs)."</td>
                    <td>".$this->format->indo($ketenaga->jht_2/100*$tampil->gaji_bpjs)."</td>
                    <td>".$this->format->indo($ketenaga->jkk/100*$tampil->gaji_bpjs)."</td>
                    <td>".$this->format->indo($ketenaga->jkm/100*$tampil->gaji_bpjs)."</td>
                    <td>".$this->format->indo($kesehatan->jpk_1/100*$tampil->gaji_bpjs)."</td>
                    <td>".$this->format->indo($kesehatan->jpk_2/100*$tampil->gaji_bpjs)."</td>
                    <td>".$this->format->indo($total_tanggungan)."</td>
                    <td>".$this->format->indo($total2)."</td>
                    </tr>";
        $no++; 
        }
        echo "</table>";
       }
       //exit();
   }

  public function ex_gaji()
    {
        $this->load->model('model_gaji');
        $tanggal=time();
        $bln = $this->input->post('bln');
        if ($bln!=null) {
          $data=$this->model_gaji->rekap_gaji($bln);
        } else {
          $bln = date('m');
          $data=$this->model_gaji->rekap_gaji(date('m'));
        }
        header("Content-type: application/x-msdownload");
        header("Content-Disposition: attachment; filename=DATA_GAJI_KARYAWAN_".$this->format->BulanIndo($bln).".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        /*$tgl1=$this->input->post('tgl1');
        $tgl2=$this->input->post('tgl2');
        $data=$this->model_gaji->rekap_gaji($tgl1,$tgl2);*/
        //$this->table->set_heading(array('NO','NIK','NAMA','JABATAN','DEPARTMENT','NAMA REKENING','NO REKENING','UPAH JAMSOSTEK','GAJI POKOK','TUNJANGAN JABATAN','EKSTRA','PINJ','PPH','JHT','JPK','DP CUTI','GAJI DITERIMA','PAYROLL','APPROVED','KETERANGAN'));
        $this->table->set_heading(array('NO','CABANG','JUMLAH KARYAWAN','GAJI','TUNJANGAN JABATAN','EKSTRA','DP CUTI','PINJ','PPH','TOTAL POTONGAN BPJS','GAJI DITERIMA','PAYROLL'));
        $tmp=array('table_open'=>'<table class="table table-hover table-striped table-bordered" >',
                'thead_open'=>'<thead>',
                'thead_close'=> '</thead>',
                'tbody_open'=> '<tbody>',
                'tbody_close'=> '</tbody>',
            );
        $this->table->set_template($tmp);
        if($data==true){
          $no=1;
          foreach ($data as $val) {

            $this->table->add_row($no,$val->cabang,$val->field1,$this->format->indo($val->field2),$this->format->indo($val->field3),$this->format->indo($val->field4),$this->format->indo($val->field5),$this->format->indo($val->field6),$this->format->indo($val->field7),$this->format->indo($val->field11),$this->format->indo($val->field10),$this->format->indo($val->field10));

            $no++;
          }
          /*foreach ($data as $tampil){
                $kalender=CAL_GREGORIAN;
                $bulan = date('m');
                $tahun= date('Y');
                $jml_hari=cal_days_in_month($kalender, $bulan, $tahun);
                $ekstra=$this->db->join('tab_karyawan a','a.nik=b.nik')
                                 ->where('a.nik',$tampil->nik_karyawan)
                                 ->where('(Year(b.entry_date)=year(now()))',null)
                                 ->where('(month(b.entry_date)=month(now()))',null)
                                 ->where('b.vakasi','Dibayar')
                                 ->where('b.approved','Ya')
                                 ->select('sum(jumlah_vakasi) as total_vakasi')
                                 ->get('tab_extra b')->row();
                $cuti=$this->db->join('tab_karyawan a','a.nik=b.nik')
                               ->join('tab_kontrak_kerja c','c.nik=a.nik')
                               ->where('a.nik',$tampil->nik_karyawan)
                               ->where('(month(b.entry_date)=month(now()))',null)
                               ->where('(Year(b.entry_date)=year(now()))',null)
                               ->where('b.saldo_cuti < ',0)
                               ->select("sum((c.gaji_pokok/$jml_hari)*b.saldo_cuti) as total_cuti")
                               ->get('tab_master_dp b')->row();
                $total_pph += $tampil->jml_pph;
                $total_jht += $tampil->gaji_pokok*2/100;
                $total_jpk += $tampil->gaji_pokok*1/100;
                $total_ekstra += $ekstra->total_vakasi;
                $total_cuti += $cuti->total_cuti;
                $total_bpjs += $tampil->gaji_bpjs;
                $total_pokok += $tampil->gaji_pokok;
                $tot_tunjangan += $tampil->tunjangan_jabatan;
                $gaji_bersih=($tampil->gaji_pokok+$ekstra->total_vakasi+$tampil->tunjangan_jabatan)-$tampil->jml_pph-(($tampil->gaji_pokok*2/100)+($tampil->gaji_pokok*1/100))-$cuti->total_cuti;
                $total_gaji += $gaji_bersih;
                if ($tampil->approval=='2') $apr="Ya"; else $apr="Tidak";
                $this->table->add_row($no,$tampil->nik_karyawan,$tampil->nama_ktp,$tampil->jabatan,$tampil->department,$tampil->nama_rekening,$tampil->no_rekening,$this->format->indo($tampil->gaji_bpjs),$this->format->indo($tampil->gaji_pokok),$this->format->indo($tampil->tunjangan_jabatan),$this->format->indo($ekstra->total_vakasi),$this->format->indo(0),$this->format->indo($tampil->jml_pph),$this->format->indo($tampil->gaji_pokok*2/100),$this->format->indo($tampil->gaji_pokok*1/100),$this->format->indo($cuti->total_cuti),$this->format->indo($gaji_bersih),$this->format->indo($gaji_bersih),$apr,$tampil->keterangan);
                $no++;
          }*/
          //$this->table->add_row(array('data'=>''),array('data'=>'Total','colspan'=>6),$this->format->indo($total_bpjs),$this->format->indo($total_pokok),$this->format->indo($tot_tunjangan),$this->format->indo($total_ekstra),$this->format->indo(0),$this->format->indo($total_pph),$this->format->indo($total_jht),$this->format->indo($total_jpk),$this->format->indo($total_cuti),$this->format->indo($total_gaji),$this->format->indo($total_gaji),'','');
          $tabel=$this->table->generate();
          echo $tabel;
          }else {
            echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
          }
      exit();
    }

  public function ex_gaji_detail()
    {
        $this->load->model('model_gaji');
        $tanggal=time();
        $id = $this->input->post('id_cabang');
        $bln = $this->input->post('bln');
        $thn = $this->input->post('thn');
        $data = $this->model_gaji->detail_gaji_rekap($id,$bln,$thn);

        header("Content-type: application/x-msdownload");
        header("Content-Disposition: attachment; filename=DETAIL_DATA_GAJI_KARYAWAN_".$this->format->BulanIndo($bln)."_Tahun.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
      if($data==true){ ?>
          <table id="example-2" class="table table-hover table-striped table-bordered" style="white-space: nowrap;">
            <thead>
              <tr>
                <th>NO</th>
                <th>NIK</th>
                <th>NAMA</th>
                <th>JABATAN</th>
                <th>DEPARTMENT</th>
                <th>UPAH JAMSOSTEK</th>
                <th>GAJI POKOK</th>
                <th>TUNJANGAN JABATAN</th>
                <th>EKSTRA</th>
                <th>DP CUTI</th>
                <th>PINJ</th>
                <th>PPH</th>
                <?php
                $bpjsid = array();
                $bpjsiddetail = array();
                $potongan_bpjs = array();
                if ($bpjs) {
                  foreach ($bpjs->result() as $row) { 
                    echo '<th>'.$row->nama_potongan.'</th>';
                    array_push($bpjsid, $row->id_bpjs);
                    array_push($bpjsiddetail, $row->id_bpjs_detail);
                    array_push($potongan_bpjs, 0);
                  }
                }
                ?>
                <th>GAJI DITERIMA</th>
                <th>APPROVAL</th>
                <th>KETERANGAN</th>
              </tr>
            </thead>
            <tbody>
          <?php
          $no = 1;
          $jamsostek = 0;
          $pokok = 0;
          $tunjangan = 0;
          $ekstra = 0;
          $dp_cuti = 0;
          $pinjaman = 0;
          $pph = 0;
          $diterima = 0;

          foreach ($data as $tampil){

            $idbpjs = explode(",", $tampil->field17);
            $idbpjsdetail = explode(",", $tampil->field18);
            $bpjspotongan = explode(",", $tampil->field19);

            $jamsostek += $tampil->field5;
            $pokok += $tampil->field6;
            $tunjangan += $tampil->field7;
            $ekstra += $tampil->field8;
            $dp_cuti += $tampil->field9;
            $pinjaman += $tampil->field10;
            $pph += $tampil->field11;
            $diterima += $tampil->field14;

            if ($tampil->field15=="0") {
              $app = "Belum";
              $cetak = "hidden";
            } else if ($tampil->field15=="1") {
              $app = "Tidak";
              $cetak = "hidden";
            } else if ($tampil->field15=="2") {
              $cetak = " ";
              $app = "Setuju";
            }

            echo '
            <tr>
              <td>'.$no.'</td>
              <td>'.$tampil->field1.'</td>
              <td>'.$tampil->field2.'</td>
              <td>'.$tampil->field3.'</td>
              <td>'.$tampil->field4.'</td>
              <td>'.$this->format->indo($tampil->field5).'</td>
              <td>'.$this->format->indo($tampil->field6).'</td>
              <td>'.$this->format->indo($tampil->field7).'</td>
              <td>'.$this->format->indo($tampil->field8).'</td>
              <td>'.$this->format->indo($tampil->field9).'</td>
              <td>'.$this->format->indo($tampil->field10).'</td>
              <td>'.$this->format->indo($tampil->field11).'</td>';
              for ($i = 0; $i < count($bpjsid); $i++) { 
                for ($j = 0; $j < count($idbpjs); $j++) { 
                  if ($bpjsid[$i] == $idbpjs[$j] && $bpjsiddetail[$i] == $idbpjsdetail[$j]) {
                    echo '<td>'.$this->format->indo($bpjspotongan[$j]).'</td>';
                    $potongan_bpjs[$i] += $bpjspotongan[$j];
                  }
                }
              }
            echo'
              <td>'.$this->format->indo($tampil->field14).'</td>
              <td>'.$app.'</td>
              <td>'.$tampil->field16.'</td>
            </tr>';

            $no++;

          } ?>

            </tbody>
            <tfoot>
              <tr>
                <th colspan="5">Total </th>
                <th><?php echo $this->format->indo($jamsostek);?></th>
                <th><?php echo $this->format->indo($pokok);?></th>
                <th><?php echo $this->format->indo($tunjangan);?></th>
                <th><?php echo $this->format->indo($ekstra);?></th>
                <th><?php echo $this->format->indo($dp_cuti);?></th>
                <th><?php echo $this->format->indo($pinjaman);?></th>
                <th><?php echo $this->format->indo($pph);?></th>
                <?php
                  for ($i = 0; $i < count($bpjsid); $i++) {
                    echo '
                    <th>'.$this->format->indo($potongan_bpjs[$i]).'</th>
                    ';
                  }
                ?>
                <th><?php echo $this->format->indo($diterima);?></th>
                <th><?php echo '';?></th>
                <th><?php echo '';?></th>
                <th><?php echo '';?></th>
              </tr>
            </tfoot>
          </table>
      <?php
      } else {
        echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
      }
      exit();
    }

  public function ex_gaji_casual()
    {
        $this->load->model('model_gaji');
        $bln = $this->input->post('bln');
        $thn = $this->input->post('thn');

        if ($bln!=null) {
        } else {
          $bln = date('m');
        }
        if ($thn!=null) {
        } else {
          $thn = date('Y');
        }

        $data=$this->model_gaji->rekap_casual($bln,$thn);
        $pph=$this->db->where('month(entry_date)',$bln)->get('pph_casual')->num_rows();

        header("Content-type: application/x-msdownload");
        header("Content-Disposition: attachment; filename=DATA_GAJI_CASUAL_PLANT_".$this->format->BulanIndo($bln).".xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        $periode1 = date('d',strtotime($thn."-".$bln."-01"))." - ".date('d',strtotime($thn."-".$bln."-15"));
        $periode2 = date('d',strtotime($thn."-".$bln."-16"))." - ".date('t',strtotime($thn."-".$bln));
        $this->table->set_heading(array('NO','CABANG','JUMLAH KARYAWAN','GAJI NETTO / HARI '.$periode1,'UANG MAKAN / HARI '.$periode1,'EKSTRA '.$periode1,'PPH '.$periode1,'TOTAL DITERIMA '.$periode1,'GAJI NETTO / HARI '.$periode2,'UANG MAKAN / HARI '.$periode2,'EKSTRA '.$periode2,'PPH '.$periode2,'TOTAL DITERIMA '.$periode2,'TOTAL GAJI DITERIMA','TINDAKAN'));

        $tmp=array('table_open'=>'<table class="table table-hover table-striped table-bordered" >',
                'thead_open'=>'<thead>',
                'thead_close'=> '</thead>',
                'tbody_open'=> '<tbody>',
                'tbody_close'=> '</tbody>',
            );
        $this->table->set_template($tmp);
        if($data==true){
          $no=1;
          foreach ($data as $val) {
            $this->table->add_row($no,$val->cabang,$val->jml,$this->format->indo($val->gaji_netto),$this->format->indo($val->uang_makan_real),$this->format->indo($val->ekstra),$this->format->indo($val->pph),$this->format->indo($val->t_gaji_terima),$this->format->indo($val->gaji_netto2),$this->format->indo($val->uang_makan_real2),$this->format->indo($val->ekstra2),$this->format->indo($val->pph2),$this->format->indo($val->t_gaji_terima2),$this->format->indo($val->t_gaji_terima + $val->t_gaji_terima2),"<a class='label label-warning' href='".base_url()."gaji/".$bln."/".$thn."/".$val->id_cabang."/".str_replace(',', '-', $val->cabang)."/detailrekapcasual'>Detail</a>");
            $no++;
          }
          $tabel=$this->table->generate();
          echo $tabel;
          }else {
            echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
          }
      exit();
    }

  public function ex_gaji_casual_detail()
    {
        $this->load->model('model_gaji');
        $tanggal=time();
        $id = $this->input->post('cabang');
        $bln = $this->input->post('bln');
        $thn = $this->input->post('thn');
        $data = $this->model_gaji->detail_gaji_casual_rekap($bln,$thn,$id);

        header("Content-type: application/x-msdownload");
        header("Content-Disposition: attachment; filename=DETAIL_DATA_GAJI_CASUAL_KARYAWAN_".$this->format->BulanIndo($bln).".xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        $nama_bln = date_format(new DateTime($thn.'-'.$bln),"F Y");
        $nama_bln2 = date_format(new DateTime($thn.'-'.$bln),"t F Y");

        $periode1 = date('d',strtotime($thn."-".$bln."-01"))." - ".date('d',strtotime($thn."-".$bln."-15"));
        $periode2 = date('d',strtotime($thn."-".$bln."-16"))." - ".date('t',strtotime($thn."-".$bln));

        $this->table->set_heading(array('NO','NIK','NAMA','STATUS','NPWP','ALAMAT','STATUS PAJAK','NAMA REKENING','NO REKENING','GAJI NETTO / HARI '.$periode1,'HARI KERJA '.$periode1,'UANG MAKAN / HARI '.$periode1,'TOTAL GAJI '.$periode1,'EKSTRA '.$periode1,'TOTAL GAJI BRUTO '.$periode1,'TOTAL UANG MAKAN '.$periode1,'PPH '.$periode1,'TOTAL DITERIMA '.$periode1,'GAJI NETTO / HARI '.$periode2,'HARI KERJA '.$periode2,'UANG MAKAN / HARI '.$periode2,'TOTAL GAJI '.$periode2,'EKSTRA '.$periode2,'TOTAL GAJI BRUTO '.$periode2,'TOTAL UANG MAKAN '.$periode2,'PPH '.$periode2,'TOTAL DITERIMA '.$periode2,'TOTAL HARI KERJA','TOTAL GAJI BRUTO','TOTAL GAJI DITERIMA','APPROVAL'));
        $tmp=array('table_open'=>'<table class="table table-hover table-striped table-bordered" >',
                'thead_open'=>'<thead>',
                'thead_close'=> '</thead>',
                'tbody_open'=> '<tbody>',
                'tbody_close'=> '</tbody>',
            );
        $this->table->set_template($tmp);
        if($data==true){
          $no=1;
          foreach ($data as $tampil){

            if ($tampil->approval=="0") {
              $app = "Belum";
              $cetak = "hidden";
            } else if ($tampil->approval=="1") {
              $app = "Tidak";
              $cetak = "hidden";
            } else if ($tampil->approval=="2") {
              $cetak = " ";
              $app = "Setuju";
            }

            $this->table->add_row(
              $no,
              $tampil->nik,
              $tampil->nama_ktp,
              $tampil->status_kerja,
              $tampil->no_npwp,
              $tampil->alamat_ktp,
              $tampil->pajak,
              $tampil->nama_rekening,
              $tampil->no_rekening,
          $this->format->indo($tampil->gaji_casual),
          $tampil->jml_hadir,
          $this->format->indo($tampil->uang_makan_real),
          $this->format->indo(($tampil->jml_hadir * $tampil->uang_makan_real) + ($tampil->jml_hadir * $tampil->gaji_casual)),
          $this->format->indo($tampil->gaji_ekstra),
          $this->format->indo(
            (($tampil->jml_hadir * $tampil->uang_makan_real) + ($tampil->jml_hadir * $tampil->gaji_casual)) + $tampil->gaji_ekstra
          ),
          $this->format->indo((round($tampil->jml_hadir1, 0, PHP_ROUND_HALF_UP) * $tampil->uang_makan_real)),
          $this->format->indo($tampil->pph),
          $this->format->indo($tampil->gaji_diterima),
          $this->format->indo($tampil->gaji_casual),
          $tampil->jml_hadir2,
          $this->format->indo($tampil->uang_makan_real),
          $this->format->indo(($tampil->jml_hadir2 * $tampil->uang_makan_real) + ($tampil->jml_hadir2 * $tampil->gaji_casual)),
          $this->format->indo($tampil->gaji_ekstra2),
          $this->format->indo(
            (($tampil->jml_hadir2 * $tampil->uang_makan_real) + ($tampil->jml_hadir2 * $tampil->gaji_casual)) + $tampil->gaji_ekstra2
          ),
          $this->format->indo((round($tampil->jml_hadir2, 0, PHP_ROUND_HALF_UP) * $tampil->uang_makan_real)),
          $this->format->indo($tampil->pph2),
          $this->format->indo($tampil->gaji_diterima2),
          $tampil->jml_hadir + $tampil->jml_hadir2,
          $this->format->indo(
            ((($tampil->jml_hadir * $tampil->uang_makan_real) + ($tampil->jml_hadir * $tampil->gaji_casual)) + $tampil->gaji_ekstra) + 
            ((($tampil->jml_hadir2 * $tampil->uang_makan_real) + ($tampil->jml_hadir2 * $tampil->gaji_casual)) + $tampil->gaji_ekstra2)
          ),
              $this->format->indo($tampil->gaji_diterima + $tampil->gaji_diterima2),
              $app);

            $no++;
          }
          $tabel=$this->table->generate();
          echo $tabel;
          }else {
            echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
          }
      exit();
    }

  public function ex_gaji_resign()
    {
        $this->load->model('model_gaji');
        $tanggal=time();
        $bln = $this->input->post('bln');
        $thn = $this->input->post('thn');
        if ($bln!=null) {
          $data=$this->model_gaji->detail_gaji_resign($bln,$thn);
        } else {
          $bln = date('m');
          $thn = date('Y');
          $data=$this->model_gaji->detail_gaji_resign($bln,$thn);
        }
        header("Content-type: application/x-msdownload");
        header("Content-Disposition: attachment; filename=DATA_GAJI_RESIGN_KARYAWAN_".$this->format->BulanIndo($bln).".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        /*$tgl1=$this->input->post('tgl1');
        $tgl2=$this->input->post('tgl2');
        $data=$this->model_gaji->rekap_gaji($tgl1,$tgl2);*/
        //$this->table->set_heading(array('NO','NIK','NAMA','JABATAN','DEPARTMENT','NAMA REKENING','NO REKENING','UPAH JAMSOSTEK','GAJI POKOK','TUNJANGAN JABATAN','EKSTRA','PINJ','PPH','JHT','JPK','DP CUTI','GAJI DITERIMA','PAYROLL','APPROVED','KETERANGAN'));
        $this->table->set_heading(array('NO','NIK','NAMA','JABATAN','DEPARTMENT','UPAH JAMSOSTEK','GAJI POKOK','TUNJANGAN JABATAN','EKSTRA','DP CUTI MINUS','DP CUTI PLUS','PINJ','PPH','JHT','JPK','GAJI DITERIMA','APPROVAL','KETERANGAN'));
        $tmp=array('table_open'=>'<table class="table table-hover table-striped table-bordered" >',
                'thead_open'=>'<thead>',
                'thead_close'=> '</thead>',
                'tbody_open'=> '<tbody>',
                'tbody_close'=> '</tbody>',
            );
        $this->table->set_template($tmp);
      if($data==true){
      $no=1;
      $jamsostek = 0;
      $pokok = 0;
      $tunjangan = 0;
      $ekstra = 0;
      $dp_cuti = 0;
      $pinjaman = 0;
      $pph = 0;
      $jht = 0;
      $jpk = 0;
      $diterima = 0;

      foreach ($data as $tampil){

        $jamsostek = $jamsostek+$tampil->field5;
        $pokok = $pokok+$tampil->field5;
        $tunjangan = $tunjangan+$tampil->field7;
        $ekstra = $ekstra+$tampil->field8;
        $dp_cuti = $dp_cuti+$tampil->field9;
        $pinjaman = $pinjaman+$tampil->field10;
        $pph = $pph+$tampil->field11;
        $jht = $jht+$tampil->field12;
        $jpk = $jpk+$tampil->field13;
        $diterima = $diterima+$tampil->field14;

        $array_gaji = array(
          'nik'         => $tampil->field1,
          'nama'        => $tampil->field2,
          'gaji'        => $tampil->field6,
          'extra'       => $tampil->field8,
          'pph'         => $tampil->field11,
          'dp_cuti'     => $tampil->field9,
          'jht'         => $tampil->field12,
          'jpk'         => $tampil->field13,
          'gaji_terima' => $tampil->field14,
          'no_gaji'     => $tampil->id_gaji_karyawan,
          'cabang'      => $tampil->cabang,
          'jabatan'     => $tampil->field3,
          'pinjaman'    => $tampil->field10
        );

        if ($tampil->field15=="0") {
          $app = "Belum";
          $cetak = "hidden";
        } else if ($tampil->field15=="1") {
          $app = "Tidak";
          $cetak = "hidden";
        } else if ($tampil->field15=="2") {
          $cetak = " ";
          $app = "Setuju";
        }

        $this->table->add_row($no,$tampil->field1,$tampil->field2,$tampil->field3,$tampil->field4,$this->format->indo($tampil->field5),$this->format->indo($tampil->field6),$this->format->indo($tampil->field7),$this->format->indo($tampil->field8),$this->format->indo($tampil->field9),$this->format->indo($tampil->field17),$this->format->indo($tampil->field10),$this->format->indo($tampil->field11),$this->format->indo($tampil->field12),$this->format->indo($tampil->field13),$this->format->indo($tampil->field14),$app,$tampil->field16);

        $no++;
      }
          $tabel=$this->table->generate();
          echo $tabel;
          }else {
            echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
          }
      exit();
    }

  public function ex_bonus()
    {
        $this->load->model('bonus');
        $tanggal=time();
        $bln = $this->input->post('bln');
        $thn = $this->input->post('thn');
        if ($bln!=null) {
          $data=$this->bonus->index($bln,$thn);
        } else {
          $bln = date('m');
          $thn = date('Y');
          $data=$this->bonus->index($bln,$thn);
        }
        header("Content-type: application/x-msdownload");
        header("Content-Disposition: attachment; filename=DATA_BONUS_KARYAWAN_".$this->format->BulanIndo($bln).".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        //$this->table->set_heading(array('NO','PLANT','JUMLAH KARYAWAN','JUMLAH OMSET','BONUS BRUTO','MPD','L&B','BONUS PERSEN','BONUS NOMINAL','BONUS PURE','BONUS PER POINT','BONUS PRORATA','APRROVEMENT','KETERANGAN'));
        $this->table->set_heading(array('NO','PLANT','JUMLAH OMSET','MPD','L&B','TOTAL BONUS','TOTAL BULAT','SELISIH PEMBULATAN','BONUS DIBAGI','BONUS TIDAK DIBAGI','APPROVEMENT'));
        $tmp=array('table_open'=>'<table class="table table-hover table-striped table-bordered" >',
                'thead_open'=>'<thead>',
                'thead_close'=> '</thead>',
                'tbody_open'=> '<tbody>',
                'tbody_close'=> '</tbody>',
            );
        $this->table->set_template($tmp);
        /*if($data==true){
          $no=1;
          foreach ($data as $tampil){
            $jml_karyawan=$this->db->where('cabang',$tampil->cabang)->get('tab_karyawan')->num_rows();
            $this->table->add_row($no,$tampil->nama_cabang,$jml_karyawan,$this->format->indo($tampil->omset),$this->format->indo($tampil->bruto),$this->format->indo(($tampil->bruto*$tampil->prosen_mpd)/100),$this->format->indo(($tampil->bruto*$tampil->prosen_lb)/100),$this->format->indo($tampil->bonus_prosen),$this->format->indo($tampil->bonus_nominal),$this->format->indo($tampil->bonus_pure),$this->format->indo($tampil->bonus_point),$this->format->indo($tampil->bonus_prorata),$tampil->approved,$tampil->keterangan);
            $no++;
          }
          $tabel=$this->table->generate();
          echo $tabel;
          }else {
            echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
          }*/
          if($data==true){
          $no=1;
          foreach ($data as $tampil){
            $data2 = $this->bonus->detail($tampil->id_omset,$bln,$thn);

            $sum_total_bonus = 0;
            $sum_total_bulat = 0;
            $sum_total_kembali = 0;
            $sum_total_bonus2 = 0;

            foreach ($data2 as $tampil2){
              if ($tampil2->nik_bonus!=NULL) {

              //SUM
              $sum_total_bonus += $tampil2->total_bonus;
              $sum_total_bulat += $tampil2->total_bulat;
              $sum_total_kembali += $tampil2->total_kembali;
              $sum_total_bonus2 += $tampil2->total_diterima;
              }
            }

            $this->table->add_row($no,$tampil->nama_cabang,$this->format->indo($tampil->omset),$this->format->indo(($tampil->bruto*$tampil->prosen_mpd)/100),$this->format->indo(($tampil->bruto*$tampil->prosen_lb)/100),$this->format->indo($sum_total_bonus),$this->format->indo($sum_total_bulat),$this->format->indo($sum_total_bonus-$sum_total_bulat),$this->format->indo($sum_total_bonus2),$this->format->indo($sum_total_kembali),$tampil->approved);
            $no++;
          }
          $tabel=$this->table->generate();
          echo $tabel;
          }else {
            echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
          }
      exit();
    }

  public function ex_bonus_detail()
    {
        $this->load->model('bonus');
        $tanggal=time();
        $id = $this->input->post('id_cabang');
        $bln = $this->input->post('bln');
        $thn = $this->input->post('thn');
        $data = $this->bonus->detail($id,$bln,$thn);

        header("Content-type: application/x-msdownload");
        header("Content-Disposition: attachment; filename=DETAIL_DATA_BONUS_KARYAWAN_".$this->format->BulanIndo($bln).".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        $this->table->set_heading(array('NO','NIK','NAMA','JABATAN','GRADE','POINT','SENIORITAS','TOTAL POINT','BONUS PERSEN','BONUS NOMINAL','BONUS PER POINT','BONUS PRORATA','TOTAL BONUS','TOTAL BULAT','TOTAL KEMBALI','TOTAL DITERIMA'));
        $tmp=array('table_open'=>'<table class="table table-hover table-striped table-bordered" >',
                'thead_open'=>'<thead>',
                'thead_close'=> '</thead>',
                'tbody_open'=> '<tbody>',
                'tbody_close'=> '</tbody>',
            );
        $this->table->set_template($tmp);
        if($data==true){
        $no=1;
        $sum_total_point = 0;
        $sum_bonus_prosen = 0;
        $sum_bonus_nominal = 0;
        $sum_bonus_point = 0;
        $sum_bonus_prorata = 0;
        $sum_total_bonus = 0;
        $sum_total_bulat = 0;
        $sum_total_kembali = 0;
        $sum_total_bonus2 = 0;

        foreach ($data as $tampil){
          if ($tampil->nik_bonus!=NULL) {

          //SUM
          $sum_total_point += $tampil->total_point;
          $sum_bonus_prosen += $tampil->bonus_prosen;
          $sum_bonus_nominal += $tampil->bonus_nominal;
          $sum_bonus_point += $tampil->bonus_point;
          $sum_bonus_prorata += $tampil->bonus_prorata;
          $sum_total_bonus += $tampil->total_bonus;
          $sum_total_bulat += $tampil->total_bulat;
          $sum_total_kembali += $tampil->total_kembali;
          $sum_total_bonus2 += $tampil->total_diterima;

          $this->table->add_row($no,$tampil->nik,$tampil->nama_ktp,$tampil->jabatan,/*$this->format->indo($bonus_grade)*/$tampil->grade,$tampil->point,$tampil->senioritas,$tampil->total_point,$this->format->indo($tampil->bonus_prosen),$this->format->indo($tampil->bonus_nominal),$this->format->indo($tampil->bonus_point),$this->format->indo($tampil->bonus_prorata),$this->format->indo($tampil->total_bonus),$this->format->indo($tampil->total_bulat),$this->format->indo($tampil->total_kembali),$this->format->indo($tampil->total_diterima));
          $no++;
          }
        }
        $this->table->add_row('',array('data'=>'<b>Total</b>','colspan'=>'6'),$sum_total_point,$this->format->indo($sum_bonus_prosen),$this->format->indo($sum_bonus_nominal),$this->format->indo($sum_bonus_point),$this->format->indo($sum_bonus_prorata),$this->format->indo($sum_total_bonus),$this->format->indo($sum_total_bulat),$this->format->indo($sum_total_kembali),$this->format->indo($sum_total_bonus2));
        $tabel=$this->table->generate();
        echo $tabel;
        }else {
          echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
        }
      exit();
    }

  public function ex_absensi()
    {
        $this->load->model('model_absensi');
        $tanggal=time();
        /*$bln = $this->input->post('bln');
        $thn = $this->input->post('thn');*/
        $cabang = $this->input->post('cabang');
        if ($bln!=null) {
        } else {
          $bln = date('m');
        }
        $data = $this->model_absensi->rekap_absen($cabang);
        header("Content-type: application/x-msdownload");
        header("Content-Disposition: attachment; filename=ABSENSI_REKAP_".strtoupper($this->format->BulanIndo($bln)).".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        $this->table->set_heading(array('Nama Perusahaan','Plant','Jumlah Karyawan '));
        $tmp=array('table_open'=>'<table class="table table-hover table-striped table-bordered" >',
                'thead_open'=>'<thead>',
                'thead_close'=> '</thead>',
                'tbody_open'=> '<tbody>',
                'tbody_close'=> '</tbody>',
            );
        $this->table->set_template($tmp);
        if($data==true){
          $no=1;
          $tgl = date('Y-'.$bln.'-d');
          $tgl_akhir  = date('t', strtotime($tgl));
          foreach ($data as $tampil) {
            $this->table->add_row('CRN',$tampil->field1,intval($tampil->field2/$tgl_akhir));
            $no++;
          }
          $tabel=$this->table->generate();
          echo $tabel;
          }else {
            echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
          }
      exit();
    }

  public function ex_absensi_plant()
    {
        $this->load->model('model_absensi');
        $tanggal=time();
        /*$bln = $this->input->post('bln');
        $thn = $this->input->post('thn');*/
        $cabang = $this->input->post('cabang');
        if ($bln!=null) {
        } else {
          $bln = date('m');
        }
        $data = $this->model_absensi->rekap_absen_plant($cabang);
        header("Content-type: application/x-msdownload");
        header("Content-Disposition: attachment; filename=ABSENSI_REKAP_PLANT_".strtoupper($this->format->BulanIndo($bln)).".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        $this->table->set_heading(array('No','NIK','Nama Employee','Jabatan','Departemen'));
        $tmp=array('table_open'=>'<table class="table table-hover table-striped table-bordered" >',
                'thead_open'=>'<thead>',
                'thead_close'=> '</thead>',
                'tbody_open'=> '<tbody>',
                'tbody_close'=> '</tbody>',
            );
        $this->table->set_template($tmp);
        if($data==true){
          $no=1;
          foreach ($data as $tampil) {
            $this->table->add_row($no,$tampil->field1,$tampil->field2,$tampil->field3,$tampil->field4);
            $no++;
          }
          $tabel=$this->table->generate();
          echo $tabel;
          }else {
            echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
          }
      exit();
    }

  public function ex_absensi_detail()
    {
        $this->load->model('model_absensi');
        $tanggal=time();
        $tgl1 = $this->input->post('tgl1');
        $tgl2 = $this->input->post('tgl2');
        $cabang = $this->input->post('cabang');
        $nik = $this->input->post('nik');
        $data = $this->model_absensi->rekap_absen_detail($cabang,$nik,$tgl1,$tgl2);
        header("Content-type: application/x-msdownload");
        header("Content-Disposition: attachment; filename=ABSENSI_REKAP_DETAIL_".strtoupper($this->format->BulanIndo($bln)).".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        $this->table->set_heading(array('Nama Perusahaan','Plant','Department','Golongan','NIK','Nama Employe','Jabatan','Tanggal Absensi','Kode Shift','Tipe Shift','Jadwal Masuk','Jam Masuk','Status Masuk','Keterangan Masuk','Jadwal Keluar','Jam Keluar','Status Keluar','Keterangan Keluar','Jadwal Masuk 2','Jam Masuk 2','Status Masuk 2','Keterangan Masuk 2','Jadwal Keluar 2','Jam Keluar 2','Status Keluar 2','Keterangan Keluar 2'));
        $tmp=array('table_open'=>'<table class="table table-hover table-striped table-bordered" >',
                'thead_open'=>'<thead>',
                'thead_close'=> '</thead>',
                'tbody_open'=> '<tbody>',
                'tbody_close'=> '</tbody>',
            );
        $this->table->set_template($tmp);
        if($data==true){
          $no=1;
          foreach ($data as $val) {

            $this->table->add_row('CRN',$val->cabang_real,$val->department_real,$val->status_kerja,$val->nik_real,$val->nama_ktp,$val->jabatan_real,$this->format->TanggalIndo($val->tgl_kerja),$val->kode_jam_real,$val->tipe_shift,$val->jam_start,$val->jam_masuk1,$val->status_masuk,$val->keterangan_masuk,$val->jam_finish,$val->jam_keluar1,$val->status_keluar,$val->keterangan_keluar,$val->jam_start2,$val->jam_masuk2,$val->status_masuk2,$val->keterangan_masuk2,$val->jam_finish2,$val->jam_keluar2,$val->status_keluar2,$val->keterangan_keluar2);
            $no++;
          }
          $tabel=$this->table->generate();
          echo $tabel;
          }else {
            echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
          }
      exit();
    }

  public function ex_thr()
    {
        $this->load->model('model_thr');
        $tanggal=time();
        $tgl1=$this->input->post('tanggal1');
        $tgl2=$this->input->post('tanggal2');
        $data = $this->model_thr->rekapitulasi($tgl1,$tgl2);
        header("Content-type: application/x-msdownload");
        header("Content-Disposition: attachment; filename=REKAP_THR_PLANT_".$tgl1."_s/d_".$tgl2.".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        $this->table->set_heading(array('NO','CABANG','JUMLAH KARYAWAN','THR','PPH','THR DITERIMA','JADWAL BAGI','APPROVEMENT','KETERANGAN'));
        $tmp=array('table_open'=>'<table class="table table-hover table-striped table-bordered" >',
                'thead_open'=>'<thead>',
                'thead_close'=> '</thead>',
                'tbody_open'=> '<tbody>',
                'tbody_close'=> '</tbody>',
            );
        $this->table->set_template($tmp);
        if($data==true){
          $no=1;
            foreach ($data as $tampil){
            $this->table->add_row($no,$tampil->field1,$tampil->field2,$this->format->indo($tampil->field3),$this->format->indo($tampil->field4),$this->format->indo($tampil->field5),$this->format->TanggalIndo($tampil->field6),$tampil->field7,$tampil->field8);
            $no++;
            }
          $tabel=$this->table->generate();
          echo $tabel;
          }else {
            echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
          }
      exit();
    }

  public function ex_thr_detail()
    {
        $this->load->model('model_thr');
        $tanggal=time();
        $id_cabang=$this->input->post('cabang');
        $data = $this->model_thr->index2($id_cabang);
        header("Content-type: application/x-msdownload");
        header("Content-Disposition: attachment; filename=REKAP_THR_DETAIL.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        $this->table->set_heading(array('','NO','NIK','NAMA','JABATAN','PLANT','JENIS THR','THR','PPH','THR DITERIMA','JADWAL BAGI','APPROVEMENT','KETERANGAN'));
        $tmp=array('table_open'=>'<table class="table table-hover table-striped table-bordered" >',
                'thead_open'=>'<thead>',
                'thead_close'=> '</thead>',
                'tbody_open'=> '<tbody>',
                'tbody_close'=> '</tbody>',
            );
        $this->table->set_template($tmp);
        if($data==true){
          $no=1;
            foreach ($data as $tampil){
              if ($tampil->approved=='Ya') {
                $mati='';
                $isi_id="";
              }else{
                $isi_id=$tampil->id_thr;
                $mati="disabled";
              }
              $pure_thr=$tampil->tarif-$tampil->pph_thr;
              $this->table->add_row('',$no,$tampil->nik,$tampil->nama_ktp,$tampil->jabatan,$tampil->cabang,$tampil->jns_thr,$this->format->indo($tampil->tarif),$this->format->indo($tampil->pph_thr),$this->format->indo($pure_thr),$this->format->TanggalIndo($tampil->tanggal_ambil),$tampil->approved,$tampil->keterangan);
            $no++;
            }
          $tabel=$this->table->generate();
          echo $tabel;
          }else {
            echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
          }
      exit();
    }

  public function ex_dpcuti()
    {
        $this->load->model('model_dp');
        $tanggal=time();
        $id_cabang=$this->input->post('cabang');
        $tahun=$this->input->post('tahun');
        $bulan=$this->input->post('bulan');
        $data = $this->model_dp->detail_rekap($id_cabang,$bulan,$tahun);
        // print_r($this->db->last_query());
        header("Content-type: application/x-msdownload");
        header("Content-Disposition: attachment; filename=REKAP_DPCUTI.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        /*$this->table->set_heading(array('','NO','NIK','NAMA','JABATAN','PLANT','JENIS THR','THR','PPH','THR DITERIMA','JADWAL BAGI','APPROVEMENT','KETERANGAN'));
        $tmp=array('table_open'=>'<table class="table table-hover table-striped table-bordered" >',
                'thead_open'=>'<thead>',
                'thead_close'=> '</thead>',
                'tbody_open'=> '<tbody>',
                'tbody_close'=> '</tbody>',
            );
        $this->table->set_template($tmp);*/
        if($data==true){
          /*$no=1;
            foreach ($data as $tampil){
              if ($tampil->approved=='Ya') {
                $mati='';
                $isi_id="";
              }else{
                $isi_id=$tampil->id_thr;
                $mati="disabled";
              }
              $pure_thr=$tampil->tarif-$tampil->pph_thr;
              $this->table->add_row('',$no,$tampil->nik,$tampil->nama_ktp,$tampil->jabatan,$tampil->cabang,$tampil->jns_thr,$this->format->indo($tampil->tarif),$this->format->indo($tampil->pph_thr),$this->format->indo($pure_thr),$this->format->TanggalIndo($tampil->tanggal_ambil),$tampil->approved,$tampil->keterangan);
            $no++;
            }
          $tabel=$this->table->generate();
          echo $tabel;*/?>
              <table class="table table-hover table-striped table-bordered" id="tabel" border="1">
                <tr>
                  <th rowspan="2">No</th>
                  <th rowspan="2">NIK</th>
                  <th rowspan="2">Nama</th>
                  <th colspan="6">DP</th>
                  <th colspan="5">Cuti</th>
                </tr>
                <tr>
                <?php
                  if ($bulan == '1' || $bulan == '01') {
                ?>
                  <th>Saldo Akhir DP <?=$this->format->BulanIndo('12').' '.($tahun-1)?></th>
                  <th>Adjusment</th>
                  <th>Saldo Awal DP <?=$this->format->BulanIndo($bulan).' '.$tahun?></th>
                  <th>Jth DP</th>
                  <th>Libur</th>
                  <th>Saldo Akhir DP <?=$this->format->BulanIndo($bulan).' '.$tahun?></th>
                  <th>Saldo Akhir Cuti <?=$this->format->BulanIndo('12').' '.($tahun-1)?></th>
                  <th>Adjusment</th>
                  <!--<th>Cuti (Minus)</th>-->
                  <th>Saldo Awal Cuti <?=$this->format->BulanIndo($bulan).' '.$tahun?></th>
                  <th>Minus DP <?=$this->format->BulanIndo($bulan).' '.$tahun?></th>
                  <!--<th>Saldo Cuti Hangus <?=$this->format->BulanIndo($bulan).' '.($tahun-1)?></th>-->
                  <!--<th>Saldo Akhir Cuti <?=$tahun-1?></th>-->
                  <th>Saldo Akhir Cuti <?=$this->format->BulanIndo($bulan).' '.$tahun?></th>
                <?php
                  } else {
                ?>
                  <th>Saldo Akhir DP <?=$this->format->BulanIndo($bulan-1).' '.$tahun?></th>
                  <th>Adjusment</th>
                  <th>Saldo Awal DP <?=$this->format->BulanIndo($bulan).' '.$tahun?></th>
                  <th>Jth DP</th>
                  <th>Libur</th>
                  <th>Saldo Akhir DP <?=$this->format->BulanIndo($bulan).' '.$tahun?></th>
                  <th>Saldo Akhir Cuti <?=$this->format->BulanIndo($bulan-1).' '.$tahun?></th>
                  <th>Adjusment</th>
                  <!--<th>Cuti (Minus)</th>-->
                  <th>Saldo Awal Cuti <?=$this->format->BulanIndo($bulan).' '.$tahun?></th>
                  <th>Minus DP <?=$this->format->BulanIndo($bulan).' '.$tahun?></th>
                  <!--<th>Saldo Cuti Hangus <?=$this->format->BulanIndo($bulan).' '.($tahun-1)?></th>-->
                  <!--<th>Saldo Akhir Cuti <?=$tahun-1?></th>-->
                  <th>Saldo Akhir Cuti <?=$this->format->BulanIndo($bulan).' '.$tahun?></th>
                <?php
                  }
                ?>
                </tr>
                <?php
                $no=1;
                foreach ($data as $tampil) {
                  $new_bln = date($tahun.'-'.$tampil->bln.'-d');
                  $bln_fix = date('m',strtotime($new_bln));
                  $thn_fix = date('Y',strtotime($new_bln));
                  
                  if ($bln_fix == '1' || $bln_fix == '01') {
                    $new_bln2 = date(($thn_fix-1).'-'.(12).'-d');
                    $bln_fix2 = date('m',strtotime($new_bln2));
                    $thn_fix2 = date('Y',strtotime($new_bln2));
                  } else {
                    $new_bln2 = date($thn_fix.'-'.($tampil->bln-1).'-d');
                    $bln_fix2 = date('m',strtotime($new_bln2));
                    $thn_fix2 = date('Y',strtotime($new_bln2));
                  }

                  $begin_day_unix   = strtotime($new_bln.' 00:00:00');
                  $begin_day_unix2  = strtotime($new_bln2.' 00:00:00');

                  $hari_ini = $tahun.'-'.$bulan; // misal 8-2016 (sekarang)
                  $tgl_pertama  = date('Y-m-01', strtotime($hari_ini)); // awal bulan
                  $tgl_terakhir   = date('Y-m-t', strtotime($hari_ini)); // akhir bulan

                  // if ($tampil->nik_resign==NULL||$tampil->tanggal_resign>$tgl_pertama) {
                  /*if ($tampil->nik_resign==NULL||$tampil->tanggal_resign<$tampil->tanggal_masuk||$tampil->tanggal_masuk<$tgl_terakhir) {
                  if ($tampil->tanggal_masuk<$tgl_terakhir) {*/

                  /*$cuti=$this->db->where('nik',$tampil->nik)
                           ->where('month(tanggal_mulai)',$bln_fix)
                           ->where('cuti_khusus','Tidak')
                           ->select('sum(lama_cuti) as jml_cuti')
                           ->get('tab_cuti')->row();*/
                  /*$izin=$this->db->where('nik',$tampil->nik)
                           ->where('month(tanggal_mulai)',$bln_fix)
                           ->where('jenis_izin','Tidak Dapat Masuk')
                           ->select('sum(lama) as jml_izin')
                           ->get('tab_izin')->row();*/
                  $saldo_bln_lalu=$this->db->where('nik',$tampil->nik)
                               ->where("bulan",$bln_fix2)
                               ->where("tahun",$thn_fix2)
                               ->select("*")
                               ->get('tab_master_dp')->row();
//                  echo $this->db->last_query();
                  /*$saldo_thn_lalu=$this->db->where('nik',$tampil->nik)
                               ->where('bulan',$tampil->bln)
                               ->where('tahun',$tampil->thun-1)
                               ->select("saldo_cuti")
                               ->get('tab_master_dp')->row();*/
                  $total_thun_lalu=$this->db->where('nik',$tampil->nik)
                                           ->where('year(bulan)',$tampil->thun-1)
                                           ->select("sum(saldo_cuti) as total")
                                           ->get('tab_master_dp')->row();

                  //MENCARI JATAH DP
                  // CARI JUMLAH DP
                  $hari_ini = $tahun.'-'.$bulan; // misal 8-2016 (sekarang)
                  $tgl_pertama  = date('Y-m-01', strtotime($hari_ini)); // awal bulan
                  $tgl_terakhir   = date('Y-m-t', strtotime($hari_ini)); // akhir bulan

                  $detik = 24 * 3600; // jumlah detik dalam 1 hari

                  $tgl_awal   = strtotime($tgl_pertama);
                  $tgl_akhir  = strtotime($tgl_terakhir);

                  $minggu = 0;

                  if (date('Y-m-d',strtotime($tgl_pertama))<date('Y-m-d',strtotime($tampil->tanggal_masuk))) {
                    // cari jumlah minggu dalam 1 bulan
                    for ($i=strtotime($tampil->tanggal_masuk); $i <= $tgl_akhir; $i += $detik)
                    {
                      if (date("w", $i) == "0"){
                        $minggu++;
                      }
                    }
                    $cari_jml = $this->db->query(
                      '
                      select sum(lama) as jml from tab_hari_libur 
                      where tanggal_mulai>="'.$tampil->tanggal_masuk.'" and tanggal_selesai<="'.$tgl_terakhir.'" and cuti_khusus="Ya"
                      '
                    );
                  } else {
                    // cari jumlah minggu dalam 1 bulan
                    for ($i=$tgl_awal; $i <= $tgl_akhir; $i += $detik)
                    {
                      if (date("w", $i) == "0"){
                        $minggu++;
                      }
                    }
                    $cari_jml = $this->db->query(
                      '
                      select sum(lama) as jml from tab_hari_libur 
                      where tanggal_mulai>="'.$tgl_pertama.'" and tanggal_selesai<="'.$tgl_terakhir.'" and cuti_khusus="Ya"
                      '
                    ); 
                  }

                  if ($cari_jml<>null) // jika ada data
                  {
                    foreach ($cari_jml->result() as $valcari) {
                      $jml_libur = $valcari->jml; // jumlah hari libur non minggu ketemu
                    
                    }
                  } 
                  else 
                  {
                    $jml_libur = 0;
                  }


                  $jatah_dp = $jml_libur+$minggu;
                  //++++++++++++++++//

                  /*if ($saldo_bln_lalu->saldo_dp<0) {
                    $adj=abs($saldo_bln_lalu->saldo_dp);
                    $dp_min=abs($saldo_bln_lalu->saldo_dp);
                  }else{
                    $adj=0;
                    $dp_min=0;
                  }

                  if ($saldo_thn_lalu->saldo_cuti<0) {
                    $min_cuti=abs($saldo_thn_lalu->saldo_cuti);
                    $saldo_hangus=0;
                  }else{
                    $min_dp=0;
                    $saldo_hangus=$saldo_thn_lalu->saldo_cuti;
                  }*/

                  //$libur=$izin->jml_izin+$cuti->jml_cuti;
                  if (date('Y-m-d',strtotime($tgl_pertama))<date('Y-m-d',strtotime($tampil->tanggal_masuk))) {
                    $absen_query = $this->db->select('a.*,a.kode_jam as kode_jam_fix,b.*')
                                            ->from('tab_absensi a')
                                            ->join('tab_jam_kerja b','b.kode_jam=a.kode_jam','inner')
                                            ->where('a.nik',$tampil->nik)
                                            ->where('a.tgl_kerja >=',date('Y-m-d',strtotime($tampil->tanggal_masuk)))
                                            ->where('a.tgl_kerja <=',$tgl_terakhir)
                                            ->get();
                  } else {
                    $absen_query = $this->db->select('a.*,a.kode_jam as kode_jam_fix,b.*')
                                            ->from('tab_absensi a')
                                            ->join('tab_jam_kerja b','b.kode_jam=a.kode_jam','inner')
                                            ->where('a.nik',$tampil->nik)
                                            ->where('a.tgl_kerja >=',$tgl_pertama)
                                            ->where('a.tgl_kerja <=',$tgl_terakhir)
                                            ->get();
                  }

                  $jml_absen = 0;
                  if ($absen_query<>false) {
                    foreach ($absen_query->result() as $row) {
                      if ($row->tipe_shift=="Pagi"||$row->tipe_shift=="Sore") {
                        if ($row->status_masuk=="Bolos") {
                          $jml_absen++;
                        } else if ($row->keterangan_keluar=="Pulang Cepat") {
                          $time1    = strtotime($row->jam_masuk1);
                          $time2    = strtotime($row->jam_keluar1);
                          $selisih  = date('H:i:s', ($time2 - ($time1 - $begin_day_unix)));
                          $batas = date('H:i:s', (strtotime("05:00:00")));
                          if ($selisih<$batas) {
                            $jml_absen += 0.5;
                          }
                        /*  $time1    = strtotime($row->jam_masuk1);
                          $time2    = strtotime($row->jam_keluar1);
                          $selisih  = date('H:i:s', ($time2 - ($time1 - $begin_day_unix)));
                          $batas = date('H:i:s', (strtotime("05:00:00"));
                          if ($selisih<$batas) {
                            $jml_absen += 0.5;
                          }
                        } else if ($row->keterangan_masuk=="Telat") {
                          $jam_telat = date('i', strtotime($row->jam_masuk1));
                          $jam1 = 60;
                          $jam2 = 8;

                          if ($jam_telat) {
                            $jml_absen += round($jam_telat/$jam1/$jam2,2,PHP_ROUND_HALF_DOWN);
                          }*/
                        } else if ($row->keterangan_masuk=="Telat") {
                          $jam_telat = date('i', strtotime($row->jam_masuk1));
                          $jam1 = 60;
                          $jam2 = 8;

                          if ($jam_telat) {
                            $jml_absen += round($jam_telat/$jam1/$jam2,2,PHP_ROUND_HALF_UP);
                          }

                        } 

                        if ($row->status_masuk!="Bolos") {
                          if ($row->kode_jam_fix=="N"||$row->kode_jam_fix=="O"||$row->kode_jam_fix=="P"||$row->kode_jam_fix=="Q"||$row->kode_jam_fix=="R") {
                            $jml_absen += 0.5;
                          } 
                        }

                      } else if ($row->tipe_shift=="Pagi&Sore") {
                        if ($row->status_masuk=="Bolos") {
                          $jml_absen += 0.5;
                        }

                        if ($row->status_masuk2=="Bolos") {
                          $jml_absen += 0.5;
                        } 

                        if ($row->keterangan_keluar=="Pulang Cepat"||$row->keterangan_keluar2=="Pulang Cepat") {
                          $time1a    = strtotime($row->jam_masuk1);
                          $time2a    = strtotime($row->jam_keluar1);
                          $time1b    = strtotime($row->jam_masuk2);
                          $time2b    = strtotime($row->jam_keluar2);
                          $selisih1  = date('H:i:s', ($time2a - ($time1a - $begin_day_unix)));
                          $selisih2  = date('H:i:s', ($time2b - ($time1b - $begin_day_unix)));
                          if (($selisih1+$selisih2)<$batas) {
                            $jml_absen += 0.5;
                          }
                        } 
                        
                        if ($row->keterangan_masuk=="Telat") {
                          $jam_telat = date('i', strtotime($row->jam_masuk1));
                          $jam1 = 60;
                          $jam2 = 8;

                          if ($jam_telat) {
                            $jml_absen += round($jam_telat/$jam1/$jam2,2,PHP_ROUND_HALF_UP);
                          }
                        } 
                        
                        if ($row->keterangan_masuk2=="Telat") {
                          $jam_telat = date('i', strtotime($row->jam_masuk2));
                          $jam1 = 60;
                          $jam2 = 8;

                          if ($jam_telat) {
                            $jml_absen += round($jam_telat/$jam1/$jam2,2,PHP_ROUND_HALF_UP);
                          }
                        }

                        if ($row->status_masuk!="Bolos") {
                          if ($row->kode_jam_fix=="N"||$row->kode_jam_fix=="O"||$row->kode_jam_fix=="P"||$row->kode_jam_fix=="Q"||$row->kode_jam_fix=="R") {
                            $jml_absen += 0.5;
                          } 
                        }

                      } else if ($row->tipe_shift=="Libur") {
                        if ($row->jam_masuk1!="00:00:00"&&$row->jam_masuk2=="00:00:00") {
                          if ($row->keterangan_masuk=="Libur") {
                            $jml_absen ++;
                          } 
                        } else {
                          if ($row->keterangan_masuk=="Libur") {
                            $jml_absen += 0.5;
                          }
                          if ($row->keterangan_masuk2=="Libur") {
                            $jml_absen += 0.5;
                          } 
                        }

                        if ($row->kode_jam_fix=="N"||$row->kode_jam_fix=="O"||$row->kode_jam_fix=="P"||$row->kode_jam_fix=="Q"||$row->kode_jam_fix=="R") {
                          $jml_absen += 0.5;
                        }
                      }
                    }
                  }

                  
                  if (date('Y-m-d',strtotime($tgl_pertama))<date('Y-m-d',strtotime($tampil->tanggal_masuk))) {
                    $cuti_query = $this->db->select('*')
                                           ->from('tab_cuti')
                                           ->where('nik',$tampil->nik)
                                           ->where('tanggal_mulai >=',date('Y-m-d',strtotime($tampil->tanggal_masuk)))
                                           ->where('tanggal_mulai <=',$tgl_terakhir)
                                           ->where('cuti_khusus','Tidak')
                                           ->get();
                  } else {
                    $cuti_query = $this->db->select('*')
                                           ->from('tab_cuti')
                                           ->where('nik',$tampil->nik)
                                           ->where('tanggal_mulai >=',$tgl_pertama)
                                           ->where('tanggal_mulai <=',$tgl_terakhir)
                                           ->where('cuti_khusus','Tidak')
                                           ->get();
                  }

                  $jml_cuti = 0;
                  if ($cuti_query<>false) {
                    foreach ($cuti_query->result() as $row) {
                      $jml_cuti += $row->lama_cuti;
                    }
                  }

                  
                  if (date('Y-m-d',strtotime($tgl_pertama))<date('Y-m-d',strtotime($tampil->tanggal_masuk))) {
                    $izin_query = $this->db->select('*')
                                         ->from('tab_izin')
                                         ->where('nik',$tampil->nik)
                                         ->where('tanggal_mulai >=',date('Y-m-d',strtotime($tampil->tanggal_masuk)))
                                         ->where('tanggal_mulai <=',$tgl_terakhir)
                                         ->where('id_potong',1)
                                         ->get();
                  } else {
                    $izin_query = $this->db->select('*')
                                         ->from('tab_izin')
                                         ->where('nik',$tampil->nik)
                                         ->where('tanggal_mulai >=',$tgl_pertama)
                                         ->where('tanggal_mulai <=',$tgl_terakhir)
                                         ->where('id_potong',1)
                                         ->get();
                  }

                  $jml_izin = 0;
                  if ($izin_query<>false) {
                    foreach ($izin_query->result() as $row) {
                      $jml_izin += $row->lama;
                    }
                  }

                  $libur = $jml_absen + $jml_cuti + $jml_izin;
                  /*echo "<tr>
                       <td>$no</td>
                       <td>$tampil->nama_ktp</td>
                       <td>$saldo_bln_lalu->saldo_dp</td>
                       <td>$jatah_dp</td>
                       <td>$libur</td>
                       <td>$tampil->saldo_dp</td>
                       <td>$total_thun_lalu->total</td>
                       <td>$adj</td>
                       <td>$tampil->saldo_cuti</td>
                       <td>$dp_min</td>
                       <td>$min_dp</td>
                       <td>$saldo_hangus</td>
                       <td>0</td>
                       <td>$tampil->saldo_cuti</td>
                    </tr>";*/
                  if ($tampil->tanggal_masuk>=$tgl_pertama&&$tampil->tanggal_masuk<=$tgl_terakhir) {
                    $dp_bln_lalu_real = $saldo_bln_lalu->saldo_dp;
                    if ($tampil->status_kerja=="Kontrak 1") {
                      $dp_bln_lalu_real = 0;
                    } else if ($tampil->status_kerja=="Kontrak 2") {
                      if ($dp_bln_lalu_real!=NULL) {
                        $dp_bln_lalu_real = $dp_bln_lalu_real;
                      } else {
                        $dp_bln_lalu_real = 0;
                      } 
                    }
                  } else {
                    $dp_bln_lalu_real = $saldo_bln_lalu->saldo_dp;
                    if ($dp_bln_lalu_real!=NULL) {
                      $dp_bln_lalu_real = $dp_bln_lalu_real;
                    } else {
                      $dp_bln_lalu_real = 0;
                    } 
                  }

                  $ekstra_query = $this->db->select('*')
                                         ->from('tab_extra')
                                         ->where('nik',$tampil->nik)
                                         ->where('tanggal_ekstra >=',$tgl_pertama)
                                         ->where('tanggal_ekstra <=',$tgl_terakhir)
                                         ->where('vakasi','Tambah DP Libur')
                                         ->get();

                  $jml_ekstra = 0;
                  if ($ekstra_query<>false) {
                    foreach ($ekstra_query->result() as $row) {
                      $jml_ekstra += $row->jumlah_vakasi;
                    }
                  }

                  if ($dp_bln_lalu_real>0) {
                    $adj_dp = 0 + $jml_ekstra;
                  } else {
                    $adj_dp = $jml_ekstra + abs($dp_bln_lalu_real);
                  }

                  if ($dp_bln_lalu_real>$libur&&$jatah_dp!=0) {
                    $adj_dp = $adj_dp - ($dp_bln_lalu_real - $libur);
                  }


                  if ($tampil->tanggal_masuk>=$tgl_pertama&&$tampil->tanggal_masuk<=$tgl_terakhir) {
                    $dp_bln_lalu = $saldo_bln_lalu->saldo_dp + $adj_dp;
                    if ($tampil->status_kerja=="Kontrak 1") {
                      $dp_bln_lalu = 0;
                    } else if ($tampil->status_kerja=="Kontrak 2") {
                      if ($dp_bln_lalu_real!=NULL) {
                        $dp_bln_lalu = $dp_bln_lalu;
                      } else {
                        $dp_bln_lalu = 0;
                      } 
                    }
                  } else {
                    if ($saldo_bln_lalu->saldo_dp!=NULL) {
                      if ($saldo_bln_lalu->saldo_dp>0) {
                        $dp_bln_lalu = $saldo_bln_lalu->saldo_dp + $adj_dp; 
                      } else if ($adj_dp>$dp_bln_lalu_real) {
                        $dp_bln_lalu = $saldo_bln_lalu->saldo_dp + $adj_dp; 
                      } else {
                        $dp_bln_lalu = 0;
                      }
                    } else {
                      $dp_bln_lalu = 0;
                    }
                  }

                  $dp_bln_sekarang = ($jatah_dp + $dp_bln_lalu) - ($jml_absen + $jml_cuti + $jml_izin);

                  if ($dp_bln_sekarang<0) {
                    $minus_dp = $dp_bln_sekarang;
                  } else {
                    $minus_dp = 0;
                  }

                  if ($tampil->status_kerja=="Kontrak 1") {
                    $cuti_bln_lalu = 0;
                    $adj_cuti = 0;
                    $cuti_awal = 0;
                  } else {
                    if ($saldo_bln_lalu->saldo_cuti!=NULL) {
                      $cuti_bln_lalu = $saldo_bln_lalu->saldo_cuti;
                    }

                    if ($cuti_bln_lalu>0) {
                      $adj_cuti = 0;
                    } else {
                      $adj_cuti = abs($cuti_bln_lalu);
                    }

                    if ($cuti_bln_lalu>0) {
                      $cuti_awal = $cuti_bln_lalu;
                    } else {
                      $cuti_awal = 0;
                    }
                  }

                  $cuti_bln_sekarang = $cuti_awal + $minus_dp; 

                  if ($tgl_pertama==$tampil->tanggal_masuk&&$tampil->status_kerja!="Kontrak 1") {
                    $adj_cuti = 12;
                    $cuti_awal = 12;
                    $cuti_bln_sekarang = 12;
                  }

                  if ($bln_fix == '1' || $bln_fix == '01') {
                    if ($tampil->status_kerja == "Tetap") {
                      $adj_cuti = $cuti_bln_lalu + 12;
                      $cuti_awal = $adj_cuti;
                      $cuti_bln_sekarang = $cuti_awal + $minus_dp;
                    }
                  }

                  echo "<tr>
                        <td>$no</td>
                        <td>$tampil->nik</td>
                        <td>$tampil->nama_ktp</td>
                        <td align='right'>
                          ".number_format($dp_bln_lalu_real,2,',','.')."
                        </td>
                        <td align='right'>
                          ".number_format($adj_dp,2,',','.')."
                        </td>
                        <td align='right'>
                          ".number_format($dp_bln_lalu,2,',','.')."
                        </td>
                        <td align='right'>
                          ".number_format($jatah_dp,2,',','.')."
                        </td>
                        <td align='right'>
                          ".number_format($libur,2,',','.')."
                        </td>
                        <td align='right'>
                          ".number_format($dp_bln_sekarang,2,',','.')."
                        </td>
                        <td align='right'>
                          ".number_format($cuti_bln_lalu,2,',','.')."
                        </td>
                        <td align='right'>
                          ".number_format($adj_cuti,2,',','.')."
                        </td>
                        <td align='right'>
                          ".number_format($cuti_awal,2,',','.')."
                        </td>
                        <td align='right'>
                          ".number_format($minus_dp,2,',','.')."
                        </td>
                        <td align='right'>
                          ".number_format($cuti_bln_sekarang,2,',','.')."
                        </td>
                    </tr>";
                  $no++;
                  // }
                  // }
                }
                ?>
              </table>
          <?php }else {
            echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
          }
      exit();
    }

    function ex_omset(){
        $this->load->model('bonus');
        $tanggal=time();
        header("Content-type: application/x-msdownload");
        header("Content-Disposition: attachment; filename=REKAPITULASI_OMSET_".$tanggal.".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        $tgl1=$this->input->post('tanggal1');
        $tgl2=$this->input->post('tanggal2');
        $cb=$this->input->post('cabang');
        $data= $this->bonus->rekapitulasi_omset($tgl1,$tgl2,$cb);
        $this->table->set_heading(array('NO','PLANT','JUMLAH KARYAWAN','BULAN','OMSET','MPD','L&B','TOTAL BONUS','BONUS TERBAGI','BONUS TIDAK DIBAGI','SELISIH'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
                        'thead_open'=>'<thead>',
                        'thead_close'=> '</thead>',
                        'tbody_open'=> '<tbody>',
                        'tbody_close'=> '</tbody>',
                );
        $this->table->set_template($tmp);
        if($data==true){
        $no=1;$sisa=0;
        foreach ($data as $tampil){
        $sisa=$tampil->pure_bonus*2-$tampil->bonus_bagi;
        $this->table->add_row($no,$tampil->cabang,$tampil->jml_karyawan,$this->format->BulanIndo($tampil->bln_omset),$this->format->indo($tampil->omset),$this->format->indo($tampil->prosen_mpd),
                    $this->format->indo($tampil->prosen_lb),$this->format->indo($tampil->pure_bonus*2),$this->format->indo($tampil->bonus_bagi),
                    $this->format->indo($sisa),'0');
        $no++;
        }
        $tabel=$this->table->generate();
        echo $tabel;
        }else {
        echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
        }
    }

    public function ex_hadir()
    {
      $this->load->model('model_absensi');
      $tanggal=time();
      header("Content-type: application/x-msdownload");
      header("Content-Disposition: attachment; filename=REKAP_KEHADIRAN_KARYAWAN_".$tanggal.".xls");
      header("Pragma: no-cache");
      header("Expires: 0");
      $cabang=$this->input->post('cabang');
      if ($this->input->post('tgl1',true)==NULL) {
        $tgl1 = date('Y-m-01');
        $tgl2 = date('Y-m-t');
      } else {
        $tgl1 = $this->input->post('tgl1',true);
        $tgl2 = $this->input->post('tgl2',true); 
      }
      $data['tgl1'] = $tgl1;
      $data['tgl2'] = $tgl2;
      $data=$this->model_absensi->get_employe($cabang);
      $this->table->set_heading(array('Nama Perusahaan','Plant','Department','Golongan','NIK','Nama Employe','Jabatan','Lama Kerja STD','Lama Kerja Real','Jumlah Kehadiran','Cuti','Ijin','Alpha','Sakit','Terlambat','Pulang Mendahului','Jumlah Ekstra'));
      $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
        'thead_open'=>'<thead>',
        'thead_close'=> '</thead>',
        'tbody_open'=> '<tbody>',
        'tbody_close'=> '</tbody>',
      );
      $this->table->set_template($tmp);
      $no=1;
      foreach ($data as $tampil){
          $tgl_absen=date('Y-m-d',strtotime($tampil->jam_masuk));
          /*$q_jdwal=$this->db->join('tab_jam_kerja b','b.kode_jam=a.kode_jam')
                            ->where('a.nik',$tampil->nik)
                            ->where('month(a.tanggal)',$bulan)
                            ->where('Year(a.tanggal)',$tahun)
                            ->select('sum(b.lama) as jml_kerja')
                            ->get('tab_jadwal_karyawan a')
                            ->row();
          $q_absen=$this->db->join('tab_absensi_keluar b','b.nik=a.nik')
                            ->where('month(a.jam_masuk)',$bulan)
                            ->where('Year(a.jam_masuk)',$tahun)
                            ->where('a.nik',$tampil->nik)
                            ->select('count(a.nik) as jml_hadir,timediff(b.jam_keluar,a.jam_masuk) as jml_absen',false)
                            ->get('tab_absensi_masuk a')
                            ->row();*/
                    $q_jdwal = $this->db->query(
                      '
                      SELECT a.nik, b.jam_start, b.jam_finish, b.jam_start2, b.jam_finish2 
                      FROM tab_jadwal_karyawan a 
                      JOIN tab_jam_kerja b ON b.kode_jam=a.kode_jam 
                      WHERE a.tanggal>="'.$tgl1.'" AND a.tanggal<="'.$tgl2.'" 
                      AND a.nik="'.$tampil->nik.'"
                      '
                    );
                    $lama = 0;
                    foreach ($q_jdwal->result() as $val) {
                      $lama = $lama + ((strtotime($val->jam_finish)-strtotime($val->jam_start))/3600)+((strtotime($val->jam_finish2)-strtotime($val->jam_start2))/3600);
                    }
                    $q_absen = $this->db->query(
                      '
                      SELECT a.nik, a.jam_masuk1, a.jam_keluar1, 
                      a.status_masuk, a.keterangan_masuk, 
                      a.status_keluar, a.keterangan_keluar, 
                      a.jam_masuk2, a.jam_keluar2, 
                      a.status_masuk2, a.keterangan_masuk2, 
                      a.status_keluar2, a.keterangan_keluar2
                      FROM tab_absensi a 
                      WHERE a.tgl_kerja>="'.$tgl1.'" AND a.tgl_kerja="'.$tgl2.'" 
                      AND a.nik="'.$tampil->nik.'"
                      '
                    );
                    $lama2 = 0;
                    $jam_lama1 = 0;
                    $jam_lama2 = 0;
                    $jml_hadir = 0;
                    $jml_bolos = 0;
                    foreach ($q_absen->result() as $val) {
                      if ($val->status_masuk!="Masuk Tidak Lengkap"||$val->status_keluar!="Masuk Tidak Lengkap") {
                        $jam_lama1 = ((strtotime($val->jam_keluar1)-strtotime($val->jam_masuk1))/3600);
                      }
                      if ($val->status_masuk2!="Masuk Tidak Lengkap"||$val->status_keluar2!="Masuk Tidak Lengkap") {
                        $jam_lama2 = ((strtotime($val->jam_keluar2)-strtotime($val->jam_masuk2))/3600);
                      }
                      if ($val->status_masuk=="Masuk"||$val->status_masuk=="Masuk Tidak Lengkap"||$val->status_masuk2=="Masuk"||$val->status_masuk2=="Masuk Tidak Lengkap") {
                        $jml_hadir++;
                      }
                      if ($val->status_masuk=="Bolos"||$val->status_masuk2=="Bolos") {
                        $jml_bolos++;
                      }
                      $lama2 = $lama2 + $jam_lama1 + $jam_lama2;
                    }
          $q_ekstra=$this->db
                            ->where('tanggal_ekstra >=',$tgl1)
                            ->where('tanggal_ekstra <=',$tgl2)
                            ->where('nik',$tampil->nik)
                            ->select("sum(if(vakasi='Dibayar',jumlah_vakasi,0)) as total_ekstra,sum(if(vakasi='Tambah DP Libur',jumlah_vakasi,0)) as total_dp",false)
                            ->get('tab_extra')
                            ->row();
          $q_izin=$this->db
                            ->where('tanggal_mulai >=',$tgl1)
                            ->where('tanggal_mulai <=',$tgl2)
                            ->where('nik',$tampil->nik)
                            ->select("sum(if(jenis_izin='Datang Pukul',1,0)) as jml_telat,sum(if(jenis_izin='Pulang Pukul',1,0)) as jml_plg,sum(if(jenis_izin='Tidak Dapat Masuk',lama,0)) as jml_izin,sum(if(alasan like '%sakit%',lama,0)) as jml_sakit",false)
                            ->get('tab_izin')
                            ->row();
          $q_cuti=$this->db
                            ->where('tanggal_mulai >=',$tgl1)
                            ->where('tanggal_mulai <=',$tgl2)
                            ->where('nik',$tampil->nik)
                            ->select("sum(lama_cuti) as jml_cuti")
                            ->get('tab_cuti')
                            ->row();
          if (!empty($q_absen->jml_absen)) {
              $real=date('H:i',strtotime($q_absen->jml_absen));
          }else{
            $real=0;
          }
          $q_dp=$this->db->where('nik',$tampil->nik)->select('saldo_dp')->get('tab_master_dp')->row();
          $this->table->add_row('CRN',$tampil->cabang,$tampil->department,$tampil->status_kerja,$tampil->nik,$tampil->nama_ktp,$tampil->jabatan,$lama,$lama2,$jml_hadir,$q_cuti->jml_cuti,$q_izin->jml_izin,$jml_bolos,$q_izin->jml_sakit,$q_izin->jml_telat,$q_izin->jml_plg,$q_ekstra->total_ekstra);
      $no++;
      }
      $tabel=$this->table->generate();
      echo $tabel;
    }

    /*public function ex_absensi()
      {
        $this->load->model('model_absensi');
        $tanggal=time();
        header("Content-type: application/x-msdownload");
        header("Content-Disposition: attachment; filename=DATA_absensi_KARYAWAN_".$tanggal.".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        $tgl=$this->input->post('tanggal');
        $cabang=$this->input->post('cabang');
        $data=$this->model_absensi->rekap_absen($tgl,$cabang);
        $this->table->set_heading(array('Nama Perusahaan','Plant','Department','Golongan','NIK','Nama Employe','Jabatan','Tanggal Absensi','Jadwal Masuk','Jadwal Keluar','Jam Masuk','Jam Keluar','Keterangan','Ket. Izin','Alpha','Masuk','Kode Shift','Lama Kerja STD','Lama Kerja Real','Keterangan Ekstra','Jumlah Ekstra','Real Lembur DP','Keterangan Jam Kerja'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
          'thead_open'=>'<thead>',
          'thead_close'=> '</thead>',
          'tbody_open'=> '<tbody>',
          'tbody_close'=> '</tbody>',
        );
        $this->table->set_template($tmp);
        $no=1;
        foreach ($data as $tampil){
            $tgl_absen=date('Y-m-d',strtotime($tampil->jam_masuk));
            $q_jdwal=$this->db->join('tab_jam_kerja b','b.kode_jam=a.kode_jam')
                              ->where('a.nik',$tampil->nik)
                              ->where('a.tanggal',date('Y-m-d',strtotime($tgl_absen)))
                              ->get('tab_jadwal_karyawan a')
                              ->row();
            $q_absen=$this->db->join('tab_absensi_keluar b','b.nik=a.nik')
                              ->where('date(a.jam_masuk)',date('Y-m-d',strtotime($tgl_absen)))
                              ->where('date(b.jam_keluar)',date('Y-m-d',strtotime($tgl_absen)))
                              ->where('a.nik',$tampil->nik)
                              ->get('tab_absensi_masuk a')
                              ->row();
            $q_ekstra=$this->db
                              ->where('tanggal_ekstra',date('Y-m-d',strtotime($tgl_absen)))
                              ->where('nik',$tampil->nik)
                              ->get('tab_extra')
                              ->row();
            $q_izin=$this->db
                              ->where('date(tanggal_mulai) <=',date('Y-m-d',strtotime($tgl_absen)))
                              ->where('tanggal_finish >=',date('Y-m-d',strtotime($tgl_absen)))
                              ->where('nik',$tampil->nik)
                              ->select('alasan')
                              ->get('tab_izin')
                              ->row();
            if(count($q_jdwal)==0) {
                $ktr="Libur";
                $alpha=0;
                $lama_real=0;
                $hadir=0;
            }else {
              if ($q_absen->status=="On Time") {
                $ktr="Masuk";
                $alpha=0;
                $hadir=1;
                $lama_real=date("H:i:s",strtotime($q_absen->jam_keluar))-date("H:i:s",strtotime($q_absen->jam_masuk));
              }elseif ($q_absen->status=="Terlambat") {
                $ktr="Masuk tidak lengkap";
                $alpha=0;
                $hadir=1;
                $lama_real=date("H:i:s",strtotime($q_absen->jam_keluar))-date("H:i:s",strtotime($q_absen->jam_masuk));
              }elseif(count($q_izin)>=1){
                $ktr="Izin";
                $alpha=0;
                $hadir=0;
                $lama_real=0;
              }else{
                $ktr="Alpha";
                $alpha=1;
                $hadir=0;
                $lama_real=0;
              }
            }
            $this->table->add_row('CRN',$tampil->cabang,$tampil->department,$tampil->status_kerja,$tampil->nik,$tampil->nama_ktp,$tampil->jabatan,$this->format->TanggalIndo($tgl_absen),$q_jdwal->jam_start,$q_jdwal->jam_finish,$q_absen->jam_masuk,$q_absen->jam_keluar,$ktr,$q_izin->alasan,$alpha,$hadir,$q_absen->kd_shift,$q_jdwal->lama,$lama_real,'',$q_ekstra->lama_jam,'','');
        $no++;
        }
        $tabel=$this->table->generate();
        echo $tabel;
        exit(); 
      }*/
}