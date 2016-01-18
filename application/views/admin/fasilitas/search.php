<script type="text/javascript">
	$(function() {
		$("#frm").submit(function() {
			var act = '<?php echo base_url(); ?>index.php/admin_master_fasilitas/index';
			if(jQuery.trim($("input[name='id_fasilitas']").val()) !="") act += '/id_fasilitas/' + jQuery.trim($("input[name='id_fasilitas']").val());
			if(jQuery.trim($("input[name='nama_fasilitas']").val()) !="") act += '/nama_fasilitas/' + $("input[name='nama_fasilitas']").val();
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
						<td>Id Fasilitas</td>
						<td>:</td>
						<td><input class=input type="text" size="10" name="id_fasilitas" value="<?php echo $id_fasilitas?>" /></td>
						<td><button type="submit" class="btn"> Cari </button></td>
					</tr>
					<tr>
						<td>Nama Fasilitas</td>
						<td>:</td>
						<td><input class=input type="text" size="50" name="nama_fasilitas" value="<?php echo $nama_fasilitas?>" /></td>
					</tr>
				</table>

			</td>
		</tr>
	</table>
	<br />
</form>
<div class="clear">&nbsp;</div>
