<div class="row">
	<div class="col-md-12">
	<h4>Halaman Laporan Rekap BPJS</h4>
	<hr>
	<form class="form-inline" name="formPrint" method="post" action="<?=base_url()?>bpjs/cetak" target="new">
          <div class="form-group m-r-20">
              <label class="m-r-10">Jenis BPJS</label>
              <select class="form-control" name="jenis">
                <?php
                  $bpjs=$this->db->where('status_bpjs','1')->get('tab_master_bpjs')->result();
                  foreach ($bpjs as $row) {
                    echo "<option value='$row->id_bpjs'>$row->nama_bpjs</option>";
                  }
                ?>
              </select>
          </div>
          <div class="form-group m-r-20">
              <label class="m-r-10">Bulan</label>
              <select class="form-control" name="bulan">
                <option selected value="<?=date('m')?>"><?=$this->format->BulanIndo(date('m'))?></option>
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
          <div class="form-group m-r-20">
              <label class="m-r-10">Plant</label>
              <select class="form-control" name="cabang">
              <option value="">All</option>
                <?php
                  $cb=$this->db->get('tab_cabang')->result();
                  foreach ($cb as $cabang) {
                    echo "<option value='$cabang->id_cabang'>$cabang->cabang</option>";
                  }
                ?>
              </select>
          </div>
          <button type="submit" class="btn btn-warning" id="btn-cetak" >Cetak Data</button>
      </form>
	</div>
</div>
