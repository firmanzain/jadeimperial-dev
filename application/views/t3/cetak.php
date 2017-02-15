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

<?php
$data_t3=explode(':', $data);

$num 	= $data_t3[0];

$tahun 	= date($data_t3[9]);

if(!empty($num)){
    $no_awal=$num+1;

    if ($no_awal<10) {
    $no_t3='000'.$no_awal.'/'.$data_t3[3].'/'.date('m',strtotime($data_t3[9])).'/'.$tahun;
    }elseif ($no_awal>9 && $no_awal<99) {
      $no_t3='00'.$no_awal.'/'.$data_t3[3].'/'.date('m',strtotime($data_t3[9])).'/'.$tahun;
    }elseif ($no_awal>99 && $no_awal<999) {
      $no_t3='0'.$no_awal.'/'.$data_t3[3].'/'.date('m',strtotime($data_t3[9])).'/'.$tahun;
    }else{
      $no_t3=$no_awal.'/'.$data_t3[3].'/'.date('m',strtotime($data_t3[9])).'/'.$tahun;
    }
}
else 
{
    $no_t3='0001/'.$data_t3[3].'/'.date('m',strtotime($data_t3[9])).'/'.$tahun;
}
?>

<link rel="stylesheet" href="<?=base_url()?>/assets/styles/bootstrap.css" />

<div style="padding: auto; border: 1px solid #000; width: 300px;">
	<?=$no_t3?>
</div>
<div align="center">
  <img width="100%" src="<?=base_url()?>assets/img/logo.png">
</div>
<h4 align="center"><?=$data_t3[6]?></h4>
<div>
	<table width="100%" border="0">
		<tr>
			<td width="40%">NIK</td>
			<td width="5%">:</td>
			<td><?=$data_t3[1]?></td>
		</tr>
		<tr>
			<td>NAMA</td>
			<td>:</td>
			<td><?=$data_t3[2]?></td>
		</tr>
		<tr>
			<td>Jabatan</td>
			<td>:</td>
			<td><?=$data_t3[4]?></td>
		</tr>
		<tr>
			<td>Jumlah Hadir</td>
			<td>:</td>
			<td><b><?=$data_t3[5]?></b></td>
		</tr>
		<tr>
			<td>Tarif T3</td>
			<td>:</td>
			<td><?=$data_t3[7]?></td>
		</tr>
		<tr>
			<td>Total T3 Diterima</td>
			<td>:</td>
			<td><b><?=$data_t3[8]?></b></td>
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