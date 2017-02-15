<?php
   if ($data==true) {
		$tampil=$data;
	$k=$this->db->where('nik',$tampil->nik);
	$k1=$this->db->get('tab_karyawan')->row();
	$sk=$this->db->where('nik',$tampil->nik);
	$skk=$this->db->get('tab_skk')->row();
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
	<!--<title>Surat Resign <?=$k1->nama_ktp;?></title>-->
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
<img src="<?=base_url()?>assets/assets/images/header.png"><br><br>
<table align="center" style="font-size:16px;"><tr><td><b><u>SURAT KETERANGAN PENGALAMAN KERJA</u></b></td></tr></table>
<table align="center" style="font-size:16px;"><tr><td><b>Nomor : 0<?=$skk->id_skk?>/II/HRD/2016</b></td></tr></table>
<br>
<br>
<br>
<table style="margin-left:10%;">
<tr><td>Yang bertanda tangan di bawah ini</td><td>:</td></tr></table>
<table style="margin-left:10%;">
<tr><td>Nama</td><td>: Rinaningsih Gunadi</td></tr>
<tr><td>Jabatan	</td><td>: Manajer Representative</td></tr>
<tr><td>Alamat	</td><td>: Jl. Graha Sampurna K-19, Wiyung</td></tr>
</table><br>
<table style="margin-left:10%;">
<tr><td>Dengan ini menerangkan bahwa</td><td> :</td></tr>
</table>
<table style="margin-left:10%;">
<tr><td>Nama</td><td> : <?=$tampil->nama_ktp?></td></tr>
<tr><td>Alamat</td><td>: <?=$tampil->alamat_domisili?></td></tr>
</table>
<br>
<div style="word-wrap:break-word;width:85%;margin-left:10%;">
Benar telah bekerja pada PT. CITRA RASA NINUSA terhitung sejak <?=$tgl1.' '.$bln1.' '.$tahun1?> s/d <?=$tgl2.' '.$bln2.' '.$tahun2?> dengan jabatan sebagai <?=$tampil->jabatan?>.</div>
<div style="word-wrap:break-word;width:85%;margin-left:10%;">
Selama menajdi karyawan kami, <?=$sa?> <?=$tampil->nama_ktp?> telah menunjukkan dedikasi dan loyalitas yang tinggi selama bekerja di PT. CITRA RASA NINUSA dan tidak pernah melakukan hal-hal yang merugikan perusahaan.
</div>
<div style="word-wrap:break-word;width:85%;margin-left:10%;">
Demikian surat keterangan ini dibuat dengan sebenarnya dan dapat digunakan sebagaimana mestinya.</div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<div style="word-wrap:break-word;width:85%;margin-left:10%;">
Surabaya, <?=date('d M Y')?>
<br>
<br>
<br>
<br>
<br>
<br>
<u>Rinaningsih Gunadi</u><br>
Manajer Representative
</div>
</div>
<?php } ?>