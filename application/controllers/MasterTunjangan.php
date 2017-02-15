<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MasterTunjangan extends CI_Controller {
	public function __construct(){
		parent::__construct();
    	$this->auth->restrict();
		$this->load->model('model_masterTunjangan');
	}
	
	  public function index()
	  {
	      $data['data']=$this->model_masterTunjangan->index();
	      $this->table->set_heading(array('<input type=checkbox name=cekall id=cekall onclick="return checkedAll(form_data);">','NO','TUNJANGAN','STATUS','BULAN AMBIL','STATUS','TANGGAL INPUT','TINDAKAN'));
	        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
	        			'thead_open'=>'<thead>',
        				'thead_close'=> '</thead>',
        				'tbody_open'=> '<tbody>',
        				'tbody_close'=> '</tbody>',
        		);
	        $this->table->set_template($tmp);
			$data['halaman']=$this->load->view('master-tunjangan/index',$data,true);
			$this->load->view('beranda',$data);
	  }

	  public function create()
	  {
	      if ($this->input->post()) {
	      	$this->save();
	      } else {
	      	$data['halaman']=$this->load->view('master-tunjangan/create','',true);
	      	$this->load->view('beranda',$data);
	  	  }
	  }

	  public function save(){
	  	$data = array(
                  'nama_tunjangan' => $this->input->post('tunjangan'),
                  'status' =>$this->input->post('status'),
                  'status_tunjangan' =>$this->input->post('status_tunjangan'),
				  'bulan_ambil' =>$this->input->post('tanggal'),
				  'entry_user' =>$this->session->userdata('nama')
                );
	    $this->model_masterTunjangan->add($data);
	    $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Disimpan</div>");
	    redirect('MasterTunjangan');
	  }

	public function edit($id)
	  {
	     if ($this->input->post()) {
	     	$this->update();
	     }else{
		     $data['data']=$this->model_masterTunjangan->find($id);
		     if ($data==true) {
		     	$data['halaman']=$this->load->view('master-tunjangan/update',$data,true);
		     	$this->load->view('beranda',$data);
		     }else{
		     	show_404();
		     }
		 }
	  }

  	public function update(){
	  	$id=$this->input->post('id');
	  	$data = array(
                  'nama_tunjangan' => $this->input->post('tunjangan'),
                  'status' =>$this->input->post('status'),
                  'status_tunjangan' =>$this->input->post('status_tunjangan'),
				  'bulan_ambil' =>$this->input->post('tanggal'),
				  'entry_user' =>$this->session->userdata('nama')
                );
	    $this->model_masterTunjangan->update($id,$data);
	    $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Disimpan</div>");
	    redirect('MasterTunjangan');
	}
	
	public function hapus(){
		if(!empty($_POST['cb_data'])){
			$jml=count($_POST['cb_data']);
			for($i=0;$i<$jml;$i++){
				$id=$_POST['cb_data'][$i];
				$this->model_masterTunjangan->delete($id);
			}
	     $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Dihapus</div>");
		}
		redirect('MasterTunjangan','refresh');
	}
}