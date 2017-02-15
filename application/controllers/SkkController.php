<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class SkkController extends CI_Controller{
    //put your code here
     public function __construct()
    {
        parent::__construct();
        $this->load->library('mpdf');
		$this->load->model('skk');
    } 
    
   function index(){
       $data['data']=$this->skk->index();
      	$this->table->set_heading(array('<input type=checkbox name=cekall id=cekall onclick="return checkedAll(form_data);">','NO','Nama','Tanggal Masuk','Tanggal Resign','Jabatan','Department','PLANT','Resign','BPJS'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
	        			'thead_open'=>'<thead>',
        				'thead_close'=> '</thead>',
        				'tbody_open'=> '<tbody>',
        				'tbody_close'=> '</tbody>',
        		);
        $this->table->set_template($tmp);
		//$data['halaman']=$this->load->view('biaya/index',$data,true);
		$data['halaman']=$this->load->view('skkView/index',$data,true);
		$this->load->view('beranda',$data);
    }  
   function lihatskk(){
       $data['data']=$this->skk->lihatSkk();
      	$this->table->set_heading(array('<input type=checkbox name=cekall id=cekall onclick="return checkedAll(form_data);">','NO','Nama','Peringatan','Tanggal','Keterangan','Cetak'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
	        			'thead_open'=>'<thead>',
        				'thead_close'=> '</thead>',
        				'tbody_open'=> '<tbody>',
        				'tbody_close'=> '</tbody>',
        		);
        $this->table->set_template($tmp);
		//$data['halaman']=$this->load->view('biaya/index',$data,true);
		$data['halaman']=$this->load->view('skkView/lihatskk',$data,true);
		$this->load->view('beranda',$data);
    } 
	
    function skkKaryawan($nik){
		   if($_POST==NULL){
            $this->load->model('skk');
            $data['hasil'] = $this->skk->filterdata($nik);
            $data['halaman'] = $this->load->view('skkView/create',$data,true);
			$this->load->view('beranda',$data);
        }
        else{
            $this->load->model('skk');
            $this->skk->skkKaryawan();
            redirect('SkkController/index');
        }
    }
	function skkbKaryawan($nik){
		   if($_POST==NULL){
            $this->load->model('skk');
            $data['hasil'] = $this->skk->filterdata($nik);
            $data['halaman'] = $this->load->view('skkView/createb',$data,true);
			$this->load->view('beranda',$data);
        }
        else{
            $this->load->model('skk');
            $this->skk->skkbKaryawan();
            redirect('SkkController/index');
        }
    }
	function cetakskk($nik){
        $data['data'] = $this->skk->filterdata($nik);
		$html=$this->load->view('skkView/cetak',$data,true);
		$this->mpdf=new mPDF('utf-8', 'A4', 12, 'Times','5','5','5','5');
		  //$this->mpdf->setFooter('{PAGENO}');
		$this->mpdf->WriteHTML($html);
		$name='skk'.time().'.pdf';
		$this->mpdf->Output();
		exit();        
    }
	function cetakskkb($nik){
        $data['data'] = $this->skk->filterdata($nik);
		$html=$this->load->view('skkView/cetakb',$data,true);
		$this->mpdf=new mPDF('utf-8', 'A4', 12, 'Times','5','5','5','5');
		  //$this->mpdf->setFooter('{PAGENO}');
		$this->mpdf->WriteHTML($html);
		$name='skk'.time().'.pdf';
		$this->mpdf->Output();
		exit();        
    }
}