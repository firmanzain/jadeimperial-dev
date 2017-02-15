<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class OmsetStandartController extends CI_Controller {
	public function __construct(){
		parent::__construct();
    	$this->auth->restrict();
		$this->load->model('model_omset');
	}
	
	public function index(){
	    $data['data'] = $this->model_omset->index();
        $this->table->set_heading(array('NO', 'CABANG', 'OMSET STANDART', 'TINDAKAN'));
        $tmp=array('table_open'		=> '<table id="example-2" class="table table-hover table-striped table-bordered" >',
                   'thead_open'		=> '<thead>',
                   'thead_close'	=> '</thead>',
                   'tbody_open'		=> '<tbody>',
                   'tbody_close'	=> '</tbody>',
        );
        $this->table->set_template($tmp);
		$data['halaman'] = $this->load->view('omsetstandart/index', $data, true);
		$this->load->view('beranda',$data);
	}

	public function editData(){
		$id 		= $this->input->post('id', true);
		$nominal 	= str_replace(array('.'), array(''), $this->input->post('nominal_omset', true));
		$where['data'][] = array(
			'column' => 'id_omset',
			'param'	 => $id
		);
		$data = array(
			'nominal_omset' => $nominal,
            'entry_user'    => $this->session->userdata('username'),
            'entry_date'    => date('Y-m-d H:i:s'),
		);
		$query = $this->model_omset->update($where, $data);
		if($query->status) {
			$response['status'] = '200';
		} else {
			$response['status'] = '204';
		}
		echo json_encode($response);
	}

}