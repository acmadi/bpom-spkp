<script type="text/javascript">
	$(function() {
		$("#frm").submit(function() {
			var act = '<?php echo base_url(); ?>index.php/admin_master_resume/index';
			if(jQuery.trim($("input[name='id_resume']").val()) !="") act += '/id_resume/' + jQuery.trim($("input[name='id_resume']").val());
			if(jQuery.trim($("input[name='desc_resume']").val()) !="") act += '/desc_resume/' + $("input[name='desc_resume']").val();
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
						<td>Id Resume</td>
						<td>:</td>
						<td><input class=input type="text" size="10" name="id_resume" value="<?php echo $id_resume?>" /></td>
						<td><button type="submit" class="btn"> Cari </button></td>
					</tr>
					<tr>
						<td>Desc Resume</td>
						<td>:</td>
						<td><input class=input type="text" size="50" name="desc_resume" value="<?php echo $desc_resume?>" /></td>
					</tr>
				</table>

			</td>
		</tr>
	</table>
	<br />
</form>
<div class="clear">&nbsp;</div>
