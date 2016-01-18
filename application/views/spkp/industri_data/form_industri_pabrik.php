<script>
	$(document).ready(function(){
		$('#btn_save_pabrik').click(function(){
			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url()?>index.php/industri_master/do{act}/{id}/{id_plant}",
				data: $('#frmTab_pabrik').serialize(),
				success: function(response){
					 if(response=="1"){
						 $.notific8('Notification', {
						  life: 3000,
						  message: 'Save data succesfully.',
						  heading: 'Saving data',
						  theme: 'lime2'
						});
						$("#tabs3").click();
						close(3);
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

				$("#kotakab_pabrik").html(data.kotakab);
				$('#kotakab_pabrik').change();

			}, "json");

		});

		$('#kotakab_pabrik').change(function(){
			$.get("<?php echo base_url()?>index.php/industri_master/select_kecamatan/"+ $(this).val(), function(response) {
				var data = eval(response);

				$("#kecamatan_pabrik").html(data.kecamatan);
				$("#kecamatan_pabrik").change();

			}, "json");

		});

		$('#kecamatan_pabrik').change(function(){
			$.get("<?php echo base_url()?>index.php/industri_master/select_desa/"+ $(this).val(), function(response) {
				var data = eval(response);

				$("#desa_pabrik").html(data.desa);

			}, "json");

		});
		<?php if($act=="edit_pabrik"){ ?>
			$.get("<?php echo base_url()?>index.php/industri_master/select_kotakab/{propinsi}/{kotakab}", function(response) {
				var data = eval(response);

				$("#kotakab_pabrik").html(data.kotakab);

			}, "json");

			$.get("<?php echo base_url()?>index.php/industri_master/select_kecamatan/{kotakab}/{kecamatan}", function(response) {
				var data = eval(response);

				$("#kecamatan_pabrik").html(data.kecamatan);

			}, "json");

			$.get("<?php echo base_url()?>index.php/industri_master/select_desa/{kecamatan}/{desa}", function(response) {
				var data = eval(response);

				$("#desa_pabrik").html(data.desa);

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
				<form method="post" id="frmTab_pabrik">
				<table border="0" width="100%" cellpadding="0" cellspacing="5" class="panel">
					<tr>
						<td align="right">
							<button class='btn' id='btn_reset' type='reset'>Reset</button>
							<button class='btn' id='btn_save_pabrik' type='button'>Simpan</button>
						</td>
					</tr>
					<tr>
						<td>
						<table border="0" cellpadding="3" cellspacing="2">
							<tr>
								<td width="30%">ID Pabrik</td>
								<td width="2%">:</td>
								<td><?php if($act=="edit_pabrik"){ ?>
									<input class=input type="text" size="5" name="id_plant" id="id_plant" disabled value="<?php 
										if(set_value('id_plant')=="" && isset($id_plant)){
											echo $id_plant;
										}else{
											echo  set_value('id_plant');
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
								<td><input class=input type="text" size="40" name="alamat_pabrik" value="<?php 
										if(set_value('alamat_pabrik')=="" && isset($alamat_pabrik)){
											echo $alamat_pabrik;
										}else{
											echo  set_value('alamat_pabrik');
										}
										 ?>"/> *
								</td>
							</tr>
							<tr>
								<td>Telp</td>
								<td>:</td>
								<td><input class=input type="text" size="15" name="telp_plant" value="<?php 
										if(set_value('telp_plant')=="" && isset($telp_plant)){
											echo $telp_plant;
										}else{
											echo  set_value('telp_plant');
										}
										 ?>"/>
								</td>
							</tr>
							<tr>
								<td>Fax</td>
								<td>:</td>
								<td><input class=input type="text" size="15" name="fax_plant" value="<?php 
										if(set_value('fax_plant')=="" && isset($fax_plant)){
											echo $fax_plant;
										}else{
											echo  set_value('fax_plant');
										}
										 ?>"/> 
								</td>
							</tr>
							<tr>
								<td>Jenis Lokasi</td>
								<td>:</td>
								<td><?php
									if(set_value('lokasi')=="" && isset($lokasi)){
										echo $this->crud->select_lokasi($lokasi);
									}else{
										echo $this->crud->select_lokasi();
									}
								?>
								</td> 
							</tr>
							<tr>
								<td>Luas Tanah</td>
								<td>:</td>
								<td><input class=input type="text" size="8" name="luas_tanah" value="<?php 
										if(set_value('luas_tanah')=="" && isset($luas_tanah)){
											echo $luas_tanah;
										}else{
											echo  set_value('luas_tanah');
										}
										 ?>"/> m2
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
									<select class=input id='kotakab_pabrik' name='kotakab'><option>-</option></select>
								</td> 
							</tr>
							<tr>
								<td>Kecamatan</td>
								<td>:</td>
								<td>
									<select class=input id='kecamatan_pabrik' name='kecamatan'><option>-</option></select>
								</td> 
							</tr>
							<tr>
								<td>Desa / Kelurahan</td>
								<td>:</td>
								<td>
									<select class=input id='desa_pabrik' name='desa'><option>-</option></select>
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