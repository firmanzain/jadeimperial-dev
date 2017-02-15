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
$data_thr=explode(':', $data);
$num=$data_thr[0];
$tahun=date('Y',strtotime($data_thr[10]));
if(!empty($num)){
    $no_awal=$num+1;
    if ($no_awal<10) {
    $no_thr='000'.$no_awal.'/'.$data_thr[3].'/'.date('m',strtotime($data_thr[10])).'/'.$tahun;
    }elseif ($no_awal>9 && $no_awal<99) {
      $no_thr='00'.$no_awal.'/'.$data_thr[3].'/'.date('m',strtotime($data_thr[10])).'/'.$tahun;
    }elseif ($no_awal>99 && $no_awal<999) {
      $no_thr='0'.$no_awal.'/'.$data_thr[3].'/'.date('m',strtotime($data_thr[10])).'/'.$tahun;
    }else{
      $no_thr=$no_awal.'/'.$data_thr[3].'/'.date('m',strtotime($data_thr[10])).'/'.$tahun;
    }
}else {
    $no_thr='0001/'.$data_thr[3].'/'.date('m',strtotime($data_thr[10])).'/'.$tahun;
}
?>
<link rel="stylesheet" href="<?=base_url()?>/assets/styles/bootstrap.css" />
<div style="padding: 3px; border: 1px solid #000; width: 300px;">
	<?=$no_thr?>
</div>
<div align="center">
  <img width="100%" src="<?=base_url()?>assets/img/logo.png">
</div>
<h5 align="center"><?=$data_thr[9]?></h5>
<div>
	<table width="100%" border="0">
		<tr>
			<td width="40%">NIK</td>
			<td width="5%">:</td>
			<td><?=$data_thr[1]?></td>
		</tr>
		<tr>
			<td>NAMA</td>
			<td>:</td>
			<td><?=$data_thr[2]?></td>
		</tr>
		<tr>
			<td>Jabatan</td>
			<td>:</td>
			<td><?=$data_thr[5]?></td>
		</tr>
		<tr>
			<td>THR</td>
			<td>:</td>
			<td><b><?=$data_thr[6]?></b></td>
		</tr>
		<tr>
			<td>Pph THR</td>
			<td>:</td>
			<td><?=$data_thr[7]?></td>
		</tr>
		<tr>
			<td>THR Diterima</td>
			<td>:</td>
			<td><b><?=$data_thr[8]?></b></td>
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