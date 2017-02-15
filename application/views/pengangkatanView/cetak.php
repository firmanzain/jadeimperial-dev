<?php
   if ($data==true) {
		$tampil=$data;
    ?>
	<!--<title>Pengangkatan <?=$k1->nama_ktp;?></title>-->
	<style>
		#container{
			margin-left:80px;
			padding-top:190px;
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
<h2 align="center"><u>SURAT PENGANGKATAN</u></h2>
<div id="no"><i>Nomor : <?=$tampil->no_pengangkatan?></i></div>
<br>
<br>
<h4 style="margin-left:75px;">Dengan ini mengangkat Sdr. <?=$tampil->nama_ktp?> dengan jabatan sebagai	:</h4>
<br>
<h1 align="center"><?=preg_replace('/[0-9]+/', '', $tampil->jabatan);?></h1>
<h2 align="center"><?="Status Kerja : ".$tampil->status_kerja?></h2>
<p id="tgl">Per tanggal	: <?=$this->format->TanggalIndo($tampil->tanggal_per)?></p>
<br>
<h4 align="center">Demikian surat pengangkatan ini supaya dapat dijalankan dengan penuh tanggung jawab.</h4>
<br>
<br>
<h4>Surabaya, <?=$this->format->TanggalIndo(date('Y-m-d'));?></h4>

<h4>Hormat Kami</h4>
<br>
<br>
<br>
<h3><u><?=$tampil->manager?></u><br>
Management Representative<h3>

</div>
<?php } ?>