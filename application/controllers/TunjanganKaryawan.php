<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TunjanganKaryawan extends CI_Controller {
	public function __construct(){
		parent::__construct();
    	$this->auth->restrict();
		$this->load->model('model_tunjanganKaryawan');
	}
	
	  public function index()
	  {
        if ($this->input->post('tgl1',true)==NULL) {
          $tgl1 = date('Y-m-01');
          $tgl2 = date('Y-m-t');
        } else {
          $tgl1 = $this->input->post('tgl1',true);
          $tgl2 = $this->input->post('tgl2',true); 
        }
        $data['tgl1'] = $tgl1;
        $data['tgl2'] = $tgl2;
	      $data['data']=$this->model_tunjanganKaryawan->index($tgl1,$tgl2);
	      $this->table->set_heading(array('<input type=checkbox name=cekall id=cekall onclick="return checkedAll(form_data);">','NO','NIK','NAMA ','JABATAN','PLANT','TUNJANGAN','TARIF','TINDAKAN'));
	        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
	        			'thead_open'=>'<thead>',
        				'thead_close'=> '</thead>',
        				'tbody_open'=> '<tbody>',
        				'tbody_close'=> '</tbody>',
        		);
	        $this->table->set_template($tmp);
			$data['halaman']=$this->load->view('tunjangan-karyawan/index',$data,true);
			$this->load->view('beranda',$data);
	  }

	  public function create()
	  {
	      if ($this->input->post()) {
	      	$this->save();
	      } else {
	      	$data['tunjangan']=$this->db->get('tab_master_tunjangan')->result();
	      	$data['halaman']=$this->load->view('tunjangan-karyawan/create',$data,true);
	      	$this->load->view('beranda',$data);
	  	  }
	  }

	  public function save(){
	  	$data = array(
                  'tunjangan' => $this->input->post('tunjangan'),
                  'tarif' =>$this->input->post('tarif'),
                  'nik' =>$this->input->post('nik'),
				  'entry_user' =>$this->session->userdata('username')
                );
	    $this->model_tunjanganKaryawan->add($data);
	    $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Disimpan</div>");
	    redirect('TunjanganKaryawan');
	  }

	public function edit($id)
	  {
	     if ($this->input->post()) {
	     	$this->update();
	     }else{
		     $data['data']=$this->model_tunjanganKaryawan->find($id);
		     if ($data==true) {
	      		$data['tunjangan']=$this->db->get('tab_master_tunjangan')->result();
		     	$data['halaman']=$this->load->view('tunjangan-karyawan/update',$data,true);
		     	$this->load->view('beranda',$data);
		     }else{
		     	show_404();
		     }
		 }
	  }

  	public function update(){
	  	$id=$this->input->post('id');
	  	$data = array(
                  'tunjangan' => $this->input->post('tunjangan'),
                  'tarif' =>str_replace('.', '', $this->input->post('tarif')),
                  'nik' =>$this->input->post('nik'),
				  'entry_user' =>$this->session->userdata('username')
                );
	    $this->model_tunjanganKaryawan->update($id,$data);
	    $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Disimpan</div>");
	    redirect('TunjanganKaryawan');
	}
	public function hapus(){
		if(!empty($_POST['cb_data'])){
			$jml=count($_POST['cb_data']);
			for($i=0;$i<$jml;$i++){
				$id=$_POST['cb_data'][$i];
				$this->model_tunjanganKaryawan->delete($id);
			}
	     $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Dihapus</div>");
		}
		redirect('TunjanganKaryawan','refresh');
	}

	public function copy_nama()
	{
		$nama = $this->input->post('nama');

		$this->db->select('*');
		$this->db->from('tab_karyawan');
		$this->db->where('nama_ktp', $nama);
		$query = $this->db->get();
		foreach ($query->result() as $val) {
			$response['nik'] = $val->nik;
		}
		echo json_encode($response);
	}
}