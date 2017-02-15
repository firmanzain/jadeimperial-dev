<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aprov extends CI_Controller {
	public function __construct(){
		parent::__construct();
    	$this->auth->restrict();
		$this->load->model('model_aprov');
		$this->load->model('model_gaji');
		$this->load->model('bonus');
	}
	
	public function komisi()
	  {
        $data['data']=$this->model_aprov->komisi_index();
      	$this->table->set_heading(array('NO','NIK','NAMA','PLANT','DEPARTMENT','KOMISI','OMSET','TINDAKAN'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
	        			'thead_open'=>'<thead>',
        				'thead_close'=> '</thead>',
        				'tbody_open'=> '<tbody>',
        				'tbody_close'=> '</tbody>',
        		);
        $this->table->set_template($tmp);
		$data['halaman']=$this->load->view('Aproval/slip_komisi',$data,true);
		$this->load->view('beranda',$data);
	  }

	  public function aprove_casual()
	  {
	    $data['data']=$this->model_aprov->aprov_casual2();
	    //print_r($this->db->last_query());
	    $this->table->set_heading(array('','NO','NIK','NAMA','JABATAN','DEPARTMEN','KEPALA DEPARTMEN','HRD','PLANT','JUMLAH CASUAL','JUMLAH UPAH','APPROVEMENT','KETERANGAN','KETERANGAN EKSTRA','TINDAKAN'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
                'thead_open'=>'<thead>',
                'thead_close'=> '</thead>',
                'tbody_open'=> '<tbody>',
                'tbody_close'=> '</tbody>',
            );
        $this->table->set_template($tmp);
		$data['halaman']=$this->load->view('Aproval/slip_casual',$data,true);
		$this->load->view('beranda',$data);
	  }

	  public function aprove_thr()
      {
        $data['data']=$this->model_aprov->aprov_thr();
        //print_r($this->db->last_query());
        //$this->table->set_heading(array('<input type=checkbox name=cekall id=cekall onclick="return checkedAll(form_data);">','NO','NIK','NAMA','JABATAN','DEPARTEMEN','PLANT','NAMA REKENING','NO REKENING','THR','PPH','THR TERIMA','JADWAL BAGI','TINDAKAN'));
        $this->table->set_heading(array('','NO','CABANG','JUMLAH KARYAWAN','THR','PPH','THR DITERIMA','JADWAL BAGI','APPROVEMENT','KETERANGAN','TINDAKAN'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
                        'thead_open'=>'<thead>',
                        'thead_close'=> '</thead>',
                        'tbody_open'=> '<tbody>',
                        'tbody_close'=> '</tbody>',
                );
        $this->table->set_template($tmp);
        $data['halaman']=$this->load->view('Aproval/slip_thr',$data,true);
        $this->load->view('beranda',$data);
      }
	
	function bonus(){
		if ($this->input->post('bln',true)==NULL) {
			$bln = date('m');
			$thn = date('Y');
		} else {
			$bln=$this->input->post('bln',true);
			$thn=$this->input->post('tahun',true); 
		}
		$data['bln'] = $bln;
		$data['thn'] = $thn;
        $data['data']=$this->model_aprov->bonus($bln,$thn);
        $this->table->set_heading(array('NO','PLANT','JUMLAH OMSET','MPD','L&B','TOTAL BONUS','TOTAL BULAT','SELISIH PEMBULATAN','BONUS DIBAGI','BONUS TIDAK DIBAGI','APPROVEMENT','TINDAKAN'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
                        'thead_open'=>'<thead>',
                        'thead_close'=> '</thead>',
                        'tbody_open'=> '<tbody>',
                        'tbody_close'=> '</tbody>',
                );
        $this->table->set_template($tmp);
        $data['halaman']=$this->load->view('Aproval/slip_bonus',$data,true);
        $this->load->view('beranda',$data);
    }

    function tunjangan(){
        $data['data']=$this->model_aprov->tunjangan_index();
        $this->table->set_heading(array('<input type=checkbox name=cekall id=cekall onclick="return checkedAll(form_data);">','NO','NIK','NAMA','JABATAN','PLANT','TUNJANGAN','TARIF','TINDAKAN'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
                        'thead_open'=>'<thead>',
                        'thead_close'=> '</thead>',
                        'tbody_open'=> '<tbody>',
                        'tbody_close'=> '</tbody>',
                );
        $this->table->set_template($tmp);
        $data['halaman']=$this->load->view('Aproval/slip_tunjangan',$data,true);
        $this->load->view('beranda',$data);
    }

    public function tunjangan_aprov(){
	  	$cb_id=$this->input->post('cb_data');
	  	if (!empty($cb_id)) {
	  		$jml_id=count($cb_id);
		  	for ($i=0; $i < $jml_id ; $i++) { 
		  		$id=$cb_id[$i];
		  		$data = array(
			                  'approved' => "Ya",
			                  'keterangan' => $this->input->post('keterangan')
			                );
		  		$this->model_aprov->aprove_tunjangan($id,$data);
		  	}
		  	redirect('Aprov/tunjangan');
	  	} elseif($this->input->post('id_tunjangan')) {
	  		$id=$this->input->post('id_tunjangan');
	  		$data = array(
			                  'approved' => "Tidak",
			                  'keterangan' => $this->input->post('keterangan')
			                );
		  	$this->model_aprov->aprove_tunjangan($id,$data);
		    echo "sukses";
	  	}
	}

	public function casual_aprov(){
	  	/*$cb_id=$this->input->post('cb_data');
	  	if (!empty($cb_id)) {
	  		$jml_id=count($cb_id);
		  	for ($i=0; $i < $jml_id ; $i++) { 
		  		$id=$cb_id[$i];
		  		$data = array(
			                  'approved' => "Ya",
			                  'keterangan' => $this->input->post('keterangan')
			                );
		  		$this->model_aprov->aprove_casual($id,$data);
		  	}
		  	redirect('aprov/aprove_casual');
	  	} elseif($this->input->post('id_casual')) {
	  		$id=$this->input->post('id_casual');
	  		$data = array(
			                  'approved' => "Tidak",
			                  'keterangan' => $this->input->post('keterangan')
			                );
		  	$this->model_aprov->aprove_casual($id,$data);
		    echo "sukses";
	  	} else {
	  			redirect('aprov/aprove_casual');
	  	}*/

	  	for($i=0; $i<sizeof($this->input->post('iddet', TRUE)); $i++){

			$query = $this->db->query(
				'
				SELECT a.id_casual  
				FROM tab_casual_ekstra a
				WHERE a.id_casual='.$_POST['iddet'][$i].'
				'
			);

			foreach ($query->result() as $val) {
		  		
		  		$data = array(
		  			'approved'	=> '2',
		        	'keterangan' => "Disetujui",
		        	"entry_user" => $this->session->userdata('username'),
		        	'entry_date' => date('Y-m-d H:i:s')
				);
				$this->db->where('id_casual', $val->id_casual);
				$this->db->update('tab_casual_ekstra', $data);

			}

	  	}
	  	redirect('Aprov/aprove_casual');

	}

	public function thr_aprov(){
	  	/*$cb_id=$this->input->post('cb_data');
	  	if (!empty($cb_id)) {
	  		$jml_id=count($cb_id);
		  	for ($i=0; $i < $jml_id ; $i++) { 
		  		$id=$cb_id[$i];
		  		$data = array(
			                  'approved' => "Ya",
			                  'keterangan' => $this->input->post('keterangan')
			                );
		  		$this->model_aprov->aprove_thr($id,$data);
		  	}
		  	redirect('Aprov/aprove_thr');
	  	} elseif($this->input->post('id_thr')) {
	  		$id=$this->input->post('id_thr');
	  		$data = array(
			                  'approved' => "Tidak",
			                  'keterangan' => $this->input->post('keterangan')
			                );
		  	$this->model_aprov->aprove_thr($id,$data);
		    echo "sukses";
	  	} else  {
	  	 	redirect('Aprov/aprove_thr');
	  	}*/

	  	for($i=0; $i<sizeof($this->input->post('iddet', TRUE)); $i++){

			$query = $this->db->query(
				'
				SELECT a.id_thr 
				FROM tab_master_thr a
				INNER JOIN tab_karyawan b ON b.nik=a.nik  
				LEFT JOIN tab_cabang c ON c.id_cabang=b.cabang 
				WHERE c.id_cabang='.$_POST['iddet'][$i].'
				'
			);

			foreach ($query->result() as $val) {
		  		
		  		$data = array(
		  			'approved'	=> 'Ya',
		        	'keterangan' => "Disetujui",
		        	"entry_user" => $this->session->userdata('username'),
		        	//'entry_date' => date('Y-m-d H:i:s')
				);

				$this->db->where('id_thr', $val->id_thr);
				$this->db->update('tab_master_thr', $data);

			}
	  	}
	  	redirect('Aprov/aprove_thr');
	}

    function detail_bonus($id){
        $data['data'] = $this->model_aprov->detail_bonus($id);
        $this->table->set_heading(array('<input type=checkbox name=cekall id=cekall onclick="return checkedAll(form_data);">','NO','NIK','NAMA','JABATAN','BONUS GRADE','BONUS SENIORITAS','BONUS PROTA','BONUS PERSEN','BONUS NOMINAL','TOTAL BONUS','TINDAKAN'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
                        'thead_open'=>'<thead>',
                        'thead_close'=> '</thead>',
                        'tbody_open'=> '<tbody>',
                        'tbody_close'=> '</tbody>',
                );
        $this->table->set_template($tmp);
        $data['halaman']=$this->load->view('Aproval/detail_bonus',$data,true);
		$this->load->view('beranda',$data);
    }

	public function gaji()
	  {
		if ($this->input->post('bln',true)==NULL) {
			$bln = date('m');
			$thn = date('Y');
		} else {
			$bln=$this->input->post('bln',true);
			$thn=$this->input->post('tahun',true); 
		}
		$data['bln'] = $bln;
		$data['thn'] = $thn;
        $data['data']=$this->model_gaji->indexnew2($bln,$thn);
      	$this->table->set_heading(array('','NO','CABANG','JUMLAH KARYAWAN','GAJI','TUNJANGAN JABATAN','EKSTRA','DP CUTI','PINJ','PPH','TOTAL POTONGAN BPJS','GAJI DITERIMA','PAYROLL','STATUS','TINDAKAN'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
	        			'thead_open'=>'<thead>',
        				'thead_close'=> '</thead>',
        				'tbody_open'=> '<tbody>',
        				'tbody_close'=> '</tbody>',
        		);
        $this->table->set_template($tmp);
		$data['halaman']=$this->load->view('Aproval/slip_gaji',$data,true);
		$this->load->view('beranda',$data);
	  }

	public function gajiresign()
	  {
		if ($this->input->post('bln',true)==NULL) {
			$bln = date('m');
			$thn = date('Y');
		} else {
			$bln=$this->input->post('bln',true);
			$thn=$this->input->post('tahun',true); 
		}
		$data['bln'] = $bln;
		$data['thn'] = $thn;
        $data['data']=$this->model_gaji->detail_gaji_resign($bln,$thn);
      	$this->table->set_heading(array('','NO','NIK','NAMA','JABATAN','DEPARTMENT','UPAH JAMSOSTEK','GAJI POKOK','TUNJANGAN JABATAN','EKSTRA','DP CUTI MINUS','DP CUTI PLUS','PINJ','PPH','JHT','JPK','GAJI DITERIMA','APPROVAL','KETERANGAN','TINDAKAN'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
	        			'thead_open'=>'<thead>',
        				'thead_close'=> '</thead>',
        				'tbody_open'=> '<tbody>',
        				'tbody_close'=> '</tbody>',
        		);
        $this->table->set_template($tmp);
		$data['halaman']=$this->load->view('Aproval/slip_gaji_resign',$data,true);
		$this->load->view('beranda',$data);
	  }

	public function gajicasual()
	  {
		if ($this->input->post('bln',true)==NULL) {
			$bln = date('m');
			$thn = date('Y');
		} else {
			$bln=$this->input->post('bln',true);
			$thn=$this->input->post('tahun',true); 
		}
		$data['bln'] = $bln;
		$data['thn'] = $thn;
        $periode1 = date('d',strtotime($thn."-".$bln."-01"))." - ".date('d',strtotime($thn."-".$bln."-15"));
        $periode2 = date('d',strtotime($thn."-".$bln."-16"))." - ".date('t',strtotime($thn."-".$bln));
        $data['data']=$this->model_gaji->indexcasualnew($bln,$thn);
        $this->table->set_heading(array('','NO','CABANG','JUMLAH KARYAWAN','GAJI NETTO / HARI '.$periode1,'UANG MAKAN / HARI '.$periode1,'EKSTRA '.$periode1,'PPH '.$periode1,'TOTAL DITERIMA '.$periode1,'GAJI NETTO / HARI '.$periode2,'UANG MAKAN / HARI '.$periode2,'EKSTRA '.$periode2,'PPH '.$periode2,'TOTAL DITERIMA '.$periode2,'TOTAL GAJI DITERIMA','TINDAKAN'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
	        			'thead_open'=>'<thead>',
        				'thead_close'=> '</thead>',
        				'tbody_open'=> '<tbody>',
        				'tbody_close'=> '</tbody>',
        		);
        $this->table->set_template($tmp);
		$data['halaman']=$this->load->view('Aproval/slip_gaji2',$data,true);
		$this->load->view('beranda',$data);
	  }

	public function gaji_detail($id_cabang,$cabang)
	  {
        $data['data']=$this->model_gaji->detail_gaji($id_cabang);
        $data['cabang']=str_replace('-', ',', $cabang);
      	$this->table->set_heading(array('<input type=checkbox name=cekall id=cekall onclick="return checkedAll(form_data);">','NO','NIK','NAMA','JABATAN','DEPARTMENT','UPAH JAMSOSTEK','GAJI POKOK','EKSTRA','PINJ','PPH','JHT','JPK','DP CUTI','GAJI DITERIMA','TINDAKAN'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
	        			'thead_open'=>'<thead>',
        				'thead_close'=> '</thead>',
        				'tbody_open'=> '<tbody>',
        				'tbody_close'=> '</tbody>',
        		);
        $this->table->set_template($tmp);
		$data['halaman']=$this->load->view('Aproval/detail_slip_gaji',$data,true);
		$this->load->view('beranda',$data);
	  }

	public function ekstra()
	  {
        $data['data']=$this->model_aprov->ekstra_index();
      	$this->table->set_heading(array('NO','NIK','NAMA','JABATAN','DEPARTMENT','PLANT','JAM EXTRA','LAMA','VAKASI','JUMLAH','KETERANGAN','TINDAKAN'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
	        			'thead_open'=>'<thead>',
        				'thead_close'=> '</thead>',
        				'tbody_open'=> '<tbody>',
        				'tbody_close'=> '</tbody>',
        		);
        $this->table->set_template($tmp);
		$data['halaman']=$this->load->view('Aproval/slip_ekstra',$data,true);
		$this->load->view('beranda',$data);
	  }

  	public function goAprove(){
	  	$id=$this->input->post('id');
	  	$data = array(
                  'approved' => "Ya",
                  'keterangan' => 'Null'
                );
	    $this->model_aprov->aprove_data($id,$data);
	    echo "sukses";
	}

	public function disAprove(){
	  	$id=$this->input->post('id');
	  	$data = array(
                  'approved' => "Tidak",
                  'keterangan' => $this->input->post('keterangan')
                );
	    $this->model_aprov->aprove_data($id,$data);
	    echo "sukses";
	}

	public function aproveGajiCabang(){
	  	/*$id=$this->input->post('id');
	  	$keterangan=$this->input->post('keterangan');
	  	$cb_id=$this->input->post('cb_data');
	  	if (!empty($cb_id)) {
	  		$jml_id=count($cb_id);
		  	for ($i=0; $i < $jml_id ; $i++) { 
		  		$id=$cb_id[$i];
		  		$approv=2;
		  		$this->model_aprov->aproveGajiCabang($id,$approv,$keterangan);
		  	}
		  	redirect('aprov/gaji');
	  	} else {
	  		$approv=1;
		  	$this->model_aprov->aproveGajiCabang($id,$approv,$keterangan);
		    echo "sukses";
	  	}*/
	  	// error_reporting(E_ALL);

	  	for($i=0; $i<sizeof($this->input->post('iddet', TRUE)); $i++){

			$query = $this->db->query(
				'
				SELECT a.id_gaji_karyawan 
				FROM tab_gaji_karyawan_new a
				INNER JOIN tab_karyawan b ON b.nik=a.nik  
				LEFT JOIN tab_cabang c ON c.id_cabang=b.cabang 
				WHERE c.id_cabang='.$_POST['iddet'][$i].' AND MONTH(a.tanggal_gaji)="'.$_POST['bln'][$i].'" 
      			AND YEAR(a.tanggal_gaji)="'.$_POST['thn'][$i].'" 
				'
			);

			foreach ($query->result() as $val) {
		  		
		  		$data = array(
		  			'approval'	=> '2',
		        	'keterangan' => "Disetujui",
		        	"entry_user" => $this->session->userdata('username'),
		        	'entry_date' => date('Y-m-d H:i:s')
				);

				$this->db->where('id_gaji_karyawan', $val->id_gaji_karyawan);
				$this->db->update('tab_gaji_karyawan_new', $data);

			}
	  	}
	  	redirect('Aprov/gaji');
	}

	public function cancelaproveGajiCabang(){

		$query = $this->db->query(
			'
			SELECT a.id_gaji_karyawan 
			FROM tab_gaji_karyawan_new a
			INNER JOIN tab_karyawan b ON b.nik=a.nik  
			LEFT JOIN tab_cabang c ON c.id_cabang=b.cabang 
			WHERE MONTH(a.tanggal_gaji)="'.$_POST['bln'].'" 
  			AND YEAR(a.tanggal_gaji)="'.$_POST['thn'].'" 
			'
		);

		if ($query <> false) {
			foreach ($query->result() as $val) {
		  		
		  		$data = array(
		  			'approval'	=> '0',
		        	'keterangan' => "Cancel Approve",
		        	"entry_user" => $this->session->userdata('username'),
		        	'entry_date' => date('Y-m-d H:i:s')
				);

				$this->db->where('id_gaji_karyawan', $val->id_gaji_karyawan);
				$this->db->update('tab_gaji_karyawan_new', $data);

			}
		}

	  	redirect('Aprov/gaji');
	}


	public function aproveGajicasualCabang(){

	  	for($i=0; $i<sizeof($this->input->post('iddet', TRUE)); $i++){

			$query = $this->db->query(
				'
				SELECT a.id_gaji_karyawan 
				FROM tab_gaji_casual_new a
				INNER JOIN tab_karyawan b ON b.nik=a.nik  
				LEFT JOIN tab_cabang c ON c.id_cabang=b.cabang 
				WHERE c.id_cabang='.$_POST['iddet'][$i].'
				'
			);

			foreach ($query->result() as $val) {
		  		
		  		$data = array(
		  			'approval'	=> '2',
		        	'keterangan' => "Disetujui",
		        	"entry_user" => $this->session->userdata('username'),
		        	//'entry_date' => date('Y-m-d H:i:s')
				);

				$this->db->where('id_gaji_karyawan', $val->id_gaji_karyawan);
				$this->db->update('tab_gaji_casual_new', $data);

			}
	  	}
	  	redirect('Aprov/gajicasual');
	}

	public function cancelaproveGajicasualCabang(){

	  	$query = $this->db->query(
			'
			SELECT a.id_gaji_karyawan 
			FROM tab_gaji_casual_new a
			INNER JOIN tab_karyawan b ON b.nik=a.nik  
			LEFT JOIN tab_cabang c ON c.id_cabang=b.cabang 
			WHERE MONTH(a.tanggal_gaji_1)="'.$_POST['bln'].'" 
  			AND YEAR(a.tanggal_gaji_1)="'.$_POST['thn'].'" 
			'
		);

		foreach ($query->result() as $val) {
	  		
	  		$data = array(
	  			'approval'	=> '0',
	        	'keterangan' => "Cancel Approve",
	        	"entry_user" => $this->session->userdata('username'),
	        	'entry_date' => date('Y-m-d H:i:s')
			);

			$this->db->where('id_gaji_karyawan', $val->id_gaji_karyawan);
			$this->db->update('tab_gaji_casual_new', $data);

		}

	  	redirect('Aprov/gajicasual');
	}

	public function aproveGajiresign(){

	  	for($i=0; $i<sizeof($this->input->post('iddet', TRUE)); $i++){

	  		if ($_POST['iddet'][$i]!=NULL) {

				$query = $this->db->query(
					'
					SELECT a.id_gaji_karyawan 
					FROM tab_gaji_karyawan_resign a
					INNER JOIN tab_karyawan b ON b.nik=a.nik  
					LEFT JOIN tab_cabang c ON c.id_cabang=b.cabang 
					WHERE a.id_gaji_karyawan='.$_POST['iddet'][$i].'
					'
				);

				foreach ($query->result() as $val) {
			  		
			  		$data = array(
			  			'approval'	=> '2',
			        	'keterangan' => "Disetujui",
			        	"entry_user" => $this->session->userdata('username'),
			        	//'entry_date' => date('Y-m-d H:i:s')
					);

					$this->db->where('id_gaji_karyawan', $val->id_gaji_karyawan);
					$this->db->update('tab_gaji_karyawan_resign', $data);

				}
	  		}
	  	}
	  	redirect('Aprov/gajiresign');
	}

	public function cancelaproveGajiresign(){

	  	$query = $this->db->query(
			'
			SELECT a.id_gaji_karyawan 
			FROM tab_gaji_karyawan_resign a
			INNER JOIN tab_karyawan b ON b.nik=a.nik  
			LEFT JOIN tab_cabang c ON c.id_cabang=b.cabang 
			WHERE MONTH(a.tanggal_gaji)="'.$_POST['bln'].'" 
  			AND YEAR(a.tanggal_gaji)="'.$_POST['thn'].'" 
			'
		);

		foreach ($query->result() as $val) {
	  		
	  		$data = array(
	  			'approval'	=> '0',
	        	'keterangan' => "Cancel Approve",
	        	"entry_user" => $this->session->userdata('username'),
	        	'entry_date' => date('Y-m-d H:i:s')
			);

			$this->db->where('id_gaji_karyawan', $val->id_gaji_karyawan);
			$this->db->update('tab_gaji_karyawan_resign', $data);

		}
	  	redirect('Aprov/gajiresign');
	}

	public function aprov_gaji_v2()
	{
		$id = $this->input->post('id');
		$bln = $this->input->post('bln');
		$thn = $this->input->post('thn');
		$ket = $this->input->post('keterangan');

		$query = $this->db->query(
			'
			SELECT a.id_gaji_karyawan 
			FROM tab_gaji_karyawan_new a
			INNER JOIN tab_karyawan b ON b.nik=a.nik  
			LEFT JOIN tab_cabang c ON c.id_cabang=b.cabang 
			WHERE c.id_cabang='.$id.' and MONTH(a.tanggal_gaji)="'.$bln.'" 
      		AND YEAR(a.tanggal_gaji)="'.$thn.'" 
			'
		);

		foreach ($query->result() as $val) {

			$data = array(
				'approval'	 => '1',
	        	'keterangan' => $ket,
	        	"entry_user" => $this->session->userdata('username'),
	        	'entry_date' => date('Y-m-d H:i:s')
			);

			$this->db->where('id_gaji_karyawan', $val->id_gaji_karyawan);
			$this->db->update('tab_gaji_karyawan_new', $data);

		}

		$response['status'] = '200';
		echo json_encode($response);
	}

	public function aprov_gajicasual()
	{
		$id = $this->input->post('id');
		$ket = $this->input->post('keterangan');

		$query = $this->db->query(
			'
			SELECT a.id_gaji_karyawan 
			FROM tab_gaji_casual_new a
			INNER JOIN tab_karyawan b ON b.nik=a.nik  
			LEFT JOIN tab_cabang c ON c.id_cabang=b.cabang 
			WHERE c.id_cabang='.$id.'
			'
		);

		foreach ($query->result() as $val) {

			$data = array(
				'approval'	 => '1',
	        	'keterangan' => $ket,
	        	"entry_user" => $this->session->userdata('username'),
	        	//'entry_date' => date('Y-m-d H:i:s')
			);

			$this->db->where('id_gaji_karyawan', $val->id_gaji_karyawan);
			$this->db->update('tab_gaji_casual_new', $data);

		}

		$response['status'] = '200';
		echo json_encode($response);
	}

	public function aprov_ekstra_casual_v2()
	{
		$id = $this->input->post('id');
		$ket = $this->input->post('keterangan');

		$query = $this->db->query(
			'
			SELECT a.id_casual  
			FROM tab_casual_ekstra a
			WHERE a.id_casual='.$id.'
			'
		);

		foreach ($query->result() as $val) {

			$data = array(
				'approved'	 => '1',
	        	'keterangan' => $ket,
	        	"entry_user" => $this->session->userdata('username'),
	        	'entry_date' => date('Y-m-d H:i:s')
			);

			$this->db->where('id_casual', $val->id_casual);
			$this->db->update('tab_casual_ekstra', $data);

		}

		$response['status'] = '200';
		echo json_encode($response);
	}

	public function aprov_gajiresign_v2()
	{
		$id = $this->input->post('id');
		$ket = $this->input->post('keterangan');

		$query = $this->db->query(
			'
			SELECT a.id_gaji_karyawan 
			FROM tab_gaji_karyawan_resign a
			INNER JOIN tab_karyawan b ON b.nik=a.nik  
			LEFT JOIN tab_cabang c ON c.id_cabang=b.cabang 
			WHERE a.id_gaji_karyawan='.$id.'
			'
		);

		foreach ($query->result() as $val) {

			$data = array(
				'approval'	 => '1',
	        	'keterangan' => $ket,
	        	"entry_user" => $this->session->userdata('username'),
	        	'entry_date' => date('Y-m-d H:i:s')
			);

			$this->db->where('id_gaji_karyawan', $val->id_gaji_karyawan);
			$this->db->update('tab_gaji_karyawan_resign', $data);

		}

		$response['status'] = '200';
		echo json_encode($response);
	}

	public function aprov_thr_v2()
	{
		$id = $this->input->post('id');
		$ket = $this->input->post('keterangan');

		$query = $this->db->query(
			'
			SELECT a.id_thr 
			FROM tab_master_thr a
			INNER JOIN tab_karyawan b ON b.nik=a.nik  
			LEFT JOIN tab_cabang c ON c.id_cabang=b.cabang 
			WHERE a.id_gaji_karyawan='.$id.'
			'
		);

		foreach ($query->result() as $val) {

			$data = array(
				'approved'	 => 'Tidak',
	        	'keterangan' => $ket,
	        	"entry_user" => $this->session->userdata('username'),
	        	'entry_date' => date('Y-m-d H:i:s')
			);

			$this->db->where('id_thr', $val->id_thr);
			$this->db->update('tab_master_thr', $data);

		}

		$response['status'] = '200';
		echo json_encode($response);
	}

	public function aprov_bonus(){
	  	/*$cb_bonus=$this->input->post('cb_data');
	  	$id=$this->input->post('id');
	  	if (!empty($cb_bonus)) {
	  		$jml_bonus=count($cb_bonus);
		  	for ($i=0; $i < $jml_bonus ; $i++) { 
		  		$array_data=explode(':', $cb_bonus[$i]);
		  		$isi= array(
		  					"nik" => $array_data[0],
		  					"nominal" => $array_data[1],
		  					"senioritas" => $array_data[2],
		  					"grade" => $array_data[3],
		  					"persentase" => $array_data[4],
		  					"prota" => $array_data[5],
		  					"tanggal_bonus" => $array_data[6],
	  						"include_pph" => $array_data[9],
		  					"approved" => $array_data[7],
		  					"keterangan" => $array_data[8],
		  					"entry_user" => $this->session->userdata('username')
		  					);
		  		$this->model_aprov->aprove_bonus($isi);
		  	}
		  	redirect('aprov/bonus/'.$id.'/detail');
	  	} elseif(!empty($this->input->post('data'))) {
	  		$data=$this->input->post('data');
	  		$array_data=explode(':', $data);
	  		$isi= array(
	  					"nik" => $array_data[0],
	  					"nominal" => $array_data[1],
	  					"senioritas" => $array_data[2],
	  					"grade" => $array_data[3],
	  					"persentase" => $array_data[4],
	  					"prota" => $array_data[5],
	  					"tanggal_bonus" => $array_data[6],
	  					"approved" => "Tidak",
	  					"include_pph" => $array_data[9],
	  					"keterangan" => $this->input->post('keterangan'),
	  					"entry_user" => $this->session->userdata('username')
	  					);
	  		$this->model_aprov->aprove_bonus($isi);
		  	$this->model_aprov->aproveGajiCabang($id,$approv,$keterangan);
		    echo "sukses";
	  	} else {
	  		redirect('aprov/bonus/'.$id.'/detail');
	  	}*/

	  	for($i=0; $i<sizeof($this->input->post('iddet', TRUE)); $i++){
	  		$data = array(
	  			'approved'	=> "Ya",
	        	'keterangan' => "Disetujui",
	        	"entry_user" => $this->session->userdata('username'),
	        	'entry_date' => date('Y-m-d H:i:s')
			);
			$this->db->where('id_omset', $_POST['iddet'][$i]);
			$this->db->update('tab_omset', $data);
	  	}
	  	redirect('Aprov/bonus');
	}

	public function aprov_bonus_v2()
	{
		$id = $this->input->post('id');
		$ket = $this->input->post('keterangan');

		$data = array(
			'approved'	 => "Tidak",
        	'keterangan' => $ket,
        	"entry_user" => $this->session->userdata('username'),
        	'entry_date' => date('Y-m-d H:i:s')
		);

		$this->db->where('id_omset', $id);
		$this->db->update('tab_omset', $data);
		$this->db->where('id_omset', $id);
		$this->db->update('tab_bonus_karyawan', $data);

		$response['status'] = '200';
		echo json_encode($response);
	}

	public function cancelaprov_bonus(){

  		$data = array(
  			'approved'	=> "Belum",
        	'keterangan' => "Cancel Approve",
        	"entry_user" => $this->session->userdata('username'),
        	'entry_date' => date('Y-m-d H:i:s')
		);
		$this->db->where('month(bulan_bonus)', $_POST['bln']);
		$this->db->where('year(bulan_bonus)', $_POST['thn']);
		$this->db->update('tab_omset', $data);
		$this->db->where('month(tanggal_bonus)', $_POST['bln']);
		$this->db->where('year(tanggal_bonus)', $_POST['thn']);
		$this->db->update('tab_bonus_karyawan', $data);

	  	redirect('Aprov/bonus');
	}

	public function aprov_t3(){
	  	/*$cb_t3=$this->input->post('cb_data');
	  	$id=$this->input->post('id');
	  	if (!empty($cb_t3)) {
	  		$jml_t3=count($cb_t3);
		  	for ($i=0; $i < $jml_t3 ; $i++) { 
		  		$array_data=explode(':', $cb_t3[$i]);
		  		$isi= array(
		  					"nik" => $array_data[0],
		  					"jml_hadir" => $array_data[1],
		  					"total_t3" => $array_data[2],
  							"tanggal" => $array_data[3],
		  					"approved" => 'Ya',
		  					"keterangan" => $this->input->post('keterangan'),
		  					"entry_user" => $this->session->userdata('username')
		  					);
		  		$this->model_aprov->aprove_t3($isi);
		  	}
		  	redirect('t3Controller/approvement');
	  	} elseif(!empty($this->input->post('data'))) {
	  		$data=$this->input->post('data');
	  		$array_data=explode(':', $data);
	  		$isi= array(
  					"nik" => $array_data[0],
  					"jml_hadir" => $array_data[1],
  					"total_t3" => $array_data[2],
  					"tanggal" => $array_data[3],
		  			"approved" => 'Tidak',
  					"keterangan" => $this->input->post('keterangan'),
  					"entry_user" => $this->session->userdata('username')
  					);
	  		$this->model_aprov->aprove_t3($isi);
		    echo "sukses";
	  	} else {
	  		redirect('t3Controller/approvement');
	  	}*/

	  	for($i=0; $i<sizeof($this->input->post('iddet', TRUE)); $i++){
	  		$data = array(
	  			'approved'	=> "Ya",
	        	'keterangan' => "Disetujui",
	        	"entry_user" => $this->session->userdata('username'),
	        	'entry_date' => date('Y-m-d H:i:s')
			);
			$this->db->where('id', $_POST['iddet'][$i]);
			$this->db->update('tab_t3', $data);
	  	}
	  	redirect('T3Controller/approvement');
	}

	public function aprov_t3_v2()
	{
		$id = $this->input->post('id');
		$ket = $this->input->post('keterangan');

		$data = array(
			'approved'	 => "Tidak",
        	'keterangan' => $ket,
        	"entry_user" => $this->session->userdata('username'),
        	'entry_date' => date('Y-m-d H:i:s')
		);

		$this->db->where('id', $id);
		$this->db->update('tab_t3', $data);
		// print_r($this->db->last_query());

		$response['status'] = '200';
		echo json_encode($response);
	}

	public function cancelaprov_t3(){

	  	$data = array(
  			'approved'	=> "Belum",
        	'keterangan' => "Cancel Aprov",
        	"entry_user" => $this->session->userdata('username'),
        	'entry_date' => date('Y-m-d H:i:s')
		);
		$this->db->where('month(tanggal)', $_POST['bln']);
		$this->db->where('year(tanggal)', $_POST['thn']);
		$this->db->update('tab_t3', $data);
	  	redirect('T3Controller/approvement');
	}

	public function gajiKaryawan(){
	  	$keterangan=$this->input->post('keterangan');
	  	$cb_nik=$this->input->post('cb_data');
	  	$data_nik=$this->input->post('nik');
	  	if (!empty($cb_nik)) {
	  		$jml_nik=count($cb_nik);
		  	for ($i=0; $i < $jml_nik ; $i++) { 
		  		$nik=$cb_nik[$i];
		  		$approv=2;
		  		$data=explode(':', base64_decode($nik));
		  		$input=array(
		  				"gaji_karyawan" => $data[8],
		  				"nik" => $data[0],
		  				"gaji_ekstra" => $data[1],
		  				"tunjangan_jabatan" => $data[4],
		  				"pph21" => $data[2],
		  				"potongan_cuti" => $data[5],
		  				"bea_jht" => $data[6],
		  				"tanggal_gaji" => date('Y-m-d'),
		  				"bea_jpk" => $data[7],
		  				"pinjaman" => $data[3],
		  				"approval" => 2,
		  				"keterangan" => $keterangan,
		  				"entry_user" => $this->session->userdata('username')
		  			);
		  		$this->model_aprov->aproveGajiKaryawan($input);
		  	}
		  	redirect(base64_decode($data[9]));
	  	} elseif(!empty($data_nik)) {
	  		$approv=1;
	  		$data=explode(':', base64_decode($data_nik));
	  		$input=array(
	  				"gaji_karyawan" => $data[8],
	  				"nik" => $data[0],
	  				"gaji_ekstra" => $data[1],
	  				"tunjangan_jabatan" => $data[4],
	  				"pph21" => $data[2],
	  				"potongan_cuti" => $data[5],
	  				"bea_jht" => $data[6],
	  				"bea_jpk" => $data[7],
	  				"pinjaman" => $data[3],
	  				"approval" => 1,
	  				"keterangan" => $keterangan,
	  				"entry_user" => $this->session->userdata('username')
	  			);
			$this->model_aprov->aproveGajiKaryawan($input);
		    echo "sukses";
	  	}
	}

	public function aproveEkstra(){
	  	$id=$this->input->post('id');
	  	$upah=$this->input->post('upah');
	  	$data = array(
                  'entry_user' => $this->session->userdata('username'),
                  'approved' => "Ya",
                  'keterangan_aprov' => 'Null'
                );
	    //$nik=$this->db->select('*')->where('id',$id)->get('tab_extra')->row();
	    $query = $this->db->query('select * from tab_extra where id='.$id);
	    foreach ($query->result() as $val) {
	    	if ($val->vakasi=="Tambah DP Libur") {
		    	$tgl1 = $val->tanggal_ekstra;
		    	$check = $this->db->query('select * from tab_master_dp where nik="'.$val->nik.'"');
			  	if ($check->result()<>false) {
			  		foreach ($check->result() as $val2) {
			  			$dp_new	= floatval($val2->saldo_dp)+$val->jumlah_vakasi;
			  		}
			  		$this->db->query(
			  			'
			  			update tab_master_dp set saldo_dp='.$dp_new.'
						where bulan="'.date("m",strtotime($tgl1)).'" and 
						tahun="'.date("Y",strtotime($tgl1)).'" and nik="'.$val->nik.'"
						'
					);
	  			}
	    	}
	    }
	  	/*$tgl=date("Y-m-01",strtotime(date("Y-m-d")));
	  	$this->db->query("update tab_master_dp set saldo_dp=saldo_dp+".$upah." where nik='".$nik->nik."' and bulan='".$tgl."'");*/
	  	$this->model_aprov->aprove_ekstra($id,$data);
	    echo "sukses";
	}

	public function disaproveEkstra(){
	  	$id=$this->input->post('id');
	  	$data = array(
                  'entry_user' => $this->session->userdata('username'),
                  'approved' => "Tidak",
                  'keterangan_aprov' => $this->input->post('keterangan')
                );
	    $this->model_aprov->aprove_ekstra($id,$data);
	    echo "sukses";
	}
}