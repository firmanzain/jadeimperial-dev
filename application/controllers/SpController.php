<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class SpController extends CI_Controller{
    //put your code here
     public function __construct()
    {
        parent::__construct();
        //$this->load->library('mpdf');
        $this->auth->restrict();
		$this->load->model('sp');
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
        $data['data']=$this->sp->index($tgl1,$tgl2);
        $this->table->set_heading(array('<input type=checkbox name=cekall id=cekall onclick="return checkedAll(form_data);">','NO','NO SP','Nama','Jabatan','Department','Jenis SP','Tanggal Mulai','Tanggal Selesai','Terima Bonus','Keterangan','Cetak'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
                        'thead_open'=>'<thead>',
                        'thead_close'=> '</thead>',
                        'tbody_open'=> '<tbody>',
                        'tbody_close'=> '</tbody>',
                );
        $this->table->set_template($tmp);
        $data['halaman']=$this->load->view('spView/index',$data,true);
        $this->load->view('beranda',$data);
    }  
	
    public function create()
      {
          if ($this->input->post()) {
            $this->save();
          } else {
            $bulan=date('m');
            $tahun=date('Y');
            $romawi_bulan=$this->format->bulan($bulan);
            $num=$this->db->select('no_sp')->order_by('no_sp','desc')->get('tab_sp')->row();
            if(!empty($num)){
                $no_awal=substr($num->no_sp,0,4)+1;
                if ($no_awal<10) {
                $data['no_sp']='000'.$no_awal.'/'.$romawi_bulan.'/CRN-DSM/SDM/SP/'.$tahun;
                }elseif ($no_awal>9 && $no_awal<99) {
                  $data['no_sp']='00'.$no_awal.'/'.$romawi_bulan.'/CRN-DSM/SDM/SP/'.$tahun;
                }elseif ($no_awal>99 && $no_awal<999) {
                  $data['no_sp']='0'.$no_awal.'/'.$romawi_bulan.'/CRN-DSM/SDM/SP/'.$tahun;
                }else{
                  $data['no_sp']=$no_awal.'/'.$romawi_bulan.'/CRN-DSM/SDM/SP/'.$tahun;
                }
            }else {
                $data['no_sp']='0001/'.$romawi_bulan.'/CRN-DSM/SDM/SP/'.$tahun;
            }
            $data['pemeriksa']=$this->db->get('tab_karyawan')->result();
            $data['halaman']=$this->load->view('spView/create',$data,true);
            $this->load->view('beranda',$data);
          }
      }

      public function save(){
        $data = array(
                  'nik' => $this->input->post('nik'),
                  'jenis_sp' =>$this->input->post('jenis_sp'),
                  'isi_sp' =>$this->input->post('keterangan'),
                  'no_sp' =>$this->input->post('no_sp'),
                  'saksi' =>$this->input->post('saksi'),
                  'pemeriksa' =>$this->input->post('pemeriksa'),
                  'pemohon' =>$this->input->post('pemohon'),
                  'sanksi' =>$this->input->post('sanksi'),
                  'tanggal_sp' =>$this->input->post('tanggal_sp'),
                  'tanggal_sp_selesai' =>$this->input->post('tanggal_sp_selesai'),
                  'terima_bonus' =>$this->input->post('terima_bonus'),
                  'entry_user' =>$this->session->userdata('username'),
                );
        $this->sp->add($data);
        $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Disimpan</div>");
        redirect('peringatan','refresh');
      }

	function cetaksp($id){
        $data['data'] = $this->sp->filterdatasp($id);
        $data['pemeriksa'] = $this->sp->periksa($id);
		    $data['sp1']=$this->load->view('spView/cetak',$data,true);
        $data['sp2']=$this->load->view('spView/bp',$data,true);
        $data['sp3']=$this->load->view('spView/lembar_pembinaan',$data,true);
        $data['sp4']=$this->load->view('spView/pernyataan',$data,true);
        $data['halaman']=$this->load->view('spView/p_sp',$data,True);
        $this->load->view('beranda',$data);
    }

    public function hapus(){
        if(!empty($_POST['cb_data'])){
            $jml=count($_POST['cb_data']);
            for($i=0;$i<$jml;$i++){
                $id=$_POST['cb_data'][$i];
                $this->sp->delete($id);
            }
         $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Dihapus</div>");
        }
        redirect('peringatan','refresh');
    }
}