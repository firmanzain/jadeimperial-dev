<div class="row">
	<div class="col-md-12">
	<h4>Halaman Laporan Absensi Karyawan</h4>
	<hr>
	<form class="form-inline" name="formPrint" method="post" action="" target="new">
          <div class="form-group m-r-20">
              <label class="m-r-10">Bulan</label>
              <select class="form-control" name="bulan">
              	<?php
					for ($i=1; $i <=12 ; $i++) { 
						echo "<option value='$i'>".$this->format->BulanIndo($i)."</option>";
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
          <button type="submit" class="btn btn-warning" id="btn-cetak" >Cetak Data</button>
      </form>
	</div>
</div>
