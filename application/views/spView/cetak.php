<?php
   if ($data==true) {
		$tampil=$data;
	$k=$this->db->where('nik',$tampil->nik);
	$k1=$this->db->get('tab_karyawan')->row();
	$p=$this->db->where('nik',$tampil->nik);
	$p1=$this->db->get('tab_sp');
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
    ?>
	<!--<title>Surat Peringatan <?=$k1->nama_ktp;?></title>-->
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
<table align="center">
<tr><td><p style="font-size:24px;">PT. CITRA RASA NINUSA</p></td></tr>
</table>
<table align="center" style="margin-left:17.5px;">
<tr><td><p style="font-size:16px;" >Jl. Raya Kupang Indah No. 27</p></td></tr>
</table>
<table align="center" style="margin-left:17.5px;">
<tr><td><p style="font-size:16px;" >Telp. 031 – 7342927, 7328471-2</p></td></tr>
</table>
<table align="center" style="margin-left:17.5px;">
<tr><td><p style="font-size:16px;" >SURABAYA</p></td></tr>
</table>
<hr style="height:2px;width:80%;color:#000;">
<br>
<table style="margin-left:71px;">
<tr><td>No</td> 	<td>: <?= $tampil->no_sp?></td></tr>
<tr><td>Perihal </td><td>: Surat Peringatan <?= $tampil->peringatan?>	</tr>
</table>
<br>
<br>
<div style="margin-left:71px;">
Kepada Yth<br>
Sdr. <?= $k1->nama_ktp;?><br>
Di Tempat
<br>
<br>
<br>
Dengan hormat,
<br><div style="word-wrap:break-word;width:95%;height:auto; text-align: justify;">
Berdasarkan data yang kami terima bahwa <?= $sa?> <?= $k1->nama_ktp;?> pada tanggal <?=$this->format->TanggalIndo($tampil->tanggal_sp);?> telah melakukan tindakan indisipliner dalam bekerja yaitu <?= strip_tags($tampil->isi_sp) ?>.
</div>
<br><div style="word-wrap:break-word;width:95%;height:auto; text-align: justify;">Hal tersebut menunjukkan bahwa <?= $sa?> <?= $k1->nama_ktp;?> telah melakukan pelanggaran terhadap ketentuan dan peraturan yang telah ditetapkan, maka kepada Saudara diberikan Surat Peringatan <?= $i;?>.</div>
<br><div style="word-wrap:break-word;width:95%;height:auto; text-align: justify;">Apabila dalam kurun waktu 6 (enam) bulan setelah keluarnya Surat Peringatan <?= $i;?> ini Saudara masih melakukan kesalahan yang sama atau lebih berat, maka kepada <?= $sa?> akan diberikan Surat Peringatan <?= $s;?> tindakan berupa Pemutusan Hubungan Kerja sesuai dengan ketentuan yang berlaku.</div>
<br><div style="word-wrap:break-word;width:95%;height:auto; text-align: justify;">Demikian kami sampaikan, dan semoga Surat Peringatan ini dapat menjadi pendorong bagi <?= $sa?> untuk memperbaiki diri.</div>
<br>
<br>
<br>
Surabaya, <?=$this->format->TanggalIndo(date('Y-m-d'))?>
<br>
<br>
<br>
<div style="width:33%;float:left;">Hormat kami,</div><div style="width:31%;float:left;">Menyetujui,</div> 	<div style="width:30%;">Yang bersangkutan,</div>
<br>
<br>
<br>
<br>	
<br>
<div style="width:33%;float:left;"><u>Clara Chandra W.</u></div> <div style="width:29%;float:left;margin-left:25px;"><u>Afranut</u></div><div style="width:33%;float:left;margin-left:1px;"><u><?=$k1->nama_ktp?></u></div>
<div style="width:31%;float:left;">HR & Personalia</div><div style="width:35%;float:left;">PJS Koord. Satpam </div><div style="width:33%;float:left;">Karyawan</div>

</div>
<?php } ?>