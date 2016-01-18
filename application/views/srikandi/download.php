<script type="text/javascript">
    $(document).ready(function(){
		$("button").jqxInput({ theme: 'fresh', height: '28px', width: '100px' }); 

		$("[name='btn_download']").click(function(){
			window.open("<?php echo base_url()?>srikandi/dodownload/{id_srikandi}");
		});
	});
</script>
<div id="uploadloader" style='display:none;text-align:center'><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>uploading<br><br><br><br></div>
<div id="uploaddiv" style="padding:5px;text-align:center">
<form method="POST" id="frmData">
	<button type="button" name="btn_download"> Download </button>
	<button type="button" onCLick="close_dialog_upload();"> Batal </button>
	<br />
	<br />
    <table border="0" cellpadding="0" cellspacing="8" align="center">
		<tr>
			<td colspan="2"><b>{judul}</b></td>
		</tr>
        <tr>
			<td colspan="2">{deskripsi}</td>
		</tr>
		<tr>
			<td rowspan="2" width="10%" align="center"><img src="<?php echo base_url()?>public/images/save.png"></td>
			<td>File: {filename}</td>
		</tr>
		<tr>
			<td>Ukuran: {filesize} KB</td>
		</tr>
	</table>
</form>
</div>