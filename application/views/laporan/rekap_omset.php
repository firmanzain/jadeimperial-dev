<div class="col-md-12">
    <h4>Rekapitulasi Omset Dan Bonus</h4>
    <hr>
    <div class="row">
        <div class="col-xs-12" style="margin-bottom: 20px;">
            <div class="row">
                <div class="col-sm-1">
                    <button class="btn btn-danger" id="filter">Filter</button>
                </div>
                <div class="col-sm-11">
                    <div class="row" id="form-filter">
                        <form method="post" action="" class="form-inline">
                            <div class="form-group m-r-20">
                                <label class="m-r-10">Dari Tanggal</label>
                                <div class="input-group date" id="date-picker1">
                                    <input type="text" name="tanggal1" class="form-control">
                                    <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                </div>
                            </div>
                            <div class="form-group m-r-20">
                                <label class="m-r-10">Sampai Tanggal</label>
                                <div class="input-group date" id="date-picker2">
                                    <input type="text" name="tanggal2" class="form-control">
                                    <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                </div>
                            </div>
                            <div class="form-group m-r-20">
                                <label class="m-r-10">Plant</label>
                                <select class="form-control" name="cabang">
                                    <option value="">All</option>
                                    <?php
                                        foreach ($cabang as $plant) {
                                            echo "<option value='$plant->id_cabang'>$plant->cabang</option>";
                                        }
                                    ?>
                                </select>
                                <button class="btn btn-primary" id="ft-data">Filter Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form method="post" id="form_data" action="<?=base_url()?>laporan/ex_omset" target="new">
        <input type="hidden" value="<?=$this->input->post('tanggal1')?>" name="tanggal1">
        <input type="hidden" value="<?=$this->input->post('tanggal2')?>" name="tanggal2">
        <input type="hidden" value="<?=$this->input->post('cabang')?>" name="cabang">
    <div class="table-responsive" style="overflow: scroll;">        
        <?php
        if($data==true){
        $no=1;$sisa=0;
        foreach ($data as $tampil){
        $sisa=$tampil->pure_bonus*2-$tampil->bonus_bagi;
        $this->table->add_row($no,$tampil->cabang,$tampil->jml_karyawan,$this->format->BulanIndo($tampil->bln_omset),$this->format->indo($tampil->omset),$this->format->indo($tampil->prosen_mpd),
                    $this->format->indo($tampil->prosen_lb),$this->format->indo($tampil->pure_bonus*2),$this->format->indo($tampil->bonus_bagi),
                    $this->format->indo($sisa),'0');
        $no++;
        }
        $tabel=$this->table->generate();
        echo $tabel;
        }else {
        echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
        }
        ?>
    </div>
    <div class="form-group">
        <button class="btn btn-success">
            Export Excel
        </button>
    </div>
    </form>
</div>
<script>
function cetak(a) {
  sUrl="<?=base_url()?>komisi/"+a+"/print"; features = 'toolbar=no, left=350,top=100, ' + 
  'directories=no, status=no, menubar=no, ' + 
  'scrollbars=no, resizable=no';
  window.open(sUrl,"winChild",features);
}
$('#filter').click(function(){
    $("#form-filter").show( "slide", {direction: "left" }, 500 );
})
$( document ).ready(function() {
        $('#form-filter').hide();
});
</script>