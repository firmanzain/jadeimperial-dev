<h4>Halaman Update Tunjangan Karyawan</h4>
<hr>
<div class="row">
	<form action="" method="post">
		<div class="form-group col-md-6">
			<label>NIK Karyawan</label>
			<input type="text" class="form-control" name="nik" value="<?=$data->nik?>" id="nik"/>
			<input type="hidden" class="form-control" name="id" value="<?=$data->id?>" id="id"/>
		</div>
		<div class="form-group col-md-6">
			<label>Tunjangan</label>
			<select name="tunjangan" class="form-control">
				<option selected value="<?=$data->id_tunjangan?>"><?=$data->nama_tunjangan?></option>
			<?php
				foreach ($tunjangan as $rs_tunjangan) {
					if ($rs_tunjangan->status_tunjangan=="Aktif") {
						echo "<option value='$rs_tunjangan->id_tunjangan'>$rs_tunjangan->nama_tunjangan</option>";
					}
				}
			?>
			</select>
		</div>
		<div class="form-group col-md-12">
			<label>Tarif</label>
			<input type="number" class="form-control" value="<?=$data->tarif?>" name="tarif" id="tarif"/>
		</div>
		<div class="form-group col-md-12">
			<button type="submit" class="btn btn-primary" name="submit">Simpan</button>
			<button type="button" class="btn btn-warning" onclick="window.history.go(-1); return false;" name="submit">Cancel</button>
		</div>
	</form>
</div>
<?php
	function ambil_nama(){
	   $nama='';
	  $sql_nama=mysql_query("select * from tab_karyawan");
	  while($data_nama=mysql_fetch_array($sql_nama)){
	  $nama.='"'.stripslashes($data_nama['nik']).'",';
	  }
	  return(strrev(substr(strrev($nama),1)));
	}
?>
<script type="text/javascript">
	$(function() {
	    var DaftarNama = [<?php echo ambil_nama();?> ];
	    $( "#nik" ).autocomplete({
	      source: DaftarNama
	    });
  });
</script>