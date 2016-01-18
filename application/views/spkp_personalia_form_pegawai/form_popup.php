<script type="text/javascript">
    $(document).ready(function(){
		$("button,submit,reset").jqxInput({ theme: 'fresh', height: '28px', width: '100px' }); 
		$("input[name='alasan']").jqxInput({ theme: 'fresh', height: '28px', width: '500px' }); 
        
		$("#tgl,#tgl_cuti").jqxDateTimeInput({ width: '110px', height: '28px', formatString: 'yyyy-MM-dd', theme: theme, value: '{tgl}' });

		$("[name='btn_simpan']").click(function(){
			$("#uploaddiv").hide();
			$.ajax({ 
				type: "POST",
				cache: false,
				url: "<?php echo base_url()?>spkp_personalia_form_pegawai/do{action}/{uid}",
				data: $("#frmDataCB").serialize(),
				success: function(response){
					res = response.split("_");
					 if(res[0]=="OK"){
						$.notific8('Notification', {
						  life: 5000,
						  message: 'Save data succesfully.',
						  heading: 'Saving data',
						  theme: 'lime2'
						});
						window.location.href="<?php echo base_url()?>spkp_personalia_form_pegawai/edit/{uid}/"+res[1];
					 }else{
						$("#uploadloader").show("fade");
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

	});
</script>
<div id="uploadloader" style='display:none;text-align:center'><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>uploading<br><br><br><br></div>
<div id="uploaddiv" style="padding:5px;text-align:center">
<form method="POST" id="frmDataCB">
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
						<td>Tgl Pengajuan *</td>
						<td>:</td>
						<td>
							<div id='tgl'></div>
						</td>
					</tr>
					<tr>
						<td>Tgl Mulai Cuti *</td>
						<td>:</td>
						<td>
							<div id='tgl_cuti'></div>
						</td>
					</tr>
					<tr>
						<td>Jenis</td>
						<td>:</td>
						<td>{option_izincuti} *</td>
					</tr>
					<tr>
						<td>Keperluan</td>
						<td>:</td>
						<td><input type="text" size="75" name="alasan" style="padding: 2px;" value="<?php 
								if(set_value('alasan')=="" && isset($alasan)){
								 	echo $alasan;
								}else{
									echo  set_value('alasan');
								}
								 ?>"/>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</form>
</div>