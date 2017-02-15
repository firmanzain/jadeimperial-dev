<div style="margin: 50px; ">
	<p align="center" style="margin-bottom: 100px; padding-top: 100px;"><b style="font-size: 18px;"><u>SURAT KETERANGAN BERHENTI KERJA</u></b><br>
	Nomor : __/<?=$this->format->bulan(date('m'))?>/CRN~JCR/SDM/SK/<?=date('Y')?></p>
		
	<p><u>Kepada yang berkepentingan</u></p>
	<p><u>Bersama ini kami terangkan bahwa : <?=ucwords($employe->nama_ktp)?></u></p>
	<p><u>Telah bekerja pada PT. CITRA RASA  NINUSA</u></p>
	<p><u>Sebagai : <?=$employe->jabatan?></u></p>
	<p><u>dari tanggal <?=$this->format->TanggalIndo($employe->tanggal_masuk)?> sampai <?=$this->format->TanggalIndo($employe->tanggal_resign)?></u></p>
	<p><u>Alasan Berhenti 	: <?php if(empty($employe->keterangan)) echo "Kontrak Habis"; else echo ucwords($employe->keterangan)?></u></p>
	<p><u>Demikian surat keterangan ini dibuat agar dapat digunakan seperlunya.</u></p>
	<div align="right" style="padding-left: 70%;">
		<p style="margin-bottom: 50px">Surabaya, <?=$this->format->TanggalIndo(date('Y-m-d'))?></p>
		<p><b><u><?=$hrd->nama_ktp?></u></b><br><?=$hrd->jabatan?></p>
	</div>
</div>