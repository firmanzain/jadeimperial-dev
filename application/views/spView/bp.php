
<div style="margin: 2cm 2cm 2cm 2cm">
	<h4 align="center" style="padding-top: 1cm">BERITA ACARA PEMERIKSAAN DI LAPANGAN</h4>

	<div style="margin-top: 30px">
		<table width="100%">
			<tr>
				<td width="30%">Nama</td>
				<td width="2%">:</td>
				<td><?=$data->nama_ktp?></td>
			</tr>
			<tr>
				<td>Jabatan</td>
				<td>:</td>
				<td><?=$data->jabatan?></td>
			</tr>
			<tr>
				<td>Departemen</td>
				<td>:</td>
				<td><?=$data->department?></td>
			</tr>
			<tr>
				<td>Perusahaan</td>
				<td>:</td>
				<td>PT. CITRA RASA NINUSA</td>
			</tr>
			<tr>
				<td>Tanggal Pemeriksaan</td>
				<td>:</td>
				<td><?=$this->format->TanggalIndo($data->tanggal_sp)?></td>
			</tr>
			<tr>
				<td>Lokasi Pemeriksaan</td>
				<td>:</td>
				<td>JADE IMPERAL RESTAURAN</td>
			</tr>
			<tr>
				<td>Hasil Pemeriksaan</td>
				<td>:</td>
				<td>Terhadap yang bersangkutan bahwa :</td>
			</tr>
		</table>
		<div style="margin-top: 15px; text-align: justify;">
			<?=strip_tags($data->isi_sp)?>
		</div>
		<div style="margin-top: 10px">
			<table width="100%">
				<tr>
					<td width="30%">Nama Pemeriksa</td>
					<td width="2%">:</td>
					<td><?=$pemeriksa->nama_ktp?></td>
				</tr>
				<tr>
					<td>Jabatan</td>
					<td>:</td>
					<td><?=$pemeriksa->jabatan?></td>
				</tr>
				<tr>
					<td>Departemen</td>
					<td>:</td>
					<td><?=$pemeriksa->department?></td>
				</tr>
				<tr>
					<td>Perusahaan</td>
					<td>:</td>
					<td>PT. CITRA RASA NINUSA</td>
				</tr>
			</table>
		</div>
		<div style="margin-top: 10px">
			<p>Surabaya, <?=$this->format->TanggalIndo(date('Y-m-d'))?></p>
			<table align="center" width="100%" style="text-align: center;">
				<tr>
					<td>Pemeriksa</td>
					<td>Yang diperiksa</td>
					<td>Saksi</td>
				</tr>
				<tr>
					<td height="150px"><?=$pemeriksa->nama_ktp?></td>
					<td height="150px"><?=$data->nama_ktp?></td>
					<td height="150px"><?=$data->saksi?></td>
				</tr>
			</table>
		</div>
		<div>
			<p style="margin-top: 5px">Terhadap hasil pemeriksaan tersebut, kami mengajukan permohonan agar yang diperiksa tersebut diberikan <?=$data->sanksi?></p>
		</div>
		<div style="margin-top: 10px">
			<p>Surabaya, <?=$this->format->TanggalIndo(date('Y-m-d'))?></p>
			<table align="center" width="100%" style="text-align: center;">
				<tr>
					<td width="50%">Pemohon</td>
					<td width="50%">Menyetujui</td>
				</tr>
				<tr>
					<td height="150px">(................................)</td>
					<td height="150px">(................................)</td>
				</tr>
			</table>
		</div>
	</div>
</div>