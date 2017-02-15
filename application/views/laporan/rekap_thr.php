<div class="col-md-12">
    <h4>Data Rekapitulasi Tunjangan THR Karyawan</h4>
    <hr>
    <div class="row">
        <div class="col-xs-12" style="margin-bottom: 20px;">
            <div class="row">
                <div class="col-sm-1">
                    <button class="btn btn-danger" id="filter">Filter</button>
                </div>
                <div class="col-sm-11">
                    <div class="row" id="form-filter">
                        <form class="form-inline" name="formPrint" method="post" action="">
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
                            <!--<div class="form-group m-r-20">
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
                            </div>-->
                            <div class="form-group m-r-20">
                                <button class="btn btn-primary" id="ft-data">Filter Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form method="post" id="form_data" action="<?=base_url('Laporan/ex_thr')?>" target="new">
        <div class="table-responsive" style="overflow: scroll; margin-top: 10px;">
            <input type="hidden" value="<?=$this->input->post('tanggal1')?>" name="tanggal1">
            <input type="hidden" value="<?=$this->input->post('tanggal2')?>" name="tanggal2">
            <input type="hidden" value="<?=$this->input->post('cabang')?>" name="cabang">
          <?=$this->session->flashdata('pesan');?>
            <?php
            if($data==true){
            $no=1;
            foreach ($data as $tampil){
            /*$pure_thr=$tampil->tarif-$tampil->pph_thr;
            $this->table->add_row($no,$this->format->TanggalIndo($tampil->tanggal_ambil),$tampil->nik,$tampil->nama_ktp,$tampil->jabatan,$tampil->department,$tampil->cabang,$tampil->nama_rekening,$tampil->no_rekening,$this->format->indo($tampil->tarif),$this->format->indo($tampil->pph_thr),$this->format->indo($pure_thr),$tampil->approved,$tampil->keterangan);*/
            $this->table->add_row($no,$tampil->field1,$tampil->field2,$this->format->indo($tampil->field3),$this->format->indo($tampil->field4),$this->format->indo($tampil->field5),$this->format->TanggalIndo($tampil->field6),$tampil->field7,$tampil->field8,"<a class='label label-warning' href='".base_url()."ThrController/".$tampil->field0."/".str_replace(',', '-', $tampil->field1)."/detailrekap'>Detail</a>");
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
            <!--<button type="submit" name="btn_aksi" value="cetak" class="btn btn-primary">
              Print All Data
            </button>-->
            <button type="submit" name="btn_aksi" value="excel" class="btn btn-success">
              Export Excel
            </button>
        </div>
    </form>
</div>
<script type="text/javascript">
  $('#filter').click(function(){
    $("#form-filter").show( "slide", {direction: "left" }, 500 );
  })
  $( document ).ready(function() {
          $('#form-filter').hide();
  });
</script>