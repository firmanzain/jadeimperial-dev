<link rel="stylesheet" href="<?=base_url()?>/assets/styles/bootstrap.css" />
<div align="center">
	<img width="100%" src="<?=base_url()?>assets/img/logo.png">
</div>
<h4 align="center">Rekap Schedule Karyawan</h4>
<?php
$nama_bulan="bln Januari Februari Maret April Mei Juni Juli Agustus September Oktober November Desember";
$arr_nama=explode(" ", $nama_bulan);
echo "<center><b>$arr_nama[$bulan] $tahun</b></center>";
?>
<hr>
<div class="table-responsive">
	<table class="table table-bordered">
		<tr>
			<th rowspan="2">No</th>
			<th rowspan="2">NIK</th>
			<th colspan="31" align="center">Tanggal</th>
		</tr>
		<tr>
		<?php
			$x=$this->db->where("month(tanggal)",$bulan)
						->where("year(tanggal)",$tahun)
						->group_by('tanggal')
						->get("tab_jadwal_karyawan")->num_rows();
			for ($i=1; $i <=$x ; $i++) { 
				echo "<th>$i</th>";
			}
		?>
		</tr>
		<?php
			$data=$this->db->where("month(tanggal)",$bulan)->where("year(tanggal)",$tahun)->group_by('nik')->get('tab_jadwal_karyawan')->result();
			$no=1;
			foreach ($data as $rs) {
				echo "<tr><td>$no</td><td>$rs->nik</td>";
				for ($a=1; $a <= $x; $a++) { 
					$jam=$this->db->where("month(tanggal)",$bulan)
								  ->where("DAYOFMONTH(tanggal)",$a)
								  ->where("year(tanggal)",$tahun)
								  ->where("nik",$rs->nik)
								  ->get("tab_jadwal_karyawan")
								  ->row();
				if(count($jam->kode_jam)>="1")
				echo "<td>$jam->kode_jam</td>";
				else
				echo "<td></td>";
				}
				echo "</tr>";
				$no++;
			}
		?>
	</table>
</div>
