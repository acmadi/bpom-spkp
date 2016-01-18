<script type="text/javascript">
    $(document).ready(function(){
       $("button,submit,reset").jqxInput({ theme: 'fresh', height: '28px' }); 
    });
</script>
<div style="padding:5px;text-align:center">
<form method="POST" id="frmData">
	<button type="button" onClick="save_{action}_dialog($('#frmData').serialize());">Simpan</button>
	<button type="reset">Ulang</button>
	<button type="button" onClick="close_dialog();">Batal</button>
	<br />
	<br />
	<table border="0" cellpadding="0" cellspacing="8" class="panel" align="center">
		<tr>
			<td>

				<table border="0" cellpadding="3" cellspacing="2">
					<tr>
						<td>ID Golongan</td>
						<td>:</td>
						<td><?php if($action=="add"){ ?>
								{auto-number}
							<?php }else{?>
								<input class=input type="text" size="10" name="id_golongan" readonly value="<?php 
								if(set_value('id_golongan')=="" && isset($id_golongan)){
								 	echo $id_golongan;
								}else{
									echo  set_value('id_golongan');
								}
								?>"/>
							<?php }?>
						</td>
					</tr>
					                    <tr>
						<td>Jabatan</td>
						<td>:</td>
						<td><input class=input type="text" size="50" name="jabatan" value="<?php 
								if(set_value('jabatan')=="" && isset($jabatan)){
								 	echo $jabatan;
								}else{
									echo  set_value('jabatan');
								}
								 ?>"/>
						</td>
					</tr>

                    <tr>
						<td>Golongan</td>
						<td>:</td>
						<td><input class=input type="text" size="50" name="golongan" value="<?php 
								if(set_value('golongan')=="" && isset($golongan)){
								 	echo $golongan;
								}else{
									echo  set_value('golongan');
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