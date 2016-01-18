<script type="text/javascript">
    $(document).ready(function(){
        $("button,submit,reset").jqxInput({ theme: 'fresh', height: '28px', width: '100px' }); 
		$("input[name='keterangan']").jqxInput({ theme: 'fresh', height: '22px', width: '500px' }); 
        
		$("[name='btn_simpan']").click(function(){
			$("#uploaddiv").hide();
			$("#uploadloader").show("fade");

			var data = new FormData();
			jQuery.each($("[name='filename']")[0].files, function(i, file) {
				data.append('filename', file);
			});			
			data.append('departemen', $("[name='departemen']").val());
            data.append('jenis', $("[name='jenis']").val());
            data.append('keterangan', $("[name='keterangan']").val());
            data.append('status', $("[name='status']").val());

			$.ajax({ 
				type: "POST",
				cache: false,
				contentType: false,
				processData: false,
				url: "<?php echo base_url()?>spkp_personalia_kerjasama_int/do{action}_upload/{id}",
				data: data,
				success: function(response){
					res = response.split("_");
					 if(res[0]=="OK"){
						 $.notific8('Notification', {
						  life: 5000,
						  message: 'Save data succesfully.',
						  heading: 'Saving data',
						  theme: 'lime2'
						});
						$("#filename").val("");
						close_dialog_upload(1);
					 }else{
						 $.notific8('Notification', {
						  life: 5000,
						  message: res[1],
						  heading: 'Saving data FAIL',
						  theme: 'red2'
						});
					 }
					$("#uploadloader").hide();
					$("#uploaddiv").show("fade");
				}
			 }); 		
		});

		$("[name='btn_delete']").click(function(){
			if(confirm('Hapus dokumen ini?')){
			
				$("#uploaddiv").hide();
				$("#uploadloader").show("fade");

				$.ajax({ 
					type: "POST",
					cache: false,
					contentType: false,
					processData: false,
					url: "<?php echo base_url()?>spkp_personalia_kerjasama_int/delete_upload/{id}",
					success: function(response){
						res = response.split("_");
						 if(res[0]=="OK"){
							 $.notific8('Notification', {
							  life: 5000,
							  message: 'Save data succesfully.',
							  heading: 'Saving data',
							  theme: 'lime2'
							});
							close_dialog_upload(1);
						 }else{
							 $.notific8('Notification', {
							  life: 5000,
							  message: res[1],
							  heading: 'Saving data FAIL',
							  theme: 'red2'
							});
						 }
						$("#uploadloader").hide();
						$("#uploaddiv").show("fade");
					}
				 }); 
			}				 
		});
	});
</script>
<div id="uploadloader" style='display:none;text-align:center'><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>uploading<br><br><br><br></div>
<div id="uploaddiv" style="padding:5px;text-align:center">
<form method="POST" id="frmData">
	<?php if($action=="edit"){ ?><button type="button" name="btn_delete"> Delete Data </button> - <?php } ?>
	<button type="button" name="btn_simpan"> Simpan </button>
	<button type="reset"> Ulang </button>
	<button type="button" onCLick="close_dialog_upload();"> Batal </button>
	<br />
	<br />
	<table border="0" cellpadding="0" cellspacing="8" align="center" width='90%'>
		<tr>
			<td>
                <table border="0" cellpadding="3" cellspacing="2" width='100%'>
					<tr>
						<td>Departemen</td>
						<td>:</td>
						<td>
                            <select size="1" name="departemen" style="margin: 0;width: 250px;height:25px;padding:2px">
                                <?php
                                $data_int = $this->spkp_personalia_kerjasama_int_model->get_all_departmen_int();
                                if($data_int->num_rows()>0){
                                    if(set_value('departemen')=="" && isset($departemen)){
                                        foreach($data_int->result() as $row_int){
                                    ?>
                                        <option value="<?php echo $row_int->id_departemen; ?>" <?php if($row_int->id_departemen==$departemen) echo "Selected";  ?>><?php echo $row_int->ket; ?></option>
                                    <?php
                                        }    
                                    }else{
                                        foreach($data_int->result() as $row_int){
                                    ?>
                                        <option value="<?php echo $row_int->id_departemen; ?>" <?php if($row_int->id_departemen==$departemen) echo "Selected";  ?>><?php echo $row_int->ket; ?></option>
                                    <?php    
                                        }
                                        }
                                }else{
                                    ?>
                                    <option></option>
                                    <?php
                                }       
                                ?>
                            </select> *
						</td>
					</tr>
                    <tr>
                        <td>Jenis</td>
                        <td>:</td>
                        <td>
                            <select size="1" name="jenis" style="width: 110px;margin: 0;">
                                <?php
                                if(set_value('jenis')=="" && isset($jenis)){
                                    ?>
                                    <option value="Overview" <?php if($jenis=="Overview") echo "Selected";  ?>>Overview</option>
                                    <option value="Dokumen" <?php if($jenis=="Dokumen") echo "Selected";  ?>>Dokumen</option>
                                    <?php
                                }else{
                                    ?>
                                    <option value="Overview">Overview</option>
                                    <option value="Dokumen">Dokumen</option>
                                    <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
						<td>File</td>
						<td>:</td>
						<td><input type="file" size="10" name="filename" value="<?php 
								if(set_value('filename')=="" && isset($filename)){
								 	echo $filename;
								}else{
									echo  set_value('filename');
								}
								 ?>"/> *
						</td>
					</tr>
                    <tr>
                        <td width='14%'>Keterangan</td>
                        <td width='3%' align='middle'>:</td>
                        <td width='50%'>
                            <input type="text" size="80" maxlength="200" name="keterangan" style="margin: 0;" value="<?php 
    								if(set_value('keterangan')=="" && isset($keterangan)){
    								 	echo $keterangan;
    								}else{
    									echo  set_value('keterangan');
    								}
    								 ?>"/>
                        </td>
                    </tr>
					<tr>
						<td>Publish</td>
						<td>:</td>
						<td><select name="status" style="height:25px;padding:2px;margin: 0;">
							<option value='1' <?php echo(isset($status) && $status==1 ? "selected":"") ?>>Published</option>
							<option value='0' <?php echo(isset($status) && $status==0 ? "selected":"") ?>>Unpublished</option>
						</select>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</form>
</div>