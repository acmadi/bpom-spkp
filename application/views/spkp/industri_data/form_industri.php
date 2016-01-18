<script>
	$(document).ready(function(){
		$("#tabs").tabs();
		$("#tabs2").click(function(){
			$("#tabs-3").empty();
			$("#tabs-4").empty();
			$("#tabs-5").empty();
			$("#tabs-6").empty();
			$.ajax({ 
				type: "GET",
				url: "<?php echo base_url()?>index.php/industri_data/tab/{id}/tab2",
				success: function(response){
					$("#tabs-2").html(response);
				}
			 }); 		
		});
		$("#tabs3").click(function(){
			$("#tabs-2").empty();
			$("#tabs-4").empty();
			$("#tabs-5").empty();
			$("#tabs-6").empty();
			$.ajax({ 
				type: "GET",
				url: "<?php echo base_url()?>index.php/industri_data/tab/{id}/tab3",
				success: function(response){
					$("#tabs-3").html(response);
				}
			 }); 		
		});

		$("#tabs4").click(function(){
			$("#tabs-3").empty();
			$("#tabs-2").empty();
			$("#tabs-5").empty();
			$("#tabs-6").empty();
			$.ajax({ 
				type: "GET",
				url: "<?php echo base_url()?>index.php/industri_data/tab/{id}/tab4",
				success: function(response){
					$("#tabs-4").html(response);
				}
			 }); 		
		});

		$("#tabs5").click(function(){
			$("#tabs-2").empty();
			$("#tabs-3").empty();
			$("#tabs-4").empty();
			$("#tabs-6").empty();
			$.ajax({ 
				type: "GET",
				url: "<?php echo base_url()?>index.php/industri_data/tab/{id}/tab5",
				success: function(response){
					$("#tabs-5").html(response);
				}
			 }); 		
		});

		$("#tabs6").click(function(){
			$("#tabs-2").empty();
			$("#tabs-3").empty();
			$("#tabs-4").empty();
			$("#tabs-5").empty();
			$.ajax({ 
				type: "GET",
				url: "<?php echo base_url()?>index.php/industri_data/tab/{id}/tab6",
				success: function(response){
					$("#tabs-6").html(response);
				}
			 }); 		
		});

		<?php if(isset($tab)){?>
			$("#a_tabs<?php echo $tab ?>").click();
		<?php }?>


		$("#mulai_produksi").datepicker({ dateFormat: "yy-mm-dd" });
		$("#tgl_akte_pendirian").datepicker({ dateFormat: "yy-mm-dd" });

		$('#status').change(function(){
			if($(this).val()=="1"){
				$('#tbl_status').hide('fade');
			}else{
				$('#tbl_status').show('fade');
			}
		});

		$('#btn_save').click(function(){
			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url()?>index.php/industri_data/do{act}/{id}",
				data: $('#frmTab1').serialize(),
				success: function(response){
					 if(response=="1"){
						 $.notific8('Notification', {
						  life: 3000,
						  message: 'Save data succesfully.',
						  heading: 'Saving data',
						  theme: 'lime2'
						});
						<?php if($id==""){ ?>
							window.location.reload();
						<?php } ?>
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
			<td style='background:#FFFFFF;-moz-border-radius:5px 0px 0px 5px;border-radius:5px 0px 0px 5px;padding-left:5px;font-size:15px;color:#585858;font-weight:bold' width='50%'>
				. {title}
			</td>
		</tr>
	</table>
</div>
<div style="width:99%;background-color:#DDDDDD;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #ebebeb;">
	<table width="100%">
		<tr>
			<td>
				<div id="tabs" style="min-height:400px">
					<ul>
						<li id="tabs1"><a href="#tabs-1">Data Industri Farmasi</a></li>
						<?php if($id!=""){ ?>
						<li id="tabs2"><a id="a_tabs2" href="#tabs-2">Daftar Kantor</a></li>
						<li id="tabs3"><a id="a_tabs3" href="#tabs-3">Daftar Pabrik</a></li>
						<li id="tabs4"><a id="a_tabs4" href="#tabs-4">Karyawan / Direksi</a></li>
						<li id="tabs5"><a id="a_tabs5" href="#tabs-5">Bentuk Sediaan</a></li>
						<li id="tabs6"><a id="a_tabs6" href="#tabs-6">Izin / SK</a></li>
						<?php } ?>
					</ul>
					<div id="tabs-1">
					<form method="post" id="frmTab1">
					<table border="0" width="100%" cellpadding="0" cellspacing="5" class="panel">
						<tr>
							<td align="right">
								<button class='btn' id='btn_reset' type='reset'>Reset</button>
								<button class='btn' id='btn_save' type='button'>Simpan</button>
							</td>
						</tr>
						<tr>
							<td>
								<table border="0" cellpadding="3" cellspacing="2">
									<tr>
										<td width="30%">ID Industri</td>
										<td width="2%">:</td>
										<td><?php if($id!=""){ ?>
											<input class=input type="text" size="10" name="id_industri" id="id_industri" readonly value="<?php 
												if(set_value('id_industri')=="" && isset($id_industri)){
													echo $id_industri;
												}else{
													echo  set_value('id_industri');
												}
												?>"/>
										<?php }else{ ?>
											{auto-number}
										<?php } ?>
										</td>
									</tr>
									<tr>
										<td>Nama Industri</td>
										<td>:</td>
										<td><input class=input type="text" size="50" name="nama_industri" value="<?php 
												if(set_value('nama_industri')=="" && isset($nama_industri)){
													echo $nama_industri;
												}else{
													echo  set_value('nama_industri');
												}
												 ?>"/> *
										</td>
									</tr>
									<tr>
										<td>Status Industri</td>
										<td>:</td>
										<td><?php
											if(set_value('id_status')=="" && isset($id_status)){
												echo $this->crud->get_jenis_status($id_status);
											}else{
												echo $this->crud->get_jenis_status();
											}
										?> *
										</td>
									</tr>
									<tr>
										<td>Jenis Industri</td>
										<td>:</td>
										<td><?php
											if(set_value('id_jenis')=="" && isset($id_jenis)){
												echo $this->crud->get_jenis_industri($id_jenis);
											}else{
												echo $this->crud->get_jenis_industri();
											}
										?> *
										</td>
									</tr>
									<tr>
										<td>Bentuk Usaha</td>
										<td>:</td>
										<td><?php
											if(set_value('bentuk_usaha')=="" && isset($bentuk_usaha)){
												echo $this->crud->get_bentuk_usaha($bentuk_usaha);
											}else{
												echo $this->crud->get_bentuk_usaha();
											}
										?> *
										</td> 
									</tr>
								</table>
							</td>
						</tr>
					</table>
					<br>
					<table border="0" width="100%" cellpadding="0" cellspacing="5" class="panel">
						<tr valign=top>
							<td width="50%">
								<table border="0" cellpadding="3" cellspacing="2">
									<tr>
										<td width=41%>NPWP</td>
										<td>:</td>
										<td><input class=input type="text" size="20" name="npwp" value="<?php 
												if(set_value('npwp')=="" && isset($npwp)){
													echo $npwp;
												}else{
													echo  set_value('npwp');
												}
												 ?>"/>
										</td>
									</tr>
									<tr>
										<td valign="top">Pimpinan</td>
										<td valign="top">:</td>
										<td><input class=input type="text" size="40" name="pimpinan" value="<?php 
												if(set_value('pimpinan')=="" && isset($pimpinan)){
													echo $pimpinan;
												}else{
													echo  set_value('pimpinan');
												}
												 ?>"/>
										</td>
									</tr>
									<tr>
										<td>Jumlah Karyawan</td>
										<td>:</td>
										<td><input class=input type="text" size="5" name="jumlah_karyawan" value="<?php 
												if(set_value('jumlah_karyawan')=="" && isset($jumlah_karyawan)){
													echo $jumlah_karyawan;
												}else{
													echo  set_value('jumlah_karyawan');
												}
												 ?>"/>
										</td>
									</tr>
									<tr>
										<td>Investasi</td>
										<td>:</td>
										<td><input class=input type="text" size="10" name="investasi" value="<?php 
												if(set_value('investasi')=="" && isset($investasi)){
													echo $investasi;
												}else{
													echo  set_value('investasi');
												}
												 ?>"/>
										</td>
									</tr>
									<tr>
										<td>Mulai Produksi</td>
										<td>:</td>
										<td><input class=input type="text" size="8" readonly id="mulai_produksi" name="mulai_produksi" value="<?php 
												if(set_value('mulai_produksi')=="" && isset($mulai_produksi)){
													echo $mulai_produksi;
												}else{
													echo  set_value('mulai_produksi');
												}
												 ?>"/>  <img src="<?php echo base_url();?>media/images/calendar.png"/>
										</td>
									</tr>
									<tr>
										<td>Bidang Usaha</td>
										<td>:</td>
										<td><input class=input type="text" size="20" name="bidang_usaha" value="<?php 
												if(set_value('bidang_usaha')=="" && isset($bidang_usaha)){
													echo $bidang_usaha;
												}else{
													echo  set_value('bidang_usaha');
												}
												 ?>"/>
										</td>
									</tr>
									<tr>
										<td>Aset Selain Tanah</td>
										<td>:</td>
										<td>Rp. <input class=input type="text" size="12" name="aset_selain_tanah" value="<?php 
												if(set_value('aset_selain_tanah')=="" && isset($aset_selain_tanah)){
													echo $aset_selain_tanah;
												}else{
													echo  set_value('aset_selain_tanah');
												}
												 ?>" style="text-align:right"/>
										</td>
									</tr>
									<tr>
										<td>Aset Tanah</td>
										<td>:</td>
										<td>Rp. <input class=input type="text" size="12" name="aset_tanah" value="<?php 
												if(set_value('aset_tanah')=="" && isset($aset_tanah)){
													echo $aset_tanah;
												}else{
													echo  set_value('aset_tanah');
												}
												 ?>" style="text-align:right"/>
										</td>
									</tr>
									<tr>
										<td>Aset Seluruh</td>
										<td>:</td>
										<td>Rp. <input class=input type="text" size="12" name="aset_seluruh" value="<?php 
												if(set_value('aset_seluruh')=="" && isset($aset_seluruh)){
													echo $aset_seluruh;
												}else{
													echo  set_value('aset_seluruh');
												}
												 ?>" style="text-align:right"/>
										</td>
									</tr>
								</table>
							</td>
							<td>
								<table border="0" cellpadding="3" cellspacing="2">
									<tr>
										<td width=41%>No Akte Pendirian</td>
										<td>:</td>
										<td><input class=input type="text" size="30" name="no_akte_pendirian" value="<?php 
												if(set_value('no_akte_pendirian')=="" && isset($no_akte_pendirian)){
													echo $no_akte_pendirian;
												}else{
													echo  set_value('no_akte_pendirian');
												}
												 ?>"/>
										</td>
									</tr>
									<tr>
										<td>Tgl Akte Pendirian</td>
										<td>:</td>
										<td><input class=input type="text" size="8" readonly id="tgl_akte_pendirian" name="tgl_akte_pendirian" value="<?php 
												if(set_value('tgl_akte_pendirian')=="" && isset($tgl_akte_pendirian)){
													echo $tgl_akte_pendirian;
												}else{
													echo  set_value('tgl_akte_pendirian');
												}
												 ?>"/> <img src="<?php echo base_url();?>media/images/calendar.png"/>
										</td>
									</tr>
									<tr>
										<td>No IUI</td>
										<td>:</td>
										<td><input class=input type="text" size="20" name="no_iui" value="<?php 
												if(set_value('no_iui')=="" && isset($no_iui)){
													echo $no_iui;
												}else{
													echo  set_value('no_iui');
												}
												 ?>"/>
										</td>
									</tr>
									<tr>
										<td>Status</td>
										<td>:</td>
										<td><?php
											if(set_value('status')=="" && isset($status)){
												echo $this->crud->get_status_industri($status);
											}else{
												echo $this->crud->get_status_industri();
											}
										?> *
										</td>
									</tr>
									<tr>
										<td colspan=3 id="tbl_status" style="padding-left:40px;display:<?php echo (isset($status) &&$status=="1") ? "none":"";?>">
											<table border="0" cellpadding="3" cellspacing="2" width="100%">
												<tr>
													<td width="35%">Dasar Non Aktif</td>
													<td width="1%">:</td>
													<td><input class=input type="text" size="20" name="dasar_non_aktif" value="<?php 
															if(set_value('dasar_non_aktif')=="" && isset($dasar_non_aktif)){
																echo $dasar_non_aktif;
															}else{
																echo  set_value('dasar_non_aktif');
															}
															 ?>"/>
													</td>
												</tr>
												<tr>
													<td>Surat Non Aktif</td>
													<td>:</td>
													<td><input class=input type="text" size="20" name="surat_non_aktif" value="<?php 
															if(set_value('surat_non_aktif')=="" && isset($surat_non_aktif)){
																echo $surat_non_aktif;
															}else{
																echo  set_value('surat_non_aktif');
															}
															 ?>"/>
													</td>
												</tr>
												<tr>
													<td>Sebab Non Aktif</td>
													<td>:</td>
													<td><input class=input type="text" size="20" name="sebab_non_aktif" value="<?php 
															if(set_value('sebab_non_aktif')=="" && isset($sebab_non_aktif)){
																echo $sebab_non_aktif;
															}else{
																echo  set_value('sebab_non_aktif');
															}
															 ?>"/>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						
					</table>
				</div>
				</form>
				<?php if($act=="edit"){ ?>
					<div id="tabs-2"></div>
					<div id="tabs-3"></div>
					<div id="tabs-4"></div>
					<div id="tabs-5"></div>
					<div id="tabs-6"></div>
				<?php } ?>
				</div>
			</td>
		</tr>
	</table>
</div><br>
<div id="datacetak" style="display:none;">
	<?php
	if(isset($content_print))
		echo $content_print;
	?>
	<br>
</div>