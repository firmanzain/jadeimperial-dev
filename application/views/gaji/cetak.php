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
$data_gaji=explode(':', $data);
// var_dump($data_gaji);
$num=$data_gaji[9];
$tahun=date('Y');
if(!empty($num)){
    $no_awal=$num+1;
    if ($no_awal<10) {
    $no_gaji='000'.$no_awal.'/'.$data_gaji[10].'/'.date('m').'/'.$tahun;
    }elseif ($no_awal>9 && $no_awal<99) {
      $no_gaji='00'.$no_awal.'/'.$data_gaji[10].'/'.date('m').'/'.$tahun;
    }elseif ($no_awal>99 && $no_awal<999) {
      $no_gaji='0'.$no_awal.'/'.$data_gaji[10].'/'.date('m').'/'.$tahun;
    }else{
      $no_gaji=$no_awal.'/'.$data_gaji[10].'/'.date('m').'/'.$tahun;
    }
}else {
    $no_gaji='0001/'.$data_gaji[10].'/'.date('m').'/'.$tahun;
}
?>
<link rel="stylesheet" href="<?=base_url()?>/assets/styles/bootstrap.css" />
<div style="padding: auto; border: 1px solid #000; width: 300px;">
	<?=$no_gaji?>
</div>
<div align="center">
  <img width="100%" src="<?=base_url()?>assets/img/logo.png">
</div>
<h4 align="center"><?=$this->format->BulanIndo(date('m')).' '.$tahun?></h4>
<div>
	<table width="100%" border="0">
		<tr>
			<td width="40%">NIK</td>
			<td width="5%">:</td>
			<td><?=$data_gaji[0]?></td>
		</tr>
		<tr>
			<td>NAMA</td>
			<td>:</td>
			<td><?=$data_gaji[1]?></td>
		</tr>
		<tr>
			<td>Jabatan</td>
			<td>:</td>
			<td><?=$data_gaji[12]?></td>
		</tr>
		<tr>
			<td>Gaji Pokok</td>
			<td>:</td>
			<td><b><?=$this->format->indo($data_gaji[2])?></b></td>
		</tr>
		<tr>
			<td>Tunjangan Jabatan</td>
			<td>:</td>
			<td><b><?=$this->format->indo($data_gaji[3])?></b></td>
		</tr>
		<tr>
			<td>Extra</td>
			<td>:</td>
			<td><b><?=$this->format->indo($data_gaji[4])?></b></td>
		</tr>
		<?php
			$cek_resign=$this->db->where('nik',$data_gaji[0])
								 ->where('month(tanggal) <= ',date('m'))
								 ->select('month(tanggal) as bln,year(tanggal) as thun')
								 ->get('tab_resign')->row();
			$gaji_rs=0;
			if (count($cek_resign)>=1) {
				$saldo_dp=$this->db->where('nik',$data[0])
								   ->where('month(bulan)',$cek_resign->bln)
								   ->where('Year(bulan)',$cek_resign->thun)
								   ->select('saldo_dp')
								   ->get('tab_master_dp')->row();
				$kalender=CAL_GREGORIAN;
				$jml_hari=cal_days_in_month($kalender, $cek_resign->bln, $cek_resign->thun);
				$gaji_rs=$data_gaji[2]/$jml_hari*$saldo_dp->saldo_dp;
				echo "<tr>
						<td>Gaji Resign</td>
						<td>:</td>
						<td>".$this->format->indo($gaji_rs)."</td>
						</tr>";
			}
		?>
	</table>
	<p style="margin-top: 10px; margin-bottom: 0px; font-weight: bold;">Potongan</p>
	<table width="100%" border="0">
		<tr>
			<td width="40%">Pinjaman</td>
			<td width="5%">:</td>
			<td><?=$this->format->indo($data_gaji[13])?></td>
		</tr>
		<tr>
			<td width="40%">PPH21</td>
			<td width="5%">:</td>
			<td><?=$this->format->indo($data_gaji[5])?></td>
		</tr>
		<tr>
			<td width="40%">DP Cuti</td>
			<td width="5%">:</td>
			<td><?=$this->format->indo($data_gaji[6])?></td>
		</tr>
		<tr>
			<td>JHT </td>
			<td>:</td>
			<td><?=$this->format->indo($data_gaji[7])?></td>
		</tr>
		<tr>
			<td>BPJS </td>
			<td>:</td>
			<td><?=$this->format->indo($data_gaji[8])?></td>
		</tr>
		<tr>
			<td>Gaji Bersih</td>
			<td>:</td>
			<td style="font-weight: bold;"><?=$this->format->indo($data_gaji[9]+$gaji_rs)?></td>
		</tr>
	</table>
	<!--<?php
			$param=array( 
						'nik' => $data_gaji[0],
						'month(bulan)' => date('m'),
						'approved'=>'Ya',
						'includepph' => 1
						);
			$param2=array( 
						'nik' => $data_gaji[0],
						'month(tanggal_bonus)' => date('m'),
						'approved'=>'Ya',
						'include_pph' => 1
						);
			$param3=array( 
						'nik' => $data_gaji[0],
						'month(entry_date)' => date('m'),
						'approved'=>'Ya'
						);
			$komisi=$this->db->where($param)
								->get('tab_komisi')
								->result();
			$bonus=$this->db->where($param2)
								->select("nominal+senioritas+grade+persentase+prota as total_bonus",false)
								->get('tab_bonus_karyawan')
								->row();
			$tunjangan=$this->db->where($param3)
								->get('tab_tunjangan_karyawan')
								->result();
		if (count($komisi)>=1 || count($tunjangan)>=1 || count($bonus)>=1) echo '<p style="margin-top: 10px; margin-bottom: 0px; font-weight: bold;">Include PPH</p>';
		echo "<table border='0' width='50%'>";
			if (count($komisi)>=1) {
				echo "<tr><td rowspan='".count($komisi)."'>Komisi</td><td rowspan='".count($komisi)."'>:</td>";
				foreach ($komisi as $rs_komisi) {
					echo "<td>".$this->format->indo($rs_komisi->komisi)."</td>";
				}
				echo "</tr>";
			}
			if (count($tunjangan)>=1) {
				echo "<tr><td rowspan='".count($tunjangan)."'>Komisi</td><td rowspan='".count($tunjangan)."'>:</td>";
				foreach ($tunjangan as $rs_tj) {
					echo "<td>".$this->format->indo($rs_tj->tarif)."</td>";
				}
				echo "</tr>";
			}
			if (count($bonus)>=1) {
				echo "<tr><td rowspan='".count($bonus)."'>Bonus</td><td rowspan='".count($bonus)."'>:</td>";
				echo "<td>".$this->format->indo($bonus->total_bonus)."</td>";
				echo "</tr>";
			}
		echo "</table>";
		?>-->
</div>
<div align="left">
<p style="margin-top: 10px;">
Surabaya, <?=$this->format->TanggalIndo(date('Y-m-d'))?>
<br>
Mengetahui,</p>

<p style="margin-top: 50px;">(................................)</p>
</div>