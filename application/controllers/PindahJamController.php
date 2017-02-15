<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PindahJamController extends CI_Controller {
	public function __construct(){
		parent::__construct();
    	$this->auth->restrict();
		$this->load->model('model_jampindah');
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
        $data['data']=$this->model_jampindah->index($tgl1,$tgl2);
      	$this->table->set_heading(array('<input type=checkbox name=cekall id=cekall onclick="return checkedAll(form_data);">','NO','NIK','NAMA','JAM ASAL','JAM PINDAH','UNTUK TANGGAL','KETERANGAN','TINDAKAN'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
	        			'thead_open'=>'<thead>',
        				'thead_close'=> '</thead>',
        				'tbody_open'=> '<tbody>',
        				'tbody_close'=> '</tbody>',
        		);
        $this->table->set_template($tmp);
		$data['halaman']=$this->load->view('pindah_jam/index',$data,true);
		$this->load->view('beranda',$data);
	  }

	  public function create()
	  {
	      if ($this->input->post()) {
	      	$this->save();
	      } else {
	      	$data['jenis']=$this->db->get('tab_jam_kerja')->result();
	      	$data['halaman']=$this->load->view('pindah_jam/create',$data,true);
	      	$this->load->view('beranda',$data);
	  	  }
	  }

	  public function show_data()
	  {
	      $nik=$this->input->post('nik',true);
	      $bln=$this->input->post('bln',true);
	      $tahun=$this->input->post('tahun',true);
	      $cek=$this->model_jampindah->cek($nik,$bln,$tahun);
	      $this->table->set_heading(array('NO','TANGGAL','KODE JAM AWAL','KODE JAM PINDAH','KETERANGAN'));
	      $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
		        			'thead_open'=>'<thead>',
	        				'thead_close'=> '</thead>',
	        				'tbody_open'=> '<tbody>',
	        				'tbody_close'=> '</tbody>',
	        		);
	      $this->table->set_template($tmp);
	      $tombol='<div class="form-group col-md-12">
						<button type="button" class="btn btn-primary" onclick="saveData()" id="simpan">Simpan</button>
						<button type="button" class="btn btn-warning" onclick="aksiClose()">Cancel</button>
						</div>';
		  $no=1;
		  $data['karyawan']="Pindah Schedule Kerja Karyawan $detail_nik->nama_ktp";
		  $data['tombol']=$tombol;
		  $isi_kode=$this->db->get('tab_jam_kerja')->result();
		  foreach ($isi_kode as $rs_kode) {
				$array_op[]="<option>$rs_kode->kode_jam</option>";
		  }
     	  $option=str_replace(':', '', implode(':', $array_op))."</select>";
	      if ($cek==false) {
		    echo "0";
	      } else {
	      	$detail_nik=$cek->row();
	      	foreach ($cek->result() as $rs_data) {
	      		$i=$no;
	      		$kode='<select name="kd_jam['.$i.']" id="kd_jam['.$i.']" class="form-control"><option value="">---</option>';
				$tgl="<input type='hidden' name='tanggal[$i]' value='".$rs_data->tanggal."'>";
				$txt_nik="<input type='hidden' name='nik[$i]' value='$nik'>";
				$form_tgl=$this->format->TanggalIndo($rs_data->tanggal);
				$keterangan="<input type='text' name='keterangan[$i]' class='form-control' />";
				$kd_aja="<input type='hidden' name='kd_asal[$i]' value='$rs_data->kode_jam' />";
				$this->table->add_row($no.$tgl.$txt_nik,$form_tgl,$rs_data->kode_jam.$kd_aja,$kode.$option,$keterangan);
				$no++;
	      	}
		    $data['tabel']=$this->table->generate();
		    echo json_encode($data);
		  }
	  }

	 public function save(){

	  	$jml=count($this->input->post('kd_jam'));

	  	$jml2 = 0;

	  	for ($i=1; $i <= $jml ; $i++) {

	  		$kode=$this->input->post('kd_jam')[$i];

	  		if ($kode!=NULL) {

				$data = array(
                  	'nik' => $this->input->post('nik')[$i],
                  	'entry_user' =>$this->session->userdata('username'),
                  	'kode_jam_asal' =>$this->input->post('kd_asal')[$i],
				  	'kode_jam_pindah' =>$kode,
				  	'keterangan' =>$this->input->post('keterangan')[$i],
					'tanggal_pindah' =>$this->input->post('tanggal')[$i],
		        );


			  	$check = $this->db->query(
			  		'
			  		select * from tab_pindah_jam 
			  		where nik="'.$data['nik'].'" and kode_jam_asal="'.$data['kode_jam_asal'].'" 
			  		and kode_jam_pindah="'.$data['kode_jam_pindah'].'" and tanggal_pindah="'.$data['tanggal_pindah'].'" 
			  		'
			  	);

				if ($check->result()<>false) { // gak masuk
						$jml2++;
				}
				else
				{
	  			
			    	$hasil=$this->model_jampindah->add($data); // masukno data sek
			    	$data1 = array(
			    		'kode_jam' =>$kode
			    	);

					$this->db->where('nik', $data['nik']);
					$this->db->where('kode_jam', $data['kode_jam_asal']);
					$this->db->where('tanggal', $data['tanggal_pindah']);
					$this->db->update('tab_jadwal_karyawan', $data1);
				    // $jml += $hasil;
	
				    /*
				  	if ($check->result()<>false) { // jika datanya ada (cek masuk opo gak), berarti masuk
				  		$jml2++; // lek masuk, lebih dari 1
				  	}*/
				  	$query = $this->db->query('select * from tab_jam_kerja where kode_jam="'.$data['kode_jam_pindah'].'"');
	            	if ($query->result()<>false) {
	            		foreach ($query->result() as $val) {
		            		$jam_masuk1	 = $val->jam_start;
		            		$jam_keluar1 = $val->jam_finish;
		            		$jam_masuk2	 = $val->jam_start2;
		            		$jam_keluar2 = $val->jam_finish2;
	            			if ($val->jam_start!="00:00:00"&&$val->jam_start2=="00:00:00") {
	            				$tipe_shift = "Pagi";
								$status1 	 = "";
								$keterangan1 = "";
								$status2 	 = "";
								$keterangan2 = "";
								$statusk1 	 = "";
								$keterangank1 = "";
								$statusk2 	 = "";
								$keterangank2 = "";
	            				$shift = 1;
	            			} else if ($val->jam_start=="00:00:00"&&$val->jam_start2!="00:00:00") {
								$tipe_shift = "Sore";
								$status1 	 = "";
								$keterangan1 = "";
								$status2 	 = "";
								$keterangan2 = "";
								$statusk1 	 = "";
								$keterangank1 = "";
								$statusk2 	 = "";
								$keterangank2 = "";
								$shift = 1;
	            			} else if ($val->jam_start!="00:00:00"&&$val->jam_start2!="00:00:00") {
								$tipe_shift = "Pagi&Sore";
								$status1 	 = "";
								$keterangan1 = "";
								$status2 	 = "";
								$keterangan2 = "";
								$statusk1 	 = "";
								$keterangank1 = "";
								$statusk2 	 = "";
								$keterangank2 = "";
								$shift = 2;
	            			} else if ($val->jam_start=="00:00:00"&&$val->jam_start2=="00:00:00") {
								$tipe_shift  = "Libur";
								$status1 	 = "Libur";
								$keterangan1 = "Libur";
								$status2 	 = "Libur";
								$keterangan2 = "Libur";
								$statusk1 	 = "Libur";
								$keterangank1 = "Libur";
								$statusk2 	 = "Libur";
								$keterangank2 = "Libur";
								$shift = 0;
	            			}
	            		}
	            	} else {
	            		$jam_masuk1	 = "00:00:00";
	            		$jam_keluar1 = "00:00:00";
	            		$jam_masuk2	 = "00:00:00";
	            		$jam_keluar2 = "00:00:00";
						$status1 	 = "";
						$keterangan1 = "";
						$status2 	 = "";
						$keterangan2 = "";
						$statusk1 	 = "";
						$keterangank1 = "";
						$statusk2 	 = "";
						$keterangank2 = "";
	            		$shift 		 = 0;
	            		$tipe_shift	 = "-";
	            	}
	            	if ($jam_masuk1=="00:00:00"&&$jam_masuk2=="00:00:00"&&$jam_keluar1=="00:00:00"&&$jam_keluar2=="00:00:00") {
		            	$data2 =  array(
		            		'kode_jam'		=> $data['kode_jam_pindah'],
		            		'kode_shift'	=> $shift,
		            		'tipe_shift'	=> $tipe_shift,
		            		'status_masuk'	=> $status1,
		            		'keterangan_masuk' => $keterangan1,
		            		'status_masuk2'	=> $status2,
		            		'keterangan_masuk2' => $keterangan2,
		            		'status_keluar'	=> $statusk1,
		            		'keterangan_keluar' => $keterangank1,
		            		'status_keluar2'	=> $statusk2,
		            		'keterangan_keluar2' => $keterangank2,
				            'entry_user'    => $this->session->userdata('username'),
				            'entry_date'    => date('Y-m-d H:i:s')
		            	);
	            	} else {
		            	$data2 =  array(
		            		'kode_jam'		=> $data['kode_jam_pindah'],
		            		'kode_shift'	=> $shift,
		            		'tipe_shift'	=> $tipe_shift,
				            'entry_user'    => $this->session->userdata('username'),
				            'entry_date'    => date('Y-m-d H:i:s')
		            	);	
	            	}
					$this->db->where('nik', $data['nik']);
					$this->db->where('kode_jam', $data['kode_jam_asal']);
					$this->db->where('tgl_kerja', $data['tanggal_pindah']);
					$this->db->update('tab_absensi', $data2);
				  	/*$query_absensi = $this->db->query(
				  		'
				  		update tab_absensi set kode_jam="'.$data['kode_jam_pindah'].'" where nik="'.$data['nik'].'" and kode_jam="'.$data['kode_jam_asal'].'" and tgl_kerja="'.$data['tanggal_pindah'].'"
				  		'
				  	);*/
			  	}
	  		}
	  	}

		if ($jml2==0) { // lek masuk
	    		echo 1;
		    } else {
		    	echo 0;
	    	}
	}

	public function selisih_hari($h1,$h2)
	{
		$s1=((abs(strtotime ($h2) - strtotime ($h1)))/(60*60*24));
		return $s1;
	}

	public function ajax_cari(){
		$nik=$this->input->post('nik');
		$data=$this->db->join('tab_karyawan','tab_karyawan.nik=tab_jadwal_karyawan.nik')->where('tab_jadwal_karyawan.nik',$nik)->get('tab_jadwal_karyawan')->row();
		$num_data=count($data);
		if ($num_data>=1) {
			echo json_encode($data);
		} else {
			echo "Data Penjadwalan Kosong, Silahkan Cek Data Schedule Karyawan";
		}
	}

	public function edit($id)
	  {
	     if ($this->input->post()) {
	     	$this->update();
	     }else{
		     $data['data']=$this->model_jampindah->find($id);$data['jenis']=$this->db->get('tab_jam_kerja')->result();
		     if ($data==true) {
		     	$data['halaman']=$this->load->view('pindah_jam/update',$data,true);
		     	$this->load->view('beranda',$data);
		     }else{
		     	show_404();
		     }
		 }
	  }

  	public function update(){
	  	$id=$this->input->post('id');

	  	$check = $this->db->query(
	  		'select * from tab_pindah_jam where id='.$id
	  	);
	  	foreach ($check->result() as $row) {
	  		$nik = $row->nik;
	  		$kode_jam1 = $row->kode_jam_asal;
	  		$kode_jam2 = $row->kode_jam_pindah;
	  		$tgl = $row->tanggal_pindah;
	  	}
	  	$query = $this->db->query('select * from tab_jam_kerja where kode_jam="'.$kode_jam1.'"');
    	if ($query->result()<>false) {
    		foreach ($query->result() as $val) {
        		$jam_masuk1	 = "00:00:00";
        		$jam_keluar1 = "00:00:00";
        		$jam_masuk2	 = "00:00:00";
        		$jam_keluar2 = "00:00:00";
    			if ($val->jam_start!="00:00:00"&&$val->jam_start2=="00:00:00") {
    				$tipe_shift = "Pagi";
					$status1 	 = "";
					$keterangan1 = "";
					$status2 	 = "";
					$keterangan2 = "";
					$statusk1 	 = "";
					$keterangank1 = "";
					$statusk2 	 = "";
					$keterangank2 = "";
    				$shift = 1;
    			} else if ($val->jam_start=="00:00:00"&&$val->jam_start2!="00:00:00") {
					$tipe_shift = "Sore";
					$status1 	 = "";
					$keterangan1 = "";
					$status2 	 = "";
					$keterangan2 = "";
					$statusk1 	 = "";
					$keterangank1 = "";
					$statusk2 	 = "";
					$keterangank2 = "";
					$shift = 1;
    			} else if ($val->jam_start!="00:00:00"&&$val->jam_start2!="00:00:00") {
					$tipe_shift = "Pagi&Sore";
					$status1 	 = "";
					$keterangan1 = "";
					$status2 	 = "";
					$keterangan2 = "";
					$statusk1 	 = "";
					$keterangank1 = "";
					$statusk2 	 = "";
					$keterangank2 = "";
					$shift = 2;
    			} else if ($val->jam_start=="00:00:00"&&$val->jam_start2=="00:00:00") {
					$tipe_shift  = "Libur";
					$status1 	 = "Libur";
					$keterangan1 = "Libur";
					$status2 	 = "Libur";
					$keterangan2 = "Libur";
					$statusk1 	 = "Libur";
					$keterangank1 = "Libur";
					$statusk2 	 = "Libur";
					$keterangank2 = "Libur";
					$shift = 0;
    			}
    		}
    	} else {
    		$jam_masuk1	 = "00:00:00";
    		$jam_keluar1 = "00:00:00";
    		$jam_masuk2	 = "00:00:00";
    		$jam_keluar2 = "00:00:00";
			$status1 	 = "";
			$keterangan1 = "";
			$status2 	 = "";
			$keterangan2 = "";
			$statusk1 	 = "";
			$keterangank1 = "";
			$statusk2 	 = "";
			$keterangank2 = "";
    		$shift 		 = 0;
    		$tipe_shift	 = "-";
    	}
    	$data2 =  array(
    		'kode_jam'		=> $kode_jam1,
    		'kode_shift'	=> $shift,
    		'tipe_shift'	=> $tipe_shift,
            'entry_user'    => $this->session->userdata('username'),
            'entry_date'    => date('Y-m-d H:i:s')
    	);
		$this->db->where('nik', $nik);
		$this->db->where('kode_jam', $kode_jam2);
		$this->db->where('tgl_kerja', $tgl);
		$this->db->update('tab_absensi', $data2);


	  	$data = array(
                  'nik' => $this->input->post('nik'),
                  'entry_user' =>$this->session->userdata('username'),
                  'kode_jam_asal' =>$this->input->post('jam_asal'),
				  'kode_jam_pindah' =>$this->input->post('jam_ganti'),
				  'keterangan' =>$this->input->post('keterangan'),
				  'tanggal_pindah' =>$this->input->post('tanggal'),
                );
	    $this->db->where('nik',$id);
        $this->db->update('tab_pindah_jam',$data);

	  	$check = $this->db->query(
	  		'select * from tab_pindah_jam where id='.$id
	  	);
	  	foreach ($check->result() as $row) {
	  		$nik = $row->nik;
	  		$kode_jam1 = $row->kode_jam_asal;
	  		$kode_jam2 = $row->kode_jam_pindah;
	  		$tgl = $row->tanggal_pindah;
	  	}
	  	$query = $this->db->query('select * from tab_jam_kerja where kode_jam="'.$kode_jam2.'"');
    	if ($query->result()<>false) {
    		foreach ($query->result() as $val) {
        		$jam_masuk1	 = "00:00:00";
        		$jam_keluar1 = "00:00:00";
        		$jam_masuk2	 = "00:00:00";
        		$jam_keluar2 = "00:00:00";
    			if ($val->jam_start!="00:00:00"&&$val->jam_start2=="00:00:00") {
    				$tipe_shift = "Pagi";
					$status1 	 = "";
					$keterangan1 = "";
					$status2 	 = "";
					$keterangan2 = "";
					$statusk1 	 = "";
					$keterangank1 = "";
					$statusk2 	 = "";
					$keterangank2 = "";
    				$shift = 1;
    			} else if ($val->jam_start=="00:00:00"&&$val->jam_start2!="00:00:00") {
					$tipe_shift = "Sore";
					$status1 	 = "";
					$keterangan1 = "";
					$status2 	 = "";
					$keterangan2 = "";
					$statusk1 	 = "";
					$keterangank1 = "";
					$statusk2 	 = "";
					$keterangank2 = "";
					$shift = 1;
    			} else if ($val->jam_start!="00:00:00"&&$val->jam_start2!="00:00:00") {
					$tipe_shift = "Pagi&Sore";
					$status1 	 = "";
					$keterangan1 = "";
					$status2 	 = "";
					$keterangan2 = "";
					$statusk1 	 = "";
					$keterangank1 = "";
					$statusk2 	 = "";
					$keterangank2 = "";
					$shift = 2;
    			} else if ($val->jam_start=="00:00:00"&&$val->jam_start2=="00:00:00") {
					$tipe_shift  = "Libur";
					$status1 	 = "Libur";
					$keterangan1 = "Libur";
					$status2 	 = "Libur";
					$keterangan2 = "Libur";
					$statusk1 	 = "Libur";
					$keterangank1 = "Libur";
					$statusk2 	 = "Libur";
					$keterangank2 = "Libur";
					$shift = 0;
    			}
    		}
    	} else {
    		$jam_masuk1	 = "00:00:00";
    		$jam_keluar1 = "00:00:00";
    		$jam_masuk2	 = "00:00:00";
    		$jam_keluar2 = "00:00:00";
			$status1 	 = "";
			$keterangan1 = "";
			$status2 	 = "";
			$keterangan2 = "";
			$statusk1 	 = "";
			$keterangank1 = "";
			$statusk2 	 = "";
			$keterangank2 = "";
    		$shift 		 = 0;
    		$tipe_shift	 = "-";
    	}
    	$data2 =  array(
    		'kode_jam'		=> $kode_jam2,
    		'kode_shift'	=> $shift,
    		'tipe_shift'	=> $tipe_shift,
            'entry_user'    => $this->session->userdata('username'),
            'entry_date'    => date('Y-m-d H:i:s')
    	);
		$this->db->where('nik', $nik);
		$this->db->where('kode_jam', $kode_jam1);
		$this->db->where('tgl_kerja', $tgl);
		$this->db->update('tab_absensi', $data2);

	    $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Disimpan</div>");
	    redirect('pindah_jam');
	}
	public function hapus(){
		if(!empty($_POST['cb_data'])){
			$jml=count($_POST['cb_data']);
			for($i=0;$i<$jml;$i++){
				$id=$_POST['cb_data'][$i];
				$this->model_jampindah->delete($id);
			}
	     $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Dihapus</div>");
		}
		redirect('pindah_jam','refresh');
	}
}