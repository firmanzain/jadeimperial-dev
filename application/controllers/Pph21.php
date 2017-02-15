<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pph21 extends CI_Controller {
	public function __construct(){
		parent::__construct();
    	$this->auth->restrict();
		$this->load->model('model_pph');
	}
	
	  public function index()
	  {
	    $data['data']=$this->model_pph->index();
	    $this->table->set_heading(array('NO','NIK','Nama KTP','Tanggal Resign','Gaji Pokok','Tarif Casual Tanpa Uang Makan','Tunjangan T3','Upah1','Hari Kerja '.date('01').'-'.date('15 M Y'),'Upah2','Hari Kerja '.date('16').'-'.date('t M Y'),'DP Cuti','Ekstra','BPJS Beban Perusahaan(JKK,JK,JPK)','Total Pendapatan '.$this->format->BulanIndo(date('m'))));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
        			'thead_open'=>'<thead>',
    				'thead_close'=> '</thead>',
    				'tbody_open'=> '<tbody>',
    				'tbody_close'=> '</tbody>',
    		);
        $this->table->set_template($tmp);
		$data['halaman']=$this->load->view('pph21/index',$data,true);
		$this->load->view('beranda',$data);
	  }

	  public function xs()
	  {
	    $data['data']=$this->model_pph->index();
	    
		$data['halaman']=$this->load->view('pph21/index',$data,true);
		$this->load->view('beranda',$data);
	  }
}