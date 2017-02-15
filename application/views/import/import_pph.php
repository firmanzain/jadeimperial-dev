<link rel="stylesheet" href="<?=base_url()?>/assets/styles/bootstrap.css" />
	<div class="panel panel-default">
	<div class="panel-heading">
		<div class="col-sm-12"><h2>Import Data PPH Karyawan</h2></div>
	</div>
		<div class="panel-body">
			<form name="myForm" id="myForm" action="<?=site_url()?>GajiController/go_import" method="post" enctype="multipart/form-data">
	            <label for="inputEmail3" class="col-sm-4 control-label">Bulan</label>
	            <div class="col-sm-8">
	                <select name="bulan" class="form-control">
	                    <?php
	                        $nama_bln= "bln January February March April May June July August September October November December";
	                        $arr_bulan=explode(" ", $nama_bln); // mecah data array
	                        $month_now = date('m');

	                        for ($i=1; $i <=12 ; $i++) {
	                            echo '<option value="'.$i.'">'.$arr_bulan[$i].'</option>';
	                        }
	                    ?>
	                </select>
	            </div>
	            <label for="inputEmail3" class="col-sm-4 control-label">Pilih FIle Excel(format excel 2003)</label>
	            <div class="col-sm-8">
					<input type="file" id="datague" name="datague" />
				</div>
				<div class="col-sm-12 text-right">
					<button class="btn btn-primary" type="submit">Import Data</button>
				</div>
			</form>
		</div>
	</div>
</div>

