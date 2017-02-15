<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class BpjsController extends CI_Controller {
	public function __construct(){
		parent::__construct();
    	$this->auth->restrict();
		$this->load->model('model_bpjs');
	}
	
	  public function index()
	  {
	    $data['data']=$this->model_bpjs->index();
	    // $this->table->add_row(array('data'=>'NO','rowspan'=>'2'),array('data'=>'BPJS','rowspan'=>'2'),array('data'=>'JKK','rowspan'=>'2'),array('data'=>'JHT','colspan'=>'2'),'JKM',array('data'=>'JPK','colspan'=>'2'),array('data'=>'BPJS Pensiun','colspan'=>'2'),array('data'=>'TINDAKAN','rowspan'=>'2'));
	    // $this->table->add_row('PERUSAHAAN','KARYAWAN','','PERUSAHAAN','KARYAWAN','PERUSAHAAN','KARYAWAN');

	    $this->table->add_row('NO','BPJS','STATUS','TINDAKAN');

        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
        			'thead_open'=>'<thead>',
    				'thead_close'=> '</thead>',
    				'tbody_open'=> '<tbody>',
    				'tbody_close'=> '</tbody>',
    		);
        $this->table->set_template($tmp);
		$data['halaman']=$this->load->view('bpjs/index',$data,true);
		$this->load->view('beranda',$data);
	  }

	public function tambah()
	{
		if ($this->input->post()) {
			$this->create();
		} else {
		 	$data['halaman']=$this->load->view('bpjs/create',$data,true);
		 	$this->load->view('beranda',$data);
		}
	}

  	public function create(){
	  	$data = array(
                  'nama_bpjs' => $this->input->post('nama_bpjs'),
                  'tgl_bpjs' => $this->input->post('tgl_bpjs'),
				  'status_bpjs' =>$this->input->post('status_bpjs'),
				  'entry_user' =>$this->session->userdata('username')
                );
	    $create = $this->model_bpjs->create($data);
	    // DETAIL
		for ($i = 0; $i < $this->input->post('jml_detail'); $i++) { 
		  	$datadetail = array(
              'id_bpjs' 			=> $create,
              'nama_potongan' 		=> $this->input->post('nama_potongan')[$i],
              'tujuan_potongan' 	=> $this->input->post('tujuan_potongan')[$i],
              'nilai_potongan' 		=> $this->input->post('nilai_potongan')[$i],
              'status_potongan' 	=> $this->input->post('status_potongan')[$i],
			  'entry_date' 			=> date('Y-m-d H:i:s'),
			  'entry_user' 			=> $this->session->userdata('username')
            );
		    $this->db->insert('tab_master_bpjs_detail', $datadetail);
		}

	    $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Ditambahkan</div>");
	    redirect('bpjs');
	}

	public function edit($id)
	{
		if ($this->input->post()) {
			$this->update();
		} else {
		 $data['data'] = $this->model_bpjs->find($id);
		 $data['datadetail'] = $this->model_bpjs->findDetail($id);
		 if ($data==true) {
		 	$data['halaman']=$this->load->view('bpjs/update',$data,true);
		 	$this->load->view('beranda',$data);
		 } else {
		 	show_404();
		 }
		}
	}

	public function getDataDetail(){
		$query = $this->model_bpjs->findDetail($this->input->get('id'));
		$response['val'] = array();
		if (sizeof($query) > 0) {
			foreach ($query as $row) {
				$response['val'][] = array(
					'id_bpjs_detail'	=> $row->id_bpjs_detail,
					'nama_potongan'		=> $row->nama_potongan,
					'tujuan_potongan'	=> $row->tujuan_potongan,
					'nilai_potongan'	=> $row->nilai_potongan,
					'status_potongan'	=> $row->status_potongan,
				);
			}
		}
		echo json_encode($response);
	}

  	public function update(){
	  	$id = $this->input->post('id_bpjs');
	  	$data = array(
                  'nama_bpjs' => $this->input->post('nama_bpjs'),
                  'tgl_bpjs' => $this->input->post('tgl_bpjs'),
				  'status_bpjs' =>$this->input->post('status_bpjs'),
				  'entry_user' =>$this->session->userdata('username')
                );
	    $this->model_bpjs->update($id,$data);
	    // DETAIL
		$this->db->where('id_bpjs',$id);
		$this->db->delete('tab_master_bpjs_detail');
		for ($i = 0; $i < $this->input->post('jml_detail'); $i++) { 
		  	$datadetail = array(
              'id_bpjs' 			=> $id,
              'nama_potongan' 		=> $this->input->post('nama_potongan')[$i],
              'tujuan_potongan' 	=> $this->input->post('tujuan_potongan')[$i],
              'nilai_potongan' 		=> $this->input->post('nilai_potongan')[$i],
              'status_potongan' 	=> $this->input->post('status_potongan')[$i],
			  'entry_date' 			=> date('Y-m-d H:i:s'),
			  'entry_user' 			=> $this->session->userdata('username')
            );
		    $this->db->insert('tab_master_bpjs_detail', $datadetail);
		}

	    $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Diupdate</div>");
	    redirect('bpjs');
	}
}