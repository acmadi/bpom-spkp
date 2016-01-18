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
						<td>ID Tujuan</td>
						<td>:</td>
						<td><?php if($action=="add"){ ?>
								{auto-number}
							<?php }else{?>
								<input class=input type="text" size="10" name="id_tujuan" readonly value="<?php 
								if(set_value('id_tujuan')=="" && isset($id_tujuan)){
								 	echo $id_tujuan;
								}else{
									echo  set_value('id_tujuan');
								}
								?>"/>
							<?php }?>
						</td>
					</tr>
					<tr>
						<td>Desc Tujuan</td>
						<td>:</td>
						<td><input class=input type="text" size="80" name="desc_tujuan" value="<?php 
								if(set_value('desc_tujuan')=="" && isset($desc_tujuan)){
								 	echo $desc_tujuan;
								}else{
									echo  set_value('desc_tujuan');
								}
								 ?>"/>
						</td>
					</tr>
                    <tr>
                        <td>Group</td>
                        <td>:</td>
                        <td>
                            <select size="1" class="input" name="group">
                                <?php
                                $data=$this->admin_master_tujuan_model->get_all_group();
                                foreach($data as $row){
                                ?>
                                    <?php
                                    if(set_value('grp')==0 && isset($grp)){
                                    ?>
                                        <option value="<?php echo $row->id; ?>" <?php if($row->id==$grp) echo "Selected"; ?> ><?php echo $row->name; ?></option>
                                    <?php    
                                    }else{
                                    ?>
                                        <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                                <?php
                                }
                                }
                                ?>
                            </select>
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