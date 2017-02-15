<link rel="stylesheet" href="<?=base_url()?>/assets/styles/bootstrap.css" />
<div class='row'>
<div class="col-md-12">
<div align="left">
	<img width="30%" height="100px" src="<?=base_url()?>assets/img/kesehatan.png">
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
	$bpjs_kes=$this->db->where('id_bpjs',2)->get('tab_master_bpjs')->row();
?>
		<table class="table table-bordered">
			<tr>
				<th rowspan="2">NO</th>
				<th rowspan="2">NAMA KARYAWAN</th>
				<th rowspan="2">SEX</th>
				<th rowspan="2">B/L</th>
				<th rowspan="2">UPAH</th>
				<th colspan="2" style="text-align: center;">JPK <?=$bpjs_kes->jpk_2+$bpjs_kes->jpk_1?>%</th>
				<th rowspan="2">SALDO</th>
				<th rowspan="2">PLANT</th>
			</tr>
			<tr>
				<th><?=$bpjs_kes->jpk_2?>%</th>
				<th><?=$bpjs_kes->jpk_1?>%</th>
			</tr>
			<?php
			$total_jpk1 = 0;
			$total_jpk2 = 0;
			$total_gaji = 0;
			$total_saldo = 0;
			$no=1;
				foreach ($data as $rs) {
				// if ($rs->nik_resign==NULL||$rs->tanggal_masuk>$rs->tanggal_resign) {
				// 	if ($rs->gaji_bpjs>0) {
					$jpk1=$rs->gaji_bpjs*$bpjs_kes->jpk_2/100;
					$jpk2=$rs->gaji_bpjs*$bpjs_kes->jpk_1/100;
					$saldo=$jpk1+$jpk2;
					$total_jpk1 += $jpk1;
					$total_jpk2 += $jpk2;
					$total_gaji+=$rs->gaji_bpjs;
					$total_saldo += $saldo;
					echo "<tr><td>$no</td><td>$rs->nama_ktp</td><td>$rs->jenis_kelamin</td><td>L</td><td>".$this->format->indo($rs->gaji_bpjs)."</td><td>".$this->format->indo($jpk1)."</td><td>".$this->format->indo($jpk2)."</td><td>".$this->format->indo($saldo)."</td><td>$rs->cabang</td></tr>";
					$no++;
				// 	}
				// }
				}
			?>
			<tr>
				<td></td>
				<td colspan="3"><b>Total</b></td>
				<td style="font-weight: bold;"><?=$this->format->indo($total_gaji)?></td>
				<td style="font-weight: bold;"><?=$this->format->indo($total_jpk1)?></td>
				<td style="font-weight: bold;"><?=$this->format->indo($total_jpk2)?></td>
				<td style="font-weight: bold;"><?=$this->format->indo($total_saldo)?></td>
				<td></td>
			</tr>
		</table>
	</div>
</div>