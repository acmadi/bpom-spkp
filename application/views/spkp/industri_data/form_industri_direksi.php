<script>
	$(document).ready(function(){
		$('#btn_save_kantor').click(function(){
			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url()?>index.php/industri_master/do{act}/{id}/{id_direksi}",
				data: $('#frmTab_direksi').serialize(),
				success: function(response){
					 if(response=="1"){
						 $.notific8('Notification', {
						  life: 3000,
						  message: 'Save data succesfully.',
						  heading: 'Saving data',
						  theme: 'lime2'
						});
						$("#tabs4").click();
						close(4);
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
				<form method="post" id="frmTab_direksi">
				<table border="0" width="100%" cellpadding="0" cellspacing="5" class="panel">
					<tr>
						<td align="right">
							<button class='btn' id='btn_reset' type='reset'>Reset</button>
							<button class='btn' id='btn_save_kantor' type='button'>Simpan</button>
						</td>
					</tr>
					<tr>
						<td>
						<table border="0" cellpadding="3" cellspacing="2">
							<tr>
								<td width="30%">ID </td>
								<td width="2%">:</td>
								<td><?php if($act=="edit_direksi"){ ?>
									<input class=input type="text" size="5" name="id_direksi" id="id_direksi" disabled value="<?php 
										if(set_value('id_direksi')=="" && isset($id_direksi)){
											echo $id_direksi;
										}else{
											echo  set_value('id_direksi');
										}
										?>"/>
								<?php }else{ ?>
									{auto-number}
								<?php } ?>
								</td>
							</tr>
							<tr>
								<td width="30%">ID Industri</td>
								<td width="2%">:</td>
								<td>
									<input class=input type="text" size="10" name="id_industri" id="id_industri" value="{id}" disabled/>
								</td>
							</tr>
							<tr>
								<td>Nama</td>
								<td>:</td>
								<td><input class=input type="text" size="30" name="nama_direksi" value="<?php 
										if(set_value('nama_direksi')=="" && isset($nama_direksi)){
											echo $nama_direksi;
										}else{
											echo  set_value('nama_direksi');
										}
										 ?>"/> *
								</td>
							</tr>
							<tr>
								<td>Pendidikan</td>
								<td>:</td>
								<td><input class=input type="text" size="20" name="pendidikan" value="<?php 
										if(set_value('pendidikan')=="" && isset($pendidikan)){
											echo $pendidikan;
										}else{
											echo  set_value('pendidikan');
										}
										 ?>"/>
								</td>
							</tr>
							<tr>
								<td>Keterangan</td>
								<td>:</td>
								<td><input class=input type="text" size="35" name="keterangan" value="<?php 
										if(set_value('keterangan')=="" && isset($keterangan)){
											echo $keterangan;
										}else{
											echo  set_value('keterangan');
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