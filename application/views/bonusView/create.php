<h4>Halaman Input Bonus Karyawan</h4>
<hr>
<div class="row">
	<form action="" method="post">
		<div class="form-group col-md-4">
			<label>Plant</label>
			<select name="cabang" class="form-control">
				<?php
					foreach ($cabang as $rs_cabang) {
						if ($rs_cabang->id_cabang!='2'&&$rs_cabang->status=="Aktif") {
							echo "<option value='$rs_cabang->id_cabang'>$rs_cabang->cabang</option>";
						}
					}
				?>
			</select>
		</div>
		<div class="form-group col-md-4">
			<label>Tanggal Bonus</label>
			<div class="input-group date" id="date-picker2">
                <input type="text" name="bulan_bonus" class="form-control">
                <span class="input-group-addon"><i class="fa fa-th"></i></span>
            </div>
		</div>
		<div class="form-group col-md-4">
			<label>Omset Bulan Ini</label>
			<input class="form-control" type="text" name="omset" id="omset" data-mask="#.##0" data-mask-reverse="true" data-mask-maxlength="false"/>
		</div>
		<div class="form-group col-md-12">
			<div class="form-inline">
				<div class="form-group m-r-20">
		              <label class="m-r-10">Persentase Bonus (%)</label>
		              <input type="text" name="bonus_cabang" class="form-control" value="4.30" />
		        </div>
		        <div class="form-group m-r-20">
		              <label class="m-r-10">MPD (%)</label>
		              <input type="text" name="bonus_mpd" class="form-control" value="2" />
		        </div>
		        <div class="form-group m-r-20">
		              <label class="m-r-10"> L&B (%)</label>
		              <input type="text" name="bonus_lb" class="form-control" value="8" />
		        </div>
		        <div class="form-group m-r-20">
		        	<label class="c-input c-checkbox">
    					<input type="checkbox" name="pph" id="pph" value="1"><span class="c-indicator c-indicator-warning"></span><span class="c-input-text">Include PPH</span> 
					</label>
		        </div>
		     </div>
		</div>
		<div class="form-group col-md-12">
			<button type="submit" class="btn btn-primary" name="submit">Proses Bonus</button>
			<button type="button" class="btn btn-warning" onclick="window.history.go(-1); return false;" name="submit">Cancel</button>
		</div>
	</form>
</div>