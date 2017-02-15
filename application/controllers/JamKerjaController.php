<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class JamKerjaController extends CI_Controller {
	public function __construct(){
		parent::__construct();
    	$this->auth->restrict();
		$this->load->model('model_jadwal');
		$this->load->library('PHPExcel');
		$this->load->library('PHPExcel/IOFactory');
		$this->load->library('mpdf');
	}
	
	  public function index()
	  {
        $data['data']=$this->model_jadwal->index();
      	$this->table->set_heading(array(/*'<input type=checkbox name=cekall id=cekall onclick="return checkedAll(form_data);">',*/'NO','KODE JAM','JAM PERTAMA','JAM KEDUA','KETERANGAN','DEPARTEMEN','DISPENS KETERLAMBATAN','LAMA','TINDAKAN'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
	        			'thead_open'=>'<thead>',
        				'thead_close'=> '</thead>',
        				'tbody_open'=> '<tbody>',
        				'tbody_close'=> '</tbody>',
        		);
        $this->table->set_template($tmp);
		//$data['halaman']=$this->load->view('biaya/index',$data,true);
		$data['halaman']=$this->load->view('jamKerja/index',$data,true);
		$this->load->view('beranda',$data);
	  }

	  public function create()
	  {
	      if ($this->input->post()) {
	      	$kode=$this->input->post('kode_jam');
	      	$this->cek($kode);
	      } else {
	      	$data['halaman']=$this->load->view('jamKerja/create','',true);
	      	$this->load->view('beranda',$data);
	  	  }
	  }

	  public function import_data()
	  {
	      if ($this->input->post()) {
	      	$this->go_import();
	      } else {
	      	$this->load->view('import/import_jadwal');
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
                   $dataexcel[$i - 1]['kode_jam'] = $data['cells'][$i][1];
                   $dataexcel[$i - 1]['jam_start1'] = $data['cells'][$i][2];
                   $dataexcel[$i - 1]['jam_finish1'] = $data['cells'][$i][3];
                   $dataexcel[$i - 1]['lama1'] = $data['cells'][$i][4];
                   $dataexcel[$i - 1]['jam_start2'] = $data['cells'][$i][5];
                   $dataexcel[$i - 1]['jam_finish2'] = $data['cells'][$i][6];
                   $dataexcel[$i - 1]['lama2'] = $data['cells'][$i][7];
                   $dataexcel[$i - 1]['keterangan'] = $data['cells'][$i][8];
              }
        $this->model_jadwal->import_data($dataexcel);
	   	$file = $upload_data['file_name'];
        $path = './temp_upload/'.$file;
        unlink($path);
	   	echo "<script>window.opener.location.reload();window.close()</script>";
    	}
    }

	public function get_all() {
	        $kode = $this->input->post('cari',TRUE); //variabel kunci yang di bawa dari input text id kode
	        $query = $this->mkota->get_allkota(); //query model
	        $tes       =  array();
	        foreach ($query as $d) {
	            $tes[]     = array(
	                'keterangan' => $d->keterangan //variabel yang dibawa ke id keterangan
	            );
	        }
	        echo json_encode($tes);      //data array yang telah kota deklarasikan dibawa menggunakan json
	}
	
	public function cek($kode) {
		$cek_data=$this->db->where('kode_jam',$kode)->get('tab_jam_kerja')->num_rows();
		if ($cek_data>=1) {
			 $this->session->set_flashdata("pesan", "<div class=\"alert alert-danger\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Terjadi duplikasi data, masukkan data lainnya</div>");
			redirect_back();
		} else {
			$this->save();
		}
	}
	  public function save(){
	  	$lama=$this->selisih_jam($this->input->post('jam_selesai'),$this->input->post('jam_mulai'))+$this->selisih_jam($this->input->post('jam_selesai2'),$this->input->post('jam_mulai2'));
	  	$data = array(
                  'kode_jam' => $this->input->post('kode_jam'),
                  'jam_start' => $this->input->post('jam_mulai'),
                  'jam_finish' =>$this->input->post('jam_selesai'),
                  'jam_start2' => $this->input->post('jam_mulai2'),
                  'jam_finish2' =>$this->input->post('jam_selesai2'),
                  'dispensasi' =>$this->input->post('dispensasi'),
				  'departmen' =>$this->input->post('departmen'),
				  'keterangan' =>$this->input->post('keterangan'),
				  'lama' =>$lama
                );
	    $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Disimpan</div>");
	    $this->model_jadwal->add($data);
	    redirect('jadwal');
	  }

	public function selisih_jam($jam1,$jam2)
	{
		$s1=(strtotime($jam1)-strtotime($jam2))/3600;
		return $s1;
	}

	public function cetak()
	  {
	      if ($this->input->post()) {
	      	$bln=$this->input->post('bulan');
	      	$thn=$this->input->post('tahun');
	      	$this->go_print($bln,$thn);
	      } else {
	      	$data['halaman']=$this->load->view('jamKerja/page_print','',true);
	      	$this->load->view('beranda',$data);
	  	  }
	  }

	public function go_print($bln,$thn)
	  {
	    $data['bulan']=$bln;
	    $data['tahun']=$thn;
	    $html=$this->load->view('laporan/rekap_jam_kerja',$data,true);
	    $html2=$this->load->view('laporan/pindah_jam',$data,true);
	    $this->mpdf=new mPDF('utf-8', 'A4-L', 11, 'arial','5','5','5','5');
	    $this->mpdf->WriteHTML($html);
	    $this->mpdf->AddPage();
	    $this->mpdf->WriteHTML($html2);
	    $name='HRD'.time().'.pdf';
	    $this->mpdf->Output();
	    exit();
	  }

	public function edit($id)
	  {
	     if ($this->input->post()) {
	     	$this->update();
	     }else{
		     $data['data']=$this->model_jadwal->find($id);
		     if ($data==true) {
		     	$data['halaman']=$this->load->view('jamKerja/update',$data,true);
		     	$this->load->view('beranda',$data);
		     }else{
		     	show_404();
		     }
		 }
	  }

  	public function update(){
	  	$id=$this->input->post('id');
	  	$lama=$this->selisih_jam($this->input->post('jam_selesai'),$this->input->post('jam_mulai'))+$this->selisih_jam($this->input->post('jam_selesai2'),$this->input->post('jam_mulai2'));
	  	$data = array(
                  'kode_jam' => $this->input->post('kode_jam'),
                  'jam_start' => $this->input->post('jam_mulai'),
                  'jam_finish' =>$this->input->post('jam_selesai'),
                  'jam_start2' => $this->input->post('jam_mulai2'),
                  'jam_finish2' =>$this->input->post('jam_selesai2'),
                  'dispensasi' =>$this->input->post('dispensasi'),
				  'departmen' =>$this->input->post('departmen'),
				  'keterangan' =>$this->input->post('keterangan'),
				  'lama' =>$lama
                );
	    $this->model_jadwal->update($id,$data);
	    $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Disimpan</div>");
	    redirect('jadwal');
	}
	public function hapus(){
		if(!empty($_POST['cb_data'])){
			$jml=count($_POST['cb_data']);
			for($i=0;$i<$jml;$i++){
				$id=$_POST['cb_data'][$i];
				$this->model_jadwal->delete($id);
			}
	     $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Dihapus</div>");
		}
		redirect('jadwal','refresh');
	}
}