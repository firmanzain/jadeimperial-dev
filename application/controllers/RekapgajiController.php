<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class RekapgajiController extends CI_Controller{
    //put your code here
     public function __construct()
    {
        parent::__construct();
        $this->load->library('mpdf');
		$this->load->model('rekapgaji');
    } 
    
   function index(){
		if($_POST==NULL){
         $this->load->model('rekapgaji');
        $data['hasil'] = $this->rekapgaji->lihatrekapgaji();
        $data['halaman']=$this->load->view('rekapgajiView/index',$data,true);
		$this->load->view('beranda',$data);
        }
        else{
           $this->load->model('rekapgaji');
        $data['hasil'] = $this->rekapgaji->lihatrekapgaji();
        $data['halaman']=$this->load->view('rekapgajiView/detail',$data,true);
		$this->load->view('beranda',$data);
        }
    }  
   function lihatrekapgaji(){
       $data['data']=$this->rekapgaji->lihatrekapgaji();
      	$this->table->set_heading(array('<input type=checkbox name=cekall id=cekall onclick="return checkedAll(form_data);">','NO','Nama','Peringatan','Tanggal','Keterangan','Cetak'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
	        			'thead_open'=>'<thead>',
        				'thead_close'=> '</thead>',
        				'tbody_open'=> '<tbody>',
        				'tbody_close'=> '</tbody>',
        		);
        $this->table->set_template($tmp);
		//$data['halaman']=$this->load->view('biaya/index',$data,true);
		$data['halaman']=$this->load->view('rekapgajiView/lihatrekapgaji',$data,true);
		$this->load->view('beranda',$data);
    } 
	
    function rekapgajirekapgaji($nik){
		   if($_POST==NULL){
            $this->load->model('rekapgaji');
            $data['hasil'] = $this->rekapgaji->filterdata($nik);
            $data['halaman'] = $this->load->view('rekapgajiView/create',$data,true);
			$this->load->view('beranda',$data);
        }
        else{
            $this->load->model('rekapgaji');
            $this->rekapgaji->rekapgajirekapgaji();
            redirect('RekapgajiController/index');
        }
    }
	function rekapgajibrekapgaji($nik){
		   if($_POST==NULL){
            $this->load->model('rekapgaji');
            $data['hasil'] = $this->rekapgaji->filterdata($nik);
            $data['halaman'] = $this->load->view('rekapgajiView/createb',$data,true);
			$this->load->view('beranda',$data);
        }
        else{
            $this->load->model('rekapgaji');
            $this->rekapgaji->rekapgajibrekapgaji();
            redirect('RekapgajiController/index');
        }
    }
	function cetakrekapgaji($nik){
        $data['data'] = $this->rekapgaji->filterdata($nik);
		$html=$this->load->view('rekapgajiView/cetak',$data,true);
		$this->mpdf=new mPDF('utf-8', 'A4', 12, 'Times','5','5','5','5');
		  //$this->mpdf->setFooter('{PAGENO}');
		$this->mpdf->WriteHTML($html);
		$name='rekapgaji'.time().'.pdf';
		$this->mpdf->Output();
		exit();        
    }
	function cetakrekapgajib($nik){
        $data['data'] = $this->rekapgaji->filterdata($nik);
		$html=$this->load->view('rekapgajiView/cetakb',$data,true);
		$this->mpdf=new mPDF('utf-8', 'A4', 12, 'Times','5','5','5','5');
		  //$this->mpdf->setFooter('{PAGENO}');
		$this->mpdf->WriteHTML($html);
		$name='rekapgaji'.time().'.pdf';
		$this->mpdf->Output();
		exit();        
    }
}