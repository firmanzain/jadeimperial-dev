<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CutiKhususController extends CI_Controller {
	public function __construct(){
		parent::__construct();
    	$this->auth->restrict();
		$this->load->model('model_cutiKhusus');
		$this->load->library('PHPExcel');
		$this->load->library('PHPExcel/IOFactory');
	}
	
	  public function index()
	  {
	      $data['data']=$this->model_cutiKhusus->index();
	      $this->table->set_heading(array(/*'<input type=checkbox name=cekall id=cekall onclick="return checkedAll(form_data);">',*/'No','Keterangan','Maksimal Lama','Tanggal Input','Status','Tindakan'));
	      $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
	        			'thead_open'=>'<thead>',
        				'thead_close'=> '</thead>',
        				'tbody_open'=> '<tbody>',
        				'tbody_close'=> '</tbody>',
        		);
	        $this->table->set_template($tmp);
		$data['halaman']=$this->load->view('cuti-khusus/index',$data,true);
		$this->load->view('beranda',$data);
	  }

	  public function create()
	  {
	      if ($this->input->post()) {
	      	$this->save();
	      } else {
	      	$data['halaman']=$this->load->view('cuti-khusus/create','',true);
	      	$this->load->view('beranda',$data);
	  	  }
	  }

	  public function save(){
	  	$data = array(
                  'keterangan' => $this->input->post('keterangan'),
                  'maximal_lama' =>$this->input->post('lama'),
                  'status'=>$this->input->post('status'),
				  'entry_date' => date('Y-m-d H:i:s'),
                  'entry_user' => $this->session->userdata('nama')
                );
	    $this->model_cutiKhusus->add($data);
	    $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Disimpan</div>");
	    redirect('cuti-khusus');
	  }


	public function import_data()
	  {
	      if ($this->input->post()) {
	      	$this->go_import();
	      } else {
	      	$this->load->view('import/import_cutikhusus');
	  	  }
	  }

	  public function go_import()
    {
    	$config['upload_path'] = './temp_upload/';
  		$config['allowed_types'] = 'xls';
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
      	for ($i = 2; $i <= $data['numRows']; $i++) {
                   if ($data['cells'][$i][1] == '')
                       break;
                   $dataexcel[$i - 1]['keterangan'] = $data['cells'][$i][1];
                   $dataexcel[$i - 1]['lama'] = $data['cells'][$i][2];
              }
        $this->model_cutiKhusus->import_data($dataexcel);
		//    jika kosongkan data dicentang jalankan kode berikut
	   	$file = $upload_data['file_name'];
        $path = './temp_upload/'.$file;
        unlink($path);
	   	echo "<script>window.opener.location.reload();window.close()</script>";
    	}
    }

	public function edit($id)
	  {
	     if ($this->input->post()) {
	     	$this->update();
	     }else{
		     $data['data']=$this->model_cutiKhusus->find($id);
		     if ($data==true) {
		     	$data['halaman']=$this->load->view('cuti-khusus/update',$data,true);
		     	$this->load->view('beranda',$data);
		     }else{
		     	show_404();
		     }
		 }
	  }

  	public function update(){
	  	$id=$this->input->post('id');
	  	$data = array(
                  'keterangan' => $this->input->post('keterangan'),
                  'maximal_lama' =>$this->input->post('lama'),
                  'status'=>$this->input->post('status'),
                  'entry_date' => date('Y-m-d H:i:s'),
                  'entry_user' => $this->session->userdata('nama')
                );
	    $this->model_cutiKhusus->update($id,$data);
	    $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Disimpan</div>");
	    redirect('cuti-khusus');
	}
	public function hapus(){
		if(!empty($_POST['cb_data'])){
			$jml=count($_POST['cb_data']);
			for($i=0;$i<$jml;$i++){
				$id=$_POST['cb_data'][$i];
				$this->model_cutiKhusus->delete($id);
			}
	     $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Dihapus</div>");
		}
		redirect('cuti-khusus','refresh');
	}
}