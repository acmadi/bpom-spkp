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
						<td>ID Jenis Industri</td>
						<td>:</td>
						<td><?php if($action=="add"){ ?>
								{auto-number}
							<?php }else{?>
								<input class=input type="text" size="10" name="id_jenis" readonly value="<?php 
								if(set_value('id_jenis')=="" && isset($id_jenis)){
								 	echo $id_jenis;
								}else{
									echo  set_value('id_jenis');
								}
								?>"/>
							<?php }?>
						</td>
					</tr>
					<tr>
						<td>Kode Jenis Industri</td>
						<td>:</td>
						<td><input class=input type="text" size="50" name="nama_jenis" value="<?php 
								if(set_value('nama_jenis')=="" && isset($nama_jenis)){
								 	echo $nama_jenis;
								}else{
									echo  set_value('nama_jenis');
								}
								 ?>"/>
						</td>
					</tr>
					<tr>
						<td>Nama Jenis Industri</td>
						<td>:</td>
						<td><input class=input type="text" size="50" name="nama_jenis2" value="<?php 
								if(set_value('nama_jenis2')=="" && isset($nama_jenis2)){
								 	echo $nama_jenis2;
								}else{
									echo  set_value('nama_jenis2');
								}
								 ?>"/>
						</td>
					</tr>
				</table>

			</td>
		</tr>
	</table>
</form>
</div>