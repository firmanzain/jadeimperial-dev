<link rel="stylesheet" href="<?=base_url()?>/assets/styles/bootstrap.css" />
<script type="text/javascript" src="<?=base_url()?>assets/jmask/jquery.mask.js"></script>
<div class="col-md-12 col-md-offset-1">
	<div class="panel panel-default">
	<h4 align="center" style="margin-top:20px">PPH Karyawan Casual <br> Bulan <?=$this->format->BulanIndo(date('m',strtotime($thn."-".$bln."-01"))).' '.date('Y',strtotime($thn."-".$bln."-01"))?></h4>

		<div class="panel-body">
			<form name="myForm" id="myForm" action="<?=site_url()?>GajiController/set_pph_casual" method="post" enctype="multipart/form-data">
			<input type="hidden" name="bln" value="<?php echo $bln;?>">
			<input type="hidden" name="thn" value="<?php echo $thn;?>">
				<div class="table-responsive">
					<table class="table table-bordered">
						<tr>
							<th>NO</th>
							<th>NIK</th>
							<th>NAMA KTP</th>
							<th>JABATAN</th>
							<th>PLANT</th>
							<th>PPH1</th>
							<th>PPH2</th>
						</tr>
						<?php
							$no=1;
							if ($data==true) {
								foreach ($data as $rs) {
									// $pph_casual=$this->db->where('nik',$rs->nik)
									// 					 ->where('month(entry_date)',date($bln))
									// 					 ->where('year(entry_date)',date($thn))
									// 					 ->get('pph_casual')->row();
									$pph_casual=$this->db->query('select * from pph_casual where nik='.$rs->nik.' and month(entry_date)="'.date($bln).'" and year(entry_date)="'.date($thn).'"');
									if ($pph_casual->num_rows()>0) {
										$pph1 = $pph_casual->pph_1;
										$pph2 = $pph_casual->pph_2;
									} else {
										$pph1 = 0;
										$pph2 = 0;
									}
									echo "<input type='hidden' name='nik[]' value='$rs->nik'>";
									echo "<tr>
										  	<td>$no</td>
										  	<td>$rs->nik</td>
										  	<td>$rs->nama_ktp</td>
										  	<td>$rs->jabatan</td>
										  	<td>$rs->cabang</td>
										  	<td><input class='form-control' type='text' name='pph1[]' value='$pph1' data-mask='#.##0' data-mask-reverse='true' data-mask-maxlength='false'/></td>
										  	<td><input class='form-control' type='text' name='pph2[]' value='$pph2' data-mask='#.##0' data-mask-reverse='true' data-mask-maxlength='false'/></td>
										  </tr>";
								$no++;
								}
							}
						?>
					</table>
				</div>
				<div class="form-group">
					<button class="btn btn-primary" type="submit">Simpan Data</button>
				</div>
			</form>
		</div>
	</div>
</div>

