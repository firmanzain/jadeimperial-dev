<style>
  .tabel{
  border-collapse:collapse;
  width:100%;}
  .tabel th{
  background:#BEBEBE;
  color:#000;
  border:#000000 solid 1px;
  padding:3px;}
  .tabel td{
  border-top:0px;
  border-bottom:#000000 dotted 1px;
  border-left: 0px;
  border-right: 0px;
  text-align: center;
  height: 30px;
  padding:3px;}
</style>
<div style="margin: 2cm 2cm 2cm 2cm">
	<h3 style="padding-top: 2cm" align="center">SURAT PERNYATAAN</h3>
	<p>Dengan surat ini, saya yang bertanda tangan dibawah ini :</p>
	<table width="100%">
		<tr>
			<td width="30%">Nama</td>
			<td width="2%">:</td>
			<td><?=$data->nama_ktp?></td>
		</tr>
		<tr>
			<td>Alamat</td>
			<td>:</td>
			<td><?=$data->alamat_ktp?></td>
		</tr>
		<tr>
			<td>Jabatan</td>
			<td>:</td>
			<td><?=$data->jabatan?></td>
		</tr>
		<tr>
			<td>Departemen</td>
			<td>:</td>
			<td><?=$data->department?></td>
		</tr>
		<tr>
			<td>Menyatakan</td>
			<td>:</td>
			<td></td>
		</tr>
	</table>
	<table class="tabel">
		<?php
			for ($i=0; $i < 15 ; $i++) { 
				echo "<tr><td></td></tr>";
			}
		?>
	</table>
	<div style="margin-top: 20px;">
		<p>Surabaya, <?=$this->format->TanggalIndo(date('Y-m-d'))?></p>
		<p style="margin-top: 100px"><u><?=ucwords($data->nama_ktp)?></u></p>
	</div>
</div>
