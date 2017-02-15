<link rel="stylesheet" href="<?=base_url()?>/assets/styles/bootstrap.css" />
	<div class="panel panel-default">
	<div class="panel-heading">Import Data Jadwal</div>
		<div class="panel-body">
			<form name="myForm" id="myForm" action="<?=site_url()?>JamKerjaController/go_import" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<label>Pilih FIle Excel(format excel 2003)</label>
					<input type="file" id="datague" name="datague" />
				</div>
				<div class="form-group">
					<button class="btn btn-primary" type="submit">Import Data</button>
				</div>
			</form>
		</div>
	</div>
</div>

