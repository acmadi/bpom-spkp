<script>
	$(document).ready(function(){
		$("#tgl_sik").datepicker({ dateFormat: "yy-mm-dd" });

		$('#btn_save_fasilitas').click(function(){
			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url()?>index.php/industri_master/do{act}/{id}/{id_plant}/{id_fasilitas}",
				data: $("form[name='frmTab_fasilitas{timestamp}']").serialize(),
				success: function(response){
					 if(response=="1"){
						 $.notific8('Notification', {
						  life: 3000,
						  message: 'Save data succesfully.',
						  heading: 'Saving data',
						  theme: 'lime2'
						});
						close_fasilitas();
					 }else{
						 $.notific8('Notification', {
						  life: 5000,
						  message: response,
						  heading: 'Saving data FAIL',
						  theme: 'red2'
						});
					 }
				}
			 }); 		
		});
	});
</script>
<div style="width:99%;background-color:#F6F6F6;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #F9F9F9;height:40px">
	<table width='100%' cellpadding=0 cellspacing=0 height='100%'>
		<tr valign="middle">
			<td style='background:#FFFFFF;-moz-border-radius:5px 0px 0px 5px;border-radius:5px 0px 0px 5px;padding-left:5px;font-size:15px;color:#585858;font-weight:bold'>
				. {title}
			</td>
		</tr>
	</table>
</div>
<div style="width:99%;background-color:#DDDDDD;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #ebebeb;">
	<table width="100%">
		<tr>
			<td>
				<form method="post" id="frmTab_fasilitas" name="frmTab_fasilitas{timestamp}">
				<table border="0" width="100%" cellpadding="0" cellspacing="5" class="panel">
					<tr>
						<td align="right">
							<button class='btn' id='btn_reset' type='reset'>Reset</button>
							<button class='btn' id='btn_save_fasilitas' type='button'>Simpan</button>
						</td>
					</tr>
					<tr>
						<td>
						<table border="0" cellpadding="3" cellspacing="2">
							<tr>
								<td width="35%">Nama Fasilitas</td>
								<td>:</td>
								<td><?php
									if(set_value('id_fasilitas')=="" && isset($id_fasilitas)){
										echo $this->crud->get_fasilitas_industri2($id,$id_plant,$id_fasilitas);
									}else{
										echo $this->crud->get_fasilitas_industri2($id,$id_plant);
									}
								?> *
								</td> 
							</tr>
							<tr>
								<td>Status</td>
								<td>:</td>
								<td><input class=input type="checkbox" value="1" name="status" <?php 
										if(set_value('status')=="" && isset($status)){
											if($status=="1") echo "checked=true";
										}
										 ?>"/> Ada / Tidak Ada
								</td>
							</tr>
							</table>
							</td> 
						</tr>
					</table>
				</form>
			</td>
		</tr>
	</table>
</div>