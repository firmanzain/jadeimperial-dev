<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class thrController extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->auth->restrict();
        $this->load->model('model_thr');
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');
    }
    
      public function index()
      {
        $data['data']=$this->model_thr->index();
        $this->table->set_heading(array('<input type=checkbox name=cekall id=cekall onclick="return checkedAll(form_data);">','NO','NIK','NAMA','JABATAN','PLANT','JENIS THR','THR','PPH','THR DITERIMA','JADWAL BAGI','APPROVEMENT','KETERANGAN','TINDAKAN'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
                        'thead_open'=>'<thead>',
                        'thead_close'=> '</thead>',
                        'tbody_open'=> '<tbody>',
                        'tbody_close'=> '</tbody>',
                );
        $this->table->set_template($tmp);
        $data['halaman']=$this->load->view('thr/index',$data,true);
        $this->load->view('beranda',$data);
      }

      public function rekap()
      {
        $tgl1=$this->input->post('tanggal1');
        $tgl2=$this->input->post('tanggal2');
        //$cabang=$this->input->post('cabang');
        //$data['cabang']=$this->db->get('tab_cabang')->result();
        $data['data'] = $this->model_thr->rekapitulasi($tgl1,$tgl2);
        //print_r($this->db->last_query());
        //$this->table->set_heading(array('NO','JADWAL BAGI','NIK','NAMA','JABATAN','DEPARTEMEN','PLANT','NAMA REK','NO REK','THR','PPH','THR DITERIMA','APPROVEMENT','KETERANGAN'));
        $this->table->set_heading(array('NO','CABANG','JUMLAH KARYAWAN','THR','PPH','THR DITERIMA','JADWAL BAGI','APPROVEMENT','KETERANGAN','TINDAKAN'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
                        'thead_open'=>'<thead>',
                        'thead_close'=> '</thead>',
                        'tbody_open'=> '<tbody>',
                        'tbody_close'=> '</tbody>',
                    );
        $this->table->set_template($tmp);
        $data['halaman']=$this->load->view('laporan/rekap_thr',$data,true);
        $this->load->view('beranda',$data);
      }
    
      public function detailrekap($id_cabang,$cabang)
      {
        $data['data']=$this->model_thr->index2($id_cabang);
        $data['cabang'] = $id_cabang;
        $this->table->set_heading(array('','NO','NIK','NAMA','JABATAN','PLANT','JENIS THR','THR','PPH','THR DITERIMA','JADWAL BAGI','APPROVEMENT','KETERANGAN','TINDAKAN'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
                        'thead_open'=>'<thead>',
                        'thead_close'=> '</thead>',
                        'tbody_open'=> '<tbody>',
                        'tbody_close'=> '</tbody>',
                );
        $this->table->set_template($tmp);
        $data['halaman']=$this->load->view('thr/index2',$data,true);
        $this->load->view('beranda',$data);
      }

       public function cetak($dt)
        {
          $data['data']=base64_decode($dt);
          $html=$this->load->view('thr/slip_thr',$data,true);
          $this->mpdf=new mPDF('utf-8', 'A6', 10, 'Times','5','5','5','5');
          $this->mpdf->WriteHTML($html);
          $name='HRD'.time().'.pdf';
          $this->mpdf->Output();
          exit(); 
        }

        public function create()
      {
          if ($this->input->post('simpan')) {
            $this->save();
          } else {
            $cb=$this->input->post('cabang');
            $jb=$this->input->post('jabatan');

            $data['data']=$this->model_thr->karyawan($cb,$jb);
            $data['cabang']=$this->db->get('tab_cabang')->result();
            $data['jabatan']=$this->db->get('tab_jabatan')->result();

            $data['halaman']=$this->load->view('thr/create',$data,true);
            $this->load->view('beranda',$data);
          }
      }

      public function save(){
        $jml_nik=count($this->input->post('nik'));
        for ($i=0; $i < $jml_nik; $i++) { 
            $data = array(
                  'nik' => $this->input->post('nik')[$i],
                  'tarif' =>str_replace('.', '', $this->input->post('tarif')[$i]),
                  'tanggal_ambil' =>$this->input->post('tanggal'),
                  'entry_user' =>$this->session->userdata('username')
                );
        $this->model_thr->add($data);
        }
        $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Disimpan</div>");
        redirect('ThrController');
      }

     public function hapus(){
        /*if(!empty($_POST['cb_data'])){
            $jml=count($_POST['cb_data']);
            for($i=0;$i<$jml;$i++){
                $id=$_POST['cb_data'][$i];
                $this->model_thr->delete($id);
            }
         $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Dihapus</div>");
        }*/
        for ($i=0; $i<sizeof($this->input->post('cb_data')); $i++) { 
          $this->db->where('id_thr', $this->input->post('cb_data')[$i]);
          $this->db->delete('tab_master_thr');
        }
        $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Dihapus</div>");
        redirect('ThrController');
    }

    public function importData()
    {
        if ($this->input->post()) {
          $this->go_import();
        } else {
          $this->load->view('import/import_thr');
        }
    }

    public function go_import(){
        $jns_thr = $this->input->post('jns_thr');
        $tgl_dibagi = $this->input->post('tanggal');
        $fileName = time().$_FILES['file']['name'];
        $config['upload_path'] = './temp_upload/'; //buat folder dengan nama assets di root folder
        $config['file_name'] = $fileName;
        $config['allowed_types'] = 'xls|xlsx|csv';
        $config['max_size'] = 10000;
         
        $this->load->library('upload');
        $this->upload->initialize($config);
         
        if(! $this->upload->do_upload('file') )
        $this->upload->display_errors();
             
        $media = $this->upload->data('file');
        $inputFileName = './temp_upload/'.$media['file_name'];
         
        try {
                $inputFileType = IOFactory::identify($inputFileName);
                $objReader = IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch(Exception $e) {
                die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
            }
 
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $hasil=0;$gagal=0; 
            for ($row = 2; $row <= $highestRow; $row++){                  //  Read a row of data into an array                 
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                NULL,
                                                TRUE,
                                                FALSE);
                   $cek=$this->db->where('nik',$rowData[0][0])
                                 ->where('pph_thr',0)
                                 ->where('YEAR(tanggal_ambil)',date('Y',strtotime($tgl_dibagi)))
                                 ->get('tab_master_thr')
                                 ->row();
                    $data=array(
                                    "jns_thr" => $jns_thr,
                                    "nik" => $rowData[0][0],
                                    "tarif" => $rowData[0][1],
                                    "pph_thr" => $rowData[0][2],
                                    "tanggal_ambil" => date('Y-m-d',strtotime($tgl_dibagi))
                                    );
                    if (count($cek)==1) {
                      $this->db->where('nik', $rowData[0][0])
                            ->update('tab_master_thr', $data);
                      $hasil++;
                    }else{
                      $this->db->insert('tab_master_thr', $data);
                      $hasil++;
                    }
                    var_dump($data);
                                
            }
            delete_files($media['file_path']);
            //$miss_data=implode('<br>', $data_gagal);
            $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Jumlah Data Tersimpan : $hasil<br>Data Gagal Tersimpan : $gagal </div>");
        echo "<script>window.opener.location.reload();window.close()</script>";
    }

    function cetakData(){
      $tgl1=$this->input->post('tanggal1');
      $tgl2=$this->input->post('tanggal2');
      $cb=$this->input->post('cabang');
      $data['tgl1']=$this->input->post('tanggal1');
      $data['tgl2']=$this->input->post('tanggal2');
      $data['cabang']=$this->db->where('id_cabang',$cb)->get('tab_cabang')->row();
      $data['data']=$this->model_thr->rekapitulasi($tgl1,$tgl2,$cb);
      $this->table->set_heading(array('NO','JADWAL BAGI','NIK','NAMA','JABATAN','DEPARTEMEN','PLANT','NAMA REK','NO REK','THR','PPH','THR DITERIMA','APPROVEMENT','KETERANGAN'));
        $tmp=array('table_open'=>'<table id="example-2" class="tabel" >',
                'thead_open'=>'<thead>',
                'thead_close'=> '</thead>',
                'tbody_open'=> '<tbody>',
                'tbody_close'=> '</tbody>',
              );
      $this->table->set_template($tmp);
      $aksi=$this->input->post('btn_aksi');
      if ($aksi=='cetak') {
        $html=$this->load->view('laporan/p_thr',$data,true);
        $this->mpdf=new mPDF('utf-8', 'A4-L', 11, 'Times','5','5','5','5');
        $this->mpdf->WriteHTML($html);
        $name='komisi'.time().'.pdf';
        $this->mpdf->Output();
      }elseif ($aksi=='excel') {
        $tanggal=time();
        header("Content-type: application/x-msdownload");
        header("Content-Disposition: attachment; filename=THR_KARYAWAN_".$tanggal.".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        $no=1;$t_thr=0;$t_terima=0;$t_pph=0;
        foreach ($data['data'] as $tampil){
        $pure_thr=$tampil->tarif-$tampil->pph_thr;
        $t_thr += $tampil->tarif;
        $t_pph += $tampil->pph_thr;
        $t_terima += $pure_thr;
        $this->table->add_row($no,$this->format->TanggalIndo($tampil->tanggal_ambil),$tampil->nik,$tampil->nama_ktp,$tampil->jabatan,$tampil->department,$tampil->cabang,$tampil->nama_rekening,$tampil->no_rekening,$this->format->indo($tampil->tarif),$this->format->indo($tampil->pph_thr),$this->format->indo($pure_thr),$tampil->approved,$tampil->keterangan);
        $no++;
        }
        $this->table->add_row('',array('data'=>'Total','colspan'=>8),$this->format->indo($t_thr),$this->format->indo($t_pph),$this->format->indo($t_terima),'','');
        $tabel=$this->table->generate();
        echo $tabel;
      }
      exit();        
    }
}