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
						<td>ID Pendidikan</td>
						<td>:</td>
						<td><?php if($action=="add"){ ?>
								{auto-number}
							<?php }else{?>
								<input class=input type="text" size="10" name="id_pendidikan" readonly value="<?php 
								if(set_value('id_pendidikan')=="" && isset($id_pendidikan)){
								 	echo $id_pendidikan;
								}else{
									echo  set_value('id_pendidikan');
								}
								?>"/>
							<?php }?>
						</td>
					</tr>
					                    <tr>
						<td>Nama</td>
						<td>:</td>
						<td><input class=input type="text" size="50" name="nama" value="<?php 
								if(set_value('nama')=="" && isset($nama)){
								 	echo $nama;
								}else{
									echo  set_value('nama');
								}
								 ?>"/>
						</td>
					</tr>

                    <tr>
						<td>Tingkat</td>
						<td>:</td>
						<td><input class=input type="text" size="50" name="tingkat" value="<?php 
								if(set_value('tingkat')=="" && isset($tingkat)){
								 	echo $tingkat;
								}else{
									echo  set_value('tingkat');
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