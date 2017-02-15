<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ResignController extends CI_Controller {
	public function __construct(){
		parent::__construct();
    	$this->auth->restrict();
		$this->load->model('model_resign');
		$this->load->library('mpdf');
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
	    $data['data']=$this->model_resign->index($tgl1,$tgl2);
	    $this->table->set_heading(array('<input type=checkbox name=cekall id=cekall onclick="return checkedAll(form_data);">','NO','NIK','NAMA','JABATAN','DEPARTMEN','PLANT','TANGGAL RESIGN','KETERANGAN','AKSI'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
        			'thead_open'=>'<thead>',
    				'thead_close'=> '</thead>',
    				'tbody_open'=> '<tbody>',
    				'tbody_close'=> '</tbody>',
    		);
        $this->table->set_template($tmp);
		$data['halaman']=$this->load->view('resign/index',$data,true);
		$this->load->view('beranda',$data);
	  }

	  public function create()
	  {
	      if ($this->input->post()) { // jika ada daya post
	      	$this->save(); // eksekusi function save dibawah
	      } else { // jika tidak ada
	      	$data['hrd']=$this->db->select('nik,nama_ktp')->get('tab_karyawan')->result(); // select nik, nama ktp dari tab_karyawan
	      	$data['halaman']=$this->load->view('resign/create',$data,true);
	      	$this->load->view('beranda',$data);
	  	  }
	  }

	  public function save(){
	  	$data = array(
                  'nik' => $this->input->post('nik'),
                  'nik_hrd' =>$this->input->post('nik_hrd'),
				  'tanggal_resign' =>$this->input->post('tanggal'),
				  'tanggal' =>$this->input->post('tanggal'),
				  'keterangan' =>$this->input->post('keterangan'),
                );
	    $this->model_resign->add($data);

	    //UPDATE KONTRAK KERJA
        $data2 = array(
            'tanggal_resign' => $data['tanggal_resign'],
        );
        $this->db->where('nik',$data['nik']);
        $this->db->update('tab_kontrak_kerja',$data2);
        //INSERT HISTORY
        $query3 = $this->db->query(
            '
            select * from tab_kontrak_kerja 
            WHERE nik="'.$data['nik'].'"'
        );
        foreach ($query3->result() as $row) {
            $data3 = array(
                'nik' => $row->nik,
                'status_kerja' => $row->status_kerja,
                'tanggal_masuk' => $row->tanggal_masuk,
                'tanggal_resign' => $row->tanggal_resign,
                'gaji_pokok' => $row->gaji_pokok,
                'gaji_casual' => $row->gaji_casual,
                'tunjangan_jabatan' => $row->tunjangan_jabatan,
                'uang_makan' => $row->uang_makan
            );
            $this->db->where('nik',$data3['nik']);
            $this->db->where('tanggal_masuk',$data3['tanggal_masuk']);
            $this->db->delete('tab_history_kontrak_kerja');

            $this->db->insert('tab_history_kontrak_kerja',$data3);
        }


	    $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Disimpan</div>");
	    redirect('resign');
	  }

	public function edit($id)
	  {
	     if ($this->input->post()) {
	     	$this->update();
	     }else{
	      	$data['hrd']=$this->db->select('nik,nama_ktp')->get('tab_karyawan')->result();
		     $data['data']=$this->model_resign->find($id);
		     if ($data==true) {
		     	$data['halaman']=$this->load->view('resign/update',$data,true);
		     	$this->load->view('beranda',$data);
		     }else{
		     	show_404();
		     }
		 }
	  }
	public function ajax_cari(){
		$nik=$this->input->post('nik');
		$data=$this->db->join('tab_cabang a','a.id_cabang=b.cabang','left')
                     ->join('tab_jabatan c','c.id_jabatan=b.jabatan','left')
                     ->join('tab_department d','d.id_department=b.department','left')
                     ->join('tab_kontrak_kerja f','f.nik=b.nik','left')
                     ->where('b.nik',$nik)
                     ->get('tab_karyawan b')
                     ->row();
		$num_data=count($data);
		if ($num_data>=1) {
			echo json_encode($data);
		} else {
			echo "kosong";
		}
	}

	public function aksi(){
		$tombol=$this->input->post('tombol');

		if ($tombol=='Hapus') {
			$this->hapus();
		}else{
			$this->cetakDok();
		}
	}

	public function popup_karyawan(){
        $this->load->model('karyawan');
        $this->table->set_heading(array('NO','NIK','NAMA','JENIS KELAMIN','JABATAN','PLANT','CETAK'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
                        'thead_open'=>'<thead>',
                        'thead_close'=> '</thead>',
                        'tbody_open'=> '<tbody>',
                        'tbody_close'=> '</tbody>',
                );
        $this->table->set_template($tmp);
        $data['data'] = $this->karyawan->index();
        $this->load->view('karyawan/popup_karyawan',$data);
    }

    public function cetakDok(){
    	//$data= $this->model_dokumen->find($id);
		$jml_cb=count($this->input->post('cb_data'));
		if (!empty($jml_cb)) {
		   	for ($i=0; $i < $jml_cb; $i++) { 
			$id=$this->input->post('cb_data')[$i];
			$resign=$this->model_resign->find($id);
			$data['hrd']=$this->db->join('tab_jabatan b','b.id_jabatan=a.jabatan')->where('a.nik',$resign->nik_hrd)->get('tab_karyawan a')->row();
			$data['karyawan'][]=$this->model_resign->show($id);
			}
			$html=$this->load->view('resign/bpjs_kesehatanResign',$data,true);
			$this->mpdf=new mPDF('utf-8', 'A4', 12, 'Times','15','15','10','15');
			$this->mpdf->WriteHTML($html);
			$this->mpdf->addPage();
			$html2=$this->load->view('resign/bpjs_tenagaResign',$data,true);
			$this->mpdf->WriteHTML($html2);
			$x=1;
			foreach ($data['karyawan'] as $rs) {
				$data['employe']=$rs;
				$this->mpdf->addPage();
				$htmlx=$this->load->view('resign/keterangan_kerja',$data,true);
				$this->mpdf->WriteHTML($htmlx);
				$this->mpdf->addPage();
				$htmly=$this->load->view('resign/referensi',$data,true);
				$this->mpdf->WriteHTML($htmly);
				$x++;
				$htmlx="";
				$htmly="";
			}
			$name='HRD'.time().'.pdf';
			$this->mpdf->Output();
			exit();
		}else {
			redirect('resign');
		}   
    }

    public function c_bpjs($id)
    {
    	$resign=$this->model_resign->find($id);
		$data['hrd']=$this->db->join('tab_jabatan b','b.id_jabatan=a.jabatan')->where('a.nik',$resign->nik_hrd)->get('tab_karyawan a')->row();
		$data['karyawan'][]=$this->model_resign->show($id);
		$data['bpjs']=$this->load->view('resign/bpjs_kesehatanResign',$data,true);
		$data['jamsostek']=$this->load->view('resign/bpjs_tenagaResign',$data,true);
		$data['halaman']=$this->load->view('resign/p_bpjs',$data,true);
	    $this->load->view('beranda',$data);
    }

    public function c_skpk($id)
    {
    	$resign=$this->model_resign->find($id);
		$data['hrd']=$this->db->join('tab_jabatan b','b.id_jabatan=a.jabatan')->where('a.nik',$resign->nik_hrd)->get('tab_karyawan a')->row();
		$data['employe']=$this->model_resign->show($id);
		$data['skpk']=$this->load->view('resign/keterangan_kerja',$data,true);
		$data['skbk']=$this->load->view('resign/referensi',$data,true);
		$data['halaman']=$this->load->view('resign/p_kerja',$data,true);
	    $this->load->view('beranda',$data);
    }
  	public function update(){
	  	$id=$this->input->post('id');
	  	$data = array(
                  'nik' => $this->input->post('nik'),
                  'nik_hrd' =>$this->input->post('nik_hrd'),
                  'tanggal_resign' =>$this->input->post('tanggal'),
                  'tanggal' =>$this->input->post('tanggal'),
				  'keterangan' =>$this->input->post('keterangan'),
                );
	    $this->model_resign->update($id,$data);
	    $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Disimpan</div>");
	    redirect('resign');
	}
	public function hapus(){
		if(!empty($_POST['cb_data'])){
			$jml=count($_POST['cb_data']);
			for($i=0;$i<$jml;$i++){
				$id=$_POST['cb_data'][$i];
				$this->model_resign->delete($id);
			}
	     $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Dihapus</div>");
		}
		redirect('resign','refresh');
	}
}