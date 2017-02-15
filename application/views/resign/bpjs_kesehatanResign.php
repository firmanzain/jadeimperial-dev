<div align="center">
	<img width="100%" src="<?=base_url()?>assets/img/logo.png">
</div>
<style>
  .tabel{
  border-collapse:collapse;
  width:100%;}
  .tabel th{
  background:#BEBEBE;
  color:#000;
  border:#000000 solid 1px;
  padding:3px;}
  .tabel td{
  border:#000000 solid 1px;
  text-align: center;
  padding:3px;}
</style>
<div align="right">
Surabaya, <?=$this->format->TanggalIndo(date('Y-m-d'))?>	
</div>

<div class="form-group">
	<table width="100%">
		<tr>
			<td width="13%">Nomor</td>
			<td width="2%">:</td>
			<td>_____/<?=$this->format->bulan(date('m'))?>/HRD-CRN/<?=date('Y')?></td>
		</tr>
		<tr>
			<td>Lampiran</td>
			<td>:</td>
			<td></td>
		</tr>
		<tr>
			<td>Perihal</td>
			<td>:</td>
			<td>Karyawan resign bulan <?=date('F Y')?></td>
		</tr>
	</table>
</div>
<div class="form-group" style="margin-bottom: 20px;">
	<p>Yth.<br> 
	BPJS Kesehatan KCU Surabaya</p>
</div>
<div class="form-group">
	Yang bertanda tangan dibawah ini :
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
			<td>Badan Usaha</td>
			<td>:</td>
			<td>PT. CITRA RASA NINUSA</td>
		</tr>
		<tr>
			<td>Kode Badan Usaha</td>
			<td>:</td>
			<td>02172562</td>
		</tr>
	</table>
	<p></p>
	<p style="text-align: justify;">Menyatakan bahwa tenaga kerja berikut ini dinonaktifkan pada <?=$this->format->TanggalIndo(date('Y-m-01'))?> dari kepesertaan BPJS Kesehatan dengan alasan Mengundurkan diri sehingga pada tanggal <?=$this->format->TanggalIndo(date('Y-m-01',strtotime('+1 month',strtotime(date("Y-m-d")))))?> tidak dikenakan iuran / tagihan premi.</p>
	<table width="100%" class="tabel">
		<tr>
			<th>No</th>
			<th>No Kartu</th>
			<th>Nama</th>
			<th>NIK</th>
			<th>Tanggal Lahir</th>
		</tr>
		<?php
			$no=1;
			foreach ($karyawan as $rs) {
				$no_bpjs=$this->db->where('nik',$rs->nik)->where('id_bpjs',2)->select('no_bpjs')->get('tab_bpjs_karyawan')->row();
				echo "<tr><td>$no</td><td>$no_bpjs->no_bpjs</td><td>$rs->nama_ktp</td><td>$rs->nik</td><td>".date('d-M-Y',strtotime($rs->tanggal_lahir))."</td></tr>";
				$no++;
			}
		?>
	</table>
	<p style="text-align: justify;">Kami menjamin data yang diserahkan adalah lengkap dan benar serta bertanggung jawab sepenuhnya terhadap kebenaran data. BPJS Kesehatan berhak memproses data yang telah lengkap dan sesuai ketentuan tertib administrasi kepesertaan. Data yang tidak sesuai tidak dapat diproses
	Demikian surat ini kami buat dengan sebenar–benarnya, atas kerjasama Bapak / Ibu kami ucapkan terima kasih.</p>	
</div>
<p style="margin-bottom: 50px"><b>Hormat kami,</b></p>
<p><b><u><?=$hrd->nama_ktp?></u></b><br><?=$hrd->jabatan?></p>
