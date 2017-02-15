<link rel="stylesheet" href="<?=base_url()?>/assets/styles/bootstrap.css" />
<div align="left">
	<img width="30%" height="50px" src="<?=base_url()?>assets/img/jamsostek.png">
</div>
<h4 align="center">PT CITRA RASA NINUSA</h4>
<?php
	if (!empty($cabang)) {
		echo "<h5 align=center>PLANT $cabang->cabang</h5>";
	}
?>
<h6 align="center">Pembayaran Untuk <?=$bulan.' '.$tahun?> Dibayar <?=$bulan.' '.$tahun?></h6>
<hr>

<?php
$jml_row=count($jumlah_karyawan);
$bpjs_ket=$this->db->where('id_bpjs',1)->get('tab_master_bpjs')->row();
?>
<table class="table table-borderd">
	<tr>
		<th colspan="3"></th>
		<th style="text-align: center;">Upah</th>
		<th style="text-align: center;">Jumlah Karyawan</th>
		<th style="text-align: center;">Total</th>
	</tr>
	<tr>
		<th rowspan="<?=$jml_row+1?>">a.</th>
		<th rowspan="<?=$jml_row+1?>">JKK</th>
		
	</tr>
	<?php
	$total_jkk = 0;
	$total_jht1 = 0;
	$total_jht2 = 0;
	$total_jkm = 0;
	$total_karyawan = 0;
	foreach ($jumlah_karyawan as $rs) {
		$upah=$this->format->indo($rs->gaji_bpjs);
		$jkk=$this->format->indo($rs->gaji_bpjs*$bpjs_ket->jkk/100*$rs->jml);
		$total_jkk+=$rs->gaji_bpjs*$bpjs_ket->jkk/100*$rs->jml;
		echo "<tr><td>$bpjs_ket->jkk%</td><td>$upah</td><td align='center'>$rs->jml</td><td align='right'>$jkk</td></tr>";
	}
	?>
	<tr>
		<th rowspan="<?=($jml_row*2)+1?>">b.</th>
		<th rowspan="<?=($jml_row*2)+1?>">JHT</th>
	</tr>
	<?php
	foreach ($jumlah_karyawan as $rs) {
		$upah=$this->format->indo($rs->gaji_bpjs);
		$jht1=$this->format->indo($rs->gaji_bpjs*$bpjs_ket->jht_1/100*$rs->jml);
		$total_jht1+=$rs->gaji_bpjs*$bpjs_ket->jht_1/100*$rs->jml;
		echo "<tr><td>$bpjs_ket->jht_1%</td><td>$upah</td><td align='center'>$rs->jml</td><td align='right'>$jht1</td></tr>";
	}
	?>
	<?php
	foreach ($jumlah_karyawan as $rs) {
		$upah=$this->format->indo($rs->gaji_bpjs);
		$jht2=$this->format->indo($rs->gaji_bpjs*$bpjs_ket->jht_2/100*$rs->jml);
		$total_jht2+=$rs->gaji_bpjs*$bpjs_ket->jht_2/100*$rs->jml;
		echo "<tr><td>$bpjs_ket->jht_2%</td><td>$upah</td><td align='center'>$rs->jml</td><td align='right'>$jht2</td></tr>";
	}
	?>
	<tr>
		<th rowspan="<?=$jml_row+1?>">c.</th>
		<th rowspan="<?=$jml_row+1?>">JHT</th>
	</tr>
	<?php
	foreach ($jumlah_karyawan as $rs) {
		$upah=$this->format->indo($rs->gaji_bpjs);
		$jkm=$this->format->indo($rs->gaji_bpjs*$bpjs_ket->jkm/100*$rs->jml);
		echo "<tr><td>$bpjs_ket->jkm%</td><td>$upah</td><td align='center'>$rs->jml</td><td align='right'>$jkm</td></tr>";
		$total_jkm+=$rs->gaji_bpjs*$bpjs_ket->jkm/100*$rs->jml;
		$total_karyawan += $rs->jml;
	}
	$total_semua=$total_jkm+$total_jht2+$total_jht1+$total_jkk;
	?>
	<tr>
		<th colspan="5"></th>
		<td></td>
	</tr>
	<tr>
		<th colspan="5">Total</th>
		<td align='right'><?=$this->format->indo($total_semua)?></td>
	</tr>
	<tr>
		<th colspan="5">Selisih Bayar</th>
		<td></td>
	</tr>
	<tr>
		<th colspan="5">Total Yang Dibayarkan</th>
		<td align='right'><?=$this->format->indo($total_semua)?></td>
	</tr>
</table>
<br><br>
<table class="table table-borderd">
	<tr>
		<td>Rincian :</td>
		<td></td>
		<td></td>
	</tr>
	<?php
	$total_saldo=0;$total_emp=0;
	foreach ($jumlah_karyawan2 as $row) {
		$jht1 			= $row->total * $bpjs_ket->jht_2/100;
		$jht2 			= $row->total * $bpjs_ket->jht_1/100;
		$jkk 			= $row->total * $bpjs_ket->jkk/100;
		$jkm 			= $row->total * $bpjs_ket->jkm/100;
		$saldo 			= $jht1 + $jht2 + $jkk + $jkm;
		$total_saldo 	+= $saldo;
		$total_emp 		+= $row->jml;
		echo "<tr><td>$row->nama_cabang</td><td>".$this->format->indo($saldo)."</td><td style='text-align: right;'>".$row->jml." orang</td></tr>";
	}
	?>
	<tr>
		<td><b>TOTAL : </b></td>
		<td><b><?php echo $this->format->indo($total_saldo);?></b></td>
		<td style='text-align: right;'><b><?php echo $total_emp;?> orang</b></td>
	</tr>
</table>
<br><br>
<table style="text-align: center; width: 100%">
	<tr>
		<td height="100px;">Prepared By,</td>
		<td>Checked By,</td>
		<td>ACC By,</td>
	</tr>
	<tr>
		<td>(.................................)</td>
		<td>(.................................)</td>
		<td>(.................................)</td>
	</tr>
</table>