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
						<td>ID Departemen</td>
						<td>:</td>
						<td><?php if($action=="add"){ ?>
								{auto-number}
							<?php }else{?>
								<input class=input type="text" size="10" name="id_departemen" readonly value="<?php 
								if(set_value('id_departemen')=="" && isset($id_departemen)){
								 	echo $id_departemen;
								}else{
									echo  set_value('id_departemen');
								}
								?>"/>
							<?php }?>
						</td>
					</tr>
					<tr>
						<td valign='top'>Jenis</td>
						<td valign='top'>:</td>
						<td>
                           <select size="1" class="input" name="jenis" style="width: 110px;">
                                <?php
                                if(set_value('jenis')=="" && isset($jenis)){
                                    ?>
                                    <option value="Internasional" <?php if($jenis=="Internasional") echo "Selected"; ?>>Internasional</option>
                                    <option value="Nasional" <?php if($jenis=="Nasional") echo "Selected"; ?>>Nasional</option>
                                    <?php
                                }else{
                                    ?>
                                    <option value="Internasional">Internasional</option>
                                    <option value="Nasional">Nasional</option>
                                    <?php
                                }
                                ?>
                            </select>    
						</td>
					</tr>
                    <tr>
						<td>Keterangan</td>
						<td>:</td>
						<td><input class=input type="text" size="50" name="ket" value="<?php 
								if(set_value('ket')=="" && isset($ket)){
								 	echo $ket;
								}else{
									echo  set_value('ket');
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