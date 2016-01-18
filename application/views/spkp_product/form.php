<script type="text/javascript">
    $(document).ready(function(){
        $("button,submit,reset").jqxInput({ theme: 'fresh', height: '28px', width: '100px'}); 
        $("input[name='judul']").jqxInput({ theme: 'fresh', height: '22px', width: '220px'}); 
		$("input[name='keterangan']").jqxInput({ theme: 'fresh', height: '22px', width: '500px' }); 
        
		$("[name='btn_simpan']").click(function(){
			$("#uploaddiv").hide();
			$("#uploadloader").show("fade");

			var data = new FormData();
			jQuery.each($("[name='filename']")[0].files, function(i, file) {
				data.append('filename', file);
			});			
			data.append('judul', $("[name='judul']").val());
            data.append('tipe', $("[name='tipe']").val());
            data.append('keterangan', $("[name='keterangan']").val());
            data.append('status', $("[name='status']").val());

			$.ajax({ 
				type: "POST",
				cache: false,
				contentType: false,
				processData: false,
				url: "<?php echo base_url()?>spkp_product/do{action}_upload/{id}",
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
						$("#keterangan").val("");
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
					url: "<?php echo base_url()?>spkp_product/delete_upload/{id}",
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
						<td>Judul</td>
						<td>:</td>
						<td>
                            <input type="text" size="40" maxlength="100" name="judul" value="<?php 
								if(set_value('judul')=="" && isset($judul)){
								 	echo $judul;
								}else{
									echo  set_value('judul');
								}
								 ?>"/> *
						</td>
					</tr>
                    <tr>
                        <td>tipe</td>
                        <td>:</td>
                        <td>
                            <select size="1" name="tipe" style="width: 200px;height:25px;padding:2px;margin: 0;">
                                <option value='Modul, buku saku, komik' <?php echo(isset($tipe) && $tipe=='Modul, buku saku, komik' ? "selected":"") ?>>Modul, buku saku, komik</option>
								<option value='Poster' <?php echo(isset($tipe) && $tipe=='Poster' ? "selected":"") ?>>Poster</option>
								<option value='Leaflet' <?php echo(isset($tipe) && $tipe=='Leaflet' ? "selected":"") ?>>Leaflet</option>
                            </select>  *
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
                        <td>Keterangan</td>
                        <td>:</td>
                        <td>
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