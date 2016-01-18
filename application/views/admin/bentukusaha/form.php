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
						<td>ID Bentuk Perusahaan</td>
						<td>:</td>
						<td><?php if($action=="add"){ ?>
								{auto-number}
							<?php }else{?>
								<input class=input type="text" size="10" name="id" readonly value="<?php 
								if(set_value('id')=="" && isset($id)){
								 	echo $id;
								}else{
									echo  set_value('id');
								}
								?>"/>
							<?php }?>
						</td>
					</tr>
					<tr>
						<td>Kode Bentuk Perusahaan</td>
						<td>:</td>
						<td><input class=input type="text" size="50" name="nama_bentuk" value="<?php 
								if(set_value('nama_bentuk')=="" && isset($nama_bentuk)){
								 	echo $nama_bentuk;
								}else{
									echo  set_value('nama_bentuk');
								}
								 ?>"/>
						</td>
					</tr>
					<tr>
						<td>Nama Bentuk Perusahaan</td>
						<td>:</td>
						<td><input class=input type="text" size="50" name="nama_bentuk2" value="<?php 
								if(set_value('nama_bentuk2')=="" && isset($nama_bentuk2)){
								 	echo $nama_bentuk2;
								}else{
									echo  set_value('nama_bentuk2');
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