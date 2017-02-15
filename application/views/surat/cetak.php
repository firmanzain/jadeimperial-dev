<link rel="stylesheet" href="<?=base_url()?>/assets/styles/bootstrap.css" />
<div align="center">
	<img width="100%" src="<?=base_url()?>assets/img/logo.png">
</div>
<div class="col-md-12">
	<div align="right">Surabaya, <?=$this->format->TanggalIndo($data->tanggal_surat)?></div>
	<div class="form-group">
		<table width="100%">
			<tr>
				<td width="10%">Nomor</td>
				<td width="2%">:</td>
				<td><?=$data->no_surat?></td>
			</tr>
			<tr>
				<td>Lampiran</td>
				<td>:</td>
				<td><?=$data->lampiran?></td>
			</tr>
			<tr>
				<td>Perihal</td>
				<td>:</td>
				<td><?=$data->perihal?></td>
			</tr>
		</table>
	</div>
	<div class="form-group">
			<label class="col-md-12">Yth.</label><br>
			<label class="col-md-12"><?=$data->kepada?></label>
	</div>
	<div class="form-group">
		<?= strip_tags($data->isi,'<p></p>') ?>
	</div>
	<div class="form-group">
		<p style="margin-bottom: 50px;"><b>Hormat Kami,</b></p>
		<?php
		$pengirim=$this->db->join('tab_jabatan a','a.id_jabatan=b.jabatan')->where('b.nik',$data->dari)->select('b.nama_ktp as nama,a.jabatan as jb')->get('tab_karyawan b')->row();
		echo "<b><u>$pengirim->nama<br></u></b>";
		echo "$pengirim->jb";
		?>
	</div>
</div>
