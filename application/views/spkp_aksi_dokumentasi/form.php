<script type="text/javascript">
   $(document).ready(function(){
		$("button,submit,reset").jqxInput({ theme: 'fresh', height: '28px', width: '100px' }); 
		$("input[name='judul']").jqxInput({ theme: 'fresh', height: '22px', width: '220px' }); 
		$("input[name='keterangan']").jqxInput({ theme: 'fresh', height: '22px', width: '500px' }); 
		$("select[name='status']").jqxInput({ theme: 'fresh', height: '22px', width: '200px' }); 

		$("[name='btn_simpan']").click(function(){
			$("#uploaddiv").hide();
			$("#uploadloader").show("fade");

			var data = new FormData();
			data.append('judul', $("[name='judul']").val());
			data.append('keterangan', $("[name='keterangan']").val());
			data.append('status', $("[name='status']").val());

			$.ajax({ 
				type: "POST",
				cache: false,
				contentType: false,
				processData: false,
				url: "<?php echo base_url()?>spkp_aksi_dokumentasi/do{action}/{id}",
				data: data,
				success: function(response){
					 var data = response.split("_");
					if(data[0]=="1"){
						window.location.href = "<?php echo base_url(); ?>spkp_aksi_dokumentasi/show/"+data[1];
					 }else{
						 $.notific8('Notification', {
						  life: 5000,
						  heading: 'Saving data FAIL',
						  message: response,
						  theme: 'red2'
						});
					 }
					$("#uploadloader").hide();
					$("#uploaddiv").show("fade");
					//window.location.href = "<?php echo base_url();?>spkp_aksi_dokumentasi";
				}
			 }); 		
		});

	});
	
	function close_dialog(){
		$("#popup").jqxWindow("close");
	}

</script>
<div id="uploadloader" style='display:none;text-align:center'><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>uploading<br><br><br><br></div>
<div id="uploaddiv" style="padding:5px;text-align:center">
<form method="POST" id="frmData">
	
	<button type="button" name="btn_simpan"> Simpan </button>
	<button type="reset"> Ulang </button>
	<button type="button" onCLick="close_dialog();"> Batal </button>
	<br />
	<br />
	<table border="0" cellpadding="0" cellspacing="8" align="center">
		<tr>
			<td>

				<table border="0" cellpadding="3" cellspacing="2">
					<tr>
						<td>Judul Kegiatan</td>
						<td>:</td>
						<td><input type="text" size="40" name="judul" value="<?php 
								if(set_value('judul')=="" && isset($judul)){
								 	echo $judul;
								}else{
									echo  set_value('judul');
								}
								 ?>"/> *
						</td>
					</tr>
					<tr>
						<td>Keterangan</td>
						<td>:</td>
						<td><input type="text" size="80" name="keterangan" value="<?php 
								if(set_value('keterangan')=="" && isset($keterangan)){
								 	echo $keterangan;
								}else{
									echo  set_value('keterangan');
								}
								 ?>"/>
						</td>
					</tr>
					<!--<tr>
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
					</tr>-->
					<tr>
						<td>Publish</td>
						<td>:</td>
						<td><select name="status" style="height:25px;padding:2px;">
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