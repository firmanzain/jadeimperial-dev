<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GajiController extends CI_Controller {
  public function __construct(){
    parent::__construct();
    $this->auth->restrict();
    $this->load->model('model_gaji');
    $this->load->library('PHPExcel');
    $this->load->library('PHPExcel/IOFactory');
    $this->load->library('mpdf');
    error_reporting(E_ALL);
  }
     
    // tampilkan rekap gaji per cabang
    public function index()
    {
      /*$data['data']=$this->model_gaji->index();*/
      /*$gaji = $this->model_gaji->indexnew();
      if ($gaji!=true) {
        $this->generateData();
      }*/
      if ($this->input->post('bln',true)==NULL) {
        $bln = date('m');
        $thn = date('Y');
      } else {
        $bln=$this->input->post('bln',true);
        $thn=$this->input->post('tahun',true); 
      }
      $data['bln'] = $bln;
      $data['thn'] = $thn;
      if ($bln<8&&$thn==2016) {
      } else {
        $this->update_dp_cuti($bln,$thn);
      }
      //$this->generateData($bln,$thn);

      //$data['pph']=$this->db->where('month(entry_date)',$bln)->get('tab_pph')->num_rows();
      $data['pph']=$this->db->where('month(tgl_pph)',$bln)->get('tab_pph_new')->num_rows();
      $data['gaji'] = $this->model_gaji->indexnew($bln,$thn);
      $data['bpjs'] = $this->db->query('
        SELECT a.id_bpjs, a.nama_bpjs, b.id_bpjs_detail, b.nama_potongan, b.nilai_potongan 
        FROM tab_master_bpjs a 
        INNER JOIN tab_master_bpjs_detail b ON b.id_bpjs = a.id_bpjs 
        WHERE a.status_bpjs = 1 AND b.status_potongan = 1 
        AND (b.tujuan_potongan = 0 OR b.tujuan_potongan = 2)
      ');

      // if ($data['gaji']) {
      //   $this->table->set_heading(array('NO','CABANG','JUMLAH KARYAWAN','GAJI','TUNJANGAN JABATAN','EKSTRA','DP CUTI','PINJ','PPH','JHT','JPK',$judul_fix,'GAJI DITERIMA','PAYROLL','TINDAKAN')); 
      // } else {
      //   $this->table->set_heading(array('NO','CABANG','JUMLAH KARYAWAN','GAJI','TUNJANGAN JABATAN','EKSTRA','DP CUTI','PINJ','PPH','JHT','JPK','GAJI DITERIMA','PAYROLL','TINDAKAN')); 
      // }
      
      // $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
      //           'thead_open'=>'<thead>',
      //           'thead_close'=> '</thead>',
      //           'tbody_open'=> '<tbody>',
      //           'tbody_close'=> '</tbody>',
      //       );
      // $this->table->set_template($tmp);

        $data['halaman']=$this->load->view('gaji/index',$data,true);
        $this->load->view('beranda',$data);
    }

    public function gaji_resign()
    {
      if ($this->input->post('bln',true)==NULL) {
        $bln = date('m');
        $thn = date('Y');
      } else {
        $bln=$this->input->post('bln',true);
        $thn=$this->input->post('tahun',true); 
      }
      $data['bln'] = $bln;
      $data['thn'] = $thn;

      if ($bln<8&&$thn==2016) {
      } else {
        $this->generateDataresign($bln,$thn);
      }

        $data['data']=$this->model_gaji->detail_gaji_resign($bln,$thn);
        // $data['cabang']=str_replace('-', ',', $cabang);

        $this->table->set_heading(array('NO','NIK','NAMA','JABATAN','DEPARTMENT','UPAH JAMSOSTEK','GAJI POKOK','TUNJANGAN JABATAN','EKSTRA','DP CUTI MINUS','DP CUTI PLUS','PINJ','PPH','JHT','JPK','GAJI DITERIMA','APPROVAL','KETERANGAN','CETAK'));
        
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
                'thead_open'=>'<thead>',
                'thead_close'=> '</thead>',
                'tbody_open'=> '<tbody>',
                'tbody_close'=> '</tbody>',
            );
        $this->table->set_template($tmp);
        
        $data['halaman']=$this->load->view('gaji/detail_gaji_resign',$data,true);
        $this->load->view('beranda',$data);
    }

    // ketika button detail diklik
    public function gaji_detail($id_cabang,$cabang,$bln,$thn)
    {
        $data['bln'] = $bln;
        $data['thn'] = $thn;
        $data['data']=$this->model_gaji->detail_gaji($id_cabang,$bln,$thn);
        $data['cabang']=str_replace('-', ',', $cabang);

        $nama_bln = date_format(new DateTime($thn.'-'.$bln),"F Y");
        $nama_bln2 = date_format(new DateTime($thn.'-'.$bln),"t F Y");

        $data['bpjs'] = $this->db->query('
          SELECT a.id_bpjs, a.nama_bpjs, b.id_bpjs_detail, b.nama_potongan, b.nilai_potongan 
          FROM tab_master_bpjs a 
          INNER JOIN tab_master_bpjs_detail b ON b.id_bpjs = a.id_bpjs 
          WHERE a.status_bpjs = 1 AND b.status_potongan = 1 
          AND (b.tujuan_potongan = 0 OR b.tujuan_potongan = 2)
        ');

        // $this->table->set_heading(array('NO','NIK','NAMA','JABATAN','DEPARTMENT','UPAH JAMSOSTEK','GAJI POKOK','TUNJANGAN JABATAN','EKSTRA','DP CUTI','PINJ','PPH','JHT','JPK','GAJI DITERIMA','APPROVAL','KETERANGAN','CETAK'));
        
        // $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
        //         'thead_open'=>'<thead>',
        //         'thead_close'=> '</thead>',
        //         'tbody_open'=> '<tbody>',
        //         'tbody_close'=> '</tbody>',
        //     );
        // $this->table->set_template($tmp);
        
        $data['halaman']=$this->load->view('gaji/detail_gaji',$data,true);
        $this->load->view('beranda',$data);
    }

    public function gaji_detail_rekap($id_cabang,$cabang,$bln,$thn)
    {
        $data['data']=$this->model_gaji->detail_gaji_rekap($id_cabang,$bln,$thn);
        $data['cabang']=str_replace('-', ',', $cabang);
        $data['bln'] = $bln;
        $data['thn'] = $thn;
        $data['id_cabang'] = $id_cabang;

        $data['bpjs'] = $this->db->query('
          SELECT a.id_bpjs, a.nama_bpjs, b.id_bpjs_detail, b.nama_potongan, b.nilai_potongan 
          FROM tab_master_bpjs a 
          INNER JOIN tab_master_bpjs_detail b ON b.id_bpjs = a.id_bpjs 
          WHERE a.status_bpjs = 1 AND b.status_potongan = 1 
          AND (b.tujuan_potongan = 0 OR b.tujuan_potongan = 2)
        ');

        // $this->table->set_heading(array('NO','NIK','NAMA','JABATAN','DEPARTMENT','UPAH JAMSOSTEK','GAJI POKOK','TUNJANGAN JABATAN','EKSTRA','DP CUTI','PINJ','PPH','JHT','JPK','GAJI DITERIMA','APPROVAL','KETERANGAN'));
        
        // $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
        //         'thead_open'=>'<thead>',
        //         'thead_close'=> '</thead>',
        //         'tbody_open'=> '<tbody>',
        //         'tbody_close'=> '</tbody>',
        //     );
        // $this->table->set_template($tmp);
        
        $data['halaman']=$this->load->view('gaji/detail_gaji_rekap',$data,true);
        $this->load->view('beranda',$data);
    }

    public function gaji_detail2($id_cabang,$cabang,$bln,$thn)
    {
        $data['bln'] = $bln;
        $data['thn'] = $thn;
        $data['data']=$this->model_gaji->detail_gaji_casual($id_cabang,$bln,$thn);
        $data['cabang']=str_replace('-', ',', $cabang);

        $nama_bln = date_format(new DateTime($thn.'-'.$bln),"F Y");
        $nama_bln2 = date_format(new DateTime($thn.'-'.$bln),"t F Y");
        $periode1 = date('d',strtotime($thn."-".$bln."-01"))." - ".date('d',strtotime($thn."-".$bln."-15"));
        $periode2 = date('d',strtotime($thn."-".$bln."-16"))." - ".date('t',strtotime($thn."-".$bln));

        $this->table->set_heading(array('NO','NIK','NAMA','STATUS','NPWP','ALAMAT','STATUS PAJAK','NAMA REKENING','NO REKENING','GAJI NETTO / HARI '.$periode1,'HARI KERJA '.$periode1,'UANG MAKAN / HARI '.$periode1,'TOTAL GAJI '.$periode1,'EKSTRA '.$periode1,'TOTAL GAJI BRUTO '.$periode1,'TOTAL UANG MAKAN '.$periode1,'PPH '.$periode1,'TOTAL DITERIMA '.$periode1,'GAJI NETTO / HARI '.$periode2,'HARI KERJA '.$periode2,'UANG MAKAN / HARI '.$periode2,'TOTAL GAJI '.$periode2,'EKSTRA '.$periode2,'TOTAL GAJI BRUTO '.$periode2,'TOTAL UANG MAKAN '.$periode2,'PPH '.$periode2,'TOTAL DITERIMA '.$periode2,'TOTAL HARI KERJA','TOTAL GAJI BRUTO','TOTAL GAJI DITERIMA','APPROVAL','TINDAKAN'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
                'thead_open'=>'<thead>',
                'thead_close'=> '</thead>',
                'tbody_open'=> '<tbody>',
                'tbody_close'=> '</tbody>',
            );
        $this->table->set_template($tmp);
        
        $data['halaman']=$this->load->view('gaji/detail_gaji_casual',$data,true);
        $this->load->view('beranda',$data);
    }

    public function gaji_casual()
    {
        //$data['data']=$this->model_gaji->gaji_casual();
        /*$gaji = $this->model_gaji->indexcasualnew();
        if ($gaji!=true) {
          $this->generateData2();
        }*/
        if ($this->input->post('bln',true)==NULL) {
          $bln = date('m');
          $thn = date('Y');
        } else {
          $bln=$this->input->post('bln',true);
          $thn=$this->input->post('tahun',true); 
        }
        $data['bln'] = $bln;
        $data['thn'] = $thn;
        $periode1 = date('d',strtotime($thn."-".$bln."-01"))." - ".date('d',strtotime($thn."-".$bln."-15"));
        $periode2 = date('d',strtotime($thn."-".$bln."-16"))." - ".date('t',strtotime($thn."-".$bln));
        //$this->generateData2($bln,$thn);

        $data['data']=$this->model_gaji->indexcasualnew($bln,$thn);
        $data['pph']=$this->db->where('month(tgl_pph)',date($bln))->get('pph_casual')->num_rows();
        //$this->table->set_heading(array('NO','NIK','NAMA','JABATAN','DEPARTMENT','NAMA REKENING','NO REKENING','Hari Kerja '.date('01').'-'.date('15 M Y'),'Hari Kerja '.date('16').'-'.date('t M Y'),'GAJI CASUAL','UANG MAKAN','PPH1','GAJI DITERIMA 1','PPH2','GAJI DITERIMA 2'));
        // $this->table->set_heading(array('NO','CABANG','JUMLAH KARYAWAN','GAJI CASUAL','UANG MAKAN','CASUAL EKSTRA 1','PPH 1','GAJI DITERIMA 1','CASUAL EKSTRA 2','PPH 2','GAJI DITERIMA 2','TINDAKAN'));
        $this->table->set_heading(array('NO','CABANG','JUMLAH KARYAWAN','GAJI NETTO / HARI '.$periode1,'UANG MAKAN / HARI '.$periode1,'EKSTRA '.$periode1,'PPH '.$periode1,'TOTAL DITERIMA '.$periode1,'GAJI NETTO / HARI '.$periode2,'UANG MAKAN / HARI '.$periode2,'EKSTRA '.$periode2,'PPH '.$periode2,'TOTAL DITERIMA '.$periode2,'TOTAL GAJI DITERIMA','TINDAKAN'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
                'thead_open'=>'<thead>',
                'thead_close'=> '</thead>',
                'tbody_open'=> '<tbody>',
                'tbody_close'=> '</tbody>',
            );
        $this->table->set_template($tmp);
        //$data['halaman']=$this->load->view('gaji/gaji_casual',$data,true);
        $data['halaman']=$this->load->view('gaji/index2',$data,true);
        $this->load->view('beranda',$data);
    }

    public function rekap_gaji()
    {
        /*$tgl1=$this->input->post('tanggal1');
        $tgl2=$this->input->post('tanggal2');
        $data['data']=$this->model_gaji->rekap_gaji($tgl1,$tgl2);*/
        /*$bln = $this->input->post('bln');
        if ($bln!=null) {
          $data['data']=$this->model_gaji->rekap_gaji($bln);
        } else {
          $bln = date('m');
          $data['data']=$this->model_gaji->rekap_gaji(date('m'));
        }
        $data['bln'] = $bln;*/

        if ($this->input->post('bln',true)==NULL) {
          $bln = date('m');
          $thn = date('Y');
        } else {
          $bln=$this->input->post('bln',true);
          $thn=$this->input->post('tahun',true); 
        }
        $data['bln'] = $bln;
        $data['thn'] = $thn;

        //$data['pph']=$this->db->where('month(entry_date)',$bln)->get('tab_pph')->num_rows();
        $data['pph']=$this->db->where('month(tgl_pph)',$bln)->get('tab_pph_new')->num_rows();
        $data['gaji'] = $this->model_gaji->indexnew($bln,$thn);
        //print_r($this->db->last_query());
        //$this->table->set_heading(array('NO','NIK','NAMA','JABATAN','DEPARTMENT','NAMA REKENING','NO REKENING','UPAH JAMSOSTEK','GAJI POKOK','TUNJANGAN JABATAN','EKSTRA','PINJ','PPH','JHT','JPK','DP CUTI','GAJI DITERIMA','PAYROLL','APPROVED','KETERANGAN'));
        $this->table->set_heading(array('NO','CABANG','JUMLAH KARYAWAN','GAJI','TUNJANGAN JABATAN','EKSTRA','DP CUTI','PINJ','PPH','TOTAL POTONGAN BPJS','GAJI DITERIMA','PAYROLL','TINDAKAN'));
        $tmp=array('table_open'=>'<table class="table table-hover table-striped table-bordered" >',
                'thead_open'=>'<thead>',
                'thead_close'=> '</thead>',
                'tbody_open'=> '<tbody>',
                'tbody_close'=> '</tbody>',
            );
        $this->table->set_template($tmp);
        $data['halaman']=$this->load->view('laporan/laporan_gajiKaryawan',$data,true);
        $this->load->view('beranda',$data);
    }

    public function rekap_gajicasual()
    {
        $bln = $this->input->post('bln');
        $thn = $this->input->post('tahun');

        if ($bln!=null) {
        } else {
          $bln = date('m');
        }
        if ($thn!=null) {
        } else {
          $thn = date('Y');
        }
        $data['bln'] = $bln;
        $data['thn'] = $thn;
        $periode1 = date('d',strtotime($thn."-".$bln."-01"))." - ".date('d',strtotime($thn."-".$bln."-15"));
        $periode2 = date('d',strtotime($thn."-".$bln."-16"))." - ".date('t',strtotime($thn."-".$bln));

        $data['data']=$this->model_gaji->rekap_casual($bln,$thn);
        $data['pph']=$this->db->where('month(tgl_pph)',$bln)->get('pph_casual')->num_rows();
        $this->table->set_heading(array('NO','CABANG','JUMLAH KARYAWAN','GAJI NETTO / HARI '.$periode1,'UANG MAKAN / HARI '.$periode1,'EKSTRA '.$periode1,'PPH '.$periode1,'TOTAL DITERIMA '.$periode1,'GAJI NETTO / HARI '.$periode2,'UANG MAKAN / HARI '.$periode2,'EKSTRA '.$periode2,'PPH '.$periode2,'TOTAL DITERIMA '.$periode2,'TOTAL GAJI DITERIMA','TINDAKAN'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
                'thead_open'=>'<thead>',
                'thead_close'=> '</thead>',
                'tbody_open'=> '<tbody>',
                'tbody_close'=> '</tbody>',
            );
        $this->table->set_template($tmp);
        $data['halaman']=$this->load->view('laporan/laporan_gajiKaryawanCasual',$data,true);
        $this->load->view('beranda',$data);
    }

    public function gaji_casual_detail_rekap($bln,$thn,$cabang)
    {
        $data['bln'] = $bln;
        $data['thn'] = $thn;
        $data['cabang'] = $cabang;

        $nama_bln = date_format(new DateTime($thn.'-'.$bln),"F Y");
        $nama_bln2 = date_format(new DateTime($thn.'-'.$bln),"t F Y");

        $data['data']=$this->model_gaji->detail_gaji_casual_rekap($bln,$thn,$cabang);
        $data['cabang']=str_replace('-', ',', $cabang);

        $periode1 = date('d',strtotime($thn."-".$bln."-01"))." - ".date('d',strtotime($thn."-".$bln."-15"));
        $periode2 = date('d',strtotime($thn."-".$bln."-16"))." - ".date('t',strtotime($thn."-".$bln));

        $this->table->set_heading(array('NO','NIK','NAMA','STATUS','NPWP','ALAMAT','STATUS PAJAK','NAMA REKENING','NO REKENING','GAJI NETTO / HARI '.$periode1,'HARI KERJA '.$periode1,'UANG MAKAN / HARI '.$periode1,'TOTAL GAJI '.$periode1,'EKSTRA '.$periode1,'TOTAL GAJI BRUTO '.$periode1,'TOTAL UANG MAKAN '.$periode1,'PPH '.$periode1,'TOTAL DITERIMA '.$periode1,'GAJI NETTO / HARI '.$periode2,'HARI KERJA '.$periode2,'UANG MAKAN / HARI '.$periode2,'TOTAL GAJI '.$periode2,'EKSTRA '.$periode2,'TOTAL GAJI BRUTO '.$periode2,'TOTAL UANG MAKAN '.$periode2,'PPH '.$periode2,'TOTAL DITERIMA '.$periode2,'TOTAL HARI KERJA','TOTAL GAJI BRUTO','TOTAL GAJI DITERIMA','APPROVAL'));

        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
                'thead_open'=>'<thead>',
                'thead_close'=> '</thead>',
                'tbody_open'=> '<tbody>',
                'tbody_close'=> '</tbody>',
            );
        $this->table->set_template($tmp);
        
        $data['halaman']=$this->load->view('gaji/detail_gaji_casual_rekap',$data,true);
        $this->load->view('beranda',$data);
    }

  public function print_data($dt)
    {
      $data['data']=base64_decode($dt);
      $html=$this->load->view('gaji/cetak',$data,true);
      $this->mpdf=new mPDF('utf-8', 'A5', 10, 'Times','5','5','5','5');
      $this->mpdf->WriteHTML($html);
      $name='HRD'.time().'.pdf';
      $this->mpdf->Output();
      exit();
    }

  public function print_data2($dt)
    {
      $data['data']=base64_decode($dt);
      $html=$this->load->view('gaji/cetak',$data,true);
      $this->mpdf=new mPDF('utf-8', 'A5', 10, 'Times','5','5','5','5');
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
          $this->load->view('import/import_pph');
        }
    }

    public function go_import()
    {
      $thn = date('Y');
      $bln = $this->input->post('bulan');
      $tgl = date('Y-m-d',strtotime($thn.'-'.$bln.'-01'));
      //echo $tgl;
      $config['upload_path'] = './temp_upload/';
      $config['allowed_types'] = 'xls|xlsx';
      $this->upload->initialize($config);
      if ( ! $this->upload->do_upload('datague')) {
            // jika validasi file gagal, kirim parameter error ke index
            $error = $this->upload->display_errors();
            print $error;
        } else {
      $upload_data = $this->upload->data();
      // load library Excell_Reader
        $this->load->library('excel/Excel_reader');
      //tentukan file
        $this->excel_reader->setOutputEncoding('230787');
        $file = $upload_data['full_path'];
        $this->excel_reader->read($file);
        error_reporting(E_ALL ^ E_NOTICE);
      // array data
        $data = $this->excel_reader->sheets[0];
        $dataexcel = Array();
        for ($i = 1; $i <= $data['numRows']-4; $i++) {
                   if ($data['cells'][$i+5][1] == '')
                       break;
                   /*$dataexcel[$i - 1]['nik'] = $data['cells'][$i+4][2];
                   $dataexcel[$i - 1]['biaya_jabatan'] = $data['cells'][$i+4][14];
                   $dataexcel[$i - 1]['ptkp'] = $data['cells'][$i+4][15];
                   $dataexcel[$i - 1]['jht'] = $data['cells'][$i+4][16];
                   $dataexcel[$i - 1]['pkp'] = $data['cells'][$i+4][17];
                   $dataexcel[$i - 1]['pkp_real'] = $data['cells'][$i+4][18];
                   $dataexcel[$i - 1]['pkp_real_tahunan'] = $data['cells'][$i+4][20];
                   $dataexcel[$i - 1]['pph21_tahunan'] = $data['cells'][$i+4][21];
                   $dataexcel[$i - 1]['pph21_bulanan'] = $data['cells'][$i+4][22];
                   $dataexcel[$i - 1]['pph21_program'] = $data['cells'][$i+4][23];
                   $dataexcel[$i - 1]['jml_pph'] = $data['cells'][$i+4][24];*/
                   $dataexcel[$i - 1]['nik'] = $data['cells'][$i+5][2];
                   $dataexcel[$i - 1]['tgl_pph'] = $tgl;
                   $dataexcel[$i - 1]['jml_pph'] = $data['cells'][$i+5][4];
              }

      $import=$this->model_gaji->import_data($dataexcel);
      $berhasil=count($import['berhasil']);
      $gagal=count($import['gagal']);
      $file = $upload_data['file_name'];
        $path = './temp_upload/'.$file;
        unlink($path);
        $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Jumlah Data Tersimpan $berhasil<br>Data Gagal Tersimpan : $gagal </div>");
      echo "<script>window.opener.location.reload();window.close()</script>";
      }
    }

  public function cetak_gaji() {
     $data['data']=$this->model_gaji->detail_gaji($id_cabang);
      $data['cabang']=str_replace('-', ',', $cabang);
      $this->table->set_heading(array('NO','NIK','NAMA','JABATAN','DEPARTMENT','JUMLAH PPH','JUMLAH JHT','JUMLAH JPK','JUMLAH EKSTRA','MIN CUTI','JUMLAH GAJI'));
      $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
                  'thead_open'=>'<thead>',
                  'thead_close'=> '</thead>',
                  'tbody_open'=> '<tbody>',
                  'tbody_close'=> '</tbody>',
              );
      $this->table->set_template($tmp);
      $data['halaman']=$this->load->view('gaji/detail_gaji',$data,true);
      $this->load->view('beranda',$data);

  }

  public function e_casual()
  {
    $bln = $this->input->get('bln');
    $thn = $this->input->get('thn');
    $data['bln'] = $bln;
    $data['thn'] = $thn;
    $data['data']=$this->model_gaji->get_casual();
    $this->load->view('gaji/e_casual',$data);
  }

  public function set_pph_casual()
  {
    $jml_nik=count($this->input->post('nik'));
    $data=array();
    for ($i=0; $i < $jml_nik; $i++) { 
      $data[$i]=array(
                  "nik" => $this->input->post('nik')[$i],
                  "pph_1" => $this->input->post('pph1')[$i],
                  "pph_2" => $this->input->post('pph2')[$i],
                  "entry_user" => $this->session->userdata('username'),
                  'tgl_pph' => date('Y-m-d',strtotime($this->input->post('thn')."-".$this->input->post('bln')."-01")),
                  );
      $this->model_gaji->input_pph($data[$i]);
      // print_r($data);
    }
    echo "<script>window.opener.location.reload();window.close()</script>";
  }

  public function generateDataNew()
  {
    error_reporting(E_ALL);
    $bln_param = $this->input->post('bln');
    $thn_param = $this->input->post('thn');
    $tgl = date('Y-m-d',strtotime($thn_param."-".$bln_param."-01"));
    $tgl_awal   = date('Y-m-01', strtotime($tgl));
    $tgl_akhir  = date('Y-m-t', strtotime($tgl));
    $jml_hari_real  = intval(date('d', strtotime($tgl_akhir)));
    $jml_hari = 30;
    //Bulan Lalu
    $tglold   = date('d',strtotime($tgl));
    $blnold   = date('m',strtotime($tgl));
    $thnold   = date('Y',strtotime($tgl));
    $tgl_new  = date('Y-m-d',strtotime($thnold.'-'.($blnold-1).'-'.$tglold));
    $tgl_awal2   = date('Y-m-01', strtotime($tgl_new));
    $tgl_akhir2  = date('Y-m-t', strtotime($tgl_new));
    $jml_hari_lalu  = intval(date('d', strtotime($tgl_akhir2)));
    $tgl_new2    = date('Y-m-d',strtotime($tgl_new));

    $this->db->where('approval !=', 2);
    $this->db->where('tanggal_gaji', $tgl);
    $this->db->delete('tab_gaji_karyawan_new');

    $check = $this->db->select('*')
                      ->from('tab_gaji_karyawan_new')
                      ->where('tanggal_gaji',$tgl_awal)
                      ->get();

    if ($check->result()<>false) {
    } else {

      $query = $this->db->query(
        'SELECT a.nik AS nik_real, a.*, b.*, c.*, b.tanggal_resign as tgl_resign, d.nik AS nik_gaji_resign 
        FROM (tab_karyawan a) 
        INNER JOIN tab_history_kontrak_kerja b ON b.nik=a.nik 
        LEFT JOIN tab_pph_new c ON c.nik=a.nik AND MONTH(c.tgl_pph)="'.$bln_param.'" and year(c.tgl_pph) = "'.$thn_param.'"
        left join tab_gaji_karyawan_resign d on d.nik=a.nik AND MONTH(d.tanggal_gaji)="'.$bln_param.'" AND YEAR(d.tanggal_gaji) = "'.$thn_param.'" 
        WHERE b.tanggal_masuk <= "'.$tgl_akhir.'" AND (b.tanggal_resign >= "'.$tgl_akhir.'" OR b.tanggal_resign = "0000-00-00") AND b.status_kerja NOT LIKE "%casual%" AND d.nik IS NULL GROUP BY a.nik'
      );

      foreach ($query->result() as $val) {
        $gaji_pokok = intval($val->gaji_pokok);
        $tunjangan_jabatan = intval($val->tunjangan_jabatan);

        if ($tgl_awal<date('Y-m-d',strtotime($val->tanggal_masuk))) {
          $awal_masuk = intval(date('d',strtotime($val->tanggal_masuk)));
          $gaji_pokok = ($gaji_pokok/$jml_hari)*($jml_hari_real-$awal_masuk+1);
          $tunjangan_jabatan = ($tunjangan_jabatan/$jml_hari)*($jml_hari_real-$awal_masuk+1);
        }

        //Mencari Ekstra
        $ekstra = $this->db->query(
          'select sum(jumlah_vakasi) as jml_ekstra from tab_extra 
          where nik="'.$val->nik_real.'" and vakasi not like "%dp%" 
          and approved="Ya" and tanggal_ekstra>="'.$tgl_awal.'"
          and tanggal_ekstra<="'.$tgl_akhir.'"'
        );

        if ($ekstra->result()<>false) {
          foreach ($ekstra->result() as $row1) {
            if ($row1->jml_ekstra>0) {
              $jml_ekstra = $row1->jml_ekstra;  
            } else {
              $jml_ekstra = 0;
            }
          }
        } else {
          $jml_ekstra = 0;
        }
        /*==================================================*/

        //Mencari Pinjaman
        $pinjam = $this->db->query(
          'select *  
          from tab_pinjaman where nik="'.$val->nik_real.'" 
          and sisa_pinjam>0 limit 1'
        );

        if ($pinjam->result()<>false) {
          foreach ($pinjam->result() as $row2) {
            if ($row2->jml_cicilan>0) {
              $id_pinjam = $row2->id_pinjaman;
              if ($row2->sisa_pinjam>$row2->jml_cicilan) {
                $sisa = $row2->sisa_pinjam-$row2->jml_cicilan;
                $jml_pinjam = $row2->jml_cicilan;
              } else {
                $sisa = 0;
                $jml_pinjam = $row2->sisa_pinjam;
              } 
            } else {
              $jml_pinjam = 0;
            }
          }

          $data_pinjam = array('sisa_temp' => $sisa, 'akhir_bayar' => $tgl_awal);

          $this->db->where('id_pinjaman', $id_pinjam);
          $this->db->update('tab_pinjaman', $data_pinjam);
        } else {
          $jml_pinjam = 0;
        }
        /*==================================================*/

        //Mencari Jht
        $jht = $this->db->query(
          'select a.*,b.* from tab_bpjs_karyawan a 
          inner join tab_master_bpjs_copy b on b.id_bpjs=a.id_bpjs 
          where nik="'.$val->nik_real.'" and a.id_bpjs=1 
          and a.bulan_ambil <= "'.$tgl.'"
          and a.status like "%Sudah Ada%"'
        );

        if ($jht->result()<>false) {
          foreach ($jht->result() as $row3) {
            if ($row3->no_bpjs!="") {
              $jml_jht = $val->gaji_bpjs*$row3->jht_2/100;  
            } else {
              $jml_jht = 0;
            }
          } 
        } else {
          $jml_jht = 0;
        }
        /*==================================================*/

        //Mencari Jpk
        $jpk = $this->db->query(
          'select a.*,b.* from tab_bpjs_karyawan a 
          inner join tab_master_bpjs_copy b on b.id_bpjs=a.id_bpjs 
          where a.nik="'.$val->nik_real.'" and a.id_bpjs=2 
          and a.bulan_ambil <= "'.$tgl.'"
          and a.status like "%Sudah Ada%"'
        );

        if ($jpk->result()<>false) {
          foreach ($jpk->result() as $row4) {
            if ($row4->no_bpjs!="") {
              if ($val->nik_real=="9300051") {
                $jml_jpk = 4725000*$row4->jpk_2/100;
              } else {
                $jml_jpk = $val->gaji_bpjs*$row4->jpk_2/100;
              }
            } else {
              $jml_jpk = 0;
            }
          } 
        } else {
          $jml_jpk = 0;
        }
        /*==================================================*/

        // BPJS Dinamis
        $bpjsid = array();
        $bpjsiddetail = array();
        $bpjspotongan = array();
        $total_potongan = 0;
        $bpjs_nama = $this->db->query('
          SELECT a.id_bpjs, a.nama_bpjs, b.id_bpjs_detail, b.nama_potongan, b.nilai_potongan
          FROM tab_master_bpjs a 
          INNER JOIN tab_master_bpjs_detail b ON b.id_bpjs = a.id_bpjs 
          WHERE a.status_bpjs = 1 AND b.status_potongan = 1 
          AND (b.tujuan_potongan = 0 OR b.tujuan_potongan = 2) 
        ');
        if ($bpjs_nama->result() <> false) {
          foreach ($bpjs_nama->result() as $row_bpjs) {
            array_push($bpjsid, $row_bpjs->id_bpjs);
            array_push($bpjsiddetail, $row_bpjs->id_bpjs_detail);
          }
        }
        $bpjs_query = $this->db->query('
          SELECT a.nik, a.no_bpjs, b.id_bpjs, b.nama_bpjs, c.id_bpjs_detail, c.nama_potongan, c.nilai_potongan
          FROM tab_bpjs_karyawan a 
          INNER JOIN tab_master_bpjs b ON b.id_bpjs = a.id_bpjs 
          INNER JOIN tab_master_bpjs_detail c ON c.id_bpjs = b.id_bpjs 
          WHERE nik = '.$val->nik_real.' AND b.status_bpjs = 1 
          AND c.status_potongan = 1 AND (c.tujuan_potongan = 0 OR c.tujuan_potongan = 2) 
          AND a.bulan_ambil <= "'.$tgl.'" AND a.status LIKE "%Sudah Ada%"
        ');
        if ($bpjs_query->result() <> false) {
          foreach ($bpjs_query->result() as $row_bpjs) {
            for ($i = 0; $i < sizeof($bpjsid); $i++) { 
              if ($row_bpjs->id_bpjs == $bpjsid[$i] && $row_bpjs->id_bpjs_detail == $bpjsiddetail[$i]) {
                if (strlen($row_bpjs->no_bpjs) > 0) {
                  $bpjspotongan_value = intval($val->gaji_bpjs * $row_bpjs->nilai_potongan / 100);
                  array_push($bpjspotongan, $bpjspotongan_value);
                } else {
                  array_push($bpjspotongan, 0);
                }
              }
            }
          }
        } else {
          for ($i = 0; $i < sizeof($bpjsid); $i++) {
            array_push($bpjspotongan, 0);
          }
        }

        if (sizeof($bpjsid) > sizeof($bpjspotongan)) {
          for ($i = 0; $i < sizeof($bpjsid); $i++) {
            if ($bpjspotongan[$i] != null) {
              array_push($bpjspotongan, 0);
            }
          } 
        }

        for ($i = 0; $i < sizeof($bpjspotongan); $i++) {
          $total_potongan += $bpjspotongan[$i];
        } 
        // End BPJS Dinamis

        //Mencari DP Cuti Bulan Lalu
        $cuti = $this->db->query(
          'select * from tab_master_dp  
          where nik="'.$val->nik_real.'" 
          and bulan="'.date('m',strtotime($tgl_new2)).'" 
          and tahun="'.date('Y',strtotime($tgl_new2)).'"'
        );

        $dp_new = 0; $cuti_new = 0;
        $dp_minus = 0; $dp_plus = 0;

        if ($cuti->result()<>false) {
          foreach ($cuti->result() as $row5) {
            $dp_new = $row5->saldo_dp;
            $cuti_new = $row5->saldo_cuti;
          }
        }

        if (date('Y-m-d',strtotime($tgl_awal))<date('Y-m-d',strtotime($val->tanggal_masuk))) {
          //Absensi Bulan lalu
          $absensi = $this->db->query('
            SELECT a.*,b.* 
            FROM tab_absensi a 
            INNER JOIN tab_jam_kerja b ON b.kode_jam = a.kode_jam 
            WHERE a.tgl_kerja>="'.$val->tanggal_masuk.'" 
            AND a.tgl_kerja<="'.$tgl_akhir.'" 
            AND a.nik="'.$val->nik_real.'"
          ');
        } else {
          //Absensi Bulan lalu
          $absensi = $this->db->query('
            SELECT a.*,b.* 
            FROM tab_absensi a 
            INNER JOIN tab_jam_kerja b ON b.kode_jam = a.kode_jam 
            WHERE a.tgl_kerja>="'.$tgl_awal.'" AND a.tgl_kerja<="'.$tgl_akhir.'" 
            AND a.nik="'.$val->nik_real.'"
          ');
        }

        if ($absensi->result()<>null) {
          foreach ($absensi->result() as $val2) {
            if ($val2->tipe_shift=="Pagi"||$val2->tipe_shift=="Sore") {
              if ($val2->status_masuk=="Masuk"||$val2->status_masuk=="Masuk Tidak Lengkap"&&$val2->keterangan_masuk!="Telat") {
                $dp_plus++;
              } else if ($val2->status_masuk=="Masuk"||$val2->status_masuk=="Masuk Tidak Lengkap"&&$val2->keterangan_masuk=="Telat") {
                $time1 = strtotime($val2->jam_start);
                $time2 = strtotime($val2->jam_masuk1);
                $jam_telat = date('i', ($time2 - $time1));
                $jam1 = 60;
                $jam2 = 8;
                $nilai_real = 1 - round($jam_telat/$jam1/$jam2,2,PHP_ROUND_HALF_DOWN);

                if ($jam_telat<=30) {
                  $dp_plus += $nilai_real;
                }
              }
            } else if ($val2->tipe_shift=="Pagi&Sore") {
              if ($val2->status_masuk=="Masuk"||$val2->status_masuk=="Masuk Tidak Lengkap"&&$val2->keterangan_masuk!="Telat") {
                $dp_plus += 0.5;
              } else if ($val2->status_masuk=="Masuk"||$val2->status_masuk=="Masuk Tidak Lengkap"&&$val2->keterangan_masuk=="Telat") {
                $time1 = strtotime($val2->jam_start1);
                $time2 = strtotime($val2->jam_masuk1);
                $jam_telat = date('i', ($time2 - $time1));
                $jam1 = 60;
                $jam2 = 8;
                $nilai_real = 0.5 - round($jam_telat/$jam1/$jam2,2,PHP_ROUND_HALF_DOWN);

                if ($jam_telat<=30) {
                  $dp_plus += $nilai_real;
                }
              }
              if ($val2->status_masuk2=="Masuk"||$val2->status_masuk2=="Masuk Tidak Lengkap"&&$val2->keterangan_masuk2!="Telat") {
                $dp_plus += 0.5;
              } else if ($val2->status_masuk2=="Masuk"||$val2->status_masuk2=="Masuk Tidak Lengkap"&&$val2->keterangan_masuk2=="Telat") {
                $time1 = strtotime($val2->jam_start2);
                $time2 = strtotime($val2->jam_masuk2);
                $jam_telat = date('i', ($time2 - $time1));
                $jam1 = 60;
                $jam2 = 8;
                $nilai_real = 0.5 - round($jam_telat/$jam1/$jam2,2,PHP_ROUND_HALF_DOWN);

                if ($jam_telat<=30) {
                  $dp_plus += $nilai_real;
                }
              }
            }
          }
        }

        $cuti_now = $cuti_new;

        if ($cuti_now<0) {
          $jml_cuti = abs((($gaji_pokok+$tunjangan_jabatan)/$jml_hari_lalu)*$cuti_now);
        } else {
          $jml_cuti = 0;
        }

        /*==================================================*/

        if ($val->jml_pph==NULL) {
          $val->jml_pph = 0;
        }

        $jml_diterima = (($gaji_pokok)+($tunjangan_jabatan)+($jml_ekstra))-(($jml_cuti)+($jml_pinjam)+($val->jml_pph)+($jml_jht)+($jml_jpk));

        if ($jml_diterima>0) {
          $jml_diterima = $jml_diterima;
        } else {
          $jml_diterima = 0;
        }
        $jml_diterima_fix = substr($jml_diterima, 0, -2)."00";
        //$jml_diterima_fix = $jml_diterima;

        $data = array (
          'nik'                 => $val->nik_real,
          'gaji_bpjs'           => $val->gaji_bpjs,
          'gaji_karyawan'       => $gaji_pokok,
          'tunjangan_jabatan'   => $tunjangan_jabatan,
          'gaji_ekstra'         => $jml_ekstra,
          'potongan_cuti'       => $jml_cuti,
          'pinjaman'            => $jml_pinjam,
          'pph21'               => $val->jml_pph,
          'bea_jht'             => $jml_jht,
          'bea_jpk'             => $jml_jpk,
          'potongan_bpjs_id'    => implode(",",$bpjsid),
          'potongan_bpjs_id_detail' => implode(",",$bpjsiddetail),
          'potongan_bpjs'       => implode(",",$bpjspotongan),
          'total_potongan_bpjs' => $total_potongan,
          'gaji_diterima'       => $jml_diterima_fix,
          'tanggal_gaji'        => $tgl,
          'approval'            => 0,
          'keterangan'          => "Auto Generate",
          'entry_user'          => $this->session->userdata('username'),
          'entry_date'          => date('Y-m-d H:i:s')
        );
        // if ($data['nik']=="9100306") {
          //var_dump($data);
        // }
        if ($data['nik']!=null||$data['nik']!="null") {
          $this->db->where('nik', $data['nik']);
          $this->db->where('tanggal_gaji', $data['tanggal_gaji']);
          $this->db->delete('tab_gaji_karyawan_new');

          $this->db->insert('tab_gaji_karyawan_new', $data); 
        }
      }//END FOREACH
    }

    $response['status'] = '200';
    echo json_encode($response);
  }

  public function generateData($bln_param,$thn_param)
  {
    error_reporting(E_ALL);
    //Bulan Sekarang
    //$tgl  = date('Y-m-d', strtotime("2016-06-15"));
    $tgl = date('Y-m-d',strtotime($thn_param."-".$bln_param."-01"));

    $tgl_awal   = date('Y-m-01', strtotime($tgl));
    $tgl_akhir  = date('Y-m-t', strtotime($tgl));
    //$jml_hari   = intval(date('d', strtotime($tgl_akhir)));
    $jml_hari_real  = intval(date('d', strtotime($tgl_akhir)));
    $jml_hari = 30;
    //Bulan Lalu
    $tglold   = date('d',strtotime($tgl));
    $blnold   = date('m',strtotime($tgl));
    $thnold   = date('Y',strtotime($tgl));
    $tgl_new  = date('Y-m-d',strtotime($thnold.'-'.($blnold-1).'-'.$tglold));
    $tgl_awal2   = date('Y-m-01', strtotime($tgl_new));
    $tgl_akhir2  = date('Y-m-t', strtotime($tgl_new));
    $tgl_new2    = date('Y-m-d',strtotime($tgl_new));

    $this->db->where('approval !=', 2);
    $this->db->where('tanggal_gaji', $tgl);
    $this->db->delete('tab_gaji_karyawan_new');

    $check = $this->db->select('*')
                      ->from('tab_gaji_karyawan_new')
                      ->where('tanggal_gaji',date('Y-m-d', strtotime($tgl)))
                      ->get();
    
    if ($check->result()<>false) {
      $response['result'] = "Onok";
    } else {
      $response['result'] = "Gak Onok";
      /*$query = $this->db->select('a.*,a.nik as nik_real,b.*,c.*,d.nik as nik_resign, d.tanggal_resign as tgl_resign')
                        ->from('tab_karyawan a')
                        ->join('tab_kontrak_kerja b','b.nik=a.nik','inner')
                        //->join('tab_pph c','c.nik=a.nik','left')
                        ->join('tab_pph_new c','c.nik=a.nik and month(c.tgl_pph)='.$bln_param.'','left')
                        ->join('tab_resign d','d.nik=a.nik','left')
                        //->where('month(c.tgl_pph)',$bln_param)
                        ->or_not_like('b.status_kerja','casual')
                        ->or_not_like('b.status_kerja2','casual')
                        ->get();*/

      $query = $this->db->select('a.*,a.nik as nik_real,b.*,c.*')
                        ->from('tab_karyawan a')
                        ->join('tab_history_kontrak_kerja b','b.nik=a.nik','inner')
                        ->join('tab_pph_new c','c.nik=a.nik and month(c.tgl_pph)='.$bln_param.'','left')
                        ->where('b.tanggal_resign >=',$tgl_akhir)
                        ->or_where('b.tanggal_resign','0000-00-00')
                        ->not_like('b.status_kerja','casual')
                        ->get();

      foreach ($query->result() as $val) {
        $gaji_pokok = intval($val->gaji_pokok);
        $tunjangan_jabatan = intval($val->tunjangan_jabatan);

        if ($tgl_awal<date('Y-m-d',strtotime($val->tanggal_masuk))) {
          $awal_masuk = intval(date('d',strtotime($val->tanggal_masuk)));
          $gaji_pokok = ($gaji_pokok/$jml_hari)*($jml_hari_real-$awal_masuk+1);
          $tunjangan_jabatan = ($tunjangan_jabatan/$jml_hari)*($jml_hari_real-$awal_masuk+1);
        }

        //Mencari Ekstra
        $ekstra = $this->db->query(
          'select sum(jumlah_vakasi) as jml_ekstra from tab_extra 
          where nik="'.$val->nik_real.'" and vakasi not like "%dp%" 
          and approved="Ya" and tanggal_ekstra>="'.$tgl_awal.'"
          and tanggal_ekstra<="'.$tgl_akhir.'"'
        );

        if ($ekstra->result()<>false) {
          foreach ($ekstra->result() as $row1) {
            if ($row1->jml_ekstra>0) {
              $jml_ekstra = $row1->jml_ekstra;  
            } else {
              $jml_ekstra = 0;
            }
          }
        } else {
          $jml_ekstra = 0;
        }
        /*==================================================*/

        //Mencari Pinjaman
        $pinjam = $this->db->query(
          'select *  
          from tab_pinjaman where nik="'.$val->nik_real.'" 
          and sisa_pinjam>0 limit 1'
        );

        if ($pinjam->result()<>false) {
          foreach ($pinjam->result() as $row2) {
            if ($row2->jml_cicilan>0) {
              $id_pinjam = $row2->id_pinjaman;
              if ($row2->sisa_pinjam>$row2->jml_cicilan) {
                $sisa = $row2->sisa_pinjam-$row2->jml_cicilan;
                $jml_pinjam = $row2->jml_cicilan;
              } else {
                $sisa = 0;
                $jml_pinjam = $row2->sisa_pinjam;
              } 
            } else {
              $jml_pinjam = 0;
            }
          }

          $data_pinjam = array('sisa_temp' => $sisa, 'akhir_bayar' => $tgl_awal);

          $this->db->where('id_pinjaman', $id_pinjam);
          $this->db->update('tab_pinjaman', $data_pinjam);
        } else {
          $jml_pinjam = 0;
        }
        /*==================================================*/

        //Mencari Jht
        $jht = $this->db->query(
          'select a.*,b.* from tab_bpjs_karyawan a 
          inner join tab_master_bpjs b on b.id_bpjs=a.id_bpjs 
          where nik="'.$val->nik_real.'" and a.id_bpjs=1 
          and month(a.bulan_ambil)<='.$bln_param.'
          and a.status like "%Sudah Ada%"'
        );

        if ($jht->result()<>false) {
          foreach ($jht->result() as $row3) {
            if ($row3->no_bpjs!="") {
              $jml_jht = $val->gaji_bpjs*$row3->jht_2/100;  
            } else {
              $jml_jht = 0;
            }
          } 
        } else {
          $jml_jht = 0;
        }
        /*==================================================*/

        //Mencari Jpk
        $jpk = $this->db->query(
          'select a.*,b.* from tab_bpjs_karyawan a 
          inner join tab_master_bpjs b on b.id_bpjs=a.id_bpjs 
          where a.nik="'.$val->nik_real.'" and a.id_bpjs=2 
          and month(a.bulan_ambil)<='.$bln_param.'
          and a.status like "%Sudah Ada%"'
        );

        if ($jpk->result()<>false) {
          foreach ($jpk->result() as $row4) {
            if ($row4->no_bpjs!="") {
              if ($val->nik_real=="9300051") {
                $jml_jpk = 4725000*$row4->jpk_2/100;
              } else {
                $jml_jpk = $val->gaji_bpjs*$row4->jpk_2/100;
              }
            } else {
              $jml_jpk = 0;
            }
          } 
        } else {
          $jml_jpk = 0;
        }
        /*==================================================*/

        //Mencari DP Cuti Bulan Lalu
        $cuti = $this->db->query(
          'select * from tab_master_dp  
          where nik="'.$val->nik_real.'" 
          and bulan="'.date('m',strtotime($tgl_new2)).'" 
          and tahun="'.date('Y',strtotime($tgl_new2)).'"'
        );

        $dp_new = 0; $cuti_new = 0;
        $dp_minus = 0; $dp_plus = 0;

        if ($cuti->result()<>false) {
          foreach ($cuti->result() as $row5) {
            $dp_new = $row5->saldo_dp;
            $cuti_new = $row5->saldo_cuti;
          }
        }

        if (date('Y-m-d',strtotime($tgl_awal))<date('Y-m-d',strtotime($val->tanggal_masuk))) {
          //Absensi Bulan lalu
          $absensi = $this->db->query('
            SELECT a.*,b.* 
            FROM tab_absensi a 
            INNER JOIN tab_jam_kerja b ON b.kode_jam = a.kode_jam 
            WHERE a.tgl_kerja>="'.$val->tanggal_masuk.'" 
            AND a.tgl_kerja<="'.$tgl_akhir.'" 
            AND a.nik="'.$val->nik_real.'"
          ');
        } else {
          //Absensi Bulan lalu
          $absensi = $this->db->query('
            SELECT a.*,b.* 
            FROM tab_absensi a 
            INNER JOIN tab_jam_kerja b ON b.kode_jam = a.kode_jam 
            WHERE a.tgl_kerja>="'.$tgl_awal.'" AND a.tgl_kerja<="'.$tgl_akhir.'" 
            AND a.nik="'.$val->nik_real.'"
          ');
        }

        if ($absensi->result()<>null) {
          foreach ($absensi->result() as $val2) {
            if ($val2->tipe_shift=="Pagi"||$val2->tipe_shift=="Sore") {
              if ($val2->status_masuk=="Masuk"||$val2->status_masuk=="Masuk Tidak Lengkap"&&$val2->keterangan_masuk!="Telat") {
                $dp_plus++;
              } else if ($val2->status_masuk=="Masuk"||$val2->status_masuk=="Masuk Tidak Lengkap"&&$val2->keterangan_masuk=="Telat") {
                $time1 = strtotime($val2->jam_start);
                $time2 = strtotime($val2->jam_masuk1);
                $jam_telat = date('i', ($time2 - $time1));
                $jam1 = 60;
                $jam2 = 8;
                $nilai_real = 1 - round($jam_telat/$jam1/$jam2,2,PHP_ROUND_HALF_DOWN);

                if ($jam_telat<=30) {
                  $dp_plus += $nilai_real;
                }
              }
            } else if ($val2->tipe_shift=="Pagi&Sore") {
              if ($val2->status_masuk=="Masuk"||$val2->status_masuk=="Masuk Tidak Lengkap"&&$val2->keterangan_masuk!="Telat") {
                $dp_plus += 0.5;
              } else if ($val2->status_masuk=="Masuk"||$val2->status_masuk=="Masuk Tidak Lengkap"&&$val2->keterangan_masuk=="Telat") {
                $time1 = strtotime($val2->jam_start1);
                $time2 = strtotime($val2->jam_masuk1);
                $jam_telat = date('i', ($time2 - $time1));
                $jam1 = 60;
                $jam2 = 8;
                $nilai_real = 0.5 - round($jam_telat/$jam1/$jam2,2,PHP_ROUND_HALF_DOWN);

                if ($jam_telat<=30) {
                  $dp_plus += $nilai_real;
                }
              }
              if ($val2->status_masuk2=="Masuk"||$val2->status_masuk2=="Masuk Tidak Lengkap"&&$val2->keterangan_masuk2!="Telat") {
                $dp_plus += 0.5;
              } else if ($val2->status_masuk2=="Masuk"||$val2->status_masuk2=="Masuk Tidak Lengkap"&&$val2->keterangan_masuk2=="Telat") {
                $time1 = strtotime($val2->jam_start2);
                $time2 = strtotime($val2->jam_masuk2);
                $jam_telat = date('i', ($time2 - $time1));
                $jam1 = 60;
                $jam2 = 8;
                $nilai_real = 0.5 - round($jam_telat/$jam1/$jam2,2,PHP_ROUND_HALF_DOWN);

                if ($jam_telat<=30) {
                  $dp_plus += $nilai_real;
                }
              }
            }
          }
        }

        $cuti_now = $cuti_new;

        if ($cuti_now<0) {
          $jml_cuti = abs(($gaji_pokok/$jml_hari)*$cuti_now);
        } else {
          $jml_cuti = 0;
        }

        /*==================================================*/

        if ($val->jml_pph==NULL) {
          $val->jml_pph = 0;
        }

        $jml_diterima = (($gaji_pokok)+($tunjangan_jabatan)+($jml_ekstra))-(($jml_cuti)+($jml_pinjam)+($val->jml_pph)+($jml_jht)+($jml_jpk));

        if ($jml_diterima>0) {
          $jml_diterima = $jml_diterima;
        } else {
          $jml_diterima = 0;
        }
        $jml_diterima_fix = substr($jml_diterima, 0, -2)."00";
        //$jml_diterima_fix = $jml_diterima;

        $data = array (
          'nik'                 => $val->nik_real,
          'gaji_bpjs'           => $val->gaji_bpjs,
          'gaji_karyawan'       => $gaji_pokok,
          'tunjangan_jabatan'   => $tunjangan_jabatan,
          'gaji_ekstra'         => $jml_ekstra,
          'potongan_cuti'       => $jml_cuti,
          'pinjaman'            => $jml_pinjam,
          'pph21'               => $val->jml_pph,
          'bea_jht'             => $jml_jht,
          'bea_jpk'             => $jml_jpk,
          'gaji_diterima'       => $jml_diterima_fix,
          'tanggal_gaji'        => $tgl,
          'approval'            => 0,
          'keterangan'          => "Auto Generate",
          'entry_user'          => $this->session->userdata('username'),
          'entry_date'          => date('Y-m-d H:i:s')
        );
        //var_dump($data);
        if ($data['nik']!=null||$data['nik']!="null") {
          $this->db->where('nik', $data['nik']);
          $this->db->where('tanggal_gaji', $data['tanggal_gaji']);
          $this->db->delete('tab_gaji_karyawan_new');

          $this->db->insert('tab_gaji_karyawan_new', $data); 
        }
      }//END FOREACH
    }

    /*$response['status'] = '200';
    echo json_encode($response);*/
  }

  //public function generateData2($bln_param,$thn_param)
  public function generateData2()
  {
    error_reporting(E_ALL ^ E_NOTICE);
    // echo "HELLO";
    //Bulan Sekarang
    //$tgl  = date('Y-m-d', strtotime("2016-06-15"));
    $bln_param = $this->input->post('bln');
    $thn_param = $this->input->post('thn');
    $tgl = date('Y-m-d',strtotime($thn_param."-".$bln_param."-01"));

    $tgl_awal   = date('Y-m-01', strtotime($tgl));
    $tgl_akhir  = date('Y-m-15', strtotime($tgl));
    $jml_hari   = intval(date('d', strtotime($tgl_akhir)));

    $tgl_awal2   = date('Y-m-16', strtotime($tgl));
    $tgl_akhir2  = date('Y-m-t', strtotime($tgl));
    $jml_hari2   = date('d', strtotime($tgl_akhir2)) - date('d', strtotime($tgl_awal2)) + 1;

    $response['jml1'] = $jml_hari;
    $response['jml2'] = $jml_hari2;

    $this->db->where('approval !=', 2);
    $this->db->where('tanggal_gaji_1', $tgl_akhir);
    $this->db->delete('tab_gaji_casual_new');

    $check = $this->db->select('*')
                      ->from('tab_gaji_casual_new')
                      ->where('tanggal_gaji_1',date('Y-m-d', strtotime($tgl_akhir)))
                      ->where('tanggal_gaji_2',date('Y-m-d', strtotime($tgl_akhir2)))
                      ->get();
    // $response['query1'] = $this->db->last_query();
    
    if ($check->result()<>false) {
      $response['result'] = "Onok";
    } else {
      $response['result'] = "Gak Onok";

      /*$query = $this->db->select('a.*,a.nik as nik_real,b.*,c.*,d.nik as nik_resign, d.tanggal_resign as tgl_resign')
                        ->from('tab_karyawan a')
                        ->join('tab_kontrak_kerja b','b.nik=a.nik','inner')
                        ->join('pph_casual c','c.nik=a.nik','left')
                        ->join('tab_resign d','d.nik=a.nik','left')
                        //->like('b.status_kerja','casual')
                        ->like('b.status_kerja2','casual')
                        //->where('b.tanggal_resign','0000-00-00')
                        ->get();*/
      $query = $this->db->query(
        'SELECT a.nik AS nik_real, a.*, b.*, c.*, b.tanggal_resign as tgl_resign 
        FROM (tab_karyawan a) 
        INNER JOIN tab_history_kontrak_kerja b ON b.nik=a.nik 
        LEFT JOIN pph_casual c ON c.nik=a.nik AND MONTH(c.tgl_pph)="'.$bln_param.'" 
        LEFT JOIN tab_resign d ON d.nik=a.nik 
        WHERE (b.tanggal_resign >= "'.$tgl_akhir.'" OR b.tanggal_resign = "0000-00-00") 
        AND b.status_kerja LIKE "%casual%" AND tanggal_masuk <= "'.$tgl_akhir.'" GROUP BY a.nik'
      );
      $response['query1'] = $this->db->last_query();
      
      foreach ($query->result() as $val) {
        if ($val->nik_resign==NULL||date('m',strtotime($val->tgl_resign))==date('m',strtotime($tgl))) {
        $tgl_resign = $val->tgl_resign;
        //Mencari Ekstra
        $ekstra1 = $this->db->query(
          'select sum(total) as jml_ekstra from tab_casual_ekstra 
          where nik="'.$val->nik_real.'" and approved="2" 
          and tgl_ekstra>="'.$tgl_awal.'"
          and tgl_ekstra<="'.$tgl_akhir.'"'
        );

        if ($ekstra1->result()<>false) {
          foreach ($ekstra1->result() as $row1) {
            if ($row1->jml_ekstra>0) {
              $jml_ekstra1 = $row1->jml_ekstra;  
            } else {
              $jml_ekstra1 = 0;
            }
          }
        } else {
          $jml_ekstra1 = 0;
        }
        
        $ekstra2 = $this->db->query(
          'select sum(total) as jml_ekstra from tab_casual_ekstra 
          where nik="'.$val->nik_real.'" and approved="2" 
          and tgl_ekstra>="'.$tgl_awal2.'"
          and tgl_ekstra<="'.$tgl_akhir2.'"'
        );

        if ($ekstra2->result()<>false) {
          foreach ($ekstra2->result() as $row2) {
            if ($row2->jml_ekstra>0) {
              $jml_ekstra2 = $row2->jml_ekstra;  
            } else {
              $jml_ekstra2 = 0;
            }
          }
        } else {
          $jml_ekstra2 = 0;
        }
        /*==================================================*/

        //Mencari PPH
        $pph = $this->db->query(
          'select pph_1, pph_2 from pph_casual 
          where nik="'.$val->nik_real.'" 
          and tgl_pph>="'.$tgl_awal.'"
          and tgl_pph<="'.$tgl_akhir2.'"'
        );

        if ($pph->result()<>false) {
          foreach ($pph->result() as $row2) {
            if ($row2->pph_1>0) {
              $jml_pph1 = $row2->pph_1;
            } else {
              $jml_pph1 = 0;
            }
            if ($row2->pph_2>0) {
              $jml_pph2 = $row2->pph_2;
            } else {
              $jml_pph2 = 0;
            }
          }
        } else {
          $jml_pph1 = 0;
          $jml_pph2 = 0;
        }

        /*==================================================*/

        //Mencari JML Hadir
        /*$hadir1 = $this->db->query(
          'select count(nik) as jml_hadir from tab_absensi 
          where nik="'.$val->nik_real.'" 
          and tgl_kerja>="'.$tgl_awal.'"
          and tgl_kerja<="'.$tgl_akhir.'"
          and status_masuk LIKE "%masuk%"'
        );*/
        if ($tgl_resign!="0000-00-00"&&$tgl_resign<=$tgl_akhir) {
          $hadir1 = $this->db->query(
            'select * from tab_absensi 
            where nik="'.$val->nik_real.'" 
            and tgl_kerja>="'.$tgl_awal.'"
            and tgl_kerja<="'.$tgl_resign.'"
            and status_masuk LIKE "%masuk%"'
          ); 
        } else {
          $hadir1 = $this->db->query(
            'select * from tab_absensi 
            where nik="'.$val->nik_real.'" 
            and tgl_kerja>="'.$tgl_awal.'"
            and tgl_kerja<="'.$tgl_akhir.'"
            and status_masuk LIKE "%masuk%"'
          ); 
        }
        // echo $tgl_akhir;
        // echo $tgl_resign;
        // print_r($this->db->last_query());
        $jml_hadir1 = 0;
        if ($hadir1->result()<>false) {
          foreach ($hadir1->result() as $row3) {
            /*if ($row3->jml_hadir>0) {
              $jml_hadir1 = $row3->jml_hadir;
            } else {
              $jml_hadir1 = 0;
            }*/
            if ($row3->tipe_shift=="Pagi") {
              if ($row3->status_masuk=="Masuk"&&$row3->status_keluar=="Pulang") {
                if ($row3->keterangan_masuk=="On Time"||$row3->keterangan_masuk=="Datang Pukul"&&$row3->keterangan_keluar=="Pulang On Time"||$row3->keterangan_keluar=="Pulang Pukul") {
                  if ($row3->kode_jam=="N"||$row3->kode_jam=="O"||$row3->kode_jam=="P"||$row3->kode_jam=="Q"||$row3->kode_jam=="R"||$row3->kode_jam=="X1") {
                    $jml_hadir1 = $jml_hadir1 + 0.5;
                  } else {
                    $jml_hadir1 = $jml_hadir1 + 1;
                  }
                }
              } 
            } else if ($row3->tipe_shift=="Pagi&Sore") {
              if ($row3->status_masuk!="Telat"&&$row3->status_masuk!="Masuk Tidak Lengkap"&&$row3->status_keluar!="Pulang Tidak Lengkap"&&$row3->status_masuk2!="Telat"&&$row3->status_masuk2!="Masuk Tidak Lengkap"&&$row3->status_keluar2!="Pulang Tidak Lengkap") {

                  if ($row3->status_masuk=="Masuk"&&$row3->status_keluar=="Pulang") {
                    if ($row3->keterangan_masuk=="On Time"||$row3->keterangan_masuk=="Datang Pukul"&&$row3->keterangan_keluar=="Pulang On Time"||$row3->keterangan_keluar=="Pulang Pukul") {
                      if ($row3->kode_jam=="N"||$row3->kode_jam=="O"||$row3->kode_jam=="P"||$row3->kode_jam=="Q"||$row3->kode_jam=="R"||$row3->kode_jam=="X1") {
                        $jml_hadir1 = $jml_hadir1 + 0.5;
                      } else {
                        $jml_hadir1 = $jml_hadir1 + 0.5;
                      }
                    }
                  }
                  if ($row3->status_masuk2=="Masuk"&&$row3->status_keluar2=="Pulang") {
                      if ($row3->keterangan_masuk2=="On Time"||$row3->keterangan_masuk2=="Datang Pukul"&&$row3->keterangan_keluar2=="Pulang On Time"||$row3->keterangan_keluar2=="Pulang Pukul") {
                      if ($row3->kode_jam=="N"||$row3->kode_jam=="O"||$row3->kode_jam=="P"||$row3->kode_jam=="Q"||$row3->kode_jam=="R"||$row3->kode_jam=="X1") {
                        $jml_hadir1 = $jml_hadir1 + 0.5;
                      } else {
                        $jml_hadir1 = $jml_hadir1 + 0.5;
                      }
                    }
                  }
              }
            }
          }
        } else {
          $jml_hadir1 = 0;
        }
        
        /*$hadir2 = $this->db->query(
          'select count(nik) as jml_hadir from tab_absensi 
          where nik="'.$val->nik_real.'" 
          and tgl_kerja>="'.$tgl_awal2.'"
          and tgl_kerja<="'.$tgl_akhir2.'"
          and status_masuk LIKE "%masuk%"'
        );*/
        if ($tgl_resign!="0000-00-00"&&$tgl_resign<=$tgl_akhir2) {
          $hadir2 = $this->db->query(
            'select * from tab_absensi 
            where nik="'.$val->nik_real.'" 
            and tgl_kerja>="'.$tgl_awal2.'"
            and tgl_kerja<="'.$tgl_resign.'"
            and status_masuk LIKE "%masuk%"'
          ); 
        } else {
          $hadir2 = $this->db->query(
            'select * from tab_absensi 
            where nik="'.$val->nik_real.'" 
            and tgl_kerja>="'.$tgl_awal2.'"
            and tgl_kerja<="'.$tgl_akhir2.'"
            and status_masuk LIKE "%masuk%"'
          ); 
        }
        /*$hadir2 = $this->db->query(
          'select * from tab_absensi 
          where nik="'.$val->nik_real.'" 
          and tgl_kerja>="'.$tgl_awal2.'"
          and tgl_kerja<="'.$tgl_akhir2.'"
          and status_masuk LIKE "%masuk%"'
        );*/
        $jml_hadir2 = 0;
        if ($hadir2->result()<>false) {
          foreach ($hadir2->result() as $row3) {
            /*if ($row3->jml_hadir>0) {
              $jml_hadir2 = $row3->jml_hadir;
            } else {
              $jml_hadir2 = 0;
            }*/
            if ($row3->tipe_shift=="Pagi") {
              if ($row3->status_masuk=="Masuk"&&$row3->status_keluar=="Pulang") {
                if ($row3->keterangan_masuk=="On Time"||$row3->keterangan_masuk=="Datang Pukul"&&$row3->keterangan_keluar=="Pulang On Time"||$row3->keterangan_keluar=="Pulang Pukul") {
                  if ($row3->kode_jam=="N"||$row3->kode_jam=="O"||$row3->kode_jam=="P"||$row3->kode_jam=="Q"||$row3->kode_jam=="R"||$row3->kode_jam=="X1") {
                    $jml_hadir2 = $jml_hadir2 + 0.5;
                  } else {
                    $jml_hadir2 = $jml_hadir2 + 1;
                  }
                }
              } 
            } else if ($row3->tipe_shift=="Pagi&Sore") {
              if ($row3->status_masuk!="Telat"&&$row3->status_masuk!="Masuk Tidak Lengkap"&&$row3->status_keluar!="Pulang Tidak Lengkap"&&$row3->status_masuk2!="Telat"&&$row3->status_masuk2!="Masuk Tidak Lengkap"&&$row3->status_keluar2!="Pulang Tidak Lengkap") {

                  if ($row3->status_masuk=="Masuk"&&$row3->status_keluar=="Pulang") {
                    if ($row3->keterangan_masuk=="On Time"||$row3->keterangan_masuk=="Datang Pukul"&&$row3->keterangan_keluar=="Pulang On Time"||$row3->keterangan_keluar=="Pulang Pukul") {
                      if ($row3->kode_jam=="N"||$row3->kode_jam=="O"||$row3->kode_jam=="P"||$row3->kode_jam=="Q"||$row3->kode_jam=="R"||$row3->kode_jam=="X1") {
                        $jml_hadir2 = $jml_hadir2 + 0.5;
                      } else {
                        $jml_hadir2 = $jml_hadir2 + 0.5;
                      }
                    }
                  }
                  if ($row3->status_masuk2=="Masuk"&&$row3->status_keluar2=="Pulang") {
                      if ($row3->keterangan_masuk2=="On Time"||$row3->keterangan_masuk2=="Datang Pukul"&&$row3->keterangan_keluar2=="Pulang On Time"||$row3->keterangan_keluar2=="Pulang Pukul") {
                      if ($row3->kode_jam=="N"||$row3->kode_jam=="O"||$row3->kode_jam=="P"||$row3->kode_jam=="Q"||$row3->kode_jam=="R"||$row3->kode_jam=="X1") {
                        $jml_hadir2 = $jml_hadir2 + 0.5;
                      } else {
                        $jml_hadir2 = $jml_hadir2 + 0.5;
                      }
                    }
                  }
              }
            }
          }
        } else {
          $jml_hadir2 = 0;
        }

        $jml_hadir_all = round($jml_hadir1+$jml_hadir2, 0, PHP_ROUND_HALF_DOWN);
        $jml_hadir_real = round($jml_hadir1+$jml_hadir2, 0, PHP_ROUND_HALF_UP);

        $response['jml'][] = array('jml1' => $jml_hadir1,'jml2' => $jml_hadir2);
        /*==================================================*/

        $jml_diterima = ((($val->gaji_casual + $val->uang_makan) * $jml_hadir1) + $jml_ekstra1) - ($jml_pph1) - ($val->uang_makan * round($jml_hadir1, 0, PHP_ROUND_HALF_UP));
        $jml_diterima2 = ((($val->gaji_casual + $val->uang_makan) * $jml_hadir2) + $jml_ekstra2) - ($jml_pph2) - ($val->uang_makan * round($jml_hadir2, 0, PHP_ROUND_HALF_UP));

        $response['jml'][] = array('jml1' => $jml_diterima,'jml2' => $jml_diterima2);

        $data = array (
          'nik'                 => $val->nik_real,
          'gaji_casual'         => $val->gaji_casual,
          'uang_makan_real'     => $val->uang_makan,
          'uang_makan'          => $val->uang_makan*$jml_hadir_real,
          'jml_hadir1'          => $jml_hadir1,
          'pph21_1'             => $jml_pph1,
          'gaji_ekstra_1'       => $jml_ekstra1,
          'gaji_diterima_1'     => $jml_diterima,
          'tanggal_gaji_1'      => $tgl_akhir,
          'jml_hadir2'          => $jml_hadir2,
          'pph21_2'             => $jml_pph2,
          'gaji_ekstra_2'       => $jml_ekstra2,
          'gaji_diterima_2'     => $jml_diterima2,
          'tanggal_gaji_2'      => $tgl_akhir2,
          'approval'            => 0,
          'keterangan'          => "Auto Generate",
          'entry_user'          => $this->session->userdata('username'),
          'entry_date'          => date('Y-m-d H:i:s')
        );
        $this->db->where('nik', $data['nik']);
        $this->db->where('tanggal_gaji_1', $data['tanggal_gaji_1']);
        $this->db->delete('tab_gaji_casual_new');

        $this->db->insert('tab_gaji_casual_new', $data);
        // var_dump($data);
        }
      }//END FOREACH
    }

    $response['status'] = '200';
    echo json_encode($response);
  }

  public function generateDataresign($bln_param,$thn_param)
  {
    //Bulan Sekarang
    //$tgl = date('Y-m-d', strtotime("2016-06-18"));
    $tgl = date('Y-m-d',strtotime($thn_param."-".$bln_param."-01"));

    $tgl_awal   = date('Y-m-01', strtotime($tgl));
    //echo $tgl_awal."<br>";
    $tgl_akhir  = date('Y-m-t', strtotime($tgl));
    //$jml_hari   = intval(date('d', strtotime($tgl_akhir)));
    $jml_hari_real  = intval(date('d', strtotime($tgl_akhir)));
    $jml_hari = 30;
    $detik = 24 * 3600; // jumlah detik dalam 1 hari
    $response['jml_hari'] = $jml_hari;
    //Bulan Lalu
    $tglold   = date('d',strtotime($tgl));
    $blnold   = date('m',strtotime($tgl));
    $thnold   = date('Y',strtotime($tgl));
    $tgl_new  = date('Y-m-d',strtotime($thnold.'-'.($blnold-1).'-'.$tglold));
    $tgl_awal2   = date('Y-m-01', strtotime($tgl_new));
    $tgl_akhir2  = date('Y-m-d', strtotime($tgl_new));
    $tgl_new2    = date('Y-m-d',strtotime($tgl_new));

    $this->db->where('month(tanggal_gaji)',date('m', strtotime($tgl)));
    $this->db->delete('tab_gaji_karyawan_resign');

    $check = $this->db->select('*')
                      ->from('tab_gaji_karyawan_resign')
                      ->where('month(tanggal_gaji)',date('m', strtotime($tgl)))
                      ->get();
    //$response['query1'] = $this->db->last_query();
    //echo $this->db->last_query();
    if ($check->result()<>false) {
      $response['result'] = "Onok";
    } else {
      $response['result'] = "Gak Onok";
      // $query = $this->db->select('a.*,a.nik as nik_real,b.*,c.*,d.nik as nik_resign, d.tanggal_resign as tgl_resign,e.*,e.approval as approval_gaji')
      //                   ->from('tab_karyawan a')
      //                   ->join('tab_history_kontrak_kerja b','b.nik=a.nik','left')
      //                   //->join('tab_pph c','c.nik=a.nik','left')
      //                   ->join('tab_pph_new c','c.nik=a.nik','left')
      //                   ->join('tab_resign d','d.nik=a.nik','inner')
      //                   ->join('tab_gaji_karyawan_new e','e.nik=a.nik','left')
      //                   ->where('month(d.tanggal_resign)',date('m', strtotime($tgl)))
      //                   ->not_like('b.status_kerja','casual')
      //                   ->or_where('month(e.tanggal_gaji)',date('m', strtotime($tgl)))
      //                   ->where('month(d.tanggal_resign)',date('m', strtotime($tgl)))
      //                   ->not_like('b.status_kerja','casual')
      //                   ->group_by('a.nik')
      //                   //->where('c.jml_pph >',-1)
      //                   //->where('b.tanggal_resign',date('Y-m-d', strtotime($tgl)))
      //                   ->get();
      $query = $this->db->query(
        'SELECT a.*,a.nik as nik_real,b.*,c.*,d.nik as nik_resign, d.tanggal_resign as tgl_resign,e.*,e.approval as approval_gaji, a.gaji_bpjs as gaji_bpjs_real 
        FROM tab_karyawan a 
        LEFT JOIN tab_history_kontrak_kerja b ON b.nik=a.nik 
        LEFT JOIN tab_pph_new c ON c.nik=a.nik 
        INNER JOIN tab_resign d ON d.nik=a.nik 
        LEFT JOIN 
        ( SELECT * 
        FROM tab_gaji_karyawan_new 
        WHERE tanggal_gaji >= "'.$tgl_awal.'" AND tanggal_gaji <= "'.$tgl_akhir.'" )
        e ON e.nik=a.nik 
        WHERE MONTH(d.tanggal_resign) = '.date('m', strtotime($tgl)).' AND b.status_kerja NOT LIKE "%casual%" 
        GROUP BY a.nik'
      );
      // echo $this->db->last_query();

      foreach ($query->result() as $val) {
        // echo "<br>";
        $tgl_masuk  = $val->tanggal_masuk;
        $tgl_resign = $val->tgl_resign;

        $tgl_1  = new DateTime($val->tanggal_masuk);
        $tgl_2 = new DateTime($val->tgl_resign);
        $diff = $tgl_2->diff($tgl_1);
        $lama = (($diff->format('%y') * 12) + $diff->format('%m')) + 1;
        $lama_hari = $diff->format('%a');
        if ($lama_hari < 365) {
          $lama -= 1;
        }

        $gaji_pokok = intval($val->gaji_pokok);
        $tunjangan_jabatan = intval($val->tunjangan_jabatan);
        $gaji_harian = ($gaji_pokok+$tunjangan_jabatan)/$jml_hari;

        // echo "NIK ".$val->nik_real."<br>";
        // echo "STATUS ".$val->status_kerja."<br>";
        // echo "MASUK ".$tgl_masuk."<br>";
        // echo "RESIGN ".$tgl_resign."<br>";
        // echo "LAMA ".$lama."<br>";
        // echo "GAJI POKOK ".$gaji_pokok." | TUNJANGAN ".$tunjangan_jabatan." | HARIAN ".$gaji_harian."<br>";
        //MENCARI JATAH LIBUR
        $minggu = 0;
        // cari jumlah minggu dalam 1 bulan
        for ($i=strtotime($tgl_awal); $i<=strtotime($tgl_resign); $i+=$detik)
        {
          if (date("w", $i) == "0"){
            $minggu++;
          }
        }
        $cari_jml = $this->db->query(
          '
          select sum(lama) as jml from tab_hari_libur 
          where tanggal_mulai>="'.$tgl_awal.'" and tanggal_selesai<="'.$tgl_resign.'" 
          and cuti_khusus="Ya"
          '
        );
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
        $jatah_libur = $jml_libur+$minggu;
        //echo "<br>".$jatah_libur."<br>";
        //Mencari Ekstra
            $ekstra = $this->db->query(
              'select sum(jumlah_vakasi) as jml_ekstra from tab_extra 
              where nik="'.$val->nik_real.'" and vakasi not like "%dp%" 
              and approved="Ya" and tanggal_ekstra>="'.$tgl_awal.'"
              and tanggal_ekstra<="'.$tgl_akhir.'"'
            );

            if ($ekstra->result()<>false) {
              foreach ($ekstra->result() as $row1) {
                if ($row1->jml_ekstra>0) {
                  $jml_ekstra = $row1->jml_ekstra;  
                } else {
                  $jml_ekstra = 0;
                }
              }
            } else {
              $jml_ekstra = 0;
            }
            /*==================================================*/

            //Mencari Pinjaman
            $pinjam = $this->db->query(
              'select *  
              from tab_pinjaman where nik="'.$val->nik_real.'" 
              and sisa_pinjam>0 limit 1'
            );

            if ($pinjam->result()<>false) {
              foreach ($pinjam->result() as $row2) {
                if ($row2->jml_cicilan>0) {
                  $id_pinjam = $row2->id_pinjaman;
                  if ($row2->sisa_pinjam>$row2->jml_cicilan) {
                    $sisa = $row2->sisa_pinjam-$row2->jml_cicilan;
                    $jml_pinjam = $row2->jml_cicilan;
                  } else {
                    $sisa = 0;
                    $jml_pinjam = $row2->sisa_pinjam;
                  } 
                } else {
                  $jml_pinjam = 0;
                }
              }

              $data_pinjam = array('sisa_temp' => $sisa, 'akhir_bayar' => $tgl_awal);

              $this->db->where('id_pinjaman', $id_pinjam);
              $this->db->update('tab_pinjaman', $data_pinjam);
            } else {
              $jml_pinjam = 0;
            }
            /*==================================================*/

            //Mencari Jht
            $jht = $this->db->query(
              'select a.*,b.* from tab_bpjs_karyawan a 
              inner join tab_master_bpjs b on b.id_bpjs=a.id_bpjs 
              where nik="'.$val->nik_real.'" and a.id_bpjs=1 
              and a.bulan_ambil<="'.$tgl_akhir.'"
              and a.status like "%Sudah Ada%"'
            );

            if ($jht->result()<>false) {
              foreach ($jht->result() as $row3) {
                if ($row3->no_bpjs!="") {
                  $jml_jht = $val->gaji_bpjs_real*$row3->jht_2/100;  
                } else {
                  $jml_jht = 0;
                }
              } 
            } else {
              $jml_jht = 0;
            }
            if (date('d',strtotime($tgl_resign))<=20) {
              $jml_jht = 0;
            }
            /*==================================================*/

            //Mencari Jpk
            $jpk = $this->db->query(
              'select a.*,b.* from tab_bpjs_karyawan a 
              inner join tab_master_bpjs b on b.id_bpjs=a.id_bpjs 
              where a.nik="'.$val->nik_real.'" and a.id_bpjs=2 
              and a.bulan_ambil<="'.$tgl_akhir.'"
              and a.status like "%Sudah Ada%"'
            );

            if ($jpk->result()<>false) {
              foreach ($jpk->result() as $row4) {
                if ($row4->no_bpjs!="") {
                  if ($val->nik_real=="9300051") {
                    $jml_jpk = 4725000*$row4->jpk_2/100;
                  } else {
                    $jml_jpk = $val->gaji_bpjs_real*$row4->jpk_2/100;
                  }
                } else {
                  $jml_jpk = 0;
                }
              } 
            } else {
              $jml_jpk = 0;
            }
            if (date('d',strtotime($tgl_resign))>20) {
              $jml_jpk = $jml_jpk * 2;
            }
            /*==================================================*/

            //Mencari DP Cuti Bulan Lalu
            $cuti = $this->db->query(
              'select * from tab_master_dp  
              where nik="'.$val->nik_real.'" 
              and bulan="'.date('m',strtotime($tgl_new2)).'" 
              and tahun="'.date('Y',strtotime($tgl_new2)).'"'
            );

            $dp_new = 0; $cuti_new = 0;
            $dp_minus = 0; $dp_plus = 0;

            if ($cuti->result()<>false) {
              foreach ($cuti->result() as $row5) {
                $dp_new = $row5->saldo_dp;
                $cuti_new = $row5->saldo_cuti;
              }
            }

          $absen_query = $this->db->select('a.*,b.*')
                                  ->from('tab_absensi a')
                                  ->join('tab_jam_kerja b','b.kode_jam=a.kode_jam','inner')
                                  ->where('a.nik',$val->nik_real)
                                  ->where('a.tgl_kerja >=',$tgl_awal)
                                  ->where('a.tgl_kerja <=',$tgl_resign)
                                  ->get();

            $jml_absen = 0;
            if ($absen_query<>false) {
              foreach ($absen_query->result() as $row) {
                $begin_day_unix   = strtotime($row->tgl_kerja.' 00:00:00');
                $begin_day_unix2  = strtotime($row->tgl_kerja.' 00:00:00');
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
                    $batas = date('H:i:s', (strtotime("05:00:00")));
                    if (($selisih1+$selisih2)<$batas) {
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
                }
              }
            }

            
            $cuti_query = $this->db->select('*')
                                   ->from('tab_cuti')
                                   ->where('nik',$val->nik_real)
                                   ->where('tanggal_mulai >=',$tgl_awal)
                                   ->where('tanggal_mulai <=',$tgl_resign)
                                   ->where('cuti_khusus','Tidak')
                                   ->get();

            $jml_cuti = 0;
            if ($cuti_query<>false) {
              foreach ($cuti_query->result() as $row) {
                $jml_cuti += $row->lama_cuti;
              }
            }

            $izin_query = $this->db->select('*')
                                 ->from('tab_izin')
                                 ->where('nik',$val->nik_real)
                                 ->where('tanggal_mulai >=',$tgl_awal)
                                 ->where('tanggal_mulai <=',$tgl_resign)
                                 ->where('id_potong',1)
                                 ->get();

            $jml_izin = 0;
            if ($izin_query<>false) {
              foreach ($izin_query->result() as $row) {
                $jml_izin += $row->lama;
              }
            }

            $libur = $jml_absen + $jml_cuti + $jml_izin;
            // echo $jml_absen."<br>";
            if ($val->status_kerja=="Kontrak 1"&&$lama==12) {
              if ($dp_new>0) {
                $cuti_new = 12 + $dp_new;
              } else {
                $cuti_new = 12;
              }
            } else if ($val->status_kerja=="Kontrak 2"&&$lama==12) {
              if ($dp_new>0) {
                $cuti_new += 12 + $dp_new;
              } else {
                $cuti_new += 12;
              }
            }
            // echo "SISA CUTI ".$cuti_new."<br>";

            $jml_hari_real2 = intval(date('d', strtotime($tgl_resign)));
            $nilai_libur = $cuti_new - ($cuti_new + ($jatah_libur - $libur));
            // echo $nilai_libur."<br>";

            $nilai_saldo = $gaji_harian * ($cuti_new + ($jatah_libur - $libur));
            $nilai_masuk = $gaji_harian * ($jml_hari_real2 - abs(($jatah_libur - $libur + $nilai_libur)));
            if (($jml_hari_real2 - abs(($jatah_libur - $libur + $nilai_libur)))<$jml_hari_real) {
              $nilai_masuk = $nilai_masuk;
            } else {
              $nilai_masuk = $gaji_pokok+$tunjangan_jabatan;
            }
            if ($val->approval_gaji==2) {
              $nilai_masuk = 0;
              $jml_jht = $jml_jht - $val->bea_jht;
              $jml_jpk = $jml_jpk - $val->bea_jpk;
            }
            // echo "ABSENSI ".$nilai_masuk."<br>";
            // echo "CUTI ".$nilai_saldo."<br>";

            /*==================================================*/

            if ($val->jml_pph==NULL) {
              $val->jml_pph = 0;
            }

            // echo "JHT ".$jml_jht."<br>";
            // echo "JPK ".$jml_jpk."<br>";
            $jml_diterima = $nilai_masuk + $nilai_saldo - $jml_jht - $jml_jpk;

            if ($jml_diterima>0) {
              $jml_diterima = $jml_diterima;
            } else {
              $jml_diterima = 0;
            }

            $jml_minus = 0;
            $jml_plus = 0;
            if ($nilai_saldo<0) {
              $jml_minus = $nilai_saldo;
            } else {
              $jml_plus = $nilai_saldo;
            }
            // echo "GAJI DITERIMA ".$jml_diterima."<br>";

        $data = array (
          'nik'                 => $val->nik_real,
          'gaji_bpjs'           => $val->gaji_bpjs_real,
          'gaji_karyawan'       => $gaji_pokok,
          'tunjangan_jabatan'   => $tunjangan_jabatan,
          'gaji_ekstra'         => $jml_ekstra,
          'potongan_cuti'       => $jml_minus,
          'tambahan_cuti'       => $jml_plus,
          'pinjaman'            => $jml_pinjam,
          'pph21'               => $val->jml_pph,
          'bea_jht'             => $jml_jht,
          'bea_jpk'             => $jml_jpk,
          'gaji_diterima'       => $jml_diterima,
          'tanggal_gaji'        => $tgl,
          'approval'            => 0,
          'keterangan'          => "Auto Generate",
          'entry_user'          => $this->session->userdata('username'),
          'entry_date'          => date('Y-m-d H:i:s')
        );
        $this->db->where('nik', $data['nik']);
        $this->db->where('month(tanggal_gaji)', date('m', strtotime($tgl)));
        $this->db->delete('tab_gaji_karyawan_resign');
        //var_dump($data);
        $this->db->insert('tab_gaji_karyawan_resign', $data);
      }
    }

    /*$response['status'] = '200';
    echo json_encode($response);*/
  }

    public function update_dp_cuti($bln_param,$thn_param){
      $this->load->model('model_dp');
      error_reporting(0);
      $tahun = $thn_param;
      $bulan = $bln_param;
      $data = $this->model_dp->detail_rekap2($bln_param,$thn_param);
      //print_r($this->db->last_query());
        $no=1;
        foreach ($data as $tampil) {
                  $new_bln = date('Y-'.$tampil->bln.'-d');
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

                  $saldo_bln_lalu=$this->db->where('nik',$tampil->nik)
                               ->where("bulan",$bln_fix2)
                               ->where("tahun",$thn_fix2)
                               ->select("*")
                               ->get('tab_master_dp')->row();
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

                  $data_new = array(
                    'saldo_dp' => $dp_bln_sekarang,
                    'saldo_cuti' => $cuti_bln_sekarang,
                  );

                  $this->db->where('nik',$tampil->nik);
                  $this->db->where('bulan',$bln_param);
                  $this->db->where('tahun',$thn_param);
                  $this->db->update('tab_master_dp',$data_new);

                  $no++;

          //   }//END if
          // }//END if
          
        }//END foreach
    }//END function update_dp_cuti
}