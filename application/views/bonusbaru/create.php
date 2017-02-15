<h4>Halaman Input Bonus Karyawan</h4>
<hr>
<div class="row">
	<form action="" method="post">
		<div class="form-group col-md-4">
			<label> Cabang </label>
			<select name="cabang" class="form-control">
				<?php
					foreach ($cabang as $rs_cabang) {
						if ($rs_cabang->id_cabang != '2' && $rs_cabang->status == "Aktif") {
							echo "<option value='$rs_cabang->id_cabang'>$rs_cabang->cabang</option>";
						}
					}
				?>
			</select>
		</div>
		<div class="form-group col-md-4">
			<label> Tanggal Bagi Bonus </label>
			<div class="input-group date" id="date-picker2">
                <input type="text" name="bulan_bonus" class="form-control">
                <span class="input-group-addon"><i class="fa fa-th"></i></span>
            </div>
		</div>
		<div class="form-group col-md-4">
			<label> Omset </label>
			<input class="form-control" type="text" name="omset_real" id="omset_real" data-mask="#.##0" data-mask-reverse="true" data-mask-maxlength="false"/>
		</div>
		<div class="form-group col-md-12">
			<button type="submit" class="btn btn-primary">Proses Bonus</button>
			<button type="button" class="btn btn-warning" onclick="window.history.go(-1); return false;">Cancel</button>
		</div>
	</form>
</div>