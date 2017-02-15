<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AsuransiController extends CI_Controller {
	public function __construct(){
		parent::__construct();
    	$this->auth->restrict();
		$this->load->model('model_asuransi');
	}
	
	  public function index()
	  {
        $data['data']=$this->model_asuransi->index();
      	$this->table->set_heading(array('<input type=checkbox name=cekall id=cekall onclick="return checkedAll(form_data);">','NO','ASURANSI','VENDOR','STATUS','TANGGAL INPUT','TINDAKAN'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
	        			'thead_open'=>'<thead>',
        				'thead_close'=> '</thead>',
        				'tbody_open'=> '<tbody>',
        				'tbody_close'=> '</tbody>',
        		);
        $this->table->set_template($tmp);
		$data['halaman']=$this->load->view('asuransi/index',$data,true);
		$this->load->view('beranda',$data);
	  }

	  public function create()
	  {
	      if ($this->input->post()) {
	      	$this->save();
	      } else {
	      	$data['halaman']=$this->load->view('asuransi/create','',true);
	      	$this->load->view('beranda',$data);
	  	  }
	  }

	  public function save(){
	  	$data = array(
                  'asuransi' => $this->input->post('asuransi'),
				  'vendor' =>$this->input->post('vendor'),
                  'status'=>$this->input->post('status'),	
				  'entry_date' => date('Y-m-d H:i:s'),
                  'entry_user' => $this->session->userdata('nama')
                );
	    $this->model_asuransi->add($data);
	    $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Disimpan</div>");
	    redirect('AsuransiController');
	  }

	public function edit($id)
	  {
	     if ($this->input->post()) {
	     	$this->update();
	     }else{
		     $data['data']=$this->model_asuransi->find($id);
		     if ($data==true) {
		     	$data['halaman']=$this->load->view('asuransi/update',$data,true);
		     	$this->load->view('beranda',$data);
		     }else{
		     	show_404();
		     }
		 }
	  }

  	public function update(){
	  	$id=$this->input->post('id');
	  	$data = array(
                  'asuransi' => $this->input->post('asuransi'),
				  'vendor' =>$this->input->post('vendor'),
                  'status'=>$this->input->post('status'),				  
				  'entry_date' => date('Y-m-d H:i:s'),
                  'entry_user' => $this->session->userdata('nama')
                );
	    $this->model_asuransi->update($id,$data);
	    $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Disimpan</div>");
	    redirect('AsuransiController');
	}
	public function hapus(){
		if(!empty($_POST['cb_data'])){
			$jml=count($_POST['cb_data']);
			for($i=0;$i<$jml;$i++){
				$id=$_POST['cb_data'][$i];
				$this->model_asuransi->delete($id);
			}
	     $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Dihapus</div>");
		}
		redirect('AsuransiController','refresh');
	}
}