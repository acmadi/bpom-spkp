<script>
	$(document).ready(function(){
		$("#tgl_izin").datepicker({ dateFormat: "yy-mm-dd" });
		$("#tgl_permohonan").datepicker({ dateFormat: "yy-mm-dd" });

		$('#btn_save_izin').click(function(){
			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url()?>index.php/industri_master/do{act}/{id}/{id_izin}",
				data: $('#frmTab_izin').serialize(),
				success: function(response){
					 if(response=="1"){
						 $.notific8('Notification', {
						  life: 3000,
						  message: 'Save data succesfully.',
						  heading: 'Saving data',
						  theme: 'lime2'
						});
						$("#tabs6").click();
						close(6);
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
				<form method="post" id="frmTab_izin">
				<table border="0" width="100%" cellpadding="0" cellspacing="5" class="panel">
					<tr>
						<td align="right">
							<button class='btn' id='btn_reset' type='reset'>Reset</button>
							<button class='btn' id='btn_save_izin' type='button'>Simpan</button>
						</td>
					</tr>
					<tr>
						<td>
						<table border="0" cellpadding="3" cellspacing="2">
							<tr>
								<td width="30%">ID Industri</td>
								<td width="2%">:</td>
								<td>
									<input class=input type="text" size="10" name="id_industri" id="id_industri" value="{id}" disabled/>
								</td>
							</tr>
							<tr>
								<td>Izin</td>
								<td>:</td>
								<td><?php
									if(set_value('id_izin')=="" && isset($id_izin)){
										echo $this->crud->select_izin($id_izin);
									}else{
										echo $this->crud->select_izin();
									}
								?>
								</td> 
							</tr>
							<tr>
								<td>Tanggal Izin</td>
								<td>:</td>
								<td><input class=input type="text" size="10" name="tgl_izin" id="tgl_izin" readonly value="<?php 
										if(set_value('tgl_izin')=="" && isset($tgl_izin)){
											echo $tgl_izin;
										}else{
											echo  set_value('tgl_izin');
										}
										 ?>"/> <img src="<?php echo base_url();?>media/images/calendar.png"/>
								</td>
							</tr>
							<tr>
								<td>Tanggal Permohonan</td>
								<td>:</td>
								<td><input class=input type="text" size="10" name="tgl_permohonan" id="tgl_permohonan" readonly value="<?php 
										if(set_value('tgl_permohonan')=="" && isset($tgl_permohonan)){
											echo $tgl_permohonan;
										}else{
											echo  set_value('tgl_permohonan');
										} 
										 ?>"/> <img src="<?php echo base_url();?>media/images/calendar.png"/>
								</td>
							</tr>
							<tr>
								<td>Nomor</td>
								<td>:</td>
								<td><input class=input type="text" size="35" name="nomor" value="<?php 
										if(set_value('nomor')=="" && isset($nomor)){
											echo $nomor;
										}else{
											echo  set_value('nomor');
										}
										 ?>"/> 
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