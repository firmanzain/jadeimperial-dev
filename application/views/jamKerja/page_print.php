<div class="row">
	<div class="col-md-12">
	<h4>Halaman Laporan Rekap Schedule Karyawan</h4>
	<hr>
	<form class="form-inline " name="formPrint" method="post" action="">
          <div class="form-group m-r-20">
              <label class="m-r-10">Bulan</label>
              <select class="form-control" name="bulan">
              	<?php
					$nama_bln= "bln January February March April Mey June July August September October November December";
					$arr_bulan=explode(" ", $nama_bln);
					for ($i=1; $i <=12 ; $i++) { 
						echo "<option value='$i'>$arr_bulan[$i]</option>";
					}
              	?>
              </select>
          </div>
          <div class="form-group m-r-20">
              <label class="m-r-10">Tahun</label>
              <select class="form-control" name="tahun">
              		<option selected><?=date("Y")?></option>
              	<?php
              		for ($i=2050; $i >= 2000 ; $i--) { 
              			echo "<option>$i</option>";
              		}
              	?>
              </select>
          </div>
          <button type="submit" id="btn-cetak" onclick="proses()" class="btn btn-warning">Cetak Data</button>
      </form>
	</div>
</div>
<script type="text/javascript">
  function proses() {
    $("#btn-cetak").html("loading.....");
    $("#btn-cetak").attr("disabled",true);
    formPrint.submit();
  }
</script>