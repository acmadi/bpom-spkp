<div style="padding:5px;text-align:center">
<form method="POST" id="frmData">
	<button type="button" class=btn onClick="save_{action}_dialog($('#frmData').serialize());">Simpan</button>
	<button type="reset"  class=btn>Ulang</button>
	<button type="button" class=btn onClick="close_dialog();">Batal</button>
	<br />
	<br />
	<table border="0" cellpadding="0" cellspacing="8" class="panel">
		<tr>
			<td>

				<table border="0" cellpadding="3" cellspacing="2">
					<tr>
						<td>Id Sediaan</td>
						<td>:</td>
						<td><?php if($action=="add"){ ?>
								{auto-number}
							<?php }else{?>
								<input class=input type="text" size="10" name="id_sediaan" readonly value="<?php 
								if(set_value('id_sediaan')=="" && isset($id_sediaan)){
								 	echo $id_sediaan;
								}else{
									echo  set_value('id_sediaan');
								}
								?>"/>
							<?php }?>
						</td>
					</tr>
					<tr>
						<td>Nama Sediaan</td>
						<td>:</td>
						<td><input class=input type="text" size="50" name="nama_sediaan" value="<?php 
								if(set_value('nama_sediaan')=="" && isset($nama_sediaan)){
								 	echo $nama_sediaan;
								}else{
									echo  set_value('nama_sediaan');
								}
								 ?>"/>
						</td>
					</tr>
					<tr>
						<td>Group Jenis</td>
						<td>:</td>
						<td><?php
							if(set_value('id_jenis')=="" && isset($id_jenis)){
								echo $this->crud->get_jenis_industri($id_jenis);
							}else{
								echo $this->crud->get_jenis_industri();
							}
						?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</form>
</div>