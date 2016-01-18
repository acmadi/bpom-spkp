<script type="text/javascript">
    $(document).ready(function(){
       $("button,submit,reset").jqxInput({ theme: 'fresh', height: '28px' }); 
    });
	
	$('#subdit').change(function(){
			$.get("<?php echo base_url()?>index.php/admin_master_jabatan/select_subdit/"+ $(this).val(), function(response) {
				var data = eval(response);

				$("#atasan").html(data.atasan);
				$('#atasan').change();

			}, "json");

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
						<td>ID Jabatan</td>
						<td>:</td>
						<td><?php if($action=="add"){ ?>
								{auto-number}
							<?php }else{?>
								<input class=input type="text" size="10" name="id_jabatan" readonly value="<?php 
								if(set_value('id_jabatan')=="" && isset($id_jabatan)){
								 	echo $id_jabatan;
								}else{
									echo  set_value('id_jabatan');
								}
								?>"/>
							<?php }?>
						</td>
					</tr>
					<tr>
						<td>Subdit</td>
						<td>:</td>
						<td>
								<select class=input  name="id_subdit" id="subdit">
									<?php
										$data = $this->admin_master_subdit_model->get_list_data();
										foreach($data as $subdit){
											if($action=='add'){
									?>
											<option value="<?php echo $subdit->id_subdit; ?>"><?php echo $subdit->ket ?></option>
									<?php	
											}else{											
									?>
											<option value="<?php echo $subdit->id_subdit; ?>" <?php echo ($subdit->id_subdit==$id_subdit) ? 'selected' : '';?>>
										<?php echo $subdit->ket ?></option>
									<?php
										}}
									?>
								</select>						
						</td>
					</tr>
					<tr>
						<td>Nama Jabatan</td>
						<td>:</td>
						<td><?php if($action=="add"){ ?>
								<input class=input type="text" size="60" name="nama_jabatan">
							<?php }else{?>
								<input class=input type="text" size="60" name="nama_jabatan" value="<?php 
								if(set_value('nama_jabatan')=="" && isset($nama_jabatan)){
								 	echo $nama_jabatan;
								}else{
									echo  set_value('nama_jabatan');
								}
								?>"/>
							<?php }?>
						</td>
					</tr>
					
					<tr>
						<td>Eselon</td>
						<td>:</td>
						<td><?php 
							$data = array('-', 'I', 'II', 'III', 'IV');
							?>
							<select class=input  name="eselon">		
								<?php									
									foreach($data as $data_eselon){
										if($action=='add'){
								?>
										<option value="<?php echo $data_eselon; ?>"><?php echo $data_eselon; ?></option>
								<?php	
										}else{											
								?>
										<option value="<?php echo $data_eselon; ?>" <?php echo ($data_eselon==$eselon) ? 'selected' : '';?>>
									<?php echo $data_eselon?></option>
								<?php
									}}
								?>
							</select>	
						</td>
					</tr>
					
					<tr>
						<td>Kepala</td>
						<td>:</td>
						<td>   <?php 
								if(set_value('personil')=="" && isset($personil)){
								?>
                                    <input type="checkbox" class="input" name="personil" value="1" <?php if($personil=='1') echo "checked"; ?>/>
                                <?php    
								}else{
								?>
                                    <input type="checkbox" class="input" name="personil" value="1"/>
                                <?php
								}
								 ?>
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