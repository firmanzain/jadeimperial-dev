<script src="<?=base_url()?>assets/scripts/Chart.min.js"></script>
<style type="text/css">
    .chart-legend li span{
        display: inline-block;
        width: 12px;
        height: 12px;
        margin-right: 5px;
        list-style-type: none;
    }
    .chart-legend li {
        list-style-type: none;
        display: inline;
        padding-left: 10px;
    }
</style>
<div class="row m-b-20">
    <div class="col-xs-12">
        <h5>
           Statistik Kehadiran Harian Karyawan <?=$this->format->TanggalIndo($this->uri->segment(2))?>
        </h5>
        <hr>
    </div>
</div>
<form class="form-inline" name="formPrint" method="post" action="">
  <div class="form-group m-r-20">
      <label class="m-r-10">Plant</label>
      <select class="form-control" name="cabang">
          <option>---</option>
        <?php
          foreach ($cabang as $rs_cab) {
              echo "<option value='$rs_cab->id_cabang'>$rs_cab->cabang</option>";
          }
        ?>
      </select>
  </div>
  <button type="submit" class="btn btn-info" id="btn-cetak">Filter Data</button>
</form>
<div class="row m-b-20" style="margin-top: 30px">
    <div class="col-md-10">
        <center><b style="text-align: center;">Statistik Kehadiran Karyawan <?= ucfirst($nama_cabang->cabang) ?></b></center>
        <canvas id="bar-chart" style="width:100%; height: 300px"></canvas>
        <div id="legend-bar" class="chart-legend"></div>
    </div>
</div>
<div class="form-group">
    <button class="btn btn-warning" onclick="window.history.go(-1); return false;">Kembali</button>
</div>
<script type="text/javascript"> 
var masuk=<?=$masuk?>;
var cuti=<?=$cuti?>;
var izin=<?=$izin?>;
var absen=<?=$absen?>;
</script>
<script src="<?=base_url()?>assets/scripts/absensi_chart.js"></script>