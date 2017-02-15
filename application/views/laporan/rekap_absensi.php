<link rel="stylesheet" href="<?=base_url()?>/assets/styles/bootstrap.css" />
<div align="center">
	<img width="100%" src="<?=base_url()?>assets/img/logo.png">
</div>
<div align="center">
<h4 align="center" style="font-weight: bold;">Rekapitulasi Absensi Karyawan</h4>
<?php
$nama_bulan="bln Januari Februari Maret April Mei Juni Juli Agustus September Oktober November Desember";
$arr_nama=explode(" ", $nama_bulan);
echo "<h6 align='center'>Bulan $arr_nama[$bulan] Tahun $tahun</h6>";
$kalender=CAL_GREGORIAN;
$x=cal_days_in_month($kalender, $bulan, $tahun);
?>
</div>
<hr>
<div class="table-responsive">
	<table class="table table-bordered">
		<tr>
			<th rowspan="2">No</th>
			<th rowspan="2">NIK</th>
			<th colspan="<?=$x?>" align="center">Tanggal Absensi</th>
			<th colspan="5">Kalkulasi Absensi</th>
		</tr>
		<tr>
		<?php
			for ($i=1; $i <=$x ; $i++) { 
				echo "<th>".$i."</th>";
			}
		?>
			<th>H</th>
			<th>T</th>
			<th>CT</th>
			<th>I</th>
			<th>A</th>
		</tr>
		<?php
			$data=$this->db->where("month(jam_masuk)",$bulan)->where("year(jam_masuk)",$tahun)->get('tab_absensi_masuk')->result();
			$no=1;$cek="";
			foreach ($data as $rs) {
				echo "<tr><td>$no</td><td>$rs->nik</td>";
				$terlambat=0;$hadir=0;$liburan=0;$izinan=0;$cutian=0;$absen=0;
				for ($a=1; $a <= $x; $a++) { 
					$tgal=$a.'-'.$bulan.'-'.$tahun;
					$form_tgl=date("Y-m-d",strtotime($tgal));
					$jam=$this->db->where("date(jam_masuk)",$form_tgl)
								  ->where("nik",$rs->nik)
								  ->get("tab_absensi_masuk")
								  ->row();
					if(count($jam)>=1) {
						if ($jam->status == "Terlambat") {
							if ($cek=="") {
								echo "<td>T</td>";
								$terlambat++;
								$cek="Terlambat";
							} else {
								$cek_hadir=$this->db->where("date(jam_masuk)",$form_tgl)
											  ->where("nik",$rs->nik)
											  ->where("status !=",$cek)
											  ->get("tab_absensi_masuk")
											  ->num_rows();
								if ($cek_hadir==1) {
									echo "<td>H</td>";
									$hadir++;		
								} else {
									echo "<td>T</td>";
									$terlambat++;
								}
								$cek="";
							}
						} else {
							if ($cek=="") {
								echo "<td>H</td>";
								$hadir++;
								$cek="On Time";
							} else {
								$cek_hadir=$this->db->where("date(jam_masuk)",$form_tgl)
											  ->where("nik",$rs->nik)
											  ->like("status !=",$cek)
											  ->get("tab_absensi_masuk")
											  ->num_rows();
								if ($cek_hadir==1) {
									echo "<td>T</td>";
									$terlambat++;		
								} else {
									echo "<td>H</td>";
									$hadir++;
								}
								$cek="";
							}
						}
					} else {
						$libur=$this->db->where("(tanggal_mulai <= '".$form_tgl."' and tanggal_selesai >='".$form_tgl."')", NULL)
										->get("tab_hari_libur")
										->row();
						$cuti=$this->db
										->where("((tanggal_mulai <= '".$form_tgl."' and tanggal_finish >='".$form_tgl."'))", NULL)
										->where('nik',$rs->nik)
										->get("tab_cuti")
										->row();
						$izin=$this->db
										->where("((tanggal_mulai <= '".$form_tgl."' and tanggal_finish >='".$form_tgl."'))", NULL)
										->where('nik',$rs->nik)
										->get("tab_izin")
										->row();
						if(count($libur)==1) {
							echo "<td style='background:red'>L</td>";
							$liburan++;
						} elseif (count($cuti)==1) {
							echo "<td>CT</td>";
							$cutian++;
						} elseif (count($izin)==1) {
							$izinan++;
							echo "<td>I</td>";
						} else {
							$absen++;
							echo "<td>A</td>";
						}
					}
				}
				echo "<td>$hadir</td><td>$terlambat</td><td>$cutian</td><td>$izinan</td><td>$absen</td></tr>";
				$no++;
			}
		?>
	</table>
	<div class="col-md-12">
		Keterangan :
		<table width="100%">
			<tr>
				<td width="5%">A</td>
				<td width="2%">=</td>
				<td>Absen</td>
			</tr>
			<tr>
				<td width="5%">I</td>
				<td width="2%">=</td>
				<td>Izin</td>
			</tr>
			<tr>
				<td width="5%">CT</td>
				<td width="2%">=</td>
				<td>Cuti</td>
			</tr>
			<tr>
				<td width="5%">H</td>
				<td width="2%">=</td>
				<td>Hadir Tepat Waktu</td>
			</tr>
			<tr>
				<td width="5%">T</td>
				<td width="2%">=</td>
				<td>Hadir Terlambat</td>
			</tr>
			<tr>
				<td width="5%">L</td>
				<td width="2%">=</td>
				<td>Libur</td>
			</tr>
		</table>	
	</div>
</div>
