<div class="title">{title_form}</div>
<div class="clear">&nbsp;</div>
<?php if(validation_errors()==TRUE || $this->session->flashdata('alert')!=""):?>	
<div class="alert" id="alert">
<div align=right onClick="$('#alert').hide('fold',1000);" style="color:red;font-weight:bold">X</div>
<?php echo validation_errors();?>
<?php echo $this->session->flashdata('alert')?>
</div>
<?php endif;?>
<div class="clear">&nbsp;</div>
<form action="<?php echo base_url()?>index.php/admin_kondisi/{action}/{id}" method="POST" name="frmUsers">
	<button type="submit" class=btn>Simpan</button>
	<button type="reset" class=btn>Ulang</button>
	<button type="button" class=btn onclick="document.location.href='<?php echo base_url()?>index.php/admin_kondisi';">Kembali</button>
	<br />
	<br />
	<table border="0" cellpadding="0" cellspacing="8" class="panel">
		<tr>
			<td>

				<table border="0" cellpadding="3" cellspacing="2">
					<tr>
						<td>Kondisi</td>
						<td>:</td>
						<td><input class=input type="text" size="50" name="kondisi" value="<?php 
								if(!isset($kondisi)){
									echo  set_value('kondisi');
								}else{
								 	echo $kondisi;
								}
								 ?>"/></td>
					</tr>
				</table>

			</td>
		</tr>
	</table>
	<br />
	<button type="submit" class=btn>Simpan</button>
	<button type="reset" class=btn>Ulang</button>
	<button type="button" class=btn onclick="document.location.href='<?php echo base_url()?>index.php/admin_kondisi';">Kembali</button>
</form>
