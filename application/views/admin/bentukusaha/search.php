<script type="text/javascript">
	$(function() {
		$("#frm").submit(function() {
			var act = '<?php echo base_url(); ?>index.php/admin_master_bentukusaha/index';
			if(jQuery.trim($("input[name='id']").val()) !="") act += '/id/' + jQuery.trim($("input[name='id']").val());
			if(jQuery.trim($("input[name='nama_bentuk']").val()) !="") act += '/nama_bentuk/' + $("input[name='nama_bentuk']").val();
			if(jQuery.trim($("input[name='nama_bentuk2']").val()) !="") act += '/nama_bentuk2/' + $("input[name='nama_bentuk2']").val();
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
						<td>Id</td>
						<td>:</td>
						<td><input class=input type="text" size="10" name="id" value="<?php echo $id?>" /></td>
						<td><button type="submit" class="btn"> Cari </button></td>
					</tr>
					<tr>
						<td>Nama Bentuk</td>
						<td>:</td>
						<td><input class=input type="text" size="10" name="nama_bentuk" value="<?php echo $nama_bentuk?>" /></td>
					</tr>
					<tr>
						<td>Nama Bentuk 2</td>
						<td>:</td>
						<td><input class=input type="text" size="50" name="nama_bentuk2" value="<?php echo $nama_bentuk2?>" /></td>
					</tr>
				</table>

			</td>
		</tr>
	</table>
	<br />
</form>
<div class="clear">&nbsp;</div>
