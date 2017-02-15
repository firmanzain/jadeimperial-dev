<div class="col-md-12">
    <h4>Data Resign Karyawan Periode <br><?php echo $this->format->TanggalIndo($tgl1);?> s/d <?php echo $this->format->TanggalIndo($tgl2);?></h4>
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
            <div class="col-sm-6 text-left">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>
    <?=$this->session->flashdata('pesan');?>
        <form name="form_data" method="post" id="form_data" action="<?=base_url()?>resign/aksi">
        <?php
        if($data==true){
        $no=1;
        foreach ($data as $tampil){
        $this->table->add_row('<input type=checkbox name=cb_data[] id=cb_data[] value='.$tampil->id.'>',$no,$tampil->nik,$tampil->nama_ktp,$tampil->jabatan,$tampil->department,$tampil->cabang,$this->format->TanggalIndo($tampil->tanggal),$tampil->keterangan,anchor('ResignController/c_bpjs/'.$tampil->id,'Bpjs',['class' => 'label label-warning',"target" => "blank"]).' | '.anchor('ResignController/c_skpk/'.$tampil->id,'SKPK',['class' => 'label label-success',"target" => "blank"]));
        $no++;
        }
        $tabel=$this->table->generate();
        echo $tabel;
        }else {
        echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
        }
        ?>
        <div class="form-group">
        <?=anchor('resign/add','Tambah Data',['class' => 'btn btn-primary'])?>
        <button class="btn btn-danger" value="Hapus" name="tombol" onClick="return warning();">Hapus Data</button>
        <button class="btn btn-default" value="print" name="tombol" onclick="goPrint()" type="button" >Print Dokumen Selected</button>
        </div>
      </form>
</div>
<script type="text/javascript">
    var a = document.getElementById('form_data');
    function goPrint() {
        a.setAttribute('target','_new');
        a.submit();
        a.removeAttribute('target');
    }
</script>