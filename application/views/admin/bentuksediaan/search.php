<script type="text/javascript">
	$(function() {
		$("#frm").submit(function() {
			var act = '<?php echo base_url(); ?>index.php/admin_master_balai/index';
			if(jQuery.trim($("input[name='id_sediaan']").val()) !="") act += '/id_sediaan/' + jQuery.trim($("input[name='id_sediaan']").val());
			if(jQuery.trim($("input[name='nama_sediaan']").val()) !="") act += '/nama_sediaan/' + $("input[name='nama_sediaan']").val();
			window.location= act;
			return false;
		});
	});
</script>
<div class="clear">&nbsp;</div>
<form action="" method="post" name="frm" id="frm">
	<br />
	<table border="0" cellpadding="0" cellspacing="8" class="panel" width=80%>
		<tr>
			<td>
				<table width=100% border="0" cellpadding="3" cellspacing="2">
					<tr>
						<td>Id Sediaan</td>
						<td>:</td>
						<td><input class=input type="text" size="10" name="id_sediaan" value="<?php echo $id_sediaan?>" /></td>
						<td><button type="submit" class="btn"> Cari </button></td>
					</tr>
					<tr>
						<td>Nama Sediaan</td>
						<td>:</td>
						<td><input class=input type="text" size="50" name="nama_sediaan" value="<?php echo $nama_sediaan?>" /></td>
					</tr>
				</table>

			</td>
		</tr>
	</table>
	<br />
</form>
<div class="clear">&nbsp;</div>
