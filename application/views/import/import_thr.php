<link rel="stylesheet" href="<?=base_url()?>/assets/styles/bootstrap.css" />
<link rel="stylesheet" href="<?=base_url()?>assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css" />
<script src="<?=base_url()?>assets/scripts/jquery.min.js" type="text/javascript"></script>
<!-- global scripts -->
<script src="<?=base_url()?>/assets/bower_components/tether/dist/js/tether.js"></script>
<script src="<?=base_url()?>/assets/bower_components/bootstrap/dist/js/bootstrap.js"></script>
<script src="<?=base_url()?>/assets/bower_components/PACE/pace.js"></script>
<script src="<?=base_url()?>/assets/scripts/lodash.min.js"></script>
<script src="<?=base_url()?>/assets/scripts/components/jquery-fullscreen/jquery.fullscreen-min.js"></script>
<script src="<?=base_url()?>/assets/bower_components/jquery-storage-api/jquery.storageapi.min.js"></script>
<script src="<?=base_url()?>/assets/bower_components/wow/dist/wow.min.js"></script>
<script src="<?=base_url()?>/assets/scripts/functions.js"></script>
<script src="<?=base_url()?>/assets/scripts/colors.js"></script>
<script src="<?=base_url()?>/assets/scripts/left-sidebar.js"></script>
<script src="<?=base_url()?>/assets/scripts/navbar.js"></script>
<script src="<?=base_url()?>/assets/scripts/horizontal-navigation-1.js"></script>
<script src="<?=base_url()?>/assets/scripts/horizontal-navigation-2.js"></script>
<script src="<?=base_url()?>/assets/scripts/horizontal-navigation-3.js"></script>
<script src="<?=base_url()?>/assets/scripts/main.js"></script>
<script src="<?=base_url()?>/assets/bower_components/notifyjs/dist/notify.js"></script>
<script src="<?=base_url()?>assets/scripts/topojson.min.js"></script>
<script src="<?=base_url()?>assets/scripts/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>assets/scripts/tables-datatable.js"></script>
<script src="<?=base_url()?>assets/bower_components/bootstrap-validator/dist/validator.min.js"></script>
<script src="<?=base_url()?>assets/scripts/components/floating-labels.js"></script>
<script src="<?=base_url()?>assets/scripts/forms-validation.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/scripts/pilihan.js"></script>
<script src="<?=base_url()?>assets/scripts/jquery-ui.js"></script>
<link rel="stylesheet" href="<?=base_url()?>assets/styles/jquery-ui.css">
<script src="<?=base_url()?>assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?=base_url()?>assets/bower_components/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.js"></script>
<script src="<?=base_url()?>assets/scripts/forms-pickers.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/jmask/jquery.mask.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/numberformat/jquery.number.min.js"></script>


	<div class="panel panel-default">
	<div class="panel-heading">Import Data PPH THR Karyawan</div>
		<div class="panel-body">
			<form name="myForm" id="myForm" action="<?=site_url()?>ThrController/go_import" method="post" enctype="multipart/form-data" class="form-horizontal">
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-6 control-label">Jenis THR</label>
					<div class="col-sm-6">
						<select class="form-control" name="jns_thr" required="required">
							<option value="Natal">Natal</option>
							<option value="Idul Fitri">Idul Fitri</option>
						</select>
					</div>
				</div>
				<div class="form-group">
			        <label for="inputEmail3" class="col-sm-6 control-label">Tanggal Dibagi</label>
			        <div class="col-sm-6">
			          <input type="text" name="tanggal"  id="date-picker2" class="form-control" />
			        </div>
			    </div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-6 control-label">Pilih FIle Excel(format excel 2003)</label>
					<div class="col-sm-6">
						<input type="file" id="file" name="file" />
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12 text-right">
						<button class="btn btn-primary" type="submit">Import Data</button>
					</div>
				</div>
			</form>
		</div>
		<div class="panel-body">
			&nbsp;
		</div>
		<div class="panel-body">
			&nbsp;
		</div>
		<div class="panel-body">
			<h5>Contoh Format Import</h5>
			<table class="table table-bordered">
				<tr>
					<th>NIK</th>
					<th>TARIF</th>
					<th>PPH</th>
				</tr>
				<tr>
					<td>9100013</td>
					<td>2000000</td>
					<td>200000</td>
				</tr>
			</table>
		</div>
	</div>
</div>

