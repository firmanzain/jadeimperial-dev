<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class DokumenController extends CI_Controller{
    //put your code here
     public function __construct()
    {
        parent::__construct();
    		$this->load->model('model_dokumen');
      $this->load->library('mpdf');
    } 

   function index(){
        $data['data']=$this->model_dokumen->index();
      	$this->table->set_heading(array('<input type=checkbox name=cekall id=cekall onclick="return checkedAll(form_data);">','NO','JUDUL','ISI','UPDATE'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
	        			'thead_open'=>'<thead>',
        				'thead_close'=> '</thead>',
        				'tbody_open'=> '<tbody>',
        				'tbody_close'=> '</tbody>',
        		);
        $this->table->set_template($tmp);
		$data['halaman']=$this->load->view('dokumen/index',$data,true);
		$this->load->view('beranda',$data);
    } 
	
    public function create()
      {
          if ($this->input->post()) {
            $this->save();
          } else {
            $data['halaman']=$this->load->view('dokumen/create','',true);
            $this->load->view('beranda',$data);
          }
      }

    public function save(){
      $data = array(
                  'dokumen' =>$this->input->post('dokumen'),
                  'isi_doc' =>$this->input->post('isi'),
                  'entry_user' =>$this->session->userdata('username')
                );
      $this->model_dokumen->add($data);
      $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Disimpan</div>");
      redirect('dokumen');
    }

    public function edit($id)
      {
         if ($this->input->post()) {
            $this->update();
         }else{
             $data['data']=$this->model_dokumen->find($id);
             if ($data==true) {
                $data['halaman']=$this->load->view('dokumen/update',$data,true);
                $this->load->view('beranda',$data);
             }else{
                show_404();
             }
         }
      }

    public function update(){
        $id=$this->input->post('id');
        $data = array(
                  'dokumen' =>$this->input->post('dokumen'),
                  'isi_doc' =>$this->input->post('isi'),
                  'entry_user' =>$this->session->userdata('username')
                );
        $this->model_dokumen->update($id,$data);
        $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Disimpan</div>");
        redirect('dokumen');
    }

    public function hapus(){
        if(!empty($_POST['cb_data'])){
            $jml=count($_POST['cb_data']);
            for($i=0;$i<$jml;$i++){
                $id=$_POST['cb_data'][$i];
                $this->model_dokumen->delete($id);
            }
         $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Dihapus</div>");
        }
        redirect('dokumen','refresh');
    }

	function cetakDokumen($id){
        $data= $this->model_dokumen->find($id);
		$html=$data->isi_doc;
		$this->mpdf=new mPDF('utf-8', 'A4', 12, 'Times','20','20','20','20');
		$this->mpdf->WriteHTML($html);
		$name='HRD'.time().'.pdf';
		$this->mpdf->Output();
		exit();        
    }
}