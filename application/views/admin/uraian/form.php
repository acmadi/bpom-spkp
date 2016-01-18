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
						<td>No Uraian</td>
						<td>:</td>
						<td><?php if($action=="add"){ ?>
								{auto-number}
							<?php }else{?>
								<input class=input type="text" size="10" name="no_uraian" readonly value="<?php 
								if(set_value('no_uraian')=="" && isset($no_uraian)){
								 	echo $no_uraian;
								}else{
									echo  set_value('no_uraian');
								}
								?>"/>
							<?php }?>
						</td>
					</tr>
					<tr>
						<td>Deskripsi</td>
						<td>:</td>
						<td><input class=input type="text" size="50" name="deskripsi" value="<?php 
								if(set_value('deskripsi')=="" && isset($deskripsi)){
								 	echo $deskripsi;
								}else{
									echo  set_value('deskripsi');
								}
								 ?>"/>
						</td>
					</tr>
					<tr>
						<td>Group</td>
						<td>:</td>
						<td><input class=input type="text" size="10" name="group" value="<?php 
								if(set_value('group')=="" && isset($group)){
								 	echo $group;
								}else{
									echo  set_value('group');
								}
								 ?>"/>
						</td>
					</tr>
						<tr>
						<td>Head</td>
						<td>:</td>
						<td><input class=input type="text" size="10" name="head" value="<?php 
								if(set_value('head')=="" && isset($head)){
								 	echo $head;
								}else{
									echo  set_value('head');
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