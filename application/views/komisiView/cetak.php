<style>
  .tabel{
  border-collapse:collapse;
  width:100%;}
  .tabel th{
  background:#BEBEBE;
  color:#000;
  border:#000000 solid 1px;
  padding:5px;}
  .tabel td{
  border:#000000 solid 1px;
  padding:5px;}
</style>
<link rel="stylesheet" href="<?=base_url()?>/assets/styles/bootstrap.css" />
<div align="center">
  <img width="100%" src="<?=base_url()?>assets/img/logo.png">
</div>
<h6 align="center"> SLIP KOMISI KARYAWAN</h6>
<hr>
<div>
	<table width="100%" border="0">
		<tr>
			<td width="40%">NIK</td>
			<td width="5%">:</td>
			<td><?=$data->nik?></td>
		</tr>
		<tr>
			<td>NAMA</td>
			<td>:</td>
			<td><?=$data->nama_ktp?></td>
		</tr>
		<tr>
			<td>Jabatan</td>
			<td>:</td>
			<td><?=$data->jabatan?></td>
		</tr>
		<tr>
			<td>PLANT</td>
			<td>:</td>
			<td><?=$data->cabang?></td>
		</tr>
		<tr>
			<td>Omset Bulan Ini</td>
			<td>:</td>
			<td><b><?=$this->format->indo($data->omset)?></b></td>
		</tr>
		<tr>
			<td>Komisi Bulan Ini</td>
			<td>:</td>
			<td><b><?=$this->format->indo($data->komisi)?></b></td>
		</tr>
		<tr>
			<td>Tanggal Ambil</td>
			<td>:</td>
			<td><b><?=$this->format->TanggalIndo($data->bulan)?></b></td>
		</tr>
	</table>
</div>
<div align="left">
<p style="margin-top: 10px;">
Surabaya, <?=$this->format->TanggalIndo(date('Y-m-d'))?>
<br>
Mengetahui,</p>

<p style="margin-top: 50px;">(................................)</p>
</div>