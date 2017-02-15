<h4>Halaman Input Data User</h4>
<hr>
<div class="row">
	<form action="" name="form1" id="fomr1" method="post">
		<div class="form-group col-md-8">
			<label>Nama User</label><br>
			<input type="text" class="form-control" name="nama" id="nama" required/>
		</div>
		<div class="form-group col-md-8">
			<label>Level</label>
			<select name="level" class="form-control">
				<?php
					foreach ($level as $rs) {
						echo "<option value='$rs->kode'>$rs->deskripsi</option>";
					}
				?>
			</select>
		</div>
		<div class="form-group col-md-8">
			<label>Username</label>
			<input type="text" name="username" id="username" class="form-control" maxlength="20" placeholder="username untuk login sistem">
		</div>
		<div class="form-group col-md-8">
			<label>Password</label>
			<input type="text" name="password" class="form-control" maxlength="20">
		</div>
		<div class="form-group col-md-8">
			<label>Status</label>
			<select name="status" class="form-control">
				<option>Aktif</option>
				<option>Non Aktif</option>
			</select>
		</div>
		<div class="form-group col-md-12">
			<button type="submit" class="btn btn-primary" name="submit">Simpan</button>
			<button type="button" class="btn btn-warning" onclick="window.history.go(-1); return false;" name="submit">Cancel</button>
		</div>
	</form>
</div>
