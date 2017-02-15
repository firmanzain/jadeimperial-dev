<style type="text/css">
    #tabel td,th {
        text-align: center;
    }
    #tabel #nama_menu{
        text-align: left;
    }
    #tabel #sub_mn{
        text-align: left;
    }
</style>
<div class="col-md-12">
    <h4>Set Hak Akses User <?=ucfirst($level->deskripsi)?></h4>
    <hr>
    <?=$this->session->flashdata('pesan');?>
        <form name="form_data" method="post" id="form_data" action="">
        <table class="table table-hover table-striped table-bordered" id="tabel">
            <tr>
                <th rowspan="2">NO</th>
                <th rowspan="2">MENU USER</th>
                <th colspan="4">PRIVILLAGE</th>
            </tr>
            <tr>
                <th>
                    <label class="c-input c-checkbox">
                        <input type="checkbox" name="cek" onclick="return checkedAll(form_data);"> <span class="c-indicator c-indicator-warning"></span><span class="c-input-text">READ</span> 
                    </label>
                </th>
                <th>
                    <label class="c-input c-checkbox">
                        <input type="checkbox" name="cek"> <span class="c-indicator c-indicator-warning"></span><span class="c-input-text">CREAD</span> 
                    </label>
                </th>
                <th>
                    <label class="c-input c-checkbox">
                        <input type="checkbox" name="cek"> <span class="c-indicator c-indicator-warning"></span><span class="c-input-text">UPDATE</span> 
                    </label>
                </th>
                <th>
                    <label class="c-input c-checkbox">
                        <input type="checkbox" name="cek"> <span class="c-indicator c-indicator-warning"></span><span class="c-input-text">DELETE</span> 
                    </label>
                </th>
            </tr>
        <?php
        if($data==true)
        {
        $no=1;$i=0;$j=0;
        foreach ($data as $tampil){
        if (isset($tampil->id_level)) {
                if ($tampil->c==1) $cek_c="checked"; else $cek_c="";
                if ($tampil->r==1) $cek_r="checked"; else $cek_r="";
                if ($tampil->u==1) $cek_u="checked"; else $cek_u="";
                if ($tampil->d==1) $cek_d="checked"; else $cek_d="";
                $submenu=$this->db->join('submenu','submenu.id_sub=tab_akses_submenu.id_sub_menu','left')->where('submenu.mainmenu_idmenu',$tampil->idmenu)->get('tab_akses_submenu')->result();
        } 
        else 
        {
            $submenu=$this->db->where('mainmenu_idmenu',$tampil->idmenu)->get('submenu')->result();
            $cek="";

                // anwar
                $cek_c="";
                $cek_r="";
                $cek_u="";
                $cek_d="";
        }
        echo "<tr>
                    <td>$no</td>
                    <td id='nama_menu'><b>$tampil->nama_menu</b></td>
                    <td><input type=checkbox name=cb_read_menu[$i] id=cb_read_menu[$i] value='1' $cek_r></td>
                    <td><input type=checkbox name=cb_create_menu[$i] id=cb_create_menu[$i] value='1' $cek_c></td>
                    <td><input type=checkbox name=cb_update_menu[$i] id=cb_update_menu[$i] value='1' $cek_u></td>
                    <td><input type=checkbox name=cb_delete_menu[$i] id=cb_delete_menu[$i] value='1' $cek_d></td>
              </tr>";
           if($tampil->link_menu=='#') {
           foreach ($submenu as $rs) {
            if (isset($rs->id_level)) 
            {
                    if ($rs->c==1) $cek_c_sub="checked"; else $cek_c_sub="";
                    if ($rs->r==1) $cek_r_sub="checked"; else $cek_r_sub="";
                    if ($rs->u==1) $cek_u_sub="checked"; else $cek_u_sub="";
                    if ($rs->d==1) $cek_d_sub="checked"; else $cek_d_sub="";
            }else
            {
                $cek="";

                // anwar
                $cek_r_sub="";
                $cek_c_sub="";
                $cek_u_sub="";
                $cek_d_sub="";
            }
        ?>
        <tr>
            <td></td>
            <td id="sub_mn"><?=$rs->nama_sub?></td>
            <td><?="<input type=checkbox name=cb_read_sub[$i][$j] id=cb_read_sub[$i][$j] value='1' $cek_r_sub>"?></td>
            <td><?="<input type=checkbox name=cb_create_sub[$i][$j] id=cb_create_sub[$i][$j] value='1' $cek_c_sub>"?></td>
            <td><?="<input type=checkbox name=cb_update_sub[$i][$j] id=cb_update_sub[$i][$j] value='1' $cek_u_sub>"?></td>
            <td><?="<input type=checkbox name=cb_delete_sub[$i][$j] id=cb_delete_sub[$i][$j] value='1' $cek_d_sub>"?></td>
        </tr>
        <?php
        $j++;
            }
            }
        $no++;
        $i++;
        }
        }else {
             echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
        }
        ?>
        </table>
        <div class="panel-footer">
        <button class="btn btn-success" type="submit">Simpan Data</button>
        <button class="btn btn-warning" type="button" onclick="window.history.go(-1); return false;">Cancel</button>
        </form>
        </div>
</div>