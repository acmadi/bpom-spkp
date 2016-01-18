<script type="text/javascript">
	$(function() {
		$("#frm").submit(function() {
			var act = '<?php echo base_url(); ?>index.php/admin_master_jnsindustri/index';
			if(jQuery.trim($("input[name='id_jenis']").val()) !="") act += '/id_jenis/' + jQuery.trim($("input[name='id_jenis']").val());
			if(jQuery.trim($("input[name='nama_jenis']").val()) !="") act += '/nama_jenis/' + $("input[name='nama_jenis']").val();
			if(jQuery.trim($("input[name='nama_jenis2']").val()) !="") act += '/nama_jenis2/' + $("input[name='nama_jenis2']").val();
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
						<td>Id Jenis</td>
						<td>:</td>
						<td><input class=input type="text" size="10" name="id_jenis" value="<?php echo $id_jenis?>" /></td>
						<td><button type="submit" class="btn"> Cari </button></td>
					</tr>
					<tr>
						<td>Nama Jenis 1</td>
						<td>:</td>
						<td><input class=input type="text" size="50" name="nama_jenis" value="<?php echo $nama_jenis?>" /></td>
					</tr>
					<tr>
						<td>Nama Jenis 2</td>
						<td>:</td>
						<td><input class=input type="text" size="50" name="nama_jenis2" value="<?php echo $nama_jenis2?>" /></td>
					</tr>
				</table>

			</td>
		</tr>
	</table>
	<br />
</form>
<div class="clear">&nbsp;</div>
