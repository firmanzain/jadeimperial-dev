<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AbsensiController extends CI_Controller {
  public function __construct(){
    parent::__construct();
    $this->load->helper('timezone');
    $this->auth->restrict();
    $this->load->model('model_absensi');
    $this->load->library('PHPExcel');
    $this->load->library('PHPExcel/IOFactory');
    $this->load->library('mpdf');
  }
  
  public function index()
    {
      $data['data']=$this->model_absensi->index();
        $this->table->set_heading(array('NO','NIK','NAMA EMPLOYE','JABATAN','DEPARTMEN','DETAIL'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
                'thead_open'=>'<thead>',
                'thead_close'=> '</thead>',
                'tbody_open'=> '<tbody>',
                'tbody_close'=> '</tbody>',
            );
        $this->table->set_template($tmp);
    $data['halaman']=$this->load->view('absensi/index',$data,true);
    $this->load->view('beranda',$data);
    }

    public function detail($nik)
    {
        if ($this->input->post('tgl1',true)==NULL) {
          $tgl1 = date('Y-m-01');
          $tgl2 = date('Y-m-t');
        } else {
          $tgl1 = $this->input->post('tgl1',true);
          $tgl2 = $this->input->post('tgl2',true); 
        }
        $data['tgl1'] = $tgl1;
        $data['tgl2'] = $tgl2;
        $this->load->model('karyawan');
        $data['karyawan']=$this->karyawan->find($nik);
        $data['data']=$this->model_absensi->detail($nik,$tgl1,$tgl2);
        //echo $this->db->last_query();
        $nik=$this->input->post('nik',true);
        /*$kalender=CAL_GREGORIAN;
        if (!empty($bln) && !empty($tahun)) {
            $data['jml_bln']=cal_days_in_month($kalender, $bln, $tahun);
            $data['bl_th'] = array(
                            'bulan' => $bln,
                            'tahun' => $tahun,
                          );
        }else{
            $data['jml_bln']=cal_days_in_month($kalender, date('m'), date('Y'));
            $data['bl_th'] = array(
                            'bulan' => date('m'),
                            'tahun' => date('Y'),
                          );
        }*/
        
        $data['halaman']=$this->load->view('absensi/detail',$data,true);
        $this->load->view('beranda',$data);
    }

    public function cetak()
    {
        $cabang=$this->input->post('cabang');

        /*if ($this->input->post('tgl1',true)==NULL) {
          $tgl1 = date('Y-m-01');
          $tgl2 = date('Y-m-t');
        } else {
          $tgl1 = $this->input->post('tgl1',true);
          $tgl2 = $this->input->post('tgl2',true); 
        }
        $data['tgl1'] = $tgl1;
        $data['tgl2'] = $tgl2;*/

          if ($cabang!=NULL) {
            $this->db->select('*');
            $this->db->from('tab_cabang');
            $this->db->where('id_cabang',$cabang);
            $query_cabang = $this->db->get();
            foreach ($query_cabang->result() as $row) {
              $data['cabang'] = $row->cabang;
            }
          } else {
            $data['cabang'] = "";
          }
          $data['cabang_id'] = $cabang;

          //$data['data']=$this->model_absensi->rekap_absen($tgl1,$tgl2,$cabang);
          $data['data']=$this->model_absensi->rekap_absen($cabang);

          $data['halaman']=$this->load->view('laporan/rekapitulasi_absen',$data,true);
          
          $this->load->view('beranda',$data);
    }

    //public function cetak_plant_detail($bln,$thn,$cabang)
    public function cetak_plant_detail($cabang)
    {
          /*$data['bln'] = $bln;
          $data['thn'] = $thn;*/

          if ($cabang!=NULL) {
            $this->db->select('*');
            $this->db->from('tab_cabang');
            $this->db->where('id_cabang',$cabang);
            $query_cabang = $this->db->get();
            foreach ($query_cabang->result() as $row) {
              $data['cabang'] = $row->cabang;
            }
          } else {
            $data['cabang'] = "";
          }
          $data['cabang_id'] = $cabang;
          //$data['data']=$this->model_absensi->rekap_absen_plant($bln,$thn,$cabang);
          $data['data']=$this->model_absensi->rekap_absen_plant($cabang);

          $data['halaman']=$this->load->view('laporan/rekapitulasi_absen_plant',$data,true);
          $this->load->view('beranda',$data);
    }

    public function cetak_detail($cabang,$nik)
    {
      if ($this->input->post('tgl1',true)==NULL) {
        $tgl1 = date('Y-m-01');
        $tgl2 = date('Y-m-t');
      } else {
        $tgl1 = $this->input->post('tgl1',true);
        $tgl2 = $this->input->post('tgl2',true); 
      }
      $data['tgl1'] = $tgl1;
      $data['tgl2'] = $tgl2;

          if ($cabang!=NULL) {
            $this->db->select('*');
            $this->db->from('tab_cabang');
            $this->db->where('id_cabang',$cabang);
            $query_cabang = $this->db->get();
            foreach ($query_cabang->result() as $row) {
              $data['cabang'] = $row->cabang;
            }
          } else {
            $data['cabang'] = "";
          }

          $data['cabang_id'] = $cabang;

          if ($nik!=NULL) {
            $this->db->select('*');
            $this->db->from('tab_karyawan');
            $this->db->where('nik',$nik);
            $query_nama = $this->db->get();
            foreach ($query_nama->result() as $row) {
              $data['nama'] = $row->nama_ktp;
            }
          } else {
            $data['nama'] = "";
          }

          $data['nik'] = $nik;

          $data['data']=$this->model_absensi->rekap_absen_detail($cabang,$nik,$tgl1,$tgl2);

          $data['halaman']=$this->load->view('laporan/rekapitulasi_absen_detail',$data,true);
          $this->load->view('beranda',$data);
    }

    public function rekapKehadiran()
    {
        if ($this->input->post('tgl1',true)==NULL) {
          $tgl1 = date('Y-m-01');
          $tgl2 = date('Y-m-t');
        } else {
          $tgl1 = $this->input->post('tgl1',true);
          $tgl2 = $this->input->post('tgl2',true); 
        }
        $data['tgl1'] = $tgl1;
        $data['tgl2'] = $tgl2;

          $cabang=$this->input->post('cabang');
          if (empty($bulan)) {
            $data['bulan']=date('m');
          }else{
            $data['bulan']=$bulan;
          }
          if (empty($tahun)) {
              $data['tahun']=date('Y');
          }else{
              $data['tahun']=$tahun;
          }
          $data['data']=$this->model_absensi->get_employe($cabang);
          //$data['bulan'] = $bulan;
          //$data['tahun'] = $tahun;
          $data['cabang_id'] = $cabang;
          if ($cabang!=NULL) {
            $this->db->select('*');
            $this->db->from('tab_cabang');
            $this->db->where('id_cabang',$cabang);
            $query_cabang = $this->db->get();
            foreach ($query_cabang->result() as $row) {
              $data['cabang'] = $row->cabang;
            }
          } else {
            $data['cabang'] = "";
          }
          $data['halaman']=$this->load->view('laporan/rekap_kehadiran',$data,true);
          $this->load->view('beranda',$data);
    }

    public function on_offplant()
    {
      if ($this->input->post('tgl1',true)==NULL) {
        $tgl1 = date('Y-m-01');
        $tgl2 = date('Y-m-t');
      } else {
        $tgl1 = $this->input->post('tgl1',true);
        $tgl2 = $this->input->post('tgl2',true); 
      }
      $data['tgl1'] = $tgl1;
      $data['tgl2'] = $tgl2;
      $data['data']=$this->model_absensi->date_absen($tgl1,$tgl2);
      //print_r($this->db->last_query());
      $this->table->set_heading(array('NO','TANGGAL','LIHAT STATISTIK'));
      $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
                'thead_open'=>'<thead>',
                'thead_close'=> '</thead>',
                'tbody_open'=> '<tbody>',
                'tbody_close'=> '</tbody>',
              );
    $this->table->set_template($tmp);
    $data['halaman']=$this->load->view('absensi/on_offkaryawan',$data,true);
    $this->load->view('beranda',$data);
    }

    public function statistik($tgl)
    {
      $cb=$this->input->post('cabang');
      $karyawan=$this->model_absensi->hitung_karyawan($cb);
      $masuk=$this->model_absensi->hitung_masuk($tgl,$cb);
      $cuti=$this->model_absensi->hitung_cuti($tgl,$cb);
      $izin=$this->model_absensi->hitung_cuti($tgl,$cb);
      $absen=$karyawan-$masuk-$cuti-$izin;

      $data['cabang']=$this->db->order_by('cabang','asc')->get('tab_cabang')->result();
      $data['nama_cabang']=$this->db->where('id_cabang',$cb)->get('tab_cabang')->row();
      $data['masuk']=json_encode($masuk);
      $data['karyawan']=json_encode($karyawan);
      $data['cuti']=json_encode($cuti);
      $data['izin']=json_encode($izin);
      $data['absen']=json_encode($absen);
      $data['halaman']=$this->load->view('absensi/statistik',$data,true);
      $this->load->view('beranda',$data);
    }
    public function hapus(){
      if(!empty($_POST['cb_data'])){
      $jml=count($_POST['cb_data']);
      for($i=0;$i<$jml;$i++){
        $id=$_POST['cb_data'][$i];
        $this->model_absensi->delete($id);
      }
       $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Dihapus</div>");
      }
      redirect('absensi','refresh');
    }

    public function go_print($bln,$thn)
      {
        $data['bulan']=$bln;
        $data['tahun']=$thn;
        $html=$this->load->view('laporan/rekap_absensi',$data,true);
        $this->mpdf=new mPDF('utf-8', 'A4-L', 11, 'arial','5','5','5','5');
        $this->mpdf->WriteHTML($html);
        $name='HRD'.time().'.pdf';
        $this->mpdf->Output();
        exit();
      }

    public function import_data()
    {
        if ($this->input->post()) {
          $this->go_import();
        } else {
          $this->load->view('import/import_absensi');
        }
    }
    
    public function go_import(){
        error_reporting(E_ALL);
//        set_time_limit(0);
	ini_set('memory_limit', '-1');
        $config['upload_path']   = './temp_upload/';
        $config['allowed_types'] = 'xls|xlsx|csv';

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('file'))
        {
          $error = array('error' => $this->upload->display_errors());
          print_r($error);

        }
        else
        {
          $file = $this->upload->data();
          $name = $file["file_name"];
        }

        //EXCEL
        $inputFileName = './temp_upload/'.$name;

        $inputFileType = IOFactory::identify($inputFileName);
        $objReader = IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($inputFileName);

        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        //echo $highestRow;

        for ($row=1; $row <= ($highestRow-1) ; $row++) {
          //echo $row;
          $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row,NULL,TRUE,FALSE);
          $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row,NULL,TRUE,FALSE);

          $tgl_excel_awal = PHPExcel_Shared_Date::ExcelToPHP($rowData[0][1]);

          $nik = $rowData[0][0]; //NIK EXCEL
          $tgl = date('Y-m-d H:i:s', $tgl_excel_awal); //TGL & JAM EXCEL
          $jam = date('H:i:s', strtotime($tgl));
          $tgl_param = date('Y-m-d',strtotime($tgl));
          $tgl_fix = date('Y-m-d',strtotime($tgl));

          $tgl_awal   = date('Y-m-01', strtotime($tgl));
          $tgl_akhir  = date('Y-m-t', strtotime($tgl));

          if ($jam<="06:20:00") {
            $tgl_param = date('Y-m-d',strtotime('-1 day',strtotime($tgl_param)));
          }
          $jam_param = date('Y-m-d H:i:s',strtotime($tgl_fix.' '.$jam));

          // echo "NIK : ".$nik." || TGL : ".$tgl." || JAM  : ".$jam." || TGL PARAM  : ".$tgl_param." || JAM PARAM  : ".$jam_param."<br>";

          /*==============================*/
          /*
            $nik : parameter nik
            $tgl : tanggal asli excel
            $jam : jam asli excel
            $tgl_param : parameter tgl query
            $jam_param : parameter jam if
          */
          /*==============================*/

          $query_cari = $this->db->query(
            '
            select a.*,b.jam_start,b.jam_start2,b.jam_finish,b.jam_finish2,b.dispensasi 
            from tab_absensi a inner join tab_jam_kerja b 
            on b.kode_jam=a.kode_jam where a.nik="'.$nik.'" and 
            a.tgl_kerja="'.$tgl_param.'"
            '
          );

          if ($query_cari->result()<>false) {
            foreach ($query_cari->result() as $val) {
              if ($val->status_masuk!="Izin"||$val->status_masuk2!="Izin"||$val->status_masuk!="Cuti"||$val->status_masuk2!="Cuti"||$val->keterangan_masuk!="Datang Pukul"||$val->keterangan_masuk2!="Datang Pukul"||$val->keterangan_keluar!="Pulang Pukul"||$val->keterangan_keluar2!="Pulang Pukul") {
                //Cek di master tab_jam_kerja
                $jam_start    = $val->jam_start;
                $jam_finish   = $val->jam_finish;
                $jam_start2   = $val->jam_start2;
                $jam_finish2  = $val->jam_finish2;
                
                $jam_start_unix   = strtotime($tgl_param.' '.$jam_start);
                $jam_finish_unix  = strtotime($tgl_param.' '.$jam_finish);
                $jam_start2_unix  = strtotime($tgl_param.' '.$jam_start2);
                $jam_finish2_unix = strtotime($tgl_param.' '.$jam_finish2);

                //SET JAM 
                $begin_day_unix   = strtotime($tgl_param.' 00:00:00');
                $dispen_mnt       = strtotime($tgl_param.' 00:'.$val->dispensasi.':00');
                $sepuluh_mnt      = strtotime($tgl_param.' 00:10:00');
                $limabelas_mnt    = strtotime($tgl_param.' 00:15:00');
                $tigapuluh_mnt    = strtotime($tgl_param.' 00:30:00');
                $enampuluh_mnt    = strtotime($tgl_param.' 01:30:00');

                /* DETEKSI JAM */
                //Deteksi jam dispen
                $jam_dispen_fix  = date('H:i:s',$dispen_mnt);
                //Deteksi jam ontime
                $jam_ontime_fix  = date('H:i:s', ($jam_start_unix + ($dispen_mnt - $begin_day_unix)));
                $jam_ontime2_fix = date('H:i:s', ($jam_start2_unix + ($dispen_mnt - $begin_day_unix)));
                //Deteksi jam fail
                $jam_fail_fix   = date('H:i:s', ($jam_start_unix + ($tigapuluh_mnt - $begin_day_unix)));
                $jam_fail2_fix  = date('H:i:s', ($jam_start2_unix + ($tigapuluh_mnt - $begin_day_unix)));
                //Deteksi jam minimal pulang
                $jam_finish_fix   = date('H:i:s', ($jam_finish_unix - ($sepuluh_mnt - $begin_day_unix)));
                $jam_finish_param = date('H:i:s', ($jam_finish_unix + ($enampuluh_mnt - $begin_day_unix)));
                $jam_finish2_fix  = date('H:i:s', ($jam_finish2_unix - ($sepuluh_mnt - $begin_day_unix)));
                //Deteksi jam telat
                $jam_telat_fix_new  = date('H:i:s', (strtotime($jam_ontime_fix) + strtotime($jam_finish_fix))/2);
                $jam_telat2_fix_new = date('H:i:s', (strtotime($jam_ontime2_fix) + strtotime($jam_finish2_fix))/2);
                /* END DETEKSI JAM */
                // echo $tgl_param."<br>";
                // echo $jam_param."<br>";
                // echo "Ontime Jadwal ".$jam_start."<br>";
                // echo "Ontime 1 ".$jam_ontime_fix."<br>";
                // echo "Jam Telat ".$jam_telat_fix_new."<br>";
                // echo "Finish Jadwal ".$jam_finish."<br>";
                // echo "Finish 1 ".$jam_finish_fix."<br>";
                
                //Cek tipe shift ke 1
                if ($val->tipe_shift=="Pagi"||$val->tipe_shift=="Sore") {

                  //DETEKSI JAM MASUK
                  if ($jam_param<date('Y-m-d H:i:s',strtotime($tgl_param.' '.$jam_telat_fix_new))&&$val->jam_masuk1=="00:00:00") {
                    //Jika On Time
                    if ($jam_param<=date('Y-m-d H:i:s',strtotime($tgl_param.' '.$jam_ontime_fix))) {
                      $data = array(
                        'jam_masuk1'        => date('H:i:s',strtotime($jam_param)),
                        'status_masuk'      => "Masuk",
                        'keterangan_masuk'  => "On Time",
                        'entry_user'        => $this->session->userdata('username'),
                        'entry_date'        => date('Y-m-d H:i:s')
                      );
                      // echo "Ontime<br>";
                    }
                    //Jika Telat
                    else if ($jam_param>date('Y-m-d H:i:s',strtotime($tgl_param.' '.$jam_ontime_fix))&&$jam_param<=$jam_telat_fix_new) {
                      $data = array(
                        'jam_masuk1'        => date('H:i:s',strtotime($jam_param)),
                        'status_masuk'      => "Masuk",
                        'keterangan_masuk'  => "Telat",
                        'entry_user'        => $this->session->userdata('username'),
                        'entry_date'        => date('Y-m-d H:i:s')
                      );
                      // echo "Telat<br>";
                    }
                  }//END DETEKSI JAM MASUK
                  //DETEKSI JAM PULANG
                  else if ($jam_param>date('Y-m-d H:i:s',strtotime($tgl_param.' '.$jam_telat_fix_new))&&$val->jam_keluar1=="00:00:00") {
                    //Jika On time
                    if ($jam_param>=date('Y-m-d H:i:s',strtotime($tgl_param.' '.$jam_finish_fix))) {
                      $data = array(
                        'jam_keluar1'       => date('H:i:s',strtotime($jam_param)),
                        'status_keluar'     => "Pulang",
                        'keterangan_keluar' => "Pulang On Time",
                        'entry_user'        => $this->session->userdata('username'),
                        'entry_date'        => date('Y-m-d H:i:s')
                      );
                      // echo "Pulang Ontime<br>";
                    }
                    //Jika Pulang cepat
                    else if ($jam_param<date('Y-m-d H:i:s',strtotime($tgl_param.' '.$jam_finish_fix))) {
                      $data = array(
                        'jam_keluar1'       => date('H:i:s',strtotime($jam_param)),
                        'status_keluar'     => "Pulang",
                        'keterangan_keluar' => "Pulang Cepat",
                        'entry_user'        => $this->session->userdata('username'),
                        'entry_date'        => date('Y-m-d H:i:s')
                      );
                      // echo "Pulang Cepat<br>";
                    }
                  }//END DETEKSI JAM PULANG

                }//END if tipe shift ke 1
                //Cek tipe shift ke 2
                else if ($val->tipe_shift=="Pagi&Sore") {
                  
                  //DETEKSI JAM MASUK 1
                  if ($jam_param<date('Y-m-d H:i:s',strtotime($tgl_param.' '.$jam_telat_fix_new))&&$val->jam_masuk1=="00:00:00") {
                    //Jika On Time
                    if ($jam_param<=date('Y-m-d H:i:s',strtotime($tgl_param.' '.$jam_ontime_fix))) {
                      $data = array(
                        'jam_masuk1'        => date('H:i:s',strtotime($jam_param)),
                        'status_masuk'      => "Masuk",
                        'keterangan_masuk'  => "On Time",
                        'entry_user'        => $this->session->userdata('username'),
                        'entry_date'        => date('Y-m-d H:i:s')
                      );
                      // echo "Ontime<br>";
                    }
                    //Jika Telat
                    else if ($jam_param>date('Y-m-d H:i:s',strtotime($tgl_param.' '.$jam_ontime_fix))&&$jam_param<=$jam_telat_fix_new) {
                      $data = array(
                        'jam_masuk1'        => date('H:i:s',strtotime($jam_param)),
                        'status_masuk'      => "Masuk",
                        'keterangan_masuk'  => "Telat",
                        'entry_user'        => $this->session->userdata('username'),
                        'entry_date'        => date('Y-m-d H:i:s')
                      );
                      // echo "Telat<br>";
                    }
                  }//END DETEKSI JAM MASUK 1
                  //DETEKSI JAM PULANG 1
                  else if ($jam_param>date('Y-m-d H:i:s',strtotime($tgl_param.' '.$jam_telat_fix_new))&&$jam_param<=date('Y-m-d H:i:s',strtotime($tgl_param.' '.$jam_finish_param))&&$val->jam_keluar1=="00:00:00") {
                    //Jika On time
                    if ($jam_param>=date('Y-m-d H:i:s',strtotime($tgl_param.' '.$jam_finish_fix))) {
                      $data = array(
                        'jam_keluar1'       => date('H:i:s',strtotime($jam_param)),
                        'status_keluar'     => "Pulang",
                        'keterangan_keluar' => "Pulang On Time",
                        'entry_user'        => $this->session->userdata('username'),
                        'entry_date'        => date('Y-m-d H:i:s')
                      );
                      // echo "Pulang Ontime<br>";
                    }
                    //Jika Pulang cepat
                    else if ($jam_param<date('Y-m-d H:i:s',strtotime($tgl_param.' '.$jam_finish_fix))) {
                      $data = array(
                        'jam_keluar1'       => date('H:i:s',strtotime($jam_param)),
                        'status_keluar'     => "Pulang",
                        'keterangan_keluar' => "Pulang Cepat",
                        'entry_user'        => $this->session->userdata('username'),
                        'entry_date'        => date('Y-m-d H:i:s')
                      );
                      // echo "Pulang Cepat<br>";
                    }
                  }//END DETEKSI JAM PULANG 1
                  
                  //DETEKSI JAM MASUK 2
                  if ($jam_param<date('Y-m-d H:i:s',strtotime($tgl_param.' '.$jam_telat2_fix_new))&&$jam_param>date('Y-m-d H:i:s',strtotime($tgl_param.' '.$jam_finish_param))&&$val->jam_masuk2=="00:00:00") {
                    //Jika On Time
                    if ($jam_param<=date('Y-m-d H:i:s',strtotime($tgl_param.' '.$jam_ontime2_fix))) {
                      $data = array(
                        'jam_masuk2'        => date('H:i:s',strtotime($jam_param)),
                        'status_masuk2'     => "Masuk",
                        'keterangan_masuk2' => "On Time",
                        'entry_user'        => $this->session->userdata('username'),
                        'entry_date'        => date('Y-m-d H:i:s')
                      );
                      // echo "Ontime<br>";
                    }
                    //Jika Telat
                    else if ($jam_param>date('Y-m-d H:i:s',strtotime($tgl_param.' '.$jam_ontime2_fix))&&$jam_param<=$jam_telat2_fix_new) {
                      $data = array(
                        'jam_masuk2'        => date('H:i:s',strtotime($jam_param)),
                        'status_masuk2'     => "Masuk",
                        'keterangan_masuk2' => "Telat",
                        'entry_user'        => $this->session->userdata('username'),
                        'entry_date'        => date('Y-m-d H:i:s')
                      );
                      // echo "Telat<br>";
                    }
                  }//END DETEKSI JAM MASUK 2
                  //DETEKSI JAM PULANG 2
                  else if ($jam_param>date('Y-m-d H:i:s',strtotime($tgl_param.' '.$jam_telat2_fix_new))&&$val->jam_keluar2=="00:00:00") {
                    //Jika On time
                    if ($jam_param>=date('Y-m-d H:i:s',strtotime($tgl_param.' '.$jam_finish2_fix))) {
                      $data = array(
                        'jam_keluar2'         => date('H:i:s',strtotime($jam_param)),
                        'status_keluar2'      => "Pulang",
                        'keterangan_keluar2'  => "Pulang On Time",
                        'entry_user'          => $this->session->userdata('username'),
                        'entry_date'          => date('Y-m-d H:i:s')
                      );
                      // echo "Pulang Ontime<br>";
                    }
                    //Jika Pulang cepat
                    else if ($jam_param<date('Y-m-d H:i:s',strtotime($tgl_param.' '.$jam_finish2_fix))) {
                      $data = array(
                        'jam_keluar2'         => date('H:i:s',strtotime($jam_param)),
                        'status_keluar2'      => "Pulang Tidak Lengkap",
                        'keterangan_keluar2'  => "Pulang Cepat",
                        'entry_user'          => $this->session->userdata('username'),
                        'entry_date'          => date('Y-m-d H:i:s')
                      );
                      // echo "Pulang Cepat<br>";
                    }
                  }//END DETEKSI JAM PULANG 2
                  
                }//END if tipe shift ke 2 
                else if ($val->tipe_shift=="Libur") {
                  if ($val->jam_masuk1=="00:00:00"&&$jam_param<date('Y-m-d H:i:s',strtotime($tgl_param.' 15:00:00'))) {
                    $data = array(
                      'jam_masuk1'        => date('H:i:s',strtotime($jam_param)),
                      'status_masuk'      => "Masuk",
                      'keterangan_masuk'  => "Schedule fail",
                      'entry_user'        => $this->session->userdata('username'),
                      'entry_date'        => date('Y-m-d H:i:s')
                    );
                  } else if ($val->jam_masuk1!="00:00:00"&&$val->jam_keluar1=="00:00:00"&&$jam_param>date('Y-m-d H:i:s',strtotime($tgl_param.' '.($val->jam_masuk1 + ($enampuluh_mnt - $begin_day_unix))))) {
                    $data = array(
                      'jam_keluar1'       => date('H:i:s',strtotime($jam_param)),
                      'status_keluar'     => "Pulang",
                      'keterangan_keluar' => "Schedule fail",
                      'entry_user'        => $this->session->userdata('username'),
                      'entry_date'        => date('Y-m-d H:i:s')
                    );
                  } else if ($val->jam_masuk2=="00:00:00"&&$jam_param>=date('Y-m-d H:i:s',strtotime($tgl_param.' 15:00:00'))) {
                    $data = array(
                      'jam_masuk2'        => date('H:i:s',strtotime($jam_param)),
                      'status_masuk2'     => "Masuk",
                      'keterangan_masuk2' => "Schedule fail",
                      'entry_user'        => $this->session->userdata('username'),
                      'entry_date'        => date('Y-m-d H:i:s')
                    );
                  } else if ($val->jam_masuk2!="00:00:00"&&$val->jam_keluar2=="00:00:00"&&$jam_param>date('Y-m-d H:i:s',strtotime($tgl_param.' '.($val->jam_masuk2 + ($enampuluh_mnt - $begin_day_unix))))) {
                    $data = array(
                      'jam_keluar2'       => date('H:i:s',strtotime($jam_param)),
                      'status_keluar2'    => "Pulang",
                      'keterangan_keluar2'=> "Schedule fail",
                      'entry_user'        => $this->session->userdata('username'),
                      'entry_date'        => date('Y-m-d H:i:s')
                    );
                  }
                }

                if (@$data) {
                  $this->db->where('nik', $nik);
                  $this->db->where('tgl_kerja', date('Y-m-d',strtotime($tgl_param)));
                  $this->db->update('tab_absensi', $data);
                }
                // echo "<br>";

              }//END IF

            }//END Foreach
          }//END Check Query Cari

        }//END IMPORT EXCEL

        $query_update = $this->db->query(
          '
          update tab_absensi set status_masuk="Libur", 
          keterangan_masuk="Libur",status_keluar="Libur", 
          keterangan_keluar="Libur",status_masuk2="Libur", 
          keterangan_masuk2="Libur",status_keluar2="Libur", 
          keterangan_keluar2="Libur" where tgl_kerja>="'.$tgl_awal.'" 
          and tgl_kerja<="'.$tgl_akhir.'" and tipe_shift="Libur" 
          AND jam_masuk1="00:00:00" AND jam_keluar1="00:00:00" 
          AND jam_masuk2="00:00:00" AND jam_keluar2="00:00:00"
          '
        );

        $query_update = $this->db->query(
          '
          update tab_absensi set status_masuk="Masuk Tidak Lengkap", 
          keterangan_masuk="Finger Fail" where tgl_kerja>="'.$tgl_awal.'" 
          and tgl_kerja<="'.$tgl_akhir.'" and tipe_shift!="Libur" 
          and tipe_shift!="-" and (status_masuk != "Izin" OR status_masuk!="Cuti" OR status_masuk IS NULL) 
          and jam_masuk1="00:00:00" and jam_keluar1!="00:00:00" 
          '
        );

        $query_update = $this->db->query(
          '
          update tab_absensi set status_keluar="Pulang Tidak Lengkap", 
          keterangan_keluar="Finger Fail" where tgl_kerja>="'.$tgl_awal.'" 
          and tgl_kerja<="'.$tgl_akhir.'" and tipe_shift!="Libur" 
          and tipe_shift!="-" and (status_masuk != "Izin" OR status_masuk!="Cuti" OR status_masuk IS NULL)
          and jam_masuk1!="00:00:00" and jam_keluar1="00:00:00" 
          '
        );

        $query_update = $this->db->query(
          '
          update tab_absensi set status_masuk="Bolos", 
          keterangan_masuk="Bolos",status_keluar="Bolos", 
          keterangan_keluar="Bolos" where tgl_kerja>="'.$tgl_awal.'" 
          and tgl_kerja<="'.$tgl_akhir.'" and tipe_shift!="Libur" 
          and tipe_shift!="-" and (status_masuk != "Izin" OR status_masuk!="Cuti" OR status_masuk IS NULL) 
          and jam_masuk1="00:00:00" and jam_keluar1="00:00:00" 
          '
        );
        $query_update = $this->db->query(
          '
          update tab_absensi set status_masuk2="Masuk Tidak Lengkap", 
          keterangan_masuk2="Finger Fail" where tgl_kerja>="'.$tgl_awal.'" 
          and tgl_kerja<="'.$tgl_akhir.'" and tipe_shift!="Libur" 
          and tipe_shift!="-" and (status_masuk != "Izin" OR status_masuk!="Cuti" OR status_masuk IS NULL) 
          and jam_masuk2="00:00:00" and jam_keluar2!="00:00:00" 
          '
        );

        $query_update = $this->db->query(
          '
          update tab_absensi set status_keluar2="Pulang Tidak Lengkap", 
          keterangan_keluar2="Finger Fail" where tgl_kerja>="'.$tgl_awal.'" 
          and tgl_kerja<="'.$tgl_akhir.'" and tipe_shift!="Libur" 
          and tipe_shift!="-" and status_masuk!="Izin" and status_masuk!="Cuti" 
          and jam_masuk2!="00:00:00" and jam_keluar2="00:00:00" 
          '
        );

        $query_update = $this->db->query(
          '
          update tab_absensi set status_masuk2="Bolos", 
          keterangan_masuk2="Bolos",status_keluar2="Bolos", 
          keterangan_keluar2="Bolos" where tgl_kerja>="'.$tgl_awal.'" 
          and tgl_kerja<="'.$tgl_akhir.'" and tipe_shift!="Libur" 
          and tipe_shift!="-" and status_masuk!="Izin" and status_masuk!="Cuti" 
          and jam_masuk2="00:00:00" and jam_keluar2="00:00:00" 
          '
        );

        $query_update = $this->db->query(
          '
          update tab_absensi set status_masuk2="-", 
          keterangan_masuk2="-",status_keluar2="-", 
          keterangan_keluar2="-" where tgl_kerja>="'.$tgl_awal.'" 
          and tgl_kerja<="'.$tgl_akhir.'" and tipe_shift!="Libur" 
          and tipe_shift!="-" and tipe_shift="Pagi" and
          (status_masuk != "Izin" OR status_masuk!="Cuti" OR status_masuk IS NULL) 
          and jam_masuk2="00:00:00" and jam_keluar2="00:00:00" 
          '
        );

        echo '<script>window.opener.location.reload();window.close();</script>';
    }

  public function edit($id)
    {
       if ($this->input->post()) {
        $this->update();
       }else{
         $data['data']=$this->model_absensi->find($id);
         if ($data==true) {
          $data['halaman']=$this->load->view('absensi/update',$data,true);
          $this->load->view('beranda',$data);
         }else{
          show_404();
         }
     }
    }

    public function update(){
      $id=$this->input->post('id');
      /*$tgl=$this->input->post('tanggal_absen');
      $jam=$this->input->post('jam_masuk');
      $jam2=$this->input->post('jam_keluar');
      $format_masuk=date('Y-m-d H:i:s',strtotime($tgl.' '.$jam));
      $format_keluar=date('Y-m-d H:i:s',strtotime($tgl.' '.$jam2));
      $data = array(
                  'nik' => $this->input->post('nik'),
                  'jam_masuk' =>$format_masuk,
                  'status' =>$this->input->post('status'),
                  'terlambat' =>$this->input->post('terlambat'),
                  'keterangan_masuk' =>$this->input->post('keterangan')
                );
      $data_keluar= array(
                      'nik' => $this->input->post('nik'),
                      'jam_keluar' =>$format_keluar
                    );
      $this->model_absensi->update($id,$data,$data_keluar);*/
      $data = array(
        'jam_masuk1' => $this->input->post('jam_masuk'),
        'jam_keluar1' => $this->input->post('jam_keluar'),
        'status_masuk' => $this->input->post('status_masuk'), 
        'keterangan_masuk' => $this->input->post('keterangan_masuk'), 
        'status_keluar' => $this->input->post('status_keluar'), 
        'keterangan_keluar' => $this->input->post('keterangan_keluar'), 
        'jam_masuk2' => $this->input->post('jam_masuk2'),
        'jam_keluar2' => $this->input->post('jam_keluar2'),
        'status_masuk2' => $this->input->post('status_masuk2'), 
        'keterangan_masuk2' => $this->input->post('keterangan_masuk2'), 
        'status_keluar2' => $this->input->post('status_keluar2'), 
        'keterangan_keluar2' => $this->input->post('keterangan_keluar2'),
        'entry_user'    => $this->session->userdata('username'),
        'entry_date'    => date('Y-m-d H:i:s') 
      );

      $this->db->where('id', $id);
      $this->db->update('tab_absensi', $data);

      $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Disimpan</div>");
      redirect('absensi/'.$this->input->post('nik').'/detail');
    }
    public function create($nik)
    {
        if ($this->input->post()) {
          $this->save();
        } else {
          $data['nik']=$nik;
          $data['halaman']=$this->load->view('absensi/create',$data,true);
          $this->load->view('beranda',$data);
        }
    }

    public function save(){
      $tgl=$this->input->post('tanggal_absen');
      $jam=$this->input->post('jam_masuk');
      $jam2=$this->input->post('jam_keluar');
      $format_masuk=date('Y-m-d H:i:s',strtotime($tgl.' '.$jam));
      $format_keluar=date('Y-m-d H:i:s',strtotime($tgl.' '.$jam2));
      $data = array(
                  'nik' => $this->input->post('nik'),
                  'jam_masuk' =>$format_masuk,
                  'status' =>$this->input->post('status'),
                  'terlambat' =>$this->input->post('terlambat'),
                  'keterangan_masuk' =>$this->input->post('keterangan'),
                  'entry_user'    => $this->session->userdata('username'),
                  'entry_date'    => date('Y-m-d H:i:s')
                );
      $data_keluar= array(
                      'nik' => $this->input->post('nik'),
                      'jam_keluar' =>$format_keluar
                    );
      $this->model_absensi->add($data,$data_keluar);
      $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Disimpan</div>");
      redirect($this->input->post('url'));
    }
}
