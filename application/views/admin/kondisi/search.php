<script type="text/javascript">
	$(function() {
		$("#frmUsers").submit(function() {
			var act = '<?php echo base_url(); ?>index.php/admin_kondisi/index';
			if(jQuery.trim($("input[name='kondisi']").val()) !="") act += '/kondisi/' + jQuery.trim($("input[name='kondisi']").val());
			window.location= act;
			return false;
		});
	});
</script>
<div class="clear">&nbsp;</div>
<form action="" method="post" name="frmUsers" id="frmUsers">
	<br />
	<table border="0" cellpadding="0" cellspacing="8" class="panel" width=80%>
		<tr>
			<td>
				<table width=100% border="0" cellpadding="3" cellspacing="2">
					<tr>
						<td>Kondisi</td>
						<td>:</td>
						<td><input class=input type="text" size="40" name="kondisi" value="<?php echo $kondisi?>" /></td>
						<td><button type="submit" class="btn"> Cari </button></td>
					</tr>
				</table>

			</td>
		</tr>
	</table>
	<br />
</form>
<div class="clear">&nbsp;</div>
