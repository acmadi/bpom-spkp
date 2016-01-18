<script type="text/javascript">
	$(function() {
		$("#frm").submit(function() {
			var act = '<?php echo base_url(); ?>index.php/admin_master_tujuan/index';
			if(jQuery.trim($("input[name='id_tujuan']").val()) !="") act += '/id_tujuan/' + jQuery.trim($("input[name='id_tujuan']").val());
			if(jQuery.trim($("input[name='desc_tujuan']").val()) !="") act += '/desc_tujuan/' + $("input[name='desc_tujuan']").val();
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
						<td>Id Tujuan</td>
						<td>:</td>
						<td><input class=input type="text" size="10" name="id_tujuan" value="<?php echo $id_tujuan?>" /></td>
						<td><button type="submit" class="btn"> Cari </button></td>
					</tr>
					<tr>
						<td>Desc Tujuan</td>
						<td>:</td>
						<td><input class=input type="text" size="50" name="desc_tujuan" value="<?php echo $desc_tujuan?>" /></td>
					</tr>
				</table>

			</td>
		</tr>
	</table>
	<br />
</form>
<div class="clear">&nbsp;</div>
