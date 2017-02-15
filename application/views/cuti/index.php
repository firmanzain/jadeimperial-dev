<div class="col-md-12">
		<h4>Data Cuti Karyawan<br>Periode <?php echo $this->format->TanggalIndo($tgl1);?> s/d <?php echo $this->format->TanggalIndo($tgl2);?></h4>
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
      <form name="form_data" method="post" id="form_data" action="<?=base_url()?>cuti/hapus">
        <div class="table-responsive">
          <?php
           if($data==true){
            $no=1;
            foreach ($data as $tampil){
            if ($tampil->cuti_khusus=="Ya") {
              $data_khusus=$tampil->keterangan;
            }else{
              $data_khusus=$tampil->cuti_khusus;
            }
            //$this->table->add_row('<input type=checkbox name=cb_data[] id=cb_data[] value='.$tampil->id_cuti.'>',$no,$tampil->nama_ktp,$this->format->TanggalIndo($tampil->tanggal_mulai).' s/d '.$this->format->TanggalIndo($tampil->tanggal_finish),$tampil->lama_cuti.' Hari',$data_khusus,$tampil->keterangan_cuti,$tampil->hrd,$tampil->kepala_department,$tampil->manager,anchor('cuti/'.$tampil->id_cuti.'/edit','<i class="fa pencil-square-o"></i><span class="label label-warning">Edit</span>'));
            $this->table->add_row('<input type=checkbox name=cb_data[] id=cb_data[] value='.$tampil->id_cuti.'>',$no,$tampil->nama_ktp,$this->format->TanggalIndo($tampil->tanggal_mulai).' s/d '.$this->format->TanggalIndo($tampil->tanggal_finish),$tampil->lama_cuti.' Hari',$data_khusus,$tampil->keterangan_cuti,$tampil->hrd,$tampil->kepala_department,$tampil->manager);
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
         <?=anchor('cuti/add','Tambah Data',['class' => 'btn btn-primary'])?>
          <button class="btn btn-danger" value="Hapus" onClick="return warning();"><i class="fa fa-trash-o"></i> Hapus Data</button>
      </div>
    </form>
</div>