<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class KomisiController extends CI_Controller{
    //put your code here
     public function __construct()
    {
        parent::__construct();
    $this->load->library('PHPExcel');
    $this->load->library('PHPExcel/IOFactory');
    $this->load->library('mpdf');
		$this->load->model('komisi');
        $this->auth->restrict();
    } 
    
   function index(){
    if ($this->input->post('tgl1',true)==NULL) {
      $tgl1 = date('Y-m-01');
      $tgl2 = date('Y-m-t');
    } else {
      $tgl1 = $this->input->post('tgl1',true);
      $tgl2 = $this->input->post('tgl2',true); 
    }
    $data['tgl1'] = $tgl1;
    $data['tgl2'] = $tgl2;

		//$data['data']=$this->komisi->index($tgl1="",$tgl2="",$cb="");
    $data['data']=$this->komisi->index($tgl1,$tgl2,$cb="");
    //print_r($this->db->last_query());
      	$this->table->set_heading(array('<input type=checkbox name=cekall id=cekall onclick="return checkedAll(form_data);">','NO','NIK','Nama','Jabatan','PLANT','Omset','Komisi','Bulan Bagi'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
	        			'thead_open'=>'<thead>',
        				'thead_close'=> '</thead>',
        				'tbody_open'=> '<tbody>',
        				'tbody_close'=> '</tbody>',
        		);
        $this->table->set_template($tmp);
		$data['halaman']=$this->load->view('komisiView/index',$data,true);
		$this->load->view('beranda',$data);
    }

   function create(){
       if($this->input->post()){
    		$jml_nik=count($this->input->post('txt_nik'));
            for ($i=1; $i <= $jml_nik ; $i++) { 
              if ($this->input->post('cek_pph')[$i]!=null) {
                $pph = $this->input->post('cek_pph')[$i];
              } else {
                $pph = 0;
              }
                $data = array(
                  'nik' =>$this->input->post('txt_nik')[$i],
                  'komisi' =>str_replace('.','',$this->input->post('txt_hasil')[$i]),
                  'omset' =>str_replace('.','',$this->input->post('txt_omset')[$i]),
                  'includepph' =>$pph,
                  'bulan' => $this->input->post('bulan')[$i],
                  'entry_user' =>$this->session->userdata('username')
                );
                $this->komisi->save($data);
            }
            redirect('komisi');
       }else{
            $data['halaman']=$this->load->view('komisiView/create','',true);
	        $this->load->view('beranda',$data);
	   } 
    } 

  public function rekap_komisi()
  {
    $this->table->set_heading(array('NO','NIK','Nama','NAMA REKENING','NO REKENING','Jabatan','PLANT','Omset','Komisi','Bulan','Approved','Ket.','Tindakan'));
    $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
                'thead_open'=>'<thead>',
                'thead_close'=> '</thead>',
                'tbody_open'=> '<tbody>',
                'tbody_close'=> '</tbody>',
            );
    $this->table->set_template($tmp);
    
    if ($this->input->post('tgl1',true)==NULL) {
      $tgl1 = date('Y-m-01');
      $tgl2 = date('Y-m-t');
    } else {
      $tgl1 = $this->input->post('tgl1',true);
      $tgl2 = $this->input->post('tgl2',true); 
    }
    $data['tgl1'] = $tgl1;
    $data['tgl2'] = $tgl2;

    /*$tgl1 = $this->input->post('tanggal1');
    $tgl2 = $this->input->post('tanggal2');*/
    $cb = $this->input->post('cabang');
    if ($cb!=NULL) {
      $this->db->select('*');
      $this->db->from('tab_cabang');
      $this->db->where('id_cabang',$cb);
      $query_cabang = $this->db->get();
      foreach ($query_cabang->result() as $row) {
        $data['cabang'] = $row->cabang;
      }
    } else {
      $data['cabang'] = "";
    }

    $data['data']=$this->komisi->index($tgl1,$tgl2,$cb);
    //print_r($this->db->last_query());
    $data['halaman']=$this->load->view('laporan/rekap_komisi',$data,true);
    $this->load->view('beranda',$data);
  }
	function komisidetail(){
       $data['data']=$this->komisi->komisidetail();
      	$this->table->set_heading(array('<input type=checkbox name=cekall id=cekall onclick="return checkedAll(form_data);">','NO','Nama','Jabatan','PLANT','Point','Prorata','Nominal','Cetak'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
	        			'thead_open'=>'<thead>',
        				'thead_close'=> '</thead>',
        				'tbody_open'=> '<tbody>',
        				'tbody_close'=> '</tbody>',
        		);
        $this->table->set_template($tmp);
		//$data['halaman']=$this->load->view('biaya/index',$data,true);
		$data['halaman']=$this->load->view('komisiView/komisidetail',$data,true);
		$this->load->view('beranda',$data);
    } 
	
    
	function cetakkomisi($nik){
    $data['data'] = $this->komisi->filterdata($nik);
		$html=$this->load->view('komisiView/cetak',$data,true);
		$this->mpdf=new mPDF('utf-8', 'A6', 12, 'Times','2','2','2','2');
		$this->mpdf->WriteHTML($html);
		$name='komisi'.time().'.pdf';
		$this->mpdf->Output();
		exit();        
    }

	function cetakData(){
		/*$tgl1=$this->input->post('tanggal1');
    $tgl2=$this->input->post('tanggal2');
    $cb=$this->input->post('cabang');
    $data['tgl1']=$this->input->post('tanggal1');
    $data['tgl2']=$this->input->post('tanggal2');
    $data['cabang']=$this->db->where('id_cabang',$cb)->get('tab_cabang')->row();
    $data['data']=$this->komisi->index($tgl1,$tgl2,$cb);*/
    if ($this->input->post('tanggal1',true)==NULL) {
      $tgl1 = date('Y-m-01');
      $tgl2 = date('Y-m-t');
    } else {
      $tgl1 = $this->input->post('tanggal1',true);
      $tgl2 = $this->input->post('tanggal2',true); 
    }
    $data['tgl1'] = $tgl1;
    $data['tgl2'] = $tgl2;

    /*$tgl1 = $this->input->post('tanggal1');
    $tgl2 = $this->input->post('tanggal2');*/
    $cb = $this->input->post('cabang');

    $data['data']=$this->komisi->index($tgl1,$tgl2,$cb);
    $this->table->set_heading(array('NO','NIK','Nama','NAMA REKENING','NO REKENING','Jabatan','PLANT','Omset','Komisi','Bulan','Approved','Ket.'));
    $tmp=array('table_open'=>'<table id="example-2" class="tabel" >',
                'thead_open'=>'<thead>',
                'thead_close'=> '</thead>',
                'tbody_open'=> '<tbody>',
                'tbody_close'=> '</tbody>',
            );
    $this->table->set_template($tmp);
    $aksi=$this->input->post('cetak');
    if($aksi=='cetak'){
      $html=$this->load->view('laporan/p_komisi',$data,true);
      $this->mpdf=new mPDF('utf-8', 'A4-L', 11, 'Times','5','5','5','5');
      $this->mpdf->WriteHTML($html);
      $name='komisi'.time().'.pdf';
      $this->mpdf->Output();
    }elseif ($aksi=='excel') {
      $tanggal=time();
      header("Content-type: application/x-msdownload");
      header("Content-Disposition: attachment; filename=DATA_KOMISIKARYAWAN_".$tanggal.".xls");
      header("Pragma: no-cache");
      header("Expires: 0");
      if($data==true){
        $no=1;
        foreach ($data['data'] as $tampil){
        if (is_null($tampil->approved)) {
            $mati="disabled";
            $status="Pending";
            $keterangan="---";
        } else {
            if ($tampil->approved=="Ya") {
                $mati="";
                $status=$tampil->approved;
                $keterangan=$tampil->keterangan;
            } else {
                $mati="disabled";
                $status=$tampil->approved;
                $keterangan=$tampil->keterangan;
            }
        }
        $this->table->add_row($no,$tampil->nik,$tampil->nama_ktp,$tampil->nama_rekening,$tampil->no_rekening,$tampil->jabatan,$tampil->cabang,$this->format->indo($tampil->omset),$this->format->indo($tampil->komisi),$this->format->BulanIndo(date('m',strtotime('-1 month',strtotime($tampil->bulan)))),$status,$keterangan,"<button type='button' onclick='cetak($tampil->nik)' class='btn btn-warning' $mati>Cetak</button>");
        $no++;
        }
        $tabel=$this->table->generate();
        echo $tabel;
        }else {
        echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
        }
    }
		exit();        
    }
	public function hapus(){
        if(!empty($_POST['cb_data'])){
            $jml=count($_POST['cb_data']);
            for($i=0;$i<$jml;$i++){
                $id_komisi=$_POST['cb_data'][$i];
                $this->db->where('id_komisi',$id_komisi)->delete('tab_komisi');
            }
         $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Dihapus</div>");
        }
        redirect('komisi','refresh');
    }
}