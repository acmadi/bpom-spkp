<script>
	$(document).ready(function(){
		$('#btn_save_kantor').click(function(){
			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url()?>index.php/industri_master/do{act}/{id}/{id_kantor}",
				data: $('#frmTab_kantor').serialize(),
				success: function(response){
					 if(response=="1"){
						 $.notific8('Notification', {
						  life: 3000,
						  message: 'Save data succesfully.',
						  heading: 'Saving data',
						  theme: 'lime2'
						});
						$("#tabs2").click();
						close(2);
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

		$('#propinsi').change(function(){
			$.get("<?php echo base_url()?>index.php/industri_master/select_kotakab/"+ $(this).val(), function(response) {
				var data = eval(response);

				$("#kotakab").html(data.kotakab);
				$('#kotakab').change();

			}, "json");

		});

		$('#kotakab').change(function(){
			$.get("<?php echo base_url()?>index.php/industri_master/select_kecamatan/"+ $(this).val(), function(response) {
				var data = eval(response);

				$("#kecamatan").html(data.kecamatan);
				$("#kecamatan").change();

			}, "json");

		});

		$('#kecamatan').change(function(){
			$.get("<?php echo base_url()?>index.php/industri_master/select_desa/"+ $(this).val(), function(response) {
				var data = eval(response);

				$("#desa").html(data.desa);

			}, "json");

		});
		<?php if($act=="edit_kantor"){ ?>
			$.get("<?php echo base_url()?>index.php/industri_master/select_kotakab/{propinsi}/{kotakab}", function(response) {
				var data = eval(response);

				$("#kotakab").html(data.kotakab);

			}, "json");

			$.get("<?php echo base_url()?>index.php/industri_master/select_kecamatan/{kotakab}/{kecamatan}", function(response) {
				var data = eval(response);

				$("#kecamatan").html(data.kecamatan);

			}, "json");

			$.get("<?php echo base_url()?>index.php/industri_master/select_desa/{kecamatan}/{desa}", function(response) {
				var data = eval(response);

				$("#desa").html(data.desa);

			}, "json");
		<?php } ?>
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
				<form method="post" id="frmTab_kantor">
				<table border="0" width="100%" cellpadding="0" cellspacing="5" class="panel">
					<tr>
						<td align="right">
							<button class='btn' id='btn_reset' type='reset'>Reset</button>
							<button class='btn' id='btn_save_kantor' type='button'>Simpan</button>
							<input type="hidden" name="jenis" value="1"/>
						</td>
					</tr>
					<tr>
						<td>
						<table border="0" cellpadding="3" cellspacing="2">
							<tr>
								<td width="30%">ID Kantor</td>
								<td width="2%">:</td>
								<td><?php if($act=="edit_kantor"){ ?>
									<input class=input type="text" size="5" name="id_kantor" id="id_kantor" disabled value="<?php 
										if(set_value('id_kantor')=="" && isset($id_kantor)){
											echo $id_kantor;
										}else{
											echo  set_value('id_kantor');
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
								<td>Alamat</td>
								<td>:</td>
								<td><input class=input type="text" size="40" name="alamat_kantor" value="<?php 
										if(set_value('alamat_kantor')=="" && isset($alamat_kantor)){
											echo $alamat_kantor;
										}else{
											echo  set_value('alamat_kantor');
										}
										 ?>"/> *
								</td>
							</tr>
							<tr>
								<td>Telp</td>
								<td>:</td>
								<td><input class=input type="text" size="15" name="telp_kantor" value="<?php 
										if(set_value('telp_kantor')=="" && isset($telp_kantor)){
											echo $telp_kantor;
										}else{
											echo  set_value('telp_kantor');
										}
										 ?>"/>
								</td>
							</tr>
							<tr>
								<td>Fax</td>
								<td>:</td>
								<td><input class=input type="text" size="15" name="fax_kantor" value="<?php 
										if(set_value('fax_kantor')=="" && isset($fax_kantor)){
											echo $fax_kantor;
										}else{
											echo  set_value('fax_kantor');
										}
										 ?>"/> 
								</td>
							</tr>
							<tr>
								<td>Kode Pos</td>
								<td>:</td>
								<td><input class=input type="text" size="8" name="kodepos" value="<?php 
										if(set_value('kodepos')=="" && isset($kodepos)){
											echo $kodepos;
										}else{
											echo  set_value('kodepos');
										}
										 ?>"/>
								</td>
							</tr>
							<tr>
								<td>Propinsi</td>
								<td>:</td>
								<td><?php
									if(set_value('propinsi')=="" && isset($propinsi)){
										echo $this->crud->select_propinsi($propinsi);
									}else{
										echo $this->crud->select_propinsi();
									}
								?>
								</td> 
							</tr>
							<tr>
								<td>Kota / Kabupaten</td>
								<td>:</td>
								<td>
									<select class=input id='kotakab' name='kotakab'><option>-</option></select>
								</td> 
							</tr>
							<tr>
								<td>Kecamatan</td>
								<td>:</td>
								<td>
									<select class=input id='kecamatan' name='kecamatan'><option>-</option></select>
								</td> 
							</tr>
							<tr>
								<td>Desa / Kelurahan</td>
								<td>:</td>
								<td>
									<select class=input id='desa' name='desa'><option>-</option></select>
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