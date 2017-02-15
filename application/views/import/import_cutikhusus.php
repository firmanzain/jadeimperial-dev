<link rel="stylesheet" href="<?=base_url()?>/assets/styles/bootstrap.css" />
<div class="col-md-12 col-md-offset-1">
	<div class="panel panel-default">
	<h4>Import Data Cuti Khusus</h4>
		<div class="panel-body">
			<form name="myForm" id="myForm" action="<?=site_url()?>CutiKhususController/go_import" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<label>Pilih FIle Excel(format excel 2003)</label>
					<input type="file" id="datague" name="datague" />
				</div>
				<div class="form-group">
					<button class="btn btn-primary" type="submit">Import Data</button>
				</div>
			</form>
		</div>
		<div class="panel-body">
			<h5>Contoh Format Import</h5>
			<table class="table table-bordered">
				<tr>
					<th>Keterangan</th>
					<th>Lama Cuti(satuan hari)</th>
				</tr>
				<tr>
					<td>Melahirkan</td>
					<td>10</td>
				</tr>
			</table>
		</div>
	</div>
</div>

