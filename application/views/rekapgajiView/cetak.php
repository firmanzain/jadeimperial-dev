<?php
   if ($data==true) {
		$tampil=$data;
		$a = '60900';
				$b = '30450';
				$c = $tampil->gaji_pokok;;
			$total = $c - ($a + $b);
	$k=$this->db->where('nik',$tampil->nik);
	$k1=$this->db->get('tab_karyawan')->row();
	$skb=$this->db->where('nik',$tampil->nik);
	$skkb=$this->db->get('tab_bpjs')->row();
	if($p1->num_rows == '1'){
		$s = 'II/ III /';
		$i = 'I';
	}else if($p1->num_rows == '2'){
		$s = 'III';
		$i = 'II';
	}
	if($k1->jenis_kelamin == 'Laki-laki'){
		$sa= 'Saudara';
	}else{
		$sa= 'Saudari';
	}
				$bulan1= substr($tampil->tanggal_kerja, 5,2);
				$tgl1= substr($tampil->tanggal_kerja, 8,2);
				$tahun1= substr($tampil->tanggal_kerja, 0,4);
				$bulan2= substr($tampil->tanggal_resign, 5,2);
			if(strtolower($bulan1) == '01'){$bln1 = 'Januari'; }if(strtolower($bulan1) == '02'){$bln1 = 'Februari'; }if(strtolower($bulan1) == '03'){$bln1 = 'Maret'; }if(strtolower($bulan1) == '04'){$bln1 = 'April'; }if(strtolower($bulan1) == '05'){$bln1 = 'Mei'; }if(strtolower($bulan1) == '06'){$bln1 = 'Juni'; }if(strtolower($bulan1) == '07'){$bln1 = 'Juli'; }if(strtolower($bulan1) == '08'){$bln1 = 'Agustus'; }if(strtolower($bulan1) == '09'){$bln1 = 'September'; }if(strtolower($bulan1) == '10'){$bln1 = 'Oktober'; }if(strtolower($bulan1) == '11'){$bln1 = 'November'; }if(strtolower($bulan1) == '12'){$bln1 = 'Desember'; }
				$bulan2= substr($tampil->tanggal_resign, 5,2);
				$tgl2= substr($tampil->tanggal_resign, 8,2);
				$tahun2= substr($tampil->tanggal_resign, 0,4);
			if(strtolower($bulan2) == '01'){$bln2 = 'Januari'; }if(strtolower($bulan2) == '02'){$bln2 = 'Februari'; }if(strtolower($bulan2) == '03'){$bln2 = 'Maret'; }if(strtolower($bulan2) == '04'){$bln2 = 'April'; }if(strtolower($bulan2) == '05'){$bln2 = 'Mei'; }if(strtolower($bulan2) == '06'){$bln2 = 'Juni'; }if(strtolower($bulan2) == '07'){$bln2 = 'Juli'; }if(strtolower($bulan2) == '08'){$bln2 = 'Agustus'; }if(strtolower($bulan2) == '09'){$bln2 = 'September'; }if(strtolower($bulan2) == '10'){$bln2 = 'Oktober'; }if(strtolower($bulan2) == '12'){$bln2 = 'November'; }if(strtolower($bulan2) == '12'){$bln2 = 'Desember'; }
                  
    ?>
	<!--<title>Rekap Gaji <?=$k1->nama_ktp;?></title>-->
	<style>
		#container{
			padding-top:15px;
			
		}
		#ket{
			margin-left:50px;
			padding-top:10px;
		}
		#no{
			font-size:17px;
			margin-left:175px;
			
		}
		#tgl{
			font-size:17px;
			margin-left:235px;
			font-style:bold;
			
		}
	</style>
<div id="container">
<div style="margin-left:100px;">No: <?=$tampil->id_karyawan?></div><br><br>
<table  align="center"><tr><td><img src="<?=base_url()?>assets/assets/images/logo.png"></td>
<td><div style="font-size:30px;">PT. CITRA RASA NINUSA</div></td></tr></table>
<table  align="center">
<tr><td><div style="font-size:30px;"><?=date('M Y');?></div></td></tr>
</table><br><br>
<hr style="margin-top:-30px;color:black;width:600px;">
<hr style="margin-top:-40px;color:black;width:600px;"><br><br>
<div style="margin-left:100px;">
<table>
	<tr>
		<td>Nama</td>
		<td width="120px"></td>
		<td></td>
		<td>:</td>
		<td><?=$tampil->nama_ktp?></td>
	</tr>
	<tr>
		<td>NIK</td>
		<td></td>
		<td></td>
		<td>:</td>
		<td><?=$tampil->nik?></td>
	</tr>
	<tr>
		<td>Jabatan</td>
		<td></td>
		<td></td>
		<td>:</td>
		<td><?=$tampil->jabatan?></td>
	</tr>
	<tr>
		<td>Gaji Bruto</td>
		<td></td>
		<td></td>
		<td>:</td>
		<td><?=$tampil->gaji_pokok?></td>
	</tr>
	<tr>
		<td>Extra</td>
		<td></td>
		<td></td>
		<td>:</td>
		<td><?=$tampil->extra?></td>
	</tr>
</table>
</div><br>
<div style="margin-left:100px;">
<h3><u>POTONGAN</u></h3>
<table>
	<tr>
		<td>PPh 21</td>
		<td width="130px"></td>
		<td></td>
		<td>:</td>
		<td><?=$tampil->pph?></td>
	</tr>
	<tr>
		<td>DP Cuti</td>
		<td></td>
		<td></td>
		<td>:</td>
		<td><?=$tampil->dp?></td>
	</tr>
	<tr>
		<td>JHT 2%</td>
		<td></td>
		<td></td>
		<td>:</td>
		<td>60900</td>
	</tr>
	<tr>
		<td>BPJS 1% </td>
		<td></td>
		<td></td>
		<td>:</td>
		<td>30450</td>
	</tr>
</table>
</div><br><br><br>
<div style="margin-left:100px;">
<table>
	<tr>
		<td>
<h3><u>Gaji Yang Diterima</u></h3></td>
		<td width="10px"></td>
		<td></td>
		<td>:</td>
		<td><?=$total?></td>
	</tr>
</table>
</div>
</div>
<?php } ?>