<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class PengangkatanController extends CI_Controller{
    //put your code here
     public function __construct()
    {
        parent::__construct();
        //$this->load->library('mpdf');
		    $this->load->model('pengangkatan');
        $this->auth->restrict();
    } 
    
   function index(){
      if ($this->input->post('tgl1',true)==NULL) {
        $tgl1 = date('Y-m-01');
        $tgl2 = date('Y-m-t');
      } else {
        $tgl1 = $this->input->post('tgl1',true);
        $tgl2 = $this->input->post('tgl2',true); 
      }
      $data['tgl1'] = $tgl1;
      $data['tgl2'] = $tgl2;
       $data['data']=$this->pengangkatan->index($tgl1,$tgl2);
      	$this->table->set_heading(array('<input type=checkbox name=cekall id=cekall onclick="return checkedAll(form_data);">','NO','NIK','Nama','Status Lama','Status Baru','Jabatan Lama','Jabatan Baru','Departmen Lama','Departmen Baru','PLANT','Tanggal Berlaku','Cetak'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
	        			'thead_open'=>'<thead>',
        				'thead_close'=> '</thead>',
        				'tbody_open'=> '<tbody>',
        				'tbody_close'=> '</tbody>',
        		);
        $this->table->set_template($tmp);
		    $data['halaman']=$this->load->view('pengangkatanView/index',$data,true);
		    $this->load->view('beranda',$data);
    } 
	
    public function create()
      {
          if ($this->input->post()) {
              $hasil=$this->pengangkatan->pengangkatankaryawan();
              echo $hasil;
          } else {
            $data['hrd']=$this->db->select('nik,nama_ktp')->get('tab_karyawan')->result();
            $data['departmen']=$this->db->get('tab_department')->result();
            $data['jabatan']=$this->db->get('tab_jabatan')->result();
            $data['halaman']=$this->load->view('pengangkatanView/create',$data,true);
            $this->load->view('beranda',$data);
          }
      }

    
	  function cetakpengangkatan($id){
        $data['data'] = $this->pengangkatan->filterdatapengangkatan($id);
    		$data['angkat']=$this->load->view('pengangkatanView/cetak',$data,true);
        $data['halaman']=$this->load->view('pengangkatanView/p_pangkat',$data,true);
        $this->load->view('beranda',$data);
    }
    public function hapus(){
    if(!empty($_POST['cb_data'])){
      $jml=count($_POST['cb_data']);
      for($i=0;$i<$jml;$i++){
        $id=$_POST['cb_data'][$i];
        $this->pengangkatan->delete($id);
      }
       $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span> 
            </button> Data Berhasil Dihapus</div>");
    }
    redirect('PengangkatanController/index');
  }
}