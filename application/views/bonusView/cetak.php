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
<h6 align="center"> SLIP BONUS KARYAWAN</h6>
<h6 align="center"> <?=$this->format->BulanIndo(date('m')).' '.date('Y')?></h6>

<hr>
<div>
<p style="font-weight: bold;"><u>Karyawan</u></p>
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
		<td>Plant</td>
		<td>:</td>
		<td><?=$data->cabang?></td>
	</tr>
</table>
<p style="font-weight: bold; margin-top: 10px;"><u>Bonus</u></p>
<table width="100%" border="0">
		<tr>
			<td width="40%">Nominal</td>
			<td width="5%">:</td>
			<td><?=$this->format->indo($data->nominal)?></td>
		</tr>
		<tr>
			<td>Grade & Senioritas</td>
			<td>:</td>
			<td><?=$this->format->indo($data->grade+$data->senioritas)?></td>
		</tr>
		<tr>
			<td>Prota</td>
			<td>:</td>
			<td><?=$this->format->indo($data->prota)?></td>
		</tr>
		<tr>
			<td>Persentase</td>
			<td>:</td>
			<td><?=$this->format->indo($data->persentase)?></td>
		</tr>
		<tr>
			<td>Total Bonus</td>
			<td>:</td>
			<td><b><?=$this->format->indo($data->persentase+$data->prota+$data->grade+$data->Senioritas+$data->nominal)?></b></td>
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