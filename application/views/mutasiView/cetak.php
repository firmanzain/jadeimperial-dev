<?php
   if ($data==true) {
		$tampil=$data;
    ?>
	
	<!--<title>Mutasi <?=$k1->nama_ktp?></title>-->
	<style>
		#container{
			margin-left:80px;
			padding-top:80px;
		}
		#ket{
			margin-left:50px;
			padding-top:10px;
		}
	</style>
<div id="container">
<div style="margin-left:65%;">Surabaya, <?=$this->format->TanggalIndo(date('Y-m-d'));?></div>
<br>
<br>
<table>
<tr>
	<td>
		No.
	</td>
	<td>
		: <?=$tampil->no_mutasi;?>
	</td>
</tr>
<tr>
	<td>
		Perihal
	</td>
	<td>
		: Mutasi
	</td>
</tr>

</table>
<br>
<br>
Kepada Yth.<br>
Sdr. <?= $tampil->nama_ktp?><br>
<u>Surabaya</u><br>
<br>
<br>
Dengan Hormat,<br>
Berdasarkan hasil keputusan Manajemen PT. Citra Rasa Ninusa maka akan<br>
menempatkan :
<br>
<br>
	<div id="ket">
	<table>
	<tr><td>Nama</td>		<td>:</td> <td><?= $tampil->nama_ktp?></td></tr>
	<tr><td>Jabatan</td>		<td>:</td> <td><?= $tampil->jabatan1?></td></tr>
	<tr><td>Department</td>		<td>:</td> <td><?= $tampil->department1?></td></tr>
	<tr><td>Dari</td> 		<td>:</td> <td><?= $tampil->cabang1?></td></tr>
	<tr><td>Ke</td>			<td>:</td> <td><?= $tampil->cabang?></td></tr>
	<tr><td>Jabatan</td>		<td>:</td> <td><?= $tampil->jabatan?></td></tr>
	<tr><td>Department</td>		<td>:</td> <td><?= $tampil->department?></td></tr>
	<tr><td>Mulai tanggal</td>	<td>:</td> <td><?=$this->format->TanggalIndo($tampil->tanggal_berlaku)?></td></tr>
		</table>
	</div>
	<br>
	<br>
	Diharapkan Sdr. <?= $tampil->nama_ktp?> dapat menjalankan tugasnya dengan lebih baik dan penuh <br>
	tanggung jawab.<br><br>
	Keputusan ini berlaku sejak ditanda-tanganinya surat ini sampai dengan diberlakukannya<br>
	keputusan baru.<br><br>
	Demikian Surat Keputusan ini, terima kasih atas perhatiannya.<br><br>
	Hormat kami,	<br><br><br><br><br><br>
	<b><u><?=$tampil->manager?></u><br>
Management Representative</b>
<br>
<br>
<br>
<h5 style="margin-left:70%;"><i>PT. Citra Rasa Ninusa</i></h5>
</div>
<?php } ?>