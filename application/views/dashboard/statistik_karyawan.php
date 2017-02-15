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
           Statitistik Perkembangan Kinerja Karyawan
        </h5>
        <br>
    </div>
</div>
<div class="row m-b-20">
    <div class="col-md-12">
        <div class="col-md-12">
            <div class="col-md-6">
                        <b>Statistik Absensi Keterlambatan Karyawan</b> 
                        <canvas id="line-chart" style="width:100%; height: 300px"></canvas>
            </div>
            <div class="col-md-6">
                        <b>Statistik Penggajian Karyawan</b> 
                        <canvas id="gaji-chart" style="width:100%; height: 300px"></canvas>
            </div>
        </div>
        <div class="col-md-12">
            <div class="col-md-6">
                    <b>Statistik Komisi Karyawan</b> 
                    <canvas id="komisi-chart" style="width:100%; height: 300px"></canvas>
            </div>
            <div class="col-md-6">
                        <b>Statistik Tunjangan Karyawan</b> 
                        <canvas id="tunjangan-chart" style="width:100%; height: 300px"></canvas>
            </div>
        </div>
        <div class="col-md-12">
            <div class="col-md-6">
                        <b>Statistik Ekstra Karyawan</b> 
                        <canvas id="ekstra-chart" style="width:100%; height: 300px"></canvas>
            </div>
            <div class="col-md-6">
                    <b>Statistik Perizinan Karyawan</b> 
                    <canvas id="bar-chart" style="width:100%; height: 300px"></canvas>
                    <div id="legend-bar" class="chart-legend"></div>
            </div>
        </div>
        <div class="col-md-6">
                    <b>Statistik Cuti Karyawan</b> 
                <canvas id="cuti-chart" style="width:100%; height: 300px"></canvas>
                <div id="legend-bar-cuti" class="chart-legend"></div>
        </div>
    </div>
</div>

<script type="text/javascript"> 
var data=<?=$js_bulan?>;
var bulan_gaji=<?=$js_bulan_gaji?>;
var bulan_tj=<?=$js_bulan_tj?>;
var tunjangan=<?=$js_tj?>;
var bulan_ekstra=<?=$js_bulan_ekstra?>;
var ekstra=<?=$js_ekstra?>;
var bulan_komisi=<?=$js_bulan_komisi?>;
var komisi=<?=$js_komisi?>;
var gaji_karyawan=<?=$js_gaji?>;
var nilai=<?=$js_nilai?>;
var izin=<?=$js_izin?>;
var datang=<?=$js_datang?>;
var pulang=<?=$js_pulang?>;
var cutiBiasa=<?=$js_biasa?>;
var cutiKhusus=<?=$js_khusus?>;
</script>
<script src="<?=base_url()?>assets/scripts/charts-chart-js.js"></script>
