<link rel="stylesheet" href="<?=base_url()?>/assets/styles/bootstrap.css" />
<div class='row'>
<div class="col-md-12">
<div align="left">
	<img width="30%" height="50px" src="<?=base_url()?>assets/img/jamsostek.png">
</div>
<h4 align="center">PT CITRA RASA NINUSA</h4>
<?php
	if (!empty($cabang)) {
		echo "<h5 align=center>PLANT $cabang->cabang</h5>";
	}
?>
<h6 align="center">Bulan <?=$bulan.' '.$tahun?></h6>
<hr>
<?php
$bpjs_ket=$this->db->where('id_bpjs',1)->get('tab_master_bpjs')->row();
?>
	<table class="table table-bordered">
		<tr>
			<th rowspan="2">NO</th>
			<th rowspan="2">NAMA KARYAWAN</th>
			<th rowspan="2">SEX</th>
			<th rowspan="2">B/L</th>
			<th rowspan="2">UPAH</th>
			<th colspan="2" style="text-align: center;">JHT 5.7%</th>
			<th rowspan="2">JKK <?=$bpjs_ket->jkk?>%</th>
			<th rowspan="2">JKM <?=$bpjs_ket->jkm?>%</th>
			<th rowspan="2">SALDO</th>
			<th rowspan="2">PLANT</th>
		</tr>
		<tr>
			<th>Karyawan <?=$bpjs_ket->jht_2?>%</th>
			<th>Perusahaan <?=$bpjs_ket->jht_1?>%</th>
		</tr>
		<?php
		$no=1;
		$total_jht1=0;$total_jht2=0;$total_jkk=0;$total_jkm=0;$total_gaji=0;$total_saldo=0;
			foreach ($data as $rs) {
			// if ($rs->nik_resign==NULL||$rs->tanggal_masuk>$rs->tanggal_resign) {
			// 	if ($rs->gaji_bpjs>0) {
				$jht1=$rs->gaji_bpjs*$bpjs_ket->jht_2/100;
				$jht2=$rs->gaji_bpjs*$bpjs_ket->jht_1/100;
				$jkk=$rs->gaji_bpjs*$bpjs_ket->jkk/100;
				$jkm=$rs->gaji_bpjs*$bpjs_ket->jkm/100;
				$saldo=$jht1+$jht2+$jkk+$jkm;
				$total_jht1 += $jht1;
				$total_jht2 += $jht2;
				$total_jkk += $jkk;
				$total_jkm += $jkm;
				$total_gaji+=$rs->gaji_bpjs;
				$total_saldo += $saldo;
				echo "<tr><td>$no</td><td>$rs->nama_ktp</td><td>$rs->jenis_kelamin</td><td>L</td><td>".$this->format->indo($rs->gaji_bpjs)."</td><td>".$this->format->indo($jht1)."</td><td>".$this->format->indo($jht2)."</td><td>".$this->format->indo($jkk)."</td><td>".$this->format->indo($jkm)."</td><td>".$this->format->indo($saldo)."</td><td>$rs->cabang</td></tr>";
				$no++;
			// 	}
			// }
			}
		?>
		<tr>
			<td></td>
			<td colspan="3"><b>Total</b></td>
			<td style="font-weight: bold;"><?=$this->format->indo($total_gaji)?></td>
			<td style="font-weight: bold;"><?=$this->format->indo($total_jht1)?></td>
			<td style="font-weight: bold;"><?=$this->format->indo($total_jht2)?></td>
			<td style="font-weight: bold;"><?=$this->format->indo($total_jkk)?></td>
			<td style="font-weight: bold;"><?=$this->format->indo($total_jkm)?></td>
			<td style="font-weight: bold;"><?=$this->format->indo($total_saldo)?></td>
			<td></td>
		</tr>
	</table>
</div>
</div>