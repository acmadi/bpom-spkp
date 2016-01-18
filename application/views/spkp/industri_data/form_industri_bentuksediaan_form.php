<script>
	$(document).ready(function(){
		$('#btn_save_bentuksediaan').click(function(){
			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url()?>index.php/industri_master/do{act}/{id}/{id_plant}/{bentuksediaan}",
				data: $('#frmTab_bentuksediaan{timestamp}').serialize(),
				success: function(response){
					 if(response=="1"){
						 $.notific8('Notification', {
						  life: 3000,
						  message: 'Save data succesfully.',
						  heading: 'Saving data',
						  theme: 'lime2'
						});
						close_bentuksediaan();
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
				<form method="post" id="frmTab_bentuksediaan{timestamp}">
				<table border="0" width="100%" cellpadding="0" cellspacing="5" class="panel">
					<tr>
						<td align="right">
							<button class='btn' id='btn_reset' type='reset'>Reset</button>
							<button class='btn' id='btn_save_bentuksediaan' type='button'>Simpan</button>
						</td>
					</tr>
					<tr>
						<td>
						<table border="0" cellpadding="3" cellspacing="2">
							<tr>
								<td>Bentuk Sediaan</td>
								<td>:</td>
								<td><?php
									if(set_value('bentuk_sediaan')=="" && isset($bentuk_sediaan)){
										echo $this->crud->get_sediaan_pabrik2($id,$id_plant,$id_jenis,$bentuk_sediaan);
									}else{
										echo $this->crud->get_sediaan_pabrik2($id,$id_plant,$id_jenis);
									}
								?>  *
								</td> 
							</tr>
							<tr>
								<td>Kapasitas Produksi /tahun</td>
								<td>:</td>
								<td><input class=input type="text" size="5" name="kap_prod_pertahun" value="<?php 
										if(set_value('kap_prod_pertahun')=="" && isset($kap_prod_pertahun)){
											echo $kap_prod_pertahun;
										}else{
											echo  set_value('kap_prod_pertahun');
										}
										 ?>"/>
								</td>
							</tr>
							<tr>
								<td>Mesin Peralatan</td>
								<td>:</td>
								<td><input class=input type="text" size="30" name="mesin_peralatan" value="<?php 
										if(set_value('mesin_peralatan')=="" && isset($mesin_peralatan)){
											echo $mesin_peralatan;
										}else{
											echo  set_value('mesin_peralatan');
										}
										 ?>"/>
								</td>
							</tr>
							<tr>
								<td>Rencana Produksi</td>
								<td>:</td>
								<td><input class=input type="text" size="20" name="rencana_prod" value="<?php 
										if(set_value('rencana_prod')=="" && isset($rencana_prod)){
											echo $rencana_prod;
										}else{
											echo  set_value('rencana_prod');
										}
										 ?>"/> 
								</td>
							</tr>
							<tr>
								<td>No Pemeriksaan</td>
								<td>:</td>
								<td><input class=input type="text" size="20" name="no_pemeriksaan" value="<?php 
										if(set_value('no_pemeriksaan')=="" && isset($no_pemeriksaan)){
											echo $no_pemeriksaan;
										}else{
											echo  set_value('no_pemeriksaan');
										}
										 ?>"/> 
								</td>
							</tr>
							<tr>
								<td>No Evaluasi Denah</td>
								<td>:</td>
								<td><input class=input type="text" size="20" name="no_evaluasi_dnh" value="<?php 
										if(set_value('no_evaluasi_dnh')=="" && isset($no_evaluasi_dnh)){
											echo $no_evaluasi_dnh;
										}else{
											echo  set_value('no_evaluasi_dnh');
										}
										 ?>"/> 
								</td>
							</tr>
							<tr>
								<td>No Evaluasi RIP</td>
								<td>:</td>
								<td><input class=input type="text" size="20" name="no_evaluasi_rip" value="<?php 
										if(set_value('no_evaluasi_rip')=="" && isset($no_evaluasi_rip)){
											echo $no_evaluasi_rip;
										}else{
											echo  set_value('no_evaluasi_rip');
										}
										 ?>"/> 
								</td>
							</tr>
							<tr>
								<td>No Evaluasi AHS</td>
								<td>:</td>
								<td><input class=input type="text" size="20" name="no_evaluasi_ahs" value="<?php 
										if(set_value('no_evaluasi_ahs')=="" && isset($no_evaluasi_ahs)){
											echo $no_evaluasi_ahs;
										}else{
											echo  set_value('no_evaluasi_ahs');
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