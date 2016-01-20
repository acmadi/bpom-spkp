<script type="text/javascript">
    $(document).ready(function(){
        
        $("input[type='text']").jqxInput({ theme: 'fresh', height: '22px', width: '90%'}); 
        $("select").jqxInput({ height: '22px', width: '86%'}); 
        $("textarea").jqxInput({  height: '100px', width: '90%'}); 
        
        $('#id_subdit').change(function(){
			$.get("<?php echo base_url()?>srikandi/getKategoriParent/"+ $(this).val(), function(response) {
				var data = eval(response);

				$("#id_kategori_parent").html(data.kategori);
				$("#id_kategori_parent").change();

			}, "json");

		});
        
        $('#id_kategori_parent').change(function(){
			$.get("<?php echo base_url()?>srikandi/getKategori/"+ $(this).val(), function(response) {
				var data = eval(response);

				$("#id_kategori").html(data.kategori);

			}, "json");

		});

		$("[name='btn_simpan']").click(function(){
			$("#uploaddiv").hide();
			$("#uploadloader").show("fade");

			var data = new FormData();
			jQuery.each($("[name='filename']")[0].files, function(i, file) {
				data.append('filename', file);
			});			
			data.append('judul', $("[name='judul']").val());
            data.append('deskripsi', $("[name='deskripsi']").val());
			data.append('id_subdit', $("[name='id_subdit']").val());
			data.append('id_kategori_parent', $("[name='id_kategori_parent']").val());
			data.append('id_kategori', $("[name='id_kategori']").val());
            data.append('prioritas', $("[name='prioritas']").val());

			$.ajax({ 
				type: "POST",
				cache: false,
				contentType: false,
				processData: false,
				url: "<?php echo base_url()?>srikandi/do{action}_upload/{id_srikandi}",
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
					url: "<?php echo base_url()?>srikandi/delete_upload/{id_srikandi}",
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

		$.get("<?php echo base_url()?>srikandi/getKategoriParent/{id_subdit}/{id_kategori_parent}", function(response) {
			var data = eval(response);

			$("#id_kategori_parent").html(data.kategori);
			
			$.get("<?php echo base_url()?>srikandi/getKategori/{id_kategori_parent}/{id_kategori}", function(response) {
				var data = eval(response);

				$("#id_kategori").html(data.kategori);

			}, "json");

		}, "json");
	});
</script>
<div id="uploadloader" style='display:none;text-align:center'><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>uploading<br><br><br><br></div>
<div id="uploaddiv" style="padding:5px;text-align:center">
<form method="POST" id="frmData">
	<?php if($action=="edit"){ ?><button type="button" class="btn btn-danger" name="btn_delete"> Delete Data </button> - <?php } ?>
	<button type="button" class="btn btn-success" name="btn_simpan"> Simpan </button>
	<button type="reset" class="btn btn-info"> Ulang </button>
	<button type="button" onCLick="close_dialog_upload();" class="btn btn-warning"> Batal </button>
	<br />
	<br />
	<table border="0" cellpadding="0" cellspacing="8" align="center" width='90%'>
		<tr>
			<td>
                <table border="0" cellpadding="3" cellspacing="2" width='100%'>
					<?php if($id_srikandi_ref!=0) {
							echo "";
					}else{
					?>	
					<tr>
						<td width="30%">Judul </td>
						<td>:</td>
						<td>
                            <input type="text" size="40" maxlength="100" name="judul" value="<?php 
								if(set_value('judul')=="" && isset($judul)){
								 	echo $judul;
								}else{
									echo  set_value('judul');
								}
								 ?>"
								/> *
						</td>
					</tr>
					<tr>
						<td>Sub Dit</td>
						<td>:</td>
						<td>
							{option_subdit} *
						</td>
					</tr>				
					<tr valign="top">
						<td rowspan="2">Kategori</td>
						<td rowspan="2">:</td>
						<td>
							<select name="id_kategori_parent" id="id_kategori_parent" style="height:25px;padding:2px;margin: 0;"></select> *
						</td>
					</tr>
					<tr>
						<td>
							<select name="id_kategori" id="id_kategori" style="height:25px;padding:2px;margin: 0;"></select>
						</td>
					</tr>	
					<?php } ?>				
                    <tr>
                        <td>Deskripsi </td>
                        <td>:</td>
                        <td>
                        	<textarea name="deskripsi"><?php 
								if(set_value('deskripsi')=="" && isset($deskripsi)){
								 	echo $deskripsi;
								}else{
									echo  set_value('deskripsi');
								}
								 ?></textarea>
                        </td>
                    </tr>
                    <tr>
						<td>Dokumen Pendukung</td>
						<td>:</td>
						<td><input type="file" size="10" name="filename" value="<?php 
								if(set_value('filename')=="" && isset($filename)){
								 	echo $filename;
								}else{
									echo  set_value('filename');
								}
								

								?>"
								 

								/> *
						</td>
					</tr>
					<?php if($id_srikandi_ref!=0) {
							echo "";
					}else{
					?>	
					<tr>
						<td>Prioritas</td>
						<td>:</td>
						<td>
							<select name="prioritas" style="height:25px;padding:2px;margin: 0;">
								<option value='Biasa' <?php echo(isset($tipe) && $tipe=='Biasa' ? "selected":"") ?>>Biasa</option>
								<option value='Penting' <?php echo(isset($tipe) && $tipe=='Penting' ? "selected":"") ?>>Penting</option>							
								<option value='Segera' <?php echo(isset($tipe) && $tipe=='Segera' ? "selected":"") ?>>Segera</option>							
								<option value='Penting Segera' <?php echo(isset($tipe) && $tipe=='Penting Segera' ? "selected":"") ?>>Penting Segera</option>							
							</select>
						</td>
					</tr>
					<?php } ?>
				</table>
			</td>
		</tr>
	</table>
</form>
</div>