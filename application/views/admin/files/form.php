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
						<td>ID</td>
						<td>:</td>
						<td>
                            <?php
                            if($action=="add"){
                                echo "{auto-number}";
                            }else{
                                ?>
                                <input class=input type="text" size="10" maxlength="10" name="id" readonly="" value="<?php 
    								if(set_value('id')=="" && isset($ina['id'])){
    								 	echo $ina['id'];
    								}else{
    									echo  set_value('id');
    								}
    								?>"/>
                            <?php
                            }
                            ?>
						</td>
					</tr>
                    <tr>
						<td>Filename <strong>Indonesia</strong></td>
						<td>:</td>
						<td>
							<input class=input type="text" size="25" maxlength="100" name="ina" value="<?php 
								if(set_value('ina')=="" && isset($ina['filename'])){
								 	echo $ina['filename'];
								}else{
									echo  set_value('ina');
								}
								?>"/>
						</td>
					</tr>
					<tr>
						<td>Filename <strong>English</strong></td>
						<td>:</td>
						<td><input class=input type="text" size="25" maxlength="100" name="en" value="<?php 
								if(set_value('en')=="" && isset($en['filename'])){
								 	echo $en['filename'];
								}else{
									echo  set_value('en');
								}
								 ?>"/>
						</td>
					</tr>
                    <tr>
						<td>Module</td>
						<td>:</td>
						<td><input class=input type="text" size="25" maxlength="100" name="module" value="<?php 
								if(set_value('module')=="" && isset($ina['module'])){
								 	echo $ina['module'];
								}else{
									echo  set_value('module');
								}
								 ?>"/>
						</td>
					</tr>
                    <tr>
						<td>Theme</td>
						<td>:</td>
						<td>
                            <select size="1" name="id_theme" class="input" style="width: 120px;">
                                <?php
                                $data_theme = $this->admin_file_model->get_all_theme();
                                if(set_value('id_theme')=="" && isset($ina['id_theme'])){
                                    foreach($data_theme as $row){
                                        ?>
                                        <option value="<?php echo $row->id_theme; ?>" <?php if($row->id_theme==$ina['id_theme']) echo "Selected"; ?>><?php echo $row->name; ?></option>
                                        <?php
                                    }
                                }else{
                                    foreach($data_theme as $row){
                                        ?>
                                        <option value="<?php echo $row->id_theme; ?>"><?php echo $row->name; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
						</td>
					</tr>
                    <tr>
						<td>Description</td>
						<td>:</td>
						<td><input class=input type="text" size="50" name="description" value="<?php 
								if(set_value('description')=="" && isset($ina['description'])){
								 	echo $ina['description'];
								}else{
									echo  set_value('description');
								}
								 ?>"/>
						</td>
					</tr>
                    <tr>
						<td>Class</td>
						<td>:</td>
						<td><input class=input type="text" size="20" name="class" value="<?php 
								if(set_value('class')=="" && isset($ina['class'])){
								 	echo $ina['class'];
								}else{
									echo  set_value('class');
								}
								 ?>"/>
							<a href="<?php echo base_url();?>admin_file/show_list" target=_blank style="cursor:pointer;color:blue;text-decoration:underline">help</a>
						</td>
					</tr>
                    <tr>
						<td>Color</td>
						<td>:</td>
						<td>	
							<select size="1" name="color" class="input" style="width: 120px;">	
								<?php
									$color = array('orange', 'yellow', 'blue', 'green', 'red', 'purple', 'grey', 'black');
									if(set_value('color')=="" && isset($ina['color'])){
										foreach($color as $warna){			
								?>
											<option value="<?php echo $warna;?>" <?php if($ina['color']==$warna) echo 'selected';?>><?php echo $warna?> </option>	
								<?php
										}
									}else{
										foreach($color as $warna){
								?>
											<option value="<?php echo $warna;?>"><?php echo $warna;?></option>
								<?php
											}
									}
								?> 					   
                            </select>
							
							
						</td>
					</tr>
                    <tr>
						<td>Size</td>
						<td>:</td>
						<td><input class=input type="text" size="10" name="size" value="<?php 
								if(set_value('size')=="" && isset($ina['size'])){
								 	echo $ina['size'];
								}else{
									echo  set_value('size');
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