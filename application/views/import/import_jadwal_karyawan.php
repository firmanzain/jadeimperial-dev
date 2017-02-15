<link rel="stylesheet" href="<?=base_url()?>/assets/styles/bootstrap.css" />
<div class="col-md-12">
	<div class="panel panel-primary">
	<div class="panel-heading">Import Data Schedule Karyawan</div>
		<div class="panel-body">
			<form name="myForm" id="myForm" action="<?=site_url()?>ScheduleKaryawanController/go_import" method="post" enctype="multipart/form-data">
				<div class="form-line">
					<div class="form-group">
						<label>Bulan Ke</label>
						<select name="bulan" class="form-control">
							<?php
							$nama_bln= "bln January February March April Mey June July August September October November December";
							$arr_bln = explode(" ", $nama_bln);
								for ($i=1; $i<=12 ; $i++) { 
									echo '<option value='.$i.'>'.$arr_bln[$i].'</option>';
								}
							?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label>Pilih FIle Excel(format excel 2003)</label>
					<input type="file" id="file" name="file" />
				</div>
				<div class="form-group">
					<button class="btn btn-primary" type="submit">Import Data</button>
				</div>
			</form>
		</div>
	</div>
</div>