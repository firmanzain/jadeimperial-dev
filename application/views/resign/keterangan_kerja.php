<div align="center">
	<img width="100%" src="<?=base_url()?>assets/img/logo.png">
</div>
	<p align="center"><b style="font-size: 18px;"><u>SURAT KETERANGAN PENGALAMAN KERJA</u></b><br>
Nomor : __/<?=$this->format->bulan(date('m'))?>/HRD/<?=date('Y')?></p>

<p style="text-align: justify;">Yang bertanda tangan di bawah ini :</p>
<table width="100%">
	<tr>
		<td width="30%">Nama</td>
		<td width="2%">:</td>
		<td><?=$hrd->nama_ktp?></td>
	</tr>
	<tr>
		<td>Jabatan</td>
		<td>:</td>
		<td><?=$hrd->jabatan?></td>
	</tr>
	<tr>
		<td>Alamat</td>
		<td>:</td>
		<td><?=$hrd->alamat_domisili?></td>
	</tr>
</table>
Dengan ini menerangkan bahwa :
<table width="100%">
	<tr>
		<td width="30%">Nama</td>
		<td width="2%">:</td>
		<td><?=$employe->nama_ktp?></td>
	</tr>
	<tr>
		<td>Alamat</td>
		<td>:</td>
		<td><?=$employe->alamat_domisili?></td>
	</tr>
</table>
<p style="text-align: justify;">Benar telah bekerja pada PT. CITRA RASA NINUSA terhitung sejak <?=$this->format->TanggalIndo($employe->tanggal_masuk)?> s/d <?=$this->format->TanggalIndo($employe->tanggal_resign)?> dengan jabatan sebagai <?=$employe->jabatan?>.
Selama menjadi karyawan kami, saudara <?=$employe->nama_ktp?> telah menunjukkan dedikasi dan loyalitas yang tinggi selama bekerja di PT. CITRA RASA NINUSA dan tidak pernah melakukan hal-hal yang merugikan perusahaan.</p>
<p style="text-align: justify;">Demikian surat keterangan ini dibuat dengan sebenarnya dan dapat digunakan sebagaimana mestinya.</p>

<p style="margin-bottom: 50px"><b>Hormat kami,</b></p>
<p><b><u><?=$hrd->nama_ktp?></u></b><br><?=$hrd->jabatan?></p>