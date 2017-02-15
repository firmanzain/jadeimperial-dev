<h4>Halaman Input Master T3 Karyawan</h4>
<hr>
<div class="row">
	<div class="col-md-12">


	<form action="<?=base_url()?>T3Controller/update" method="post">
		<table class="table table-bordered" id="example-2">
			<thead>
				<tr>
					<th>No</th>
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
					echo "<tr>
							<td><input type='hidden' name='id[]' value='$rs->id'>$no</td>
							<td>$rs->nik</td>
							<td>$rs->nama_ktp</td>
							<td>$rs->jabatan</td>
							<td><input class='form-control' type='text' name='trf[]'  data-mask='#.##0' data-mask-reverse='true' value='$rs->tarif' data-mask-maxlength='false'/></td>
							</tr>";
				$no++;
				}
			?>
			</tbody>
		</table>
		<div class="form-group col-md-12">
			<button type="submit" class="btn btn-primary" value="1" name="update">Simpan</button>
			<button type="button" class="btn btn-warning" onclick="window.history.go(-1); return false;" name="submit">Cancel</button>
		</div>
	</form>

	
	</div>
</div>