<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MutasiController extends CI_Controller{
    //put your code here
     public function __construct()
    {
        parent::__construct();
        $this->auth->restrict();
        //$this->load->library('mpdf');
		    $this->load->model('mutasi');
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
       $data['data']=$this->mutasi->index($tgl1,$tgl2);
      	$this->table->set_heading(array('<input type=checkbox name=cekall id=cekall onclick="return checkedAll(form_data);">','NO','Nama','Jabatan Lama','Jabatan Baru','Department lama','Department baru','Plant lama','Plant Baru','Tanggal Berlaku','Cetak'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
	        			'thead_open'=>'<thead>',
        				'thead_close'=> '</thead>',
        				'tbody_open'=> '<tbody>',
        				'tbody_close'=> '</tbody>',
        		);
        $this->table->set_template($tmp);
		$data['halaman']=$this->load->view('mutasiView/index',$data,true);
		$this->load->view('beranda',$data);
    } 
	
    public function create()
      {
          if ($this->input->post()) {
            $hasil=$this->mutasi->mutasikaryawan();
            if ($hasil==1) {
              echo "1";
            }else{
              echo "0";
            }
          } else {
            $data['hrd']=$this->db->select('nik,nama_ktp')->get('tab_karyawan')->result();
            $data['cabang']=$this->db->get('tab_cabang')->result();
            $data['departmen']=$this->db->get('tab_department')->result();
            $data['jabatan']=$this->db->get('tab_jabatan')->result();
            $data['halaman']=$this->load->view('mutasiView/create',$data,true);
            $this->load->view('beranda',$data);
          }
      }

    function mutasikaryawan($nik){
		   if($_POST==NULL){
            $this->load->model('mutasi');
            $data['hasil'] = $this->mutasi->filterdata($nik);
            $data['halaman'] = $this->load->view('mutasiView/create',$data,true);
			$this->load->view('beranda',$data);
        }
        else{
            $this->load->model('mutasi');
            $this->mutasi->mutasiKaryawan();
            redirect('MutasiController/index');
        }
    }
	function cetakMutasi($id){
      $data['data'] = $this->mutasi->filterdatamutasi($id);
  		$data['mutasi']=$this->load->view('mutasiView/cetak',$data,true);
      $data['halaman']=$this->load->view('mutasiView/p_mutasi',$data,true);
      $this->load->view('beranda',$data);
    }
  /*
  function cetakMutasi($id){
    $data['data'] = $this->mutasi->filterdatamutasi($id);
    $html=$this->load->view('mutasiView/cetak',$data,true);
    $this->mpdf=new mPDF('utf-8', 'A4', 11, 'Times','5','5','5','5');
      //$this->mpdf->setFooter('{PAGENO}');
    $this->mpdf->WriteHTML($html);
    $name='Mutasi'.time().'.pdf';
    $this->mpdf->Output();
    exit();        
    }
  */
    public function delete()
    {
      for ($i=0; $i<sizeof($this->input->post('cb_data')); $i++) { 
        $this->db->where('id_mutasi', $this->input->post('cb_data')[$i]);
        $this->db->delete('tab_mutasi');
      }
      redirect('mutasi');
    }
}