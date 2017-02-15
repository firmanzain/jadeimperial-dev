<div class="col-sm-12">
    <h4>Rekapitulasi Detail Absensi Karyawan <?=$cabang?> <?=$nama?> <br>Periode <?php echo $this->format->TanggalIndo($tgl1);?> s/d <?php echo $this->format->TanggalIndo($tgl2);?></h4>
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
          <form method="post" action="<?=base_url('Laporan/ex_absensi_detail')?>" target="new">
            <input type="hidden" name="tgl1" value="<?=$tgl1?>">
            <input type="hidden" name="tgl2" value="<?=$tgl2?>">
            <input type="hidden" name="cabang" value="<?=$cabang_id?>">
            <input type="hidden" name="nik" value="<?=$nik?>">
            <div class="table-responsive" style="overflow:scroll;">
            <?php
                $this->table->set_heading(array('Nama Perusahaan','Plant','Department','Golongan','NIK','Nama Employe','Jabatan','Tanggal Absensi','Kode Shift','Tipe Shift','Jadwal Masuk','Jam Masuk','Status Masuk','Keterangan Masuk','Jadwal Keluar','Jam Keluar','Status Keluar','Keterangan Keluar','Jadwal Masuk 2','Jam Masuk 2','Status Masuk 2','Keterangan Masuk 2','Jadwal Keluar 2','Jam Keluar 2','Status Keluar 2','Keterangan Keluar 2'));
                $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
                  'thead_open'=>'<thead>',
                  'thead_close'=> '</thead>',
                  'tbody_open'=> '<tbody>',
                  'tbody_close'=> '</tbody>',
                );
                $this->table->set_template($tmp);

                $no=1;
                foreach ($data as $val) {

                  $this->table->add_row('CRN',$val->cabang_real,$val->department_real,$val->status_kerja,$val->nik_real,$val->nama_ktp,$val->jabatan_real,$this->format->TanggalIndo($val->tgl_kerja),$val->kode_jam_real,$val->tipe_shift,$val->jam_start,$val->jam_masuk1,$val->status_masuk,$val->keterangan_masuk,$val->jam_finish,$val->jam_keluar1,$val->status_keluar,$val->keterangan_keluar,$val->jam_start2,$val->jam_masuk2,$val->status_masuk2,$val->keterangan_masuk2,$val->jam_finish2,$val->jam_keluar2,$val->status_keluar2,$val->keterangan_keluar2);
                  $no++;
                }
                $tabel=$this->table->generate();
                echo $tabel;
            ?>
      </div>
      <div class="form-group">
        <button onclick="window.history.go(-1); return false;" class="btn btn-warning" type="button">Kembali</button>
        <button type="submit" class="btn btn-success">Export Excel</button>
      </div>
          </form>
    </div>
<script type="text/javascript">
</script>

