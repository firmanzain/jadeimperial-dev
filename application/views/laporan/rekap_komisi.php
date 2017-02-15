<div class="col-md-12">
    <h4>Rekapitulasi Komisi Karyawan <?php echo $cabang;?> <br>Periode <?php echo $this->format->TanggalIndo($tgl1);?> s/d <?php echo $this->format->TanggalIndo($tgl2);?></h4>
    <hr>
    <form class="form-horizontal" id="form-periode" method="POST">
        <div class="form-group row">
          <label class="col-sm-2 form-control-label text-center"><b>PERIODE</b></label>
            <div class="col-sm-4">
                <div class="input-daterange input-group" id="date-picker1">
                    <input type="text" class="input-sm form-control" name="tgl1" value="<?php echo $tgl1;?>" />
                    <span class="input-group-addon">s/d</span>
                    <input type="text" class="input-sm form-control" name="tgl2" value="<?php echo $tgl2;?>" />
                </div>
            </div>
            <div class="col-sm-2">
                <select class="form-control" name="cabang">
                    <option value="">All</option>
                    <?php
                        $cb=$this->db->get('tab_cabang')->result();
                        foreach ($cb as $plant) {
                            echo "<option value='$plant->id_cabang'>$plant->cabang</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="col-sm-4 text-left">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>
    <form method="post" id="form_data" action="<?=base_url()?>KomisiController/cetakData" target="new">
        <input type="hidden" value="<?=$this->input->post('tgl1')?>" name="tanggal1">
        <input type="hidden" value="<?=$this->input->post('tgl2')?>" name="tanggal2">
        <input type="hidden" value="<?=$this->input->post('cabang')?>" name="cabang">
    <div class="table-responsive" style="overflow: scroll;">        
        <?php
        if($data==true){
        $no=1;
        foreach ($data as $tampil){
        if (is_null($tampil->approved)) {
            $mati="disabled";
            $status="Pending";
            $keterangan="---";
        } else {
            if ($tampil->approved=="Ya") {
                $mati="";
                $status=$tampil->approved;
                $keterangan=$tampil->keterangan;
            } else {
                $mati="disabled";
                $status=$tampil->approved;
                $keterangan=$tampil->keterangan;
            }
        }
        $this->table->add_row($no,$tampil->nik,$tampil->nama_ktp,$tampil->nama_rekening,$tampil->no_rekening,$tampil->jabatan,$tampil->cabang,$this->format->indo($tampil->omset),$this->format->indo($tampil->komisi),$this->format->BulanIndo(date('m',strtotime('-1 month',strtotime($tampil->bulan)))),$status,$keterangan,"<button type='button' onclick='cetak($tampil->nik)' class='btn btn-warning' $mati>Cetak</button>");
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
        <button type="submit" name="cetak" value="cetak" class="btn btn-primary">
          Print All Data
        </button>
        <button type="submit" name="cetak" value="excel" class="btn btn-success">
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
$( document ).ready(function() {
});
</script>