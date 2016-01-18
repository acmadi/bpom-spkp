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
						<td>ID Balai</td>
						<td>:</td>
						<td><?php if($action=="add"){ ?>
								{auto-number}
							<?php }else{?>
								<input class=input type="text" size="10" name="id_balai" readonly value="<?php 
								if(set_value('id_balai')=="" && isset($id_balai)){
								 	echo $id_balai;
								}else{
									echo  set_value('id_balai');
								}
								?>"/>
							<?php }?>
						</td>
					</tr>
					<tr>
						<td>Nama Balai</td>
						<td>:</td>
						<td><input class=input type="text" size="50" name="nama_balai" value="<?php 
								if(set_value('nama_balai')=="" && isset($nama_balai)){
								 	echo $nama_balai;
								}else{
									echo  set_value('nama_balai');
								}
								 ?>"/>
						</td>
					</tr>
					<tr>
						<td colspan="3" height="30"></td>
					</tr>
					<tr>
						<td>Alamat</td>
						<td>:</td>
						<td><input class=input type="text" size="60" name="alamat" value="<?php 
								if(set_value('alamat')=="" && isset($alamat)){
								 	echo $alamat;
								}else{
									echo  set_value('alamat');
								}
								 ?>"/>
						</td>
					</tr>
					<tr>
						<td>Propinsi</td>
						<td>:</td>
						<td><?php
							if(set_value('propinsi')=="" && isset($propinsi)){
								echo $this->crud->get_propinsi($propinsi);
							}else{
								echo $this->crud->get_propinsi();
							}
						?>
						</td>
					</tr>
					<tr>
						<td>Kode Pos</td>
						<td>:</td>
						<td><input class=input type="text" size="10" name="kd_pos" value="<?php 
								if(set_value('kd_pos')=="" && isset($kd_pos)){
								 	echo $kd_pos;
								}else{
									echo  set_value('kd_pos');
								}
								 ?>"/>
						</td>
					</tr>
					<tr>
						<td colspan="3" height="30"></td>
					</tr>
					<tr>
						<td>Telp</td>
						<td>:</td>
						<td><input class=input type="text" size="20" name="telp" value="<?php 
								if(set_value('telp')=="" && isset($telp)){
								 	echo $telp;
								}else{
									echo  set_value('telp');
								}
								 ?>"/>
						</td>
					</tr>
					<tr>
						<td>Fax</td>
						<td>:</td>
						<td><input class=input type="text" size="20" name="fax" value="<?php 
								if(set_value('fax')=="" && isset($fax)){
								 	echo $fax;
								}else{
									echo  set_value('fax');
								}
								 ?>"/>
						</td>
					</tr>
					<tr>
						<td>Email</td>
						<td>:</td>
						<td><input class=input type="text" size="30" name="email" value="<?php 
								if(set_value('email')=="" && isset($email)){
								 	echo $email;
								}else{
									echo  set_value('email');
								}
								 ?>"/>
						</td>
					</tr>
					<tr>
						<td colspan="3" height="30"></td>
					</tr>
					<tr>
						<td>NIP Kepala</td>
						<td>:</td>
						<td><input class=input type="text" size="30" name="nip_kepala" value="<?php 
								if(set_value('nip_kepala')=="" && isset($nip_kepala)){
								 	echo $nip_kepala;
								}else{
									echo  set_value('nip_kepala');
								}
								 ?>"/>
						</td>
					</tr>
					<tr>
						<td>Nama Kepala</td>
						<td>:</td>
						<td><input class=input type="text" size="40" name="nama_kepala" value="<?php 
								if(set_value('nama_kepala')=="" && isset($nama_kepala)){
								 	echo $nama_kepala;
								}else{
									echo  set_value('nama_kepala');
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