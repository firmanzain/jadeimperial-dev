<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
  	public function __construct(){
          
	    parent::__construct();
	    $this->auth->restrict();
	    $this->load->model('model_dashboard');
	    $this->load->model('model_absensi');

  	}

	public function index()
	{	
        if ($this->input->post('bln',true)==NULL) {
          $bln = date('m');
          $thn = date('Y');
        } else {
          $bln = $this->input->post('bln',true);
          $thn = $this->input->post('thn',true); 
        }
        $data['bln'] = $bln;
        $data['thn'] = $thn;

	    $karyawan=$this->model_absensi->hitung_karyawan($cb="");
	    //$masuk=$this->model_absensi->hitung_masuk($tgl=date("Y-m-d"),$cb="");
	    $masuk = $this->db->query('select * from tab_absensi where month(tgl_kerja)="'.$bln.'" and year(tgl_kerja)="'.$thn.'" and status_masuk="Masuk" or month(tgl_kerja)="'.$bln.'" and year(tgl_kerja)="'.$thn.'" and status_masuk2="Masuk"')->num_rows();
	    /*$cuti=$this->model_absensi->hitung_cuti($tgl=date("Y-m-d"),$cb="");
	    $izin=$this->model_absensi->hitung_cuti($tgl=date("Y-m-d"),$cb="");
	    $absen=$karyawan-$masuk-$cuti-$izin;*/
	    $cuti = $this->db->query('select * from tab_absensi where month(tgl_kerja)="'.$bln.'" and year(tgl_kerja)="'.$thn.'" and status_masuk="Cuti" or month(tgl_kerja)="'.$bln.'" and year(tgl_kerja)="'.$thn.'" and status_masuk2="Cuti"')->num_rows();
	    $izin = $this->db->query('select * from tab_absensi where month(tgl_kerja)="'.$bln.'" and year(tgl_kerja)="'.$thn.'" and status_masuk="Izin" or month(tgl_kerja)="'.$bln.'" and year(tgl_kerja)="'.$thn.'" and status_masuk2="Izin"')->num_rows();
	    $absen = $this->db->query('select * from tab_absensi where month(tgl_kerja)="'.$bln.'" and year(tgl_kerja)="'.$thn.'" and status_masuk="Bolos" or month(tgl_kerja)="'.$bln.'" and year(tgl_kerja)="'.$thn.'" and status_masuk2="Bolos"')->num_rows();

	    $data['masuk']=json_encode($masuk);
	    $data['karyawan']=json_encode($karyawan);
	    $data['cuti']=json_encode($cuti);
	    $data['izin']=json_encode($izin);
	    $data['absen']=json_encode($absen);
		$data['visibel_telat']=$this->db->where('notifikasi',1)->where('level',$this->session->userdata('id_level'))->get('tab_akses_notifikasi')->row();
		$data['visibel_disiplin']=$this->db->where('notifikasi',2)->where('level',$this->session->userdata('id_level'))->get('tab_akses_notifikasi')->row();
		$data['visibel_kontrak']=$this->db->where('notifikasi',3)->where('level',$this->session->userdata('id_level'))->get('tab_akses_notifikasi')->row();
		$data['visibel_bpjs']=$this->db->where('notifikasi',4)->where('level',$this->session->userdata('id_level'))->get('tab_akses_notifikasi')->row();
		$data['visibel_schedule']=$this->db->where('notifikasi',5)->where('level',$this->session->userdata('id_level'))->get('tab_akses_notifikasi')->row();

		$data['disiplin_data']=$this->model_dashboard->notifikasi_disiplin($param="");
		$data['terlambat_data']=$this->model_dashboard->notifikasi_terlambat($param="");
		$data['data_resign']=$this->model_dashboard->notifikasi_resign();
		$data['data_schedule']=$this->model_dashboard->schedule_pindah($t1="");

		$data['data_bpjs1']=$this->model_dashboard->bpjs_kesehatan($bln1="",$thn1="");
		$data['data_bpjs2']=$this->model_dashboard->bpjs_ketenagakerjaan($bln1="",$thn1="");

		$data['jumlah_notif']=$this->model_dashboard->hitung();
		$data['halaman']=$this->load->view('home',$data,true);
		$this->load->view('beranda',$data);
	}

	public function cari_disiplin()
	{
		$tg1=$this->input->post('tgl1');
		$tg2=$this->input->post('tgl2');
		if (!empty($tg1) and !empty($tg2)) {
			$param="where tgl_kerja between '$tg1' and '$tg2'";
		}else{
			$param="";
		}
		$data=$this->model_dashboard->notifikasi_disiplin($param);

		echo '<table id="example-2" class="table table-hover table-striped table-bordered">
		    	<thead>
		    		<tr class="bg-warning-700 color-white">
		    			<th>NO</th>
		    			<th>NIK</th>
		    			<th>NAMA</th>
		    			<th>PLANT</th>
		    			<th>JABATAN</th>
		    			<th>DEPARTMENT</th>
		    			<th>TOTAL MASUK</th>
		    		</tr>
		    	</thead>';
		$no=1;
		foreach ($data as $rs) {
			echo "<tr><td>$no</td><td>$rs->nik</td><td>$rs->nama_ktp</td><td>$rs->cabang</td><td>$rs->jabatan</td><td>$rs->department</td><td>$rs->total_masuk</td></tr>";
			$no++;
		}

	}

	public function cari_telat()
	{
		$tg1=$this->input->post('tgl1');
		$tg2=$this->input->post('tgl2');
		if (!empty($tg1) and !empty($tg2)) {
			$param="where tgl_kerja between '$tg1' and '$tg2'";
		}else{
			$param="";
		}
		$data=$this->model_dashboard->notifikasi_terlambat($param);

		echo '<table id="example-2" class="table table-hover table-striped table-bordered">
		    	<thead>
		    		<tr class="bg-warning-700 color-white">
		    			<th>NO</th>
		    			<th>NIK</th>
		    			<th>NAMA</th>
		    			<th>PLANT</th>
		    			<th>JABATAN</th>
		    			<th>DEPARTMENT</th>
		    		</tr>
		    	</thead>';
		$no=1;
		foreach ($data as $rs) {
			echo "<tr><td>$no</td><td>$rs->nik</td><td>$rs->nama_ktp</td><td>$rs->cabang</td><td>$rs->jabatan</td><td>$rs->department</td></tr>";
			$no++;
		}

	}

	public function cari_jadwal()
	{
		$tg1=$this->input->post('tgl1');
		$tg2=$this->input->post('tgl2');
		if (!empty($tg1) and !empty($tg2)) {
			$param="b.tanggal_pindah between '$tg1' and '$tg2'";
		}else{
			$param="";
		}
		$data=$this->model_dashboard->schedule_pindah($param);

		echo '<table id="example-5" class="table table-hover table-striped table-bordered">
		    		<thead>
			    		<tr class="bg-warning-700 color-white">
			    			<th>NO</th>
			    			<th>NIK</th>
			    			<th>NAMA</th>
			    			<th>PLANT</th>
			    			<th>KODE JAM AWAL</th>
			    			<th>KODE JAM PINDAH</th>
			    			<th>KETERANGAN</th>
			    			<th>TANGGAL PINDAH</th>
			    			<th>AKSI</th>
			    		</tr>
			    	</thead>';
		$no=1;
		foreach ($data as $rs) {
			$tgl_sc=$this->format->TanggalIndo($rs->tanggal_pindah);
			echo "<tr><td>$no</td><td>$rs->nik</td><td>$rs->nama_ktp</td><td>$rs->cabang</td><td>$rs->kode_jam_asal</td><td>$rs->kode_jam_pindah</td><td>$rs->keterangan</td><td>$tgl_sc</td><td><a href='karyawanController/profil/$view_res->nik'><span class='label label-info'>View Detail</span></a></td></tr>";
			$no++;
		}
	}

	public function cari_bpjs_kesehatan()
	{
		$bln = $this->input->post('bln',true);
		$thn = $this->input->post('thn',true); 
		$data = $this->model_dashboard->bpjs_kesehatan($bln,$thn);
		//echo $this->db->last_query();
		echo '<table id="example-6" class="table table-hover table-striped table-bordered">
		    		<thead>
			    		<tr class="bg-warning-700 color-white">
			    			<th>NO</th>
			    			<th>NIK</th>
			    			<th>NAMA</th>
			    			<th>PLANT</th>
			    			<th>TANGGAL DAFTAR</th>
			    		</tr>
			    	</thead><tbody>';
		$no=1;
		foreach ($data as $view_bpjs1) {
			$tgl_bpjs1=$this->format->TanggalIndo($view_bpjs1->bulan_ambil);
			echo "<tr><td>$no</td><td>$view_bpjs1->nik</td><td>$view_bpjs1->nama_ktp</td><td>$view_bpjs1->cabang</td><td>$tgl_bpjs1</td></tr>";
			$no++;
		}
		echo '</tbody></table>';
	}

	public function cari_bpjs_tenaga()
	{
		$bln = $this->input->post('bln',true);
		$thn = $this->input->post('thn',true); 
		$data = $this->model_dashboard->bpjs_ketenagakerjaan($bln,$thn);
		echo '<table id="example-6" class="table table-hover table-striped table-bordered">
		    		<thead>
			    		<tr class="bg-warning-700 color-white">
			    			<th>NO</th>
			    			<th>NIK</th>
			    			<th>NAMA</th>
			    			<th>PLANT</th>
			    			<th>TANGGAL DAFTAR</th>
			    		</tr>
			    	</thead><tbody>';
		$no=1;
		foreach ($data as $view_bpjs1) {
			$tgl_bpjs2=$this->format->TanggalIndo($view_bpjs1->bulan_ambil);
			echo "<tr><td>$no</td><td>$view_bpjs1->nik</td><td>$view_bpjs1->nama_ktp</td><td>$view_bpjs1->cabang</td><td>$tgl_bpjs2</td></tr>";
			$no++;
		}
		echo '</tbody></table>';
	}

	public function hapus()
	{
		$id=$this->input->post('id');
		$notif=$this->input->post('notif');
		$data=array(
					"id" => $id,
					"notifikasi" => $notif,
					"entry_user" => $this->session->userdata('username')
			);
		$this->db->insert('tab_notifikasi_aktif',$data);

		echo "sukses";
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */