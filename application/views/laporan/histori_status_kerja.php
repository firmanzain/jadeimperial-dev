<link rel="stylesheet" href="<?=base_url()?>/assets/styles/bootstrap.css" />
<div align="center">
	<img width="100%" src="<?=base_url()?>assets/img/logo.png">
</div>
<h5 align="center">Histori Kerja Karyawan</h5>
<hr>
<div class="table-responsive">
<b>Riwayat Pergantian Status Kerja</b>
<hr>
<?php
	$this->table->set_heading(array('NO','TANGGAL','STATUS KERJA','JABATAN','DEPARTMENT','PLANT'));
    $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
        			'thead_open'=>'<thead>',
    				'thead_close'=> '</thead>',
    				'tbody_open'=> '<tbody>',
    				'tbody_close'=> '</tbody>',
    		);
    $this->table->set_template($tmp);
    if($status_kerja==true){
          $no=1;
          foreach ($status_kerja as $tampil){
	          $this->table->add_row($no,$this->format->TanggalIndo(date('Y-m-d',strtotime($tampil->masuk))),$tampil->status_kerja,$tampil->jabatan,$tampil->department,$tampil->cabang);
	          $no++;
	          $nik=$tampil->nik;
          }
          $tabel=$this->table->generate();
          echo $tabel;
     }else {
        echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
     }
?>
<b>Riwayat Kenaikan Pangkat</b>
<hr>
<?php
	$this->table->set_heading(array('NO','TANGGAL','JABATAN','DEPARTMENT','PLANT'));
    $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
        			'thead_open'=>'<thead>',
    				'thead_close'=> '</thead>',
    				'tbody_open'=> '<tbody>',
    				'tbody_close'=> '</tbody>',
    		);
    $this->table->set_template($tmp);
    $hasil=$this->db->join('tab_karyawan','tab_karyawan.nik=tab_kontrak_kerja.nik')
                        ->join('tab_jabatan','tab_jabatan.id_jabatan=tab_karyawan.jabatan')
                        ->join('tab_cabang','tab_cabang.id_cabang=tab_karyawan.cabang')
                        ->join('tab_department','tab_department.id_department=tab_karyawan.department')
                        ->select('*,tab_kontrak_kerja.entry_date as masuk')
                        ->where('tab_karyawan.nik',$nik)->get('tab_kontrak_kerja')->row();
    $this->table->add_row(1,$this->format->TanggalIndo(date('Y-m-d',strtotime($hasil->masuk))),$tampil->jabatan,$tampil->department,$tampil->cabang);
    if($status_kerja==true){
          $no=2;
          $naik=$this->db->join('tab_karyawan','tab_karyawan.nik=tab_pengangkatan.nik')
                        ->join('tab_jabatan','tab_jabatan.id_jabatan=tab_pengangkatan.jabatan2')
                        ->join('tab_cabang','tab_cabang.id_cabang=tab_karyawan.cabang')
                        ->join('tab_department','tab_department.id_department=tab_karyawan.department')
                        ->where('tab_karyawan.nik',$nik)->get('tab_pengangkatan')->result();
          foreach ($naik as $tampil){
	          $this->table->add_row($no,$this->format->TanggalIndo($tampil->tanggal_per),$tampil->jabatan,$tampil->department,$tampil->cabang);
	          $no++;

          }
          $tabel=$this->table->generate();
          echo $tabel;
     }else {
        echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
     }
?>
<b>Riwayat Absensi Karyawan</b>
<hr>
<table class="table table-bordered">
	<tr>
		<th rowspan="2" style="padding-top: 50px">NO</th>
		<th rowspan="2" style="padding-top: 50px">BULAN</th>
		<th rowspan="2" style="padding-top: 50px">TAHUN</th>
		<th colspan="2" align="center">KEHADIRAN</th>
		<th colspan="3" align="center">PERIZINAN</th>
		<th colspan="2" align="center">PERCUTIAN</th>
	</tr>
	<tr>
		<th>On Time</th>
		<th>Terlambat</th>
		<th>Absen</th>
		<th>PLG. AWAL</th>
		<th>DTG. AKHIR</th>
		<th>CUTI</th>
		<th>KHUSUS</th>
	</tr>
	<?php
		$bulan=$this->db->select('jam_masuk')->where('nik',$nik)->group_by('month(jam_masuk)')->get('tab_absensi_masuk')->result();
		if (count($bulan)>=1) {
			$no=1;
			foreach ($bulan as $rs_bln) {
				$absensi=$this->db->query('select SUM(IF(status = "Terlambat", 1, 0)) AS telat, SUM(IF(status = "On Time", 1, 0)) AS tepat from tab_absensi_masuk where nik="'.$nik.'" and month(jam_masuk)='.date('m',strtotime($rs_bln->jam_masuk)).'')->row();
				$izin=$this->db->query("select SUM(IF(jenis_izin='Tidak Dapat Masuk',lama,0)) as absen,SUM(IF(jenis_izin='Pulang Pukul',lama,0)) as pulang_dulu,SUM(IF(jenis_izin='Datang Pukul',lama,0)) as datang_telat from tab_izin where nik='$nik' and month(tanggal_mulai)='".date('m',strtotime($rs_bln->jam_masuk))."'")->row();
				$cuti=$this->db->query("select SUM(IF(cuti_khusus='Ya',lama_cuti,0)) as khusus,SUM(IF(cuti_khusus='Tidak',lama_cuti,0)) as biasa from tab_cuti where nik='$nik' and month(tanggal_mulai)='".date('m',strtotime($rs_bln->jam_masuk))."'")->row();
				echo "<tr><td>$no</td><td>".date("F",strtotime($rs_bln->jam_masuk))."</td><td>".date("Y",strtotime($rs_bln->jam_masuk))."</td><td>$absensi->tepat</td><td>$absensi->telat</td><td>$izin->absen</td><td>$izin->pulang_dulu</td><td>$izin->datang_telat</td><td>$cuti->biasa</td><td>$cuti->khusus</td></tr>";
				$no++;
			}
		}
	?>
</table>
<b>Riwayat Penggajian Karyawan</b>
<hr>
<table class="table table-bordered">
	<tr>
		<th>NO</th>
		<th>BULAN</th>
		<th>TAHUN</th>
		<th>GAJI YANG DITERIMA</th>
	</tr>
	<?php
	$gaji=$this->db->where('nik',$nik)
				   ->select('*,sum(gaji_karyawan) as gaji')
				   ->group_by('tanggal_gaji')
				   ->where('approval','2')->get('tab_gaji_karyawan')->result();
	$no=1;
	foreach ($gaji as $rs_gaji) {
		$jml_gaji=$this->format->indo($rs_gaji->gaji);
		$bulan_gaji=date('F',strtotime($rs_gaji->tanggal_gaji));
		$tahun_gaji=date('Y',strtotime($rs_gaji->tanggal_gaji));
		echo "<tr><td>$no</td><td>$bulan_gaji</td><td>$tahun_gaji</td><td>$jml_gaji</td></tr>";
		$no++;
	}
	?>
</table>
</div>