<script type="text/javascript">
	$(function() {
		$("#frm").submit(function() {
			var act = '<?php echo base_url(); ?>index.php/admin_master_balai/index';
			if(jQuery.trim($("input[name='id_balai']").val()) !="") act += '/id_balai/' + jQuery.trim($("input[name='id_balai']").val());
			if(jQuery.trim($("input[name='nama_balai']").val()) !="") act += '/nama_balai/' + $("input[name='nama_balai']").val();
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
						<td>Id Balai</td>
						<td>:</td>
						<td><input class=input type="text" size="10" name="id_balai" value="<?php echo $id_balai?>" /></td>
						<td><button type="submit" class="btn"> Cari </button></td>
					</tr>
					<tr>
						<td>Nama Balai</td>
						<td>:</td>
						<td><input class=input type="text" size="50" name="nama_balai" value="<?php echo $nama_balai?>" /></td>
					</tr>
				</table>

			</td>
		</tr>
	</table>
	<br />
</form>
<div class="clear">&nbsp;</div>
