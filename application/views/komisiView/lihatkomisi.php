<?php 
	$this->db->where('nik',$hasil->nik);
	$k = $this->db->get('tab_komisi')->row();
		$bul= substr($k->bulan, 0,7);
		$bulan = date('Y-m');
	if($bul == $bulan){ ?>
	<h3>Komisi untuk <?=$hasil->nama_ktp?></h3>
		<table class="table table-bordered">
			<tr>
			<td width="350px">Omset yang dihasilkan oleh <?=$hasil->nama_ktp?></td>
			<td>: Rp.<?=$k->omset?>,00</td>
			</tr>
			<tr>
			<td>Komisi yang didapat(Omset * 1%)</td>
			<td>: Rp.<?php $komisi = $k->omset * '0.01'; echo $komisi?>,00</td>
			</tr>
		</table>
		<table>
		<tr>
		<td>
		<form method="post" action="">
			<input type="hidden" name="komisi" value="<?=$komisi?>">
			<input type="hidden" name="id" value="<?=$k->id_komisi?>">
			<?php if($k->komisi == '0'){?>
				<button type="submit" class="btn btn-primary" name="submit">Simpan Komisi</button>
			<?php }
			else
			{
				echo anchor('KomisiController/cetakkomisi/'.$hasil->nik.'/','<span class="label label-warning" style="margin-left:30px;"><div class="zmdi zmdi-print zmdi-hc-2x"></div>Print</span>');
			}?>
		</form>
		</td><td>
	<?php 
	}else{
		echo anchor('KomisiController/komisisales/'.$hasil->nik.'/','<span class="label label-warning"> Isi Komisi Bulan '.$bulan.'</span>');
	}?></td></tr></table><br>
		<button type="button" class="btn btn-info" onclick="window.history.go(-1); return false;">Kembali</button>