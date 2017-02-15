<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MemoController extends CI_Controller{
    //put your code here
     public function __construct()
    {
        parent::__construct();
        $this->load->library('mpdf');
		$this->load->model('memo');
    } 

    public function bpjs()
    {
      $data['cabang']=$this->db->get('tab_cabang')->result();
      $data['halaman']=$this->load->view('laporan/rekap_bpjs_page',$data,true);
     $this->load->view('beranda',$data);
    }
    
        
   function index(){
		if($_POST==NULL){
            $this->load->model('memo');
        $data['hasil'] = $this->memo->lihatmemo();
        $data['halaman']=$this->load->view('memoView/index',$data,true);
		$this->load->view('beranda',$data);
        }
        else{
            $this->load->model('memo');
            $this->memo->memointernal();
            redirect('MemoController/index');
        }
    }  
   function lihatmemo(){
       $data['data']=$this->memo->lihatmemo();
      	$this->table->set_heading(array('<input type=checkbox name=cekall id=cekall onclick="return checkedAll(form_data);">','NO','Nama','Peringatan','Tanggal','Keterangan','Cetak'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
	        			'thead_open'=>'<thead>',
        				'thead_close'=> '</thead>',
        				'tbody_open'=> '<tbody>',
        				'tbody_close'=> '</tbody>',
        		);
        $this->table->set_template($tmp);
		//$data['halaman']=$this->load->view('biaya/index',$data,true);
		$data['halaman']=$this->load->view('memoView/lihatmemo',$data,true);
		$this->load->view('beranda',$data);
    } 
	
    function memomemo($nik){
		   if($_POST==NULL){
            $this->load->model('memo');
            $data['hasil'] = $this->memo->filterdata($nik);
            $data['halaman'] = $this->load->view('memoView/create',$data,true);
			$this->load->view('beranda',$data);
        }
        else{
            $this->load->model('memo');
            $this->memo->memomemo();
            redirect('MemoController/index');
        }
    }
	function memobmemo($nik){
		   if($_POST==NULL){
            $this->load->model('memo');
            $data['hasil'] = $this->memo->filterdata($nik);
            $data['halaman'] = $this->load->view('memoView/createb',$data,true);
			$this->load->view('beranda',$data);
        }
        else{
            $this->load->model('memo');
            $this->memo->memobmemo();
            redirect('MemoController/index');
        }
    }
	function cetakmemo($nik){
        $data['data'] = $this->memo->filterdata($nik);
		$html=$this->load->view('memoView/cetak',$data,true);
		$this->mpdf=new mPDF('utf-8', 'A4', 12, 'Times','5','5','5','5');
		  //$this->mpdf->setFooter('{PAGENO}');
		$this->mpdf->WriteHTML($html);
		$name='memo'.time().'.pdf';
		$this->mpdf->Output();
		exit();        
    }
	function cetakmemob($nik){
        $data['data'] = $this->memo->filterdata($nik);
		$html=$this->load->view('memoView/cetakb',$data,true);
		$this->mpdf=new mPDF('utf-8', 'A4', 12, 'Times','5','5','5','5');
		  //$this->mpdf->setFooter('{PAGENO}');
		$this->mpdf->WriteHTML($html);
		$name='memo'.time().'.pdf';
		$this->mpdf->Output();
		exit();        
    }
}