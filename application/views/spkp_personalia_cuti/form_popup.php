<script type="text/javascript">
    $(document).ready(function(){
		$("button,submit,reset").jqxInput({ theme: 'fresh', height: '28px', width: '100px' }); 
		$("input[name='keterangan']").jqxInput({ theme: 'fresh', height: '28px', width: '500px' }); 
        
		$("#tgl").jqxDateTimeInput({ width: '110px', height: '28px', formatString: 'yyyy-MM-dd', theme: theme, value: '{tgl}' });

		$("[name='btn_simpan']").click(function(){
			$("#uploaddiv").hide();
			$("#uploadloader").show("fade");

			$.ajax({ 
				type: "POST",
				cache: false,
				url: "<?php echo base_url()?>spkp_personalia_cuti/do{action}/{id}",
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
						$("[name='tgl']").val("");
						$("[name='keterangan']").val("");
						$("#jqxgridCB").jqxGrid('updatebounddata', 'cells');
						close_dialog(1);
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
						<td>Tanggal *</td>
						<td>:</td>
						<td>
							<div id='tgl'></div>
						</td>
					</tr>
					<tr>
						<td>Status</td>
						<td>:</td>
						<td><select name="status" id="status">
								<option value="Libur Nasional" <?php if(isset($status) && $status=="Libur Nasional") echo "selected"; ?>>Libur Nasional</option>
								<option value="Cuti Bersama" <?php if(isset($status) && $status=="Cuti Bersama") echo "selected"; ?>>Cuti Bersama</option>
							</select>
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
				</table>
			</td>
		</tr>
	</table>
</form>
</div>