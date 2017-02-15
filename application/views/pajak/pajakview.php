<h4>Tambah Data Pajak</h4>
<div class="col-md-12">
	<form action="" method="post">
		<div class="form-group">
			<label>Pajak</label>
			<select name="pajak" class="form-control">
				<option>TK/0</option>
				<option>TK/1</option>
				<option>TK/2</option>
				<option>TK/3</option>
				<option>K/0</option>
				<option>K/1</option>
				<option>K/2</option>
				<option>K/3</option>
			</select>
		</div>
		<div class="form-group">
			<label>Gaji/Tahun</label>
			<input class="form-control" type="text" name="gaji" id="gaji" data-mask="#.##0" data-mask-reverse="true" data-mask-maxlength="false" required/>
		</div>
		    <div class="form-group">
			<label>Gaji/Bulan</label>
			<input class="form-control" type="text" name="gaji_bulan" id="gaji_bulan" data-mask="#.##0" data-mask-reverse="true" data-mask-maxlength="false" required/>
		</div>
		    <div class="form-group">
			<label>Keterangan pajak</label>
			<textarea name="keterangan_pajak" class="form-control" rows="4"></textarea>
		</div>
		   <div class="form-group">
			<button type="submit" class="btn btn-primary" name="submit">Simpan</button>
			<button type="button" class="btn btn-warning" onclick="window.history.go(-1); return false;">Batal</button>
		</div>
	</form>
</div>