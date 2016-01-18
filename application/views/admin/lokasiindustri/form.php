<div style="padding:5px;text-align:center">
<form method="POST" id="frmData">
	<button type="button" class=btn onClick="save_{action}_dialog($('#frmData').serialize());">Simpan</button>
	<button type="reset"  class=btn>Ulang</button>
	<button type="button" class=btn onClick="close_dialog();">Batal</button>
	<br />
	<br />
	<table border="0" cellpadding="0" cellspacing="8" class="panel" align="center">
		<tr>
			<td>

				<table border="0" cellpadding="3" cellspacing="2">
					<tr>
						<td>ID Lokasi</td>
						<td>:</td>
						<td><?php if($action=="add"){ ?>
								{auto-number}
							<?php }else{?>
								<input class=input type="text" size="10" name="id_lokasi" readonly value="<?php 
								if(set_value('id_lokasi')=="" && isset($id_lokasi)){
								 	echo $id_lokasi;
								}else{
									echo  set_value('id_lokasi');
								}
								?>"/>
							<?php }?>
						</td>
					</tr>
					<tr>
						<td>Nama Lokasi</td>
						<td>:</td>
						<td><input class=input type="text" size="50" name="nama_lokasi" value="<?php 
								if(set_value('nama_lokasi')=="" && isset($nama_lokasi)){
								 	echo $nama_lokasi;
								}else{
									echo  set_value('nama_lokasi');
								}
								 ?>"/>
						</td>
					</tr>
					<tr>
						<td colspan="3" height="30"></td>
					</tr>
				</table>

			</td>
		</tr>
	</table>
</form>
</div>