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
<div style="margin: 2cm 2cm 2cm 2cm">
	<table class="tabel" border="1px" width="100%">
		<tr>
			<td colspan="2" align="center"><h4>LEMBAR PEMBINAAN</h4></td>
		</tr>
		<tr>
			<td colspan="2" style="text-align: justify;"><p>Pada hari ini <?=$this->format->hari(date('Y-m-d'))?> tanggal <?=$this->format->TanggalIndo(date('Y-m-d'))?> telah dilakukan pembinaan berupa pemangilan dan pemberian Surat Peringatan oleh ………………………………………….. Jabatan …………………………kepada Sdr <?=$data->nama_ktp?> Sehubungan dengan kesalahan / pelanggaran seperti yang tersebut pada Surat Peringatan.</p>

			<p style="margin-top: 10px;text-align: justify;">
				Dari hasil pemanggilan dan penjelasan serta pemberian Surat Peringatan tersebut yaitu yang bersangkutan Telah Memahami / Tidak Memahami kesalahan yang dilakukan, sehingga yang bersangkutan Menerima / Menolak pemberian Surat Peringatan yang diberikan kepadanya.
			</p colspan="2">
			</td>
		</tr>
		<tr style="border-top: 0px; border-bottom: 0px">
			<td align="center" style="border-top: 0px; border-bottom: 0px">Pembina</td>
			<td align="center" style="border-top: 0px; border-bottom: 0px">Yang Dibina</td>
		</tr>
		<tr>
			<td height="150px" align="center">(..............................)</td>
			<td height="150px" align="center">(..............................)</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align: justify;">
				<p>
					<p>Catatan : untuk pilihan yang dicetak tebal harap dicoret yang tidak sesuai dengan fakta, oleh Pembina, dan apapun jawabannya harus ditandatangani oleh kedua belah pihak.</p>

					<p>Contoh apabila yang dibina memahami kesalahannya maka yang dicoret : Telah Memahami / Tidak Memahami Kesalahan.</p>

					<p>Komitmen perbaikan Ybs:</p>
				</p>
			</td>
		</tr>
		<tr>
			<td colspan="2" height="300px"></td>
		</tr>
		<tr>
			<td colspan="2" align="left">Surabaya, <?=$this->format->TanggalIndo(date('Y-m-d'))?></td>
		</tr>
		<tr>
			<td height="150px" align="left" colspan="2">(............................)</td>
		</tr>
	</table>
</div>
