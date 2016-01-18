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
						<td>ID Subdit</td>
						<td>:</td>
						<td><?php if($action=="add"){ ?>
								{auto-number}
							<?php }else{?>
								<input class=input type="text" size="10" name="id_subdit" readonly value="<?php 
								if(set_value('id_subdit')=="" && isset($id_subdit)){
								 	echo $id_subdit;
								}else{
									echo  set_value('id_subdit');
								}
								?>"/>
							<?php }?>
						</td>
					</tr>
					<tr>
						<td>Direktorat / SubDit</td>
						<td>:</td>
						<td>{option_subdit}</td>
					</tr>
					<tr>
						<td valign='top'>Keterangan</td>
						<td valign='top'>:</td>
						<td>
							<input class=input type="text" size="40" name="ket" value="<?php 
							if(set_value('ket')=="" && isset($ket)){
								echo $ket;
							}else{
								echo  set_value('ket');
							}
							?>"/>
						</td>
					</tr>
                    <tr>
						<td>Status</td>
						<td>:</td>
						<td>{option_status}</td>
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