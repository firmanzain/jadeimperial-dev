<h4>Halaman Input Dokumen</h4>
<hr>
<div class="row">
	<form action="" method="post">
		<div class="form-group col-md-12">
			<label>Judul Dokumen</label>
			<input type="text" class="form-control" name="dokumen" id="dokumen"/>
		</div>
		<div class="form-group col-md-12">
			<label>Isi Dokumen</label>
			<textarea name="isi" class="ckeditor"></textarea>
		</div>
		<div class="form-group col-md-12">
			<button type="submit" class="btn btn-primary" name="submit">Simpan</button>
			<button type="button" class="btn btn-warning" onclick="window.history.go(-1); return false;" name="submit">Cancel</button>
		</div>
	</form>
</div>