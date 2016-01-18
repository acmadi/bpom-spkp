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
						<td>ID Kecamatan</td>
						<td>:</td>
						<td>
                             <input class=input type="text" size="10" name="id_kecamatan" <?php if($action=="edit") echo "readonly"; ?> value="<?php 
								if(set_value('id_kecamatan')=="" && isset($id_kecamatan)){
								 	echo $id_kecamatan;
								}else{
									echo  set_value('id_kecamatan');
								}
								?>"/>
						</td>
					</tr>
					<tr>
						<td>Nama Kecamatan</td>
						<td>:</td>
						<td><input class=input type="text" size="50" name="nama_kecamatan" value="<?php 
								if(set_value('nama_kecamatan')=="" && isset($nama_kecamatan)){
								 	echo $nama_kecamatan;
								}else{
									echo  set_value('nama_kecamatan');
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