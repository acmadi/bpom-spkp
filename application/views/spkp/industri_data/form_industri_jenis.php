<script>
	$(document).ready(function(){
		$("#tgl_sik").datepicker({ dateFormat: "yy-mm-dd" });

		$('#btn_save_jenis').click(function(){
			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url()?>index.php/industri_master/do{act}/{id}/{id_plant}/{id_jenis}",
				data: $("form[name='frmTab_jenis{timestamp}']").serialize(),
				success: function(response){
					 if(response=="1"){
						 $.notific8('Notification', {
						  life: 3000,
						  message: 'Save data succesfully.',
						  heading: 'Saving data',
						  theme: 'lime2'
						});
						close_jenis();
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
				<form method="post" id="frmTab_jenis" name="frmTab_jenis{timestamp}">
				<table border="0" width="100%" cellpadding="0" cellspacing="5" class="panel">
					<tr>
						<td align="right">
							<button class='btn' id='btn_reset' type='reset'>Reset</button>
							<button class='btn' id='btn_save_jenis' type='button'>Simpan</button>
						</td>
					</tr>
					<tr>
						<td>
						<table border="0" cellpadding="3" cellspacing="2">
							<tr>
								<td>Jenis</td>
								<td>:</td>
								<td><?php
									if(set_value('id_jenis')=="" && isset($id_jenis)){
										echo $this->crud->get_jenis_industri2($id,$id_plant,$id_jenis);
									}else{
										echo $this->crud->get_jenis_industri2($id,$id_plant);
									}
								?> *
								</td> 
							</tr>
							<tr>
								<td>Penanggung Jawab</td>
								<td>:</td>
								<td><input class=input type="text" size="30" name="penanggungjawab" value="<?php 
										if(set_value('penanggungjawab')=="" && isset($penanggungjawab)){
											echo $penanggungjawab;
										}else{
											echo  set_value('penanggungjawab');
										}
										 ?>"/> *
								</td>
							</tr>
							<tr>
								<td>Pendidikan</td>
								<td>:</td>
								<td><input class=input type="text" size="15" name="pend_penanggungjawab" value="<?php 
										if(set_value('pend_penanggungjawab')=="" && isset($pend_penanggungjawab)){
											echo $pend_penanggungjawab;
										}else{
											echo  set_value('pend_penanggungjawab');
										}
										 ?>"/>
								</td>
							</tr>
							<tr>
								<td>Strata</td>
								<td>:</td>
								<td><input class=input type="text" size="5" name="stra_penanggungjawab" value="<?php 
										if(set_value('stra_penanggungjawab')=="" && isset($stra_penanggungjawab)){
											echo $stra_penanggungjawab;
										}else{
											echo  set_value('stra_penanggungjawab');
										}
										 ?>"/> 
								</td>
							</tr>
							<tr>
								<td>Nomor SIK</td>
								<td>:</td>
								<td><input class=input type="text" size="20" name="nomor_sik" value="<?php 
										if(set_value('nomor_sik')=="" && isset($nomor_sik)){
											echo $nomor_sik;
										}else{
											echo  set_value('nomor_sik');
										}
										 ?>"/> 
								</td>
							</tr>
							<tr>
								<td>Tanggal SIK</td>
								<td>:</td>
								<td><input class=input type="text" size="8" id="tgl_sik" name="tgl_sik" value="<?php 
										if(set_value('tgl_sik')=="" && isset($tgl_sik)){
											echo $tgl_sik;
										}else{
											echo  set_value('tgl_sik');
										}
										 ?>" readonly/> <img src="<?php echo base_url()?>media/images/calendar.png" alt="calendar">
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