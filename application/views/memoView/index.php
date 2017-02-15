<form method="post" action="">
<input type="hidden" value="jenis" name="jenis">
<?php
		$m=$this->db->where('jenis_memo','jenis');
		$m1=$this->db->get('tab_memo')->row();
		?>
<textarea class="ckeditor" name="memo" ><?=$m1->isi_memo?>
</textarea>
<button type="submit" style="margin-left:40%;margin-top:5%;width:20%;height:40%;" class="btn btn-primary" name="submit">Simpan</button>
</form>