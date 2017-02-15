<div class="col-md-12">
    <h4>Data Pinjaman Karyawan</h4>
    <hr>
    <div class="table-responsive" style="overflow: scroll;">
    <?=$this->session->flashdata('pesan');?>
        <form name="form_data" method="post" id="form_data" action="<?=base_url()?>Pinjaman/hapus">
        <?php
        if($data==true){
        $no=1;
        foreach ($data as $tampil){
            $this->db->select_sum('pinjaman');
            $this->db->from('tab_gaji_karyawan_new');
            $this->db->where('nik',$tampil->nik);
            $this->db->where('approval',2);
            $query = $this->db->get();
            foreach ($query->result() as $row) {
                $sisa = $row->pinjaman;
            }

        $this->table->add_row('<input type=checkbox name=cb_data[] id=cb_data[] value='.$tampil->id_pinjaman.'>',$no,$tampil->nik,$tampil->nama_ktp,$tampil->jabatan,$tampil->department,$tampil->manager,$tampil->hrd,$tampil->cabang,$this->format->indo($tampil->jml_pinjam),$this->format->indo($tampil->jml_cicilan),$this->format->indo($tampil->jml_pinjam-$sisa),$tampil->keterangan,$this->format->TanggalIndo($data->tanggal_pinjam));
        $no++;
        }
        $tabel=$this->table->generate();
        echo $tabel;
        }else {
        echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
        }
        ?>
        <div class="form-group">
        <?=anchor('Pinjaman/create','Tambah Data',['class' => 'btn btn-primary'])?>
        <button class="btn btn-danger" value="Hapus" name="tombol" onClick="return warning();">Hapus Data</button>
        </div>
      </form>
    </div>
</div>