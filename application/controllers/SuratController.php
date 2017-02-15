<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class SuratController extends CI_Controller{
    //put your code here
     public function __construct()
    {
      parent::__construct();
	    $this->load->model('model_surat');
      $this->load->library('mpdf');
    } 
    
   function index(){
	  $data['data']=$this->model_surat->index();
      $this->table->set_heading(array('<input type=checkbox name=cekall id=cekall onclick="return checkedAll(form_data);">','NO','NO SURAT','TANGGAL SURAT','JENIS SURAT','PERIHAL','LAMPIRAN','KEPADA','ISI','TINDAKAN'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
                    'thead_open'=>'<thead>',
                    'thead_close'=> '</thead>',
                    'tbody_open'=> '<tbody>',
                    'tbody_close'=> '</tbody>',
            );
        $this->table->set_template($tmp);
        $data['halaman']=$this->load->view('surat/index',$data,true);
        $this->load->view('beranda',$data);
    }

    public function create()
      {
          if ($this->input->post()) {
            $this->save();
          } else {
            $data['hrd']=$this->db->select('nik,nama_ktp')->get('tab_karyawan')->result();
            $data['nomor']=$this->db->select("id_surat")->order_by('id_surat','desc')->get('tab_surat_lain')->row();
            $data['halaman']=$this->load->view('surat/create',$data,true);
            $this->load->view('beranda',$data);
          }
      }

    public function save(){
      $data = array(
                  'no_surat' =>$this->input->post('no_surat'),
                  'perihal' =>$this->input->post('perihal'),
                  'jenis_surat' =>$this->input->post('jenis'),
                  'lampiran' =>$this->input->post('lampiran'),
                  'kepada' =>$this->input->post('kepada'),
                  'isi' =>$this->input->post('isi'),
                  'dari' =>$this->input->post('nik'),
                  'entry_user' =>$this->session->userdata('username')
                );
      $this->model_surat->add($data);
      $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Disimpan</div>");
      redirect('surat');
    }

    public function edit($id)
      {
         if ($this->input->post()) {
            $this->update();
         }else{
            $data['hrd']=$this->db->select('nik,nama_ktp')->get('tab_karyawan')->result();
             $data['data']=$this->model_surat->find($id);
             if ($data==true) {
                $data['halaman']=$this->load->view('surat/update',$data,true);
                $this->load->view('beranda',$data);
             }else{
                show_404();
             }
         }
      }

    public function update(){
        $id=$this->input->post('id');
        $data = array(
                  'no_surat' =>$this->input->post('no_surat'),
                  'jenis_surat' =>$this->input->post('jenis'),
                  'perihal' =>$this->input->post('perihal'),
                  'lampiran' =>$this->input->post('lampiran'),
                  'kepada' =>$this->input->post('kepada'),
                  'isi' =>$this->input->post('isi'),
                  'dari' =>$this->input->post('nik'),
                  'entry_user' =>$this->session->userdata('username')
                );
        $this->model_surat->update($id,$data);
        $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Disimpan</div>");
        redirect('surat');
    }

    public function hapus(){
        if(!empty($_POST['cb_data'])){
            $jml=count($_POST['cb_data']);
            for($i=0;$i<$jml;$i++){
                $id=$_POST['cb_data'][$i];
                $this->model_surat->delete($id);
            }
         $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Dihapus</div>");
        }
        redirect('surat','refresh');
    }

	function cetakSurat($id){
        $data['data'] = $this->model_surat->find($id);
        if (count($data['data'])<1) {
            redirect(current_url());
        } else {
            $html=$this->load->view('surat/cetak',$data,true);
            $this->mpdf=new mPDF();
            $this->mpdf->addPage('P','utf-8', 'A4', 11, 'arial','5','5','5','5');
            $this->mpdf->WriteHTML($html);
            $name='HRD'.time().'.pdf';
            $this->mpdf->Output();
            exit(); 
        }
		       
    }

	function cetakmemob($nik){
        $data['data'] = $this->memo->filterdata($nik);
		$html=$this->load->view('memoView/cetakb',$data,true);
		$this->mpdf=new mPDF('utf-8', 'A4', 12, 'Times','5','5','5','5');
		  //$this->mpdf->setFooter('{PAGENO}');
		$this->mpdf->WriteHTML($html);
		$name='memo'.time().'.pdf';
		$this->mpdf->Output();
		exit();        
    }
}