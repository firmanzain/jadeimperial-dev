<h4>Halaman Input Master THR Karyawan</h4>
<hr>
<div class="row">
	<div class="col-md-12">
	<div class="col-md-12" style="margin-bottom: 30px;">
		<form class="form-inline" name="formPrint" method="post" action="">
	      <div class="form-group m-r-20">
	          <label class="m-r-10">PLANT</label>
	          <select name="cabang" class="form-control">
	          <?php
	          	foreach ($cabang as $cb) {
	          		echo "<option value='$cb->id_cabang'>$cb->cabang</option>";
	          	}
	          ?>
	          </select>
	      </div>
	      <div class="form-group m-r-20">
	          <label class="m-r-10">Jabatan</label>
	          <select name="cabang" class="form-control">
	          <?php
	          	foreach ($jabatan as $jb) {
	          		echo "<option value='$jb->id_jabatan'>$jb->jabatan</option>";
	          	}
	          ?>
	          </select>
	      </div>
	      <button type="submit" class="btn btn-warning" id="btn-cetak" >Filter Data</button>
	    </form>
	</div>
	<form action="" method="post">
		<div class="col-md-4">
			<div class="row">
				<div class="form-group m-r-20">
			          <label class="m-r-10">Tanggal Bagi</label>
			          <input type="text" name="tanggal"  id="date-picker2" class="form-control" />
			    </div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="row">
				<table class="table table-bordered" id="example-2">
					<thead>
						<tr>
							<th>No</th>
							<th hidden></th>
							<th>NIK</th>
							<th>Nama</th>
							<th>Jabatan</th>
							<th>Tarif</th>
						</tr>
					</thead>
					<tbody>
					<?php
					$no=1;
						foreach ($data as $rs) {
							echo "<tr><td>$no</td><td hidden><input type='hidden' name='nik[]' value='$rs->nik' /></td><td>$rs->nik</td><td>$rs->nama_ktp</td><td>$rs->jabatan</td><td><input class='form-control' type='text' name=tarif[]  data-mask='#.##0' data-mask-reverse='true' data-mask-maxlength='false'/></td></tr>";
						$no++;
						}
					?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="form-group col-md-12">
			<button type="submit" class="btn btn-primary" value="1" name="simpan">Simpan</button>
			<button type="button" class="btn btn-warning" onclick="window.history.go(-1); return false;" name="submit">Cancel</button>
		</div>
	</form>
	</div>
</div>